<?php

namespace App\Http\Controllers\Admin;

use App\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FCMCustomNotificationController extends Controller
{

    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function sendForm()
    {
        return view('admin.fcm_notes.custom_notes');
    }

    public function getCustomers(Request $request)
    {
        $q = $request->get('search');
//        if(!trim($q)){
//            return response()->json([
//                'results' => []
//            ]);
//        };
        $customers = Customer::where('first_name', 'LIKE', "%{$q}%")
            ->orWhere('last_name', 'LIKE', "%{$q}%")
            ->orWhere('email', 'LIKE', "%{$q}%")
            ->orWhere('phone', 'LIKE', "%{$q}%")
            ->get()->map(function ($result) {
                return array(
                    'id' => $result->id,
                    'text' => $result->fullName,
                );
            });


        return response()->json([
            'results' => $customers
        ]);
    }

    public function sendPost(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:100',
            'body' => 'required|max:500'
        ]);
        $title = $request->get('title');
        $body = $request->get('body');
        if (isset($request->customers_ids)) {
            $customers_tokens = Customer::find($request->customers_ids)->pluck('FCM_Token')->toArray();
            $result = $this->notification($title, $body, $customers_tokens);
            if (!json_decode($result, true)['success']) {
                return back()->with('error', 'Error happen, please Try again later');
            }
        } else {
            $this->notification($title, $body, '/topics/all-users');
            $this->notification($title, $body, '/topics/all-users-ios');
        }



        return back()->with('success', 'Sent successfully');
    }
}
