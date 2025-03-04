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
                    <a href="#">
                        <i class="uil-home-alt"></i>
                        <span>@lang('translation.Principal')</span>
                    </a>
                </li>

                @if(Session::has('id_user'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-padlock"></i>
                            <span>Seguridad</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="/roles">Roles</a></li>
                            <li><a href="/permisos">Permisos</a></li>
                            <li><a href="/asignar">Asignar Permisos</a></li>
                            <li><a href="/usuarios">Usuarios</a></li>
                        </ul>
                    </li>
                @endif
                @if(Session::has('id_company'))
                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-padlock"></i>
                            <span>Administracion</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/fichatecnica')}}">Creacion de Aplicacion</a></li>

                            <li><a href="{{url('/precalificacion/company/recepcion')}}">Recepcion Documentos</a></li>
                            <li><a href="{{url('/precalificacion/company/tecnica')}}">Precalificacion Tecnica</a></li>
                            <li><a href="{{url('/precalificacion/company/admin')}}">Precalificacion
                                    Administrativa</a></li>
                            {{--                            <li><a href="{{url('/precalificacion/company/admin')}}">Precalificacion--}}
                            {{--                                    Administrativa</a></li>--}}
                            <li><a href="/subastas">Eventos</a></li>
                        </ul>

                    </li>
                @endif
                @if(Session::has('id_user'))

                    <li>
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="uil-padlock"></i>
                            <span>Administracion</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            {{--                            <li><a href="{{url('/registerDistribuidor')}}">Registro de empresas</a></li>--}}
                            <li><a href="{{url('/families/products')}}">Categoria</a></li>
                            <li><a href="{{url('/family/group')}}">Sub-Categoria</a></li>
                            <li><a href="{{url('/rquisitos/group')}}">Requisitos por Categoria</a></li>
                            <li><a href="{{url('/requisitos')}}">Catalogo de Requisitos</a></li>

                            <li><a href="{{url('/medicamentos')}}">Catalogo de Productos</a></li>
                            <li><a href="{{url('/configuracion/ficha/tecnica')}}">Configuracion de Ficha
                                    Tecnica</a></li>
                            <li><a href="{{url('/configuracion/ficha/admin')}}">Configuracion de Ficha
                                    Administrativa</a></li>


                            {{--                        <li><a href="{{url('/instituciones')}}">@lang('translation.Registro de Instituciones')</a></li>--}}



                            {{--                        <li><a href="{{url('/fichatecnica')}}">Creacion de Aplicacion</a></li>--}}
                        </ul>
                    </li>
                    <li>
                        <a href="javascript: void(0);" cl ass="has-arrow waves-effect">
                            <i class="uil-padlock"></i>
                            <span>Procesos</span>
                        </a>
                        <ul class="sub-menu" aria-expanded="false">
                            <li><a href="{{url('/listCompany')}}">Solicitudes de Pre-Registro</a></li>
                            <li><a href="/recepcion/doc/list">Recepcion de Documentos</a></li>
                            {{--                            <li><a href="{{url('/registerDistribuidor')}}">Registro de empresas</a></li>--}}
                            <li><a href="/pre/calificacion/tecnica">Precalificacion Tecnica</a></li>
                            <li><a href="/pre/calificacion/Administrativas">Precalificacion Administrativa</a></li>

                            <li><a href="/event/config">Configuracion Evento</a></li>
                            <li><a href="/send/auctions">Configuracion Subasta</a></li>
                            <li><a href="/subastas">Eventos</a></li>

                            {{--                        <li><a href="{{url('/fichatecnica')}}">Creacion de Aplicacion</a></li>--}}
                        </ul>
                    </li>

                @endif


            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
