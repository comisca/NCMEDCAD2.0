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
        <div class="container">
          <div class="row">
            <div class="col-sm-12" style="text-align: center">
                <h5 style="background-color: darkcyan" >Secretaría Ejecutiva del Consejo de Ministros de salud de Centroamérica y República Diminicana (SE-COMISCA)</h5>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <img src="" alt="Imagen de sinergia">
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <form>
                <h6 style="text-align: center">LOGIN</h6>
                <div class="form-group">
                  <label for="exampleInputEmail1">Usuario</label>
                  <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">contraseña</label>
                  <input type="password" class="form-control" id="exampleInputPassword1">
                </div>
                      <p><a class="text-muted" href="#">¿Olvidó su contraseña?</a></p>
                      <button type="submit" class="btn btn-primary">Entrar</button>
                      <p>¿No tienes una cuenta? <a onclick="showDialog()" href="#!" class="link-info">Regístrese aquí</a></p>
              </form>
            </div>
            <div class="col-sm-6" style="justify-content:">
                  <p>SINERPGIA, es la plataforma informática que apoya de manera integrada todo el proceso de Negociación Regional de Precios gestionado por la SE-COMISCA. Esta plataforma está compuesta por los siguientes componentes:</p>
                  <p><strong> 1. Registro de empresas participantes y sus productos.</strong> Este componente gestiona toda la información de las empresas proveedoras y de los productos con los que participan en nuestro proceso de negociación.</p>
                  <p><strong>2. Precalificación empresas y sus productos.</strong> Gestiona todo el proceso de evaluación administrativa-legal de las empresas, y técnica de sus productos.</p>
                  <p><strong>3.  Negociación de precios.</strong> Este componente automatiza el proceso de negociación de precios en sus dos modalidades: Subasta inversa y Negociación directa.
            </div>
            
          </div>
          <!--Ultimo DIV)-->
          <dialog id="registroDialog">
            <a class="btn btn-outline-primary" href="#" role="button">FABRICANTE</a>
            <a class="btn btn-outline-secondary" href="#" role="button">DISTRIBUIDOR/REPRESENTANTE</a>
            <br>
            <button id="hide2" onclick="closeDialog()">Cerrar</button>
            </dialog> 
        </div>
          <!--FIN DE DISEÑO-->

          
       
       
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