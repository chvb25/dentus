<!DOCTYPE html>
<html dir="ltr" lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="VillachSoftware">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ URL::to('assets/images/favicon.png') }}">
    <title>DentUS</title>
    <!-- Custom CSS -->
    @yield('custom_css')

    <link href="{{ asset('css/style.min.css') }}" rel="stylesheet">
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        <nav class="navbar top-navbar navbar-expand-md navbar-dark">
            <div class="navbar-header" data-logobg="skin5">
                <!-- This is for the sidebar toggle which is visible on mobile only -->
                <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                <!-- ============================================================== -->
                <!-- Logo -->
                <!-- ============================================================== -->
                <a class="navbar-brand" href="{{ url('main') }}">
                    <!-- Logo icon -->
                    <b class="logo-icon p-l-10">
                        <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                        <!-- Dark Logo icon -->
                        <img src="{{ URL::to('assets/images/logo-icon.png') }}" alt="homepage" class="light-logo" />

                    </b>
                    <!--End Logo icon -->
                    <!-- Logo text -->
                    <span class="logo-text">
                             <!-- dark Logo text -->
                             <img src="{{ URL::to('assets/images/logo-text.png') }}" alt="homepage" class="light-logo" />

                        </span>
                    <!-- Logo icon -->
                    <!-- <b class="logo-icon"> -->
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <!-- <img src="../../assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                    <!-- </b> -->
                    <!--End Logo icon -->
                </a>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Toggle which is visible on mobile only -->
                <!-- ============================================================== -->
                <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
            </div>
            <!-- ============================================================== -->
            <!-- End Logo -->
            <!-- ============================================================== -->
            <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                <!-- ============================================================== -->
                <!-- toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav mr-auto" style="margin: 0 auto;">
                    <li class="nav-item"><span class="client-name">{{ (Session::exists('settings')) ? Session::get('settings')->clinic_name : 'Clinica sin nombre' }}</span></li>
                </ul>
                <!-- ============================================================== -->
                <!-- Right side toggle and nav items -->
                <!-- ============================================================== -->
                <ul class="navbar-nav float-right">
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ URL::to('assets/images/users/1.jpg') }}" alt="user" class="rounded-circle" width="31"></a>
                        <div class="dropdown-menu dropdown-menu-right user-dd animated">
                            <a class="dropdown-item" href="{{ url('/user-view') }}"><i class="ti-user m-r-5 m-l-5"></i> Ver perfil <br> {{ \Auth::user()->name }}</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('/users') }}"><i class="mdi mdi-account-plus m-r-5 m-l-5"></i> Lista de Usuarios</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url('setting') }}"><i class="ti-settings m-r-5 m-l-5"></i> Configuración</a>
                            <a class="dropdown-item" href="{{ url('logout') }}"><i class="fa fa-power-off m-r-5 m-l-5"></i> Cerrar Sesión</a>
                        </div>
                    </li>
                    <!-- ============================================================== -->
                    <!-- User profile and search -->
                    <!-- ============================================================== -->
                </ul>
            </div>
        </nav>
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
        <div class="scroll-sidebar">
            <!-- Sidebar navigation-->
            <nav class="sidebar-nav">
                <ul id="sidebarnav" class="p-t-30">
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-address-card"></i><span class="hide-menu">Pacientes</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ url('patients') }}"><i class="mdi mdi-clipboard-account"></i><span class="hide-menu"> Listado </span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link" href="{{ url('patients/new') }}"><i class="mdi mdi-account-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark has-arrow" href="javascript:void(0)" aria-expanded="false"><i class="far fa-calendar-alt"></i><span class="hide-menu">Citas</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item"><a href="{{ url('appointments') }}" class="sidebar-link"><i class="fas fa-calendar-check"></i><span class="hide-menu"> Listado </span></a></li>
                                <li class="sidebar-item"><a href="{{ url('appointments/new') }}" class="sidebar-link"><i class="fas fa-calendar-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-chart-bubble"></i><span class="hide-menu">Procedimientos</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-vials"></i><span class="hide-menu"> Procesos </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('procedures') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Listado </span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('procedures/new') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-book"></i><span class="hide-menu"> Cotizaciones </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('quotes') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Listado </span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('quotes/new') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-notes-medical"></i><span class="hide-menu"> Tratamientos </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('treatments') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Listado </span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('treatments/new') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-receipt"></i><span class="hide-menu">Cuestionarios</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-clipboard"></i><span class="hide-menu"> Cuetionario </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('test') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Listado </span></a></li>
                                    <li class="sidebar-item"><a href="{{ url('test/new') }}" class="sidebar-link"><i class="mdi mdi-note-plus"></i><span class="hide-menu"> Registrar Nuevo </span></a></li>
                                </ul>
                            </li>
                            <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-clipboard-check "></i><span class="hide-menu"> Resultados </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('questions') }}" class="sidebar-link"><i class="mdi mdi-note-outline"></i><span class="hide-menu"> Listado </span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-blur-linear"></i><span class="hide-menu">Ingresos</span></a>
                        <ul aria-expanded="false" class="collapse  first-level">
                            <li class="sidebar-item"><a href="{{ url('cash') }}" class="sidebar-link"><i class="far fa-money-bill-alt"></i><span class="hide-menu"> Caja </span></a></li>
                            <li class="sidebar-item"><a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-handshake"></i><span class="hide-menu"> Cuentas por cobrar </span></a>
                                <ul aria-expanded="false" class="collapse  second-level">
                                    <li class="sidebar-item"><a href="{{ url('payment_plan') }}" class="sidebar-link"><i class="fas fa-hand-holding-usd"></i><span class="hide-menu"> Cuotas </span></a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <!-- End Sidebar navigation -->
        </div>
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        @yield('content')
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            Todos los derechos reservados por VillachSoftware. Diseñado y desarrollado por <a target="_blank" href="http://villafani.com">VillachSoftware</a>.
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>

<!--Wave Effects -->
<script src="{{ asset('js/waves.js') }}"></script>
<!--Menu sidebar -->
<script src="{{ asset('js/sidebarmenu.js') }}"></script>
<!--Custom JavaScript -->
<script src="{{ asset('js/custom.min.js') }}"></script>
<script src="{{ asset('assets/extra-libs/typeahead/typeahead.js') }}"></script>
@include('layouts.messages')

@yield('custom_scripts')
</body>

</html>
