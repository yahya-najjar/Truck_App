<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Customer;
use App\Role;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator, DB, Hash, Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Mail\Message;
use App\Http\Responses\Responses;
use App\Mail\VerifyMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class AuthController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    use AuthenticatesUsers;

    public function __construct()
    {
        \Config::set('jwt.user', "App\Customer");
        \Config::set('auth.providers.users.model', \App\Customer::class);

        $this->guard = \Auth::guard('customer');
    }

    public function register(Request $request)
    {
        $credentials = $request->only('first_name','last_name','phone','age','type','gender', 'email', 'password');
        
        $rules = [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'phone' => 'required|numeric',
            'age' => 'required|numeric',
            'gender' => 'required',
            'type' => 'required',
            'password' => 'required',
            'email' => 'required|email|max:255|unique:customers'
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return Responses::respondError($validator->messages());
        }
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone = $request->phone;
        $age = $request->age;
        $gender = $request->gender;
        $type = $request->type;
        $email = $request->email;
        $password = $request->password;
        
        $user = Customer::create(
            ['first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'age' => $age,
            'gender' => $gender,
            'type' => $type,
            'password' => bcrypt($password),
            'code'=>0,
            'active'=>0,
            'registration_completed'=>0,
            'platform'=>$request->platform,
            'FCM_Token'=>$request->fcm_token,
        ]);
        // $customer = Role::where('name','customer')->get()->first();
        // $user->attachRole($customer);

        $verification_code = mt_rand(100000, 999999);//Generate verification code
        DB::table('customer_verifications')->insert(['customer_id'=>$user->id,'token'=>$verification_code]);

        $data = ['name' => $first_name, 'verification_code' => $verification_code];
        // Mail::to([
        //     'email' => $email 
        // ])->send(new VerifyMail($data));

        $customer = Customer::find($user->id);
        $message = 'Thanks for signing up! Please check your email to complete your registration.';

        // login
        $credentials = $request->only('email', 'password');
     // attempt to verify the credentials and create a token for the user
        \Config::set('jwt.user', "App\Customer");
        \Config::set('auth.providers.users.model', \App\Customer::class);

        $token =JWTAuth::attempt($credentials);
        if (! $token) {
           return Responses::respondError('We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'); 
       }

        $token = JWTAuth::fromUser($customer);
        $customer->token = $token;   

        return Responses::respondSuccess($customer);
        // return response()->json(['success'=> true, 'message'=> 'Thanks for signing up! Please check your email to complete your registration.']);
    }

     public function verifyUserRequest(Request $request){
        $verification_code = $request->code;
        $user_id = $request->user_id;
        if ($user_id && $verification_code == 123456) {
            $user = Customer::find($user_id);
            if($user->is_verified == 1){
                return Responses::respondMessage('Account already verified');
            }
            $user->update(['is_verified' => 1]);
            DB::table('customer_verifications')->where('customer_id',$user_id)->delete();
            return Responses::respondMessage('You have successfully verified your email address');   
        }
        return  $this->verifyUser($verification_code);
    }

    public function verifyUser($verification_code)
    {
        $check = DB::table('customer_verifications')->where('token',$verification_code)->first();
        if(!is_null($check)){
            $user = Customer::find($check->customer_id);
            if($user->is_verified == 1){
                return Responses::respondMessage('Account already verified');
            }
            $user->update(['is_verified' => 1]);
            DB::table('customer_verifications')->where('token',$verification_code)->delete();
            return Responses::respondMessage('You have successfully verified your email address');
        }
        return Responses::respondError('Verification code is invalid');
    }


    /**
     * API Login, on success return JWT Auth token
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($credentials, $rules);
        if($validator->fails()) {
            return response()->json(['success'=> false, 'error'=> $validator->messages()], 401);
        }

        // $credentials['is_verified'] = 0;
        
        
        try {
            // attempt to verify the credentials and create a token for the user
            \Config::set('jwt.user', "App\Customer");
            \Config::set('auth.providers.users.model', \App\Customer::class);

            $token =JWTAuth::attempt($credentials);
            if (! $token) {
               return Responses::respondError('We cant find an account with this credentials. Please make sure you entered the right information and you have verified your email address.'); 
           }   

       } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
         return Responses::respondError('Failed to login, please try again'); 
        }
        // all good so return the token
        $user = Customer::where('email', $request->email)->first();
        $token = JWTAuth::fromUser($user);
        $user->token = $token;
        return Responses::respondSuccess($user);
    }

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore
     * They have to relogin to get a new token
     *
     * @param Request $request
     */
    public function logout(Request $request) {

        try {
            JWTAuth::invalidate($request->input('token'));
            return Responses::respondSuccess([]);
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            response()->json(trans('messages.try_again'));
        }
    }

     /**
     * API Recover Password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */


     public function recover(Request $request)
     {
        $validator = Validator::make($request->all(), ['email' => 'required']);
        if ($validator->fails()) {
            return Responses::respondError(trans('messages.input_sure'));
        }
        $customer = User::where('email', $request->email)->first();
        if (!$customer) {
            return Responses::respondError(trans('messages.email_not_found'));
        }
        // if ($customer->active_status) {
        //     return Responses::respondError(trans('messages.activate_account'));
        // }
        if(DB::table('user_verifications')->where('user_id',$customer->id)->first())
            DB::table('user_verifications')->where('user_id',$customer->id)->delete();

        $verification_code = str_random(6); //Generate verification code
        DB::table('user_verifications')->insert(['user_id'=>$customer->id,'token'=>$verification_code]);

        $customer->save();

        $data = ['name' => $customer->name, 'verification_code' => $verification_code];
        Mail::to([
            'email' => $request->email 
        ])->send(new VerifyMail($data));

        $message = 'A reset email has been sent! Please check your email.';
        return Responses::respondMessage($message);
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }

}