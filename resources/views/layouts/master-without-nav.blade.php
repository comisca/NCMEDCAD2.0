<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <link rel="stylesheet" href="{{ asset('css/login.css')}}">
        @include('layouts.title-meta')
        @include('layouts.head')
  </head>
            
    <body class="authentication-bg">
        @yield('content')
        @include('layouts.vendor-scripts')
        
        <!--DISEÑO DE LOGIN -->
        <section class="vh-100">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-6 text-black">

                  <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
          
                    <form style="width: 23rem;">

                     <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Log in</h3>
        
                      <div data-mdb-input-init class="form-outline mb-4">
                        <input type="email" id="#" class="form-control form-control-lg" />
                        <label class="form-label" for="#">Usuario</label>
                      </div>
          
                      <div data-mdb-input-init class="form-outline mb-4">
                        <input type="password" id="form2Example28" class="form-control form-control-lg" />
                        <label class="form-label" for="form2Example28">Contraseña</label>
                      </div>
          
                      <div class="pt-1 mb-4">
                        <button data-mdb-button-init data-mdb-ripple-init class="btn btn-info btn-lg btn-block" type="button">Entrar</button>
                      </div>
          
                      <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">¿Olvidó su contraseña?</a></p>
                      <p>¿No tienes una cuenta? <a onclick="showDialog()" href="#!" class="link-info">Regístrese aquí</a></p>
          
                    </form>

                    
          
                  </div>
          
                </div>
                <div class="col-sm-4 px-0 d-none d-sm-block" style="text-align: justify;">
                  <p>SINERPGIA, es la plataforma informática que apoya de manera integrada todo el proceso de Negociación Regional de Precios gestionado por la SE-COMISCA. Esta plataforma está compuesta por los siguientes componentes:</p>
                  <p><strong> 1. Registro de empresas participantes y sus productos.</strong> Este componente gestiona toda la información de las empresas proveedoras y de los productos con los que participan en nuestro proceso de negociación.</p>
                  <p><strong>2. Precalificación empresas y sus productos.</strong> Gestiona todo el proceso de evaluación administrativa-legal de las empresas, y técnica de sus productos.</p>
                  <p><strong>3.  Negociación de precios.</strong> Este componente automatiza el proceso de negociación de precios en sus dos modalidades: Subasta inversa y Negociación directa.
                </p>
                </div>
              </div>
            </div>
            <dialog id="registroDialog">
                <a class="btn btn-outline-primary" href="#" role="button">FABRICANTE</a>
                <a class="btn btn-outline-secondary" href="#" role="button">DISTRIBUIDOR/REPRESENTANTE</a>
                <br>
                <button id="hide2" onclick="closeDialog()">Cerrar</button>
                </dialog> 
          </section>
          
        <script>
            function showDialog(){
                var dialog2 = document.getElementById('registroDialog');
                dialog2.show();
            }
            function closeDialog(){
                var dialog2 = document.getElementById('registroDialog');
                dialog2.close();
            }
        </script>
    </body>