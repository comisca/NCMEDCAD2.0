@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div class="container-fluid">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="row">

        <div class="col-md-4">
            <div class="card stret">
                <div class="card-body">
                    <div>
                        <span>Evento:</span>
                        <span>EVENTO DE NEGOCIACION DE PRECIOS N 02-2000 - SESIONES DE PRUEBA</span>
                    </div>
                    <div>
                        <span>Estado:</span>
                        <span>Programada</span>
                    </div>
                    <div>
                        <span>Participantes:</span>
                        <span>Participante TEST</span>
                    </div>
                    <div>
                        <span>Duracion de subasta:</span>
                        <span>25 Minutos</span>
                    </div>
                    <div>
                        <span>Tiempo de recuperacion:</span>
                        <span>4 minutos</span>
                    </div>
                    <div>
                        <span>Inicio:</span>
                        <span class="badge">20/08/2024 07:00 PM</span>
                    </div>
                    <div>
                        <span>Porcentaje de descuento:</span>
                        <span class="badge">20/08/2024 07:00 PM</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div>
                        <span>Codigo:</span>
                        <span class="badge">CTSM-FT-05-66</span>
                    </div>
                    <div>
                        <span>Descripcion:</span>
                        <span>Desatinb 1000mg Tableta recubierta, blister o foil o frasco 30 tabletas</span>
                    </div>
                    <div>
                        <span>Cantidad de subasta:</span>
                        <span class="badge">100,000</span>
                    </div>
                    <div>
                        <span>Precio de referencia:</span>
                        <span class="badge">$0.9000</span>
                    </div>
                </div>
            </div>
        </div>
        <livewire:aution-timer-component :timeLeft="$timeLeft"
                                         :key="'auction-timer-' . $auction->id"></livewire:aution-timer-component>

    </div>

    <div class="row mt-4">
        <livewire:bid-history-component :bidsAuction="$auction"
                                        :key="'bid-history-' . $auction->id"></livewire:bid-history-component>

        <livewire:minimum-bid-component :auction="$auction" :idPosdor="$IdPostor" :idAnonimo="$IdAnonimo"
                                        :key="'bid-form-' . $auction->id"></livewire:minimum-bid-component>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Mis Ofertas</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID ANONIMO</th>
                            <th>ENVIADA</th>
                            <th>VALOR</th>
                        </tr>
                        </thead>
                        <tbody>
                        <!-- Filas de la tabla -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.channel('auction.{{ $auction->id }}')
                    .listen('NewPuja', (e) => {
                        Livewire.dispatch('newBid');
                        Livewire.dispatch('updateMinumusBid');
                    });
            } else {
                console.error('Echo no está inicializado');
            }
        });
    </script>
@endsection
<!-- apexcharts -->
{{--    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>--}}
{{--    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>--}}
{{--    <script>--}}
{{--        document.addEventListener('livewire:initialized', function () {--}}
{{--            @this.--}}
{{--            on('messages-succes', (event) => {--}}
{{--                toastr.success(event.messages, 'Exito', {--}}
{{--                    "closeButton": true,--}}
{{--                    "debug": false,--}}
{{--                    "newestOnTop": false,--}}
{{--                    "progressBar": false,--}}
{{--                    "positionClass": "toast-bottom-full-width",--}}
{{--                    "preventDuplicates": false,--}}
{{--                    "onclick": null,--}}
{{--                    "showDuration": 300,--}}
{{--                    "hideDuration": 1000,--}}
{{--                    "timeOut": 5000,--}}
{{--                    "extendedTimeOut": 1000,--}}
{{--                    "showEasing": "swing",--}}
{{--                    "hideEasing": "linear",--}}
{{--                    "showMethod": "fadeIn",--}}
{{--                    "hideMethod": "fadeOut"--}}
{{--                })--}}
{{--                // Swal.fire({--}}
{{--                //     position: 'top-end',--}}
{{--                //     icon: 'success',--}}
{{--                //     title: event.messages,--}}
{{--                //     text: "Exito!!",--}}
{{--                //     showConfirmButton: false,--}}
{{--                //     timer: 2500--}}
{{--                // })--}}

{{--            })--}}
{{--            @this.on('messages-error', (event) => {--}}
{{--                toastr.error(event.messages, 'Exito', {--}}
{{--                    "closeButton": true,--}}
{{--                    "debug": false,--}}
{{--                    "newestOnTop": false,--}}
{{--                    "progressBar": false,--}}
{{--                    "positionClass": "toast-bottom-full-width",--}}
{{--                    "preventDuplicates": false,--}}
{{--                    "onclick": null,--}}
{{--                    "showDuration": 300,--}}
{{--                    "hideDuration": 1000,--}}
{{--                    "timeOut": 5000,--}}
{{--                    "extendedTimeOut": 1000,--}}
{{--                    "showEasing": "swing",--}}
{{--                    "hideEasing": "linear",--}}
{{--                    "showMethod": "fadeIn",--}}
{{--                    "hideMethod": "fadeOut"--}}
{{--                })--}}
{{--            })--}}

{{--            @this.on('roles-selected', (event) => {--}}
{{--                document.getElementById("roles").focus();--}}

{{--            })--}}

{{--        });--}}

{{--        function confirm(id) {--}}
{{--            Swal.fire({--}}
{{--                title: 'Eliminar Rol?',--}}
{{--                text: "Estas seguro de eliminar este rol?",--}}
{{--                type: 'question',--}}
{{--                showCancelButton: true,--}}
{{--                confirmButtonColor: '#3085d6',--}}
{{--                cancelButtonColor: '#d33',--}}
{{--                confirmButtonText: 'Si, Eliminar!',--}}
{{--                cancelButtonText: 'No, Cancelar'--}}
{{--            }).then((result) => {--}}
{{--                if (result.value) {--}}
{{--                    Livewire.dispatch('deleteroles', {postId: id})--}}
{{--                    swal.close();--}}
{{--                }--}}
{{--            });--}}

{{--        }--}}
{{--    </script>--}}

{{--    <script>--}}
{{--        let totalTime = 180; // Tiempo total en segundos (3 minutos)--}}
{{--        const timeDisplay = document.getElementById('time-display');--}}
{{--        const progressCircle = document.getElementById('progress-circle');--}}

{{--        const updateProgress = () => {--}}
{{--            totalTime--;--}}

{{--            const minutes = Math.floor(totalTime / 60);--}}
{{--            const seconds = totalTime % 60;--}}

{{--            timeDisplay.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;--}}

{{--            if (totalTime > 120) {--}}
{{--                progressCircle.style.background = 'conic-gradient(#4caf50 0%, #4caf50 calc((180 - ' + totalTime + ') / 180 * 100%), #ddd calc((180 - ' + totalTime + ') / 180 * 100%), #ddd 100%)';--}}
{{--            } else if (totalTime > 30) {--}}
{{--                progressCircle.style.background = 'conic-gradient(#ff9800 0%, #ff9800 calc((180 - ' + totalTime + ') / 180 * 100%), #ddd calc((180 - ' + totalTime + ') / 180 * 100%), #ddd 100%)';--}}
{{--            } else {--}}
{{--                progressCircle.style.background = 'conic-gradient(#f44336 0%, #f44336 calc((180 - ' + totalTime + ') / 180 * 100%), #ddd calc((180 - ' + totalTime + ') / 180 * 100%), #ddd 100%)';--}}
{{--            }--}}

{{--            if (totalTime > 0) {--}}
{{--                setTimeout(updateProgress, 1000);--}}
{{--            }--}}
{{--        };--}}

{{--        setTimeout(updateProgress, 1000);--}}
{{--    </script>--}}
