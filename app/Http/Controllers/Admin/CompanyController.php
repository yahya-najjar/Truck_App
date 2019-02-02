<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Carbon\Carbon;

class CompanyController extends Controller
{
	public function index(){
		$company = Company::first();
		return view('admin.company.index',compact('company'));
	}

	public function store(Request $request)
	{
		 $this->validate(request(),[
		    'about'  =>      'required',
		    'privacy' =>      'required',
		    'terms' =>      'required',		    
		]);
		$company = new Company($request->all());
		$company->save();
		return back()->with('success','Information Stored Successfully');
	}

	public function update(Request $request,Company $company)
	{
		$this->validate(request(),[
		    'about'  =>      'required',
		    'privacy' =>      'required',
		    'terms' =>      'required',		    
		]);

		$company->update($request->all());
		return back()->with('success','Information Updated Successfully');
	}
}