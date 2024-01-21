<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Frest admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Frest admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="BINDER">
    <title>Binder</title>
    <link rel="apple-touch-icon" href="../../../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/animate/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/charts/apexcharts.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/dragula.min.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/datatables.min.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/extensions/dataTables.checkboxes.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap.min.css">-->
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/pickadate/pickadate.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/daterange/daterangepicker.css')}}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/colors.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/components.css')}}">
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">-->
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">-->
    <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/core/menu/menu-types/vertical-menu.css')}}">
    <!--<link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-analytics.css">-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/pages/app-invoice.css')}}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <!-- END: Custom CSS-->

    <!-- BEGIN: Toastr -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/toastr.min.css')}}">
    <!-- END: Toastr -->

    @section('css')
    @show

    <!-- BEGIN: Adicionales personalizadas-->
    
    <!-- END: Adicionales personalizadas-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns  navbar-sticky footer-static pace-done menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top bg-darkblue">
        <div class="navbar-wrapper">
            <div class="navbar-container content" style="padding:0.7rem 0.7rem">
                <div class="navbar-collapse d-flex justify-content-end" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto">
                                <a class="nav-link nav-menu-main menu-toggle hidden-xs" style="padding-left: 0; padding-right:0" href="#">
                                    <i class="ficon bx bx-menu"></i>
                                </a>
                            </li>
                            @if (Auth::guest())
                            @else
                                <li class="nav-item my-auto">
                                    <a class="nav-link" href="{{route('cart.products', auth()->user()->id)}}" data-toggle="tooltip" data-placement="top" title="Catálogo de productos">
                                        <div class="livicon-evo" data-options=" name: home.svg; style: solid; size: 2.8rem; solidColor: #ffc13a; solidColorAction: #dff30c; colorsOnHover: custom; keepStrokeWidthOnResize: true "></div>
                                    </a>
                                </li>
                            @endif
                            <li class="nav-item my-auto">@yield('total')</li>
                        </ul>
                    </div>
                    @if (Auth::guest())
                    @else
                        <ul class="nav navbar-nav d-flex mx-auto">
                            <li class="nav-item">@yield('cliente')</li>
                            <li class="nav-item ml-3">@yield('catalog-switch')</li>
                        </ul>
                        <ul class="nav navbar-nav float-right p-0">
                            <li class="nav-item my-auto">@yield('orden')</li>
                            <li class="dropdown dropdown-user nav-item my-auto">
                                <a class="dropdown-toggle nav-link dropdown-user-link" style="padding:0" href="#" data-toggle="dropdown">
                                    <div class="user-nav d-sm-flex d-none">
                                        <span class="user-name" style="color:rgb(240,240,240) !important;">{{auth()->user()->name}}</span>
                                        <span class="user-status text-muted" style="color:rgb(220,220,220) !important;">
                                            @if(auth()->user()->autoservicio)
                                                @lang('Customer')
                                            @else
                                                @lang('Technical assistant')
                                            @endif
                                        </span>
                                        <span class="user-status" style="color:rgb(220,220,220) !important;">
                                            @if(auth()->user()->autoservicio==1)
                                                @lang('SELF-SERVICE')
                                            @else
                                                @lang('ASSISTED')
                                            @endif
                                             | {{auth()->user()->profile()->branch->branch}}
                                        </span>
                                    </div>
                                    <span>
                                        <i class="livicon-evo badge-rectangle badge-circle-secondary" data-options=" name: user.svg; style: solid; size: 2.8rem; solidColor: #61adfe; solidColorAction: #dff30c; colorsOnHover: custom; keepStrokeWidthOnResize: true "></i>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right pb-0">
                                    @if(auth()->user()->email_verified_at)
                                        {!! profileControlPanel() !!}
                                    @endif
                                    <!-- start logout -->
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">@lang('Logout')</a>
                                    <form id="frm-logout" action="{{ route('logout') }}" method="POST" style="display: none;">
                                      {{ csrf_field() }}
                                    </form>
                                    <!-- end logout -->
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-dark menu-fixed  menu-accordion menu-shadow" data-scroll-to-active="false">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto">
                    @if (Auth::guest())
                    @else
                        <a class="navbar-brand" href="{{route('cart.offers', auth()->user()->id)}}">
                            <div class="brand-logo"></div>
                            <h2 class="brand-text mb-0">Binder</h2>
                        </a>
                    @endif
                </li>
                <li class="nav-item nav-toggle">
                    <a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
                        <i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i>
                        <i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i>
                    </a>
                </li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
                @if (Auth::guest())
                @else
                    @if(auth()->user()->email_verified_at)
                        <!--start: DINAMICAL MENU-->
                        @foreach(auth()->user()->gatheredMenu()->role as $role)
                            <li class="nav-item">
                                <a href="#">
                                    {!!$role->icon!!} <span class="menu-title" data-i18n="Invoice">{{$role->role}}</span>
                                </a>
                                <ul class="menu-content">
                                    @foreach ($role->service as $service)
                                        <li><a href="{!! Route($service->route) !!}">{!! $service->icon !!}<span class=" menu-item" data-i18n="Invoice List">{{$service->service}}</span></a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                        <!--end: DINAMICAL MENU-->
                    @endif
                @endif
                <!--start: SUPPORT-->
                @if (Auth::guest())
                @else
                    <li class="navigation-header">
                        <span>@lang('Support')</span>
                    </li>
                    <li class="nav-item">
                        <a href="#"><div class="livicon-evo" data-options=" name: wrench.svg; style: solid; size: 37px; solidColor: #ffc13a; colorsOnHover: lighter "></div><span class="menu-title" data-i18n="Documentation"></span>
                        </a>
                    </li>
                @endif
                <!--start: SUPPORT-->
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            {{-- <div class="content-header mt-5">
            </div> --}}
            <div class="content-body mt-3">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light font-size-small">
        <p class="clearfix mb-0">
            <div class="float-left ">Binder, El Salvador, 2023</div>
            <div class="float-right ">Desarrollado<i class="bx bx-hive mx-20 font-small-4"></i>por<a href="#" target="_blank">cmpleitez.sv@gmail.com</a></div>
            {{-- <!--begin: WhatsApp Chat-->
            <div class="widget-chat-demo">
                @if (Auth::guest())
                @else
                    {!! whatsappChat() !!}
                @endif
            </div>
            <!--end: WhatsApp Chat--> --}}
            <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button>
        </p>
    </footer>
    <!-- END: Footer-->

    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <script src="{{asset('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.tools.js')}}"></script>
    <script src="{{asset('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.defaults.js')}}"></script>
    <script src="{{asset('app-assets/fonts/LivIconsEvo/js/LivIconsEvo.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js')}}"></script>
    <!--<script src="../../../app-assets/vendors/js/extensions/dragula.min.js"></script>-->

    {{-- <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/picker.time.js')}}"></script> --}}

    <script src="{{asset('app-assets/vendors/js/pickers/pickadate/legacy.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/daterange/moment.min.js')}}"></script>
    {{-- <script src="{{asset('app-assets/vendors/js/pickers/daterange/daterangepicker.js')}}"></script> --}}
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <!--<script src="../../../app-assets/vendors/js/extensions/polyfill.min.js"></script>-->
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/scripts/components.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/footer.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('js/number-input.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/pages/app-invoice.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/modal/components-modal.js')}}"></script>
    <!--<script src="../../../page/lib/owlcarousel/owl.carousel.js"></script>-->
    <!-- END: Page JS-->

    <!-- BEGIN: Toastr JS-->
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <!--<script src="{{asset('js/toastr.js.map')}}"></script>-->
    <script src="{{asset('js/toastr.min.js')}}"></script>
    @toastr_render
    <!-- END: Toastr JS-->

    <!-- BEGIN: Adicionales personalizadas-->
    <script src="{{asset('js/imask.js')}}"></script>
    <!-- END: Adicionales personalizadas-->


    @section('js')
        {{-- puede incluir referencia JS de html hijo --}}
    @show


    @yield('public_reports')
    
</body>
<!-- END: Body-->
</html>