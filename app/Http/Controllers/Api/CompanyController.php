<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Responses\Responses;
use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function terms(Request $request)
    {
    	$validator = Validator::make($request->all(), [
			'term' => 'required',
		]);

		if ($validator->fails()) {
			$message = $validator->errors();
			$msg = $message->first();
			return Responses::respondError($msg);
		}

    	$term = $request->term;
    	$company = Company::first();
    	$response = null;

    	switch ($term) {
    		case 'policy':
    			$response = $company->privacy;
    			break;
    		case 'about':
    			$response = $company->about;
    			break;
    		case 'terms':
    			$response = $company->terms;
    			break;
    	}

		return Responses::respondSuccess($response);
    }
}
