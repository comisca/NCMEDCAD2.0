<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a href="{{url('index')}}" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/escudo.png')}}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/COMISCA_SICA.png')}}" alt="" height="30">
            </span>
        </a>

        <a href="{{url('index')}}" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('assets/images/escudo.png')}}" alt="" height="25">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('assets/images/COMISCA_SICA.png')}}" alt="" height="30">
            </span>
        </a>
    </div>

    <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect vertical-menu-btn">
        <i class="fa fa-fw fa-bars"></i>
    </button>

    <div data-simplebar class="sidebar-menu-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">@lang('translation.Menu')</li>

                <li>
                    <a href="{{url('principal')}}">
                        <i class="uil-home-alt"></i>
                        <span>@lang('translation.Principal')</span>
                    </a>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-padlock"></i>
                        <span>@lang('translation.Seguridad')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="layouts-horizontal">@lang('translation.Opcion 1')</a></li>
                        <li><a href="layouts-dark-sidebar">@lang('translation.Opcion 2')</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="uil-padlock"></i>
                        <span>@lang('translation.Administración')</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{url('/instituciones')}}">@lang('translation.Registro de Instituciones')</a></li>
                        <li><a href="layouts-dark-sidebar">@lang('translation.Catálogo de Productos')</a></li>
                    </ul>
                </li>

                

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->