<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <title>@lang('User register')</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../img/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 1-column  navbar-sticky footer-static bg-full-screen-image  blank-page blank-page" data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- register section starts -->
                <section class="row flexbox-container">
                    <div class="col-xl-8 col-10">
                        <div class="card bg-authentication mb-0">
                            <div class="row m-0">
                                <!-- register section left -->
                                <div class="col-md-6 col-12 px-0">
                                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                                        <div class="card-header pb-1">
                                            <div class="card-title">
                                                <h4 class="text-center mb-2">@lang('Sign up')</h4>
                                            </div>
                                            <div class="text-center">
                                                <h6>@lang('Please enter your details to sign up ir order to get support from our great Work Team!')</h6>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <form method="POST" action="register">
                                                    @csrf
                                                    <!-- DUI and Phone number -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600" for="dui">DUI</label>
                                                            <input type="number" class="form-control" id="dui" placeholder="9 Dígitos sin guiones" name="dui" value="{{ old('dui') }}">
                                                        </div>
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600" for="phonenumber">@lang('Phone Number')</label>
                                                            <input type="number" class="form-control" id="phonenumber" name="phone_number" value="{{ old('phone_number') }}">
                                                        </div>
                                                    </div>
                                                    <!-- Name -->
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600" for="name">@lang('Name')</label>
                                                        <input type="text" class="form-control" id="name" placeholder="Firstname and second name" name="name" value='{{ old('name') }}'>
                                                        {!! $errors->first('name', '<small>:message</small><br>') !!}
                                                    </div>
                                                    <!-- Email address -->
                                                    <div class="form-group mb-50">
                                                        <label class="text-bold-600" for="exampleInputEmail1">@lang('Email address')</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email address"name="email" value='{{ old('email') }}'>
                                                        {!! $errors->first('email', '<small>:message</small><br>') !!}
                                                    </div>
                                                    <!-- NIT and NRC -->
                                                    <div class="form-row">
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600" for="nit">NIT</label>
                                                            <input type="number" class="form-control" id="nit" placeholder="14 dígitos sin guiones" name="nit" value='{{ old('nit') }}'>
                                                        </div>
                                                        <div class="form-group col-md-6 mb-50">
                                                            <label class="text-bold-600" for="nrc">NRC</label>
                                                            <input type="number" class="form-control" id="nrc" placeholder="7 dígitos sin guiones"name="nrc" value='{{ old('nrc') }}'>
                                                        </div>
                                                    </div>
                                                    <!-- Password -->
                                                    <div class="form-group mb-2">
                                                        <label class="text-bold-600" for="exampleInputPassword1">@lang('Password')</label>
                                                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                                                        {!! $errors->first('password', '<small>:message</small><br>') !!}
                                                    </div>
                                                    <!-- Password confirmation -->
                                                    <div class="form-group mb-2">
                                                        <label class="text-bold-600" for="password_confirmation">@lang('Password confirmation')</label>
                                                        <input type="password" class="form-control" id="password_confirmation" placeholder="Password confirmation" name="password_confirmation">
                                                        {!! $errors->first('password_confirmation', '<small>:message</small><br>') !!}
                                                    </div>
                                                    <!-- Submit -->
                                                    <button type="submit" class="btn btn-primary glow position-relative w-100">@lang('SIGN UP')<i id="icon-arrow" class="bx bx-right-arrow-alt"></i></button>
                                                </form>
                                                <hr>
                                                <div class="text-center">
                                                    <small class="mr-25">@lang('Already have an account?')</small>
                                                    <a href="{{ Route('forestLogin') }}">
                                                        <small>@lang('Sign in')</small>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- image section right -->
                                <div class="col-md-6 d-md-block d-none text-center align-self-center p-1">
                                    <img class="img-fluid" src="../../../app-assets/images/logo/logoWh.png" alt="Binder welcome screen">
                                    <h4>Binder</h4>
                                    <small>Standart version</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- register section endss -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js"></script>
    <script src="../../../app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    <script src="../../../app-assets/js/scripts/footer.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <!-- END: Page JS-->

</body>
<!-- END: Body-->
</html>