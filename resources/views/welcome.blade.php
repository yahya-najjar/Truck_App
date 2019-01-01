@extends('layouts.app')
   
       
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                @section('content')
                <div class="fix-width">
                    <div class="row banner-text">
                        <div class="col-lg-5 m-t-20">
                            <h1>The Most Beautiful &amp; Powerful <span class="text-info">Trucks Application</span> based Admin Dashboard</h1>
                            <p class="subtext"><span class="font-medium">Bootstrap 4 </span>Admin Template + Angular cli Starter kit, <span class="font-medium">Light &amp; Dark</span> Versions, Landing Page, <span class="font-medium">8 Demo</span> Variations, <span class="font-medium">4 Dashboard</span> Variations, <span class="font-medium">100+</span> Integrated Plugins, <span class="font-medium">800+</span> Pages, <span class="font-medium">3000+</span> Font Icons, <span class="font-medium">500+</span> UI Components &amp; much more...</p>
                            <div class="down-btn"> <a href="#demos" class="btn btn-info m-b-10">SEE SERVICES</a> <a href="" class="btn btn-success m-b-10">BUY NOW</a> </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="hero-banner"> <img src="{{asset('/assets/homepage/images/banner.jpg')}}" alt="Truck App admin template" /> </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Featured Section -->
                <!-- ============================================================== -->
                <div class="row light-blue">
                    <div class="col-md-12" id="demos">
                        <div class="text-center"> <small class="text-info">The Most Beautiful Truck Application</small>
                            <h2 class="display-7">Powerful Admin panel of 2018</h2>
                            <p>Don’t go by our Words, checkout our awesome demos and verify yourself.
                                <br/>You will surely fall in love over the fresh design & brilliant code.</p>
                        </div>
                        <div class="max-width">
                            <div class="row text-center">
                                <div class="col-md-4 m-t-40">
                                    <div class="image-box"> <img src="{{asset('/assets/homepage/images/adminpro-demo2.jpg')}}" alt="demo1" class="img-responsive" />
                                        <div class="image-overly"> <a class="btn btn-rounded btn-info" href="https://wrappixel.com/demos/admin-templates/admin-pro/main/index2.html" target="_blank">Live Preview</a> </div>
                                    </div>
                                    <h5 class="p-20">Main Demo Version</h5> </div>
                                    <div class="col-md-4 m-t-40">
                                    <div class="image-box"> <img src="{{asset('/assets/homepage/images/adminpro-demo1.jpg')}}" alt="demo2" class="img-responsive" />
                                        <div class="image-overly"> <a class="btn btn-rounded btn-info" href="https://wrappixel.com/demos/admin-templates/admin-pro/minisidebar/index.html" target="_blank">Live Preview</a> </div>
                                    </div>
                                    <h5 class="p-20">Mini Sidebar Demo Version</h5> </div>
                                    <div class="col-md-4 m-t-40">
                                    <div class="image-box"> <img src="{{asset('/assets/homepage/images/adminpro-demo4.jpg')}}" alt="demo5" class="img-responsive" />
                                        <div class="image-overly"> <a class="btn btn-rounded btn-info" href="https://wrappixel.com/demos/admin-templates/admin-pro/minimal/index4.html" target="_blank">Live Preview</a> </div>
                                    </div>
                                    <h5 class="p-20">Mini Sidebar Demo Version</h5> </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Feature with Icons -->
                <!-- ============================================================== -->
                <div class="row white-space">
                    <div class="col-md-12">
                        <div class="fix-width icon-section"> <small class="text-info">ALMOST COVERED EVERYTHING</small>
                            <h2 class="display-7">Amazing Features & Flexibility Provided</h2>
                            <!-- Row -->
                            <div class="row m-t-40">
                                <!-- .col -->
                                <div class="col-lg-3 col-md-6"> <img src="{{asset('/assets/homepage/images/color-skim.png')}}" alt="Truck App admin template">
                                    <h4 class="font-500">6 Color Schemes</h4>
                                    <p>We have included 6 pre-defined color schemes with Truck App admin.</p>
                                </div>
                                <!-- /.col -->
                                <!-- .col -->
                                <div class="col-lg-3 col-md-6"> <img src="{{asset('/assets/homepage/images/sidebars.png')}}" alt="Truck App admin template">
                                    <h4 class="font-500">Dark &amp; Light Sidebar</h4>
                                    <p>Included Dark and Light Sidebar for getting desire look and feel.</p>
                                </div>
                                <!-- /.col -->
                                <!-- .col -->
                                <div class="col-lg-3 col-md-6"> <img src="{{asset('/assets/homepage/images/pages.png')}}" alt="Truck App admin template">
                                    <h4 class="font-500">800+ Page Templates</h4>
                                    <p>Yes, we have 8 demos &amp; 120+ Pages per demo to make it easier.</p>
                                </div>
                                <!-- /.col -->
                               
                            </div>
                            <div class="text-center">
                                <!-- Row --><a href="https://wrappixel.com/templates/adminpro/" class="btn btn-lg btn-success m-t-40"> Buy Truck App Now</a>
                                <!-- Row -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Testimonial -->
                <!-- ============================================================== -->
                <div class="row light-blue">
                    <div class="col-md-12">
                        <div class="fix-width text-center"> <small class="text-info">ALMOST COVERED EVERYTHING</small>
                            <h2 class="display-7">What Real Buyers have to <br/>Say about Truck App Admin</h2>
                            <div class="tesimonial-box owl-carousel owl-theme" id="owl-demo2">
                                <div class="item">
                                    <p class="testimonial-text"><b class="font-500">The free version is incredible and it had everything I needed, however I bought this full template to support the developer. It’s a great, lightweight template which has loads of awesome little features and pre-made layouts to help kick-start your next admin panel, CMS, or CRM system. Keep up the good work!</b> </p>
                                    <div class="username"><b>Nick Stanbridge<br/><small class="text-danger"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></small></b></div>
                                </div>
                                <div class="item">
                                    <p class="testimonial-text"><b class="font-500">This front-end templates are very nice, very suitable for my background to do now, provide a lot of components for my use. Customer service is also very patient, very good, did not download the success of the beginning, and later also help me download finished, it is worth!</b> </p>
                                    <div class="username"><b>Shinwu Ch<br/><small class="text-danger"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></small></b></div>
                                </div>
                                <div class="item">
                                    <p class="testimonial-text"><b class="font-500">in my opinion, Truck App Admin is a professional light-weight theme that will suit multiple projects types including MVC web-projects & dashboard-type user interface. I am yet to take a deep dive into the many features it offers. But from a first-hand experience, I would say it is really worth the money you pay for it… Go ahead & give it a try</b> </p>
                                    <div class="username"><b>Mohammed Shameem<br/><small class="text-danger"><i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i></small></b></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Call to action bar -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12 call-to-action bg-success">
                        <div class="fix-width">
                            <div class="row">
                                <div class="col-md-6 m-t-20 m-b-20"><span>Are you Satisfied with what we Offer?</span></div>
                                <div class="col-md-6 align-self-center text-right"><a href="https://wrappixel.com/templates/adminpro/" target="_blank" class="btn btn-outline btn-rounded btn-default buy-btn m-t-10 m-b-10">Buy Truck App admin </a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
                @endsection
   
</body>

</html>