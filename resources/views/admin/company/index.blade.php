@extends('admin.layouts.app')
@section('title')
Company Profile
@endsection
@section('bread')
    <li class="breadcrumb-item active">Company Profile</li>
@endsection
@section('content')
<div class="row">
	<div class="col-md-12">
	    <div class="card">
	        <div class="card-body">
	            <h4 class="card-title">Company Profile</h4>
	            <h6 class="card-subtitle">your changes will be effective on <code>android & iphone applications </code></h6>
	            <!-- Nav tabs -->
	            <ul class="nav nav-tabs" role="tablist">
	                <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#about" role="tab"><span class="hidden-sm-up"><i class="ti-about"></i></span> <span class="hidden-xs-down">About</span></a> </li>
	                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#privacy" role="tab"><span class="hidden-sm-up"><i class="ti-privacy"></i></span> <span class="hidden-xs-down">Privacy Policy</span></a> </li>
	                <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#terms" role="tab"><span class="hidden-sm-up"><i class="ti-terms"></i></span> <span class="hidden-xs-down">Terms & Conditions</span></a> </li>
	            </ul>
	            <!-- Tab panes -->
	            <form class="form-material" enctype="multipart/form-data"
	                           action="{{ isset($company) ? action('Admin\CompanyController@update', $company) : action('Admin\CompanyController@store') }}"
	                           method="post">
	                           {{ csrf_field() }}


	                           @if(isset($company))
	                           {{ method_field('PATCH') }}
	                           @endif
		            <div class="tab-content tabcontent-border">
		                <div class="col-md-12 tab-pane active" id="about" role="tabpanel">
		                    <div class="p-20">
		                        <h3>About Section</h3>
		                        <textarea name="about" class="form-control required" required="true" rows="10" value="{{ isset($company) ? $company->about: '' }}">{{ isset($company) ? $company->about: '' }}</textarea>	                        
		                    </div>
		                </div>
		                <div class="tab-pane  p-20" id="privacy" role="tabpanel">
		                	<h3>Privacy & Policy Section</h3>
		                	<textarea name="privacy" class="form-control required" required="true" rows="10" value="{{ isset($company) ? $company->privacy: '' }}">{{ isset($company) ? $company->privacy: '' }}</textarea>	
		                </div>
		                <div class="tab-pane p-20" id="terms" role="tabpanel">
		                	<h3>Terms & Conditions Section</h3>
		                	<textarea name="terms" class="form-control required" required="true" rows="10" value="{{ isset($company) ? $company->terms: '' }}">{{ isset($company) ? $company->terms: '' }}</textarea>	
		                </div>
		            </div>

		            <div>
		            	<button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Submit</button>
		            </div>
	            </form>
	        </div>
	    </div>
	</div>
</div>
@endsection