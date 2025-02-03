@section('title')
    @lang('NCMEDCAD | Tiitle')
@endsection
<div class="container-fluid">

    <div class="row">

        <div class="col-md-4">
            <div class="card stret">
                <div class="card-body">
                    <div>
                        <span>Evento:</span>
                        <span>{{$auction->event_name}}</span>
                    </div>
                    <div>z
                        <span>Estado:</span>
                        <span>Programada</span>
                    </div>
                    @if(Session::has('id_company'))
                        <div>
                            <span>Participantes:</span>
                            <span>{{$namePostor}}</span>
                        </div>
                    @endif
                    <div>
                        <span>Duracion de subasta:</span>
                        <span>{{$auction->duration_time}}</span>
                    </div>
                    @if($auction->type_auction == 'Inversa')
                        <div>
                            <span>Tiempo de recuperacion:</span>
                            <span>{{$auction->recovery_time}}</span>
                        </div>
                    @endif
                    <div>
                        <span>Inicio:</span>
                        <span class="badge">{{$auction->date_start}} {{$auction->hour_start}}</span>
                    </div>
                    @if($auction->type_auction == 'Inversa')
                        <div>
                            <span>Porcentaje de descuento:</span>
                            <span class="badge">{{$auction->porcentage_reductions}} %</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div>
                        <span>Codigo:</span>
                        <span class="badge">{{$productEventData->cod_medicamento}}</span>
                    </div>
                    <div>
                        <span>Descripcion:</span>
                        <span>{{$productEventData->descripcion}}</span>
                    </div>
                    <div>
                        <span>Cantidad de subasta:</span>
                        <span class="badge">{{$auction->total}}</span>
                    </div>
                    <div>
                        <span>Precio de referencia:</span>
                        <span class="badge">${{$auction->price_reference}}</span>
                    </div>
                </div>
            </div>
        </div>
        {{--        <livewire:aution-timer-component :timeLeft="$timeLeft"--}}
        {{--                                         :key="'auction-timer-' . $auction->id"></livewire:aution-timer-component>--}}

        <div>
            <div
                x-data=" timer({{ $remainingTime }}, {{ $isRecoveryPeriod ? 'true' : 'false' }},
             {{ $auction->recovery_time }})
        "
                x-init="startTimer()"
                wire:ignore
            >
                <div
                    class="countdown"
                    :class="{ 'text-danger': isRecoveryPeriod }"
                >
                    <span x-text="formatTime(remainingTime)"></span>
                </div>

                <div
                    x-show="isRecoveryPeriod"
                    x-transition
                    class="alert alert-warning mt-2"
                >
                    ¡Período de recuperación activo! Cualquier puja reiniciará el contador a <span
                        x-text="recoveryTimeMinutes"></span> minutos.
                </div>
            </div>
        </div>


    </div>

    <div class="row mt-4">
        <livewire:bid-history-component :bidsAuction="$auction"
                                        :key="'bid-history-' . $auction->id"></livewire:bid-history-component>

        @if(Session::has('id_company'))

            <livewire:minimum-bid-component :auction="$auction" :idPosdor="$IdPostor" :idAnonimo="$IdAnonimo"
                                            :key="'bid-form-' . $auction->id"></livewire:minimum-bid-component>
        @endif
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
                        {{--                        @if(!empty($bids))--}}
                        {{--                            @foreach($bids as $bid)--}}
                        {{--                                <tr>--}}
                        {{--                                    <td>{{ $bid->code_postor }}</td>--}}
                        {{--                                    <td>{{ $bid->puja_time }}</td>--}}
                        {{--                                    <td>{{ $bid->amount }}</td>--}}
                        {{--                                </tr>--}}
                        {{--                            @endforeach--}}

                        {{--                        @endif--}}
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

                {{--window.Echo.channel('auctionEndTimer.{{ $auction->id }}')--}}
                {{--    .listen('AuctionEnded', (e) => {--}}

                {{--    });--}}
                // Corregir el listener del AuctionEnded
                window.Echo.channel('auctionEndTimer.{{ $auction->id }}')
                    .listen('AuctionEnded', (e) => {
                        // Mostrar el Sweet Alert directamente con los datos del evento
                        Swal.fire({
                            icon: e.icon,
                            title: e.title,
                            text: e.text
                        }).then((result) => {
                            // Opcional: recargar la página después de cerrar el alert
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    });


            } else {
                console.error('Echo no está inicializado');
            }
        });


        // Definir la función timer fuera del DOMContentLoaded
        function timer(initialTime, initialRecoveryStatus, recoveryTimeMinutes) {
            return {
                remainingTime: initialTime,
                isRecoveryPeriod: initialRecoveryStatus,
                recoveryTimeMinutes: recoveryTimeMinutes,
                timerInterval: null,

                startTimer() {
                    // Si el tiempo inicial es 0, no iniciamos el contador
                    if (this.remainingTime <= 0) {
                        this.remainingTime = 0;
                        return;
                    }

                    window.Echo.channel('auction.{{ $auction->id }}')
                        .listen('.TimerUpdate', (e) => {
                            this.remainingTime = e.remainingTime;
                            this.isRecoveryPeriod = e.isRecoveryPeriod;
                        })
                        .listen('NewPuja', (e) => {
                            if (this.remainingTime <= (this.recoveryTimeMinutes * 60)) {
                                this.remainingTime = this.recoveryTimeMinutes * 60;
                                this.isRecoveryPeriod = true;
                                const event = new CustomEvent('timer-reset', {
                                    detail: {remainingTime: this.remainingTime}
                                });
                                window.dispatchEvent(event);
                            }
                        });

                    window.addEventListener('timer-reset', (e) => {
                        this.remainingTime = e.detail.remainingTime;
                        this.isRecoveryPeriod = true;
                    });

                    this.timerInterval = setInterval(() => {
                        if (this.remainingTime > 0) {
                            this.remainingTime--;
                            this.isRecoveryPeriod = this.remainingTime <= (this.recoveryTimeMinutes * 60);
                        } else {
                            clearInterval(this.timerInterval);
                            // Livewire.dispatch('endAuction');
                            location.reload()
                        }
                    }, 1000);
                },

                formatTime(seconds) {
                    if (seconds <= 0) return '00:00';
                    const minutes = Math.floor(seconds / 60);
                    const remainingSeconds = seconds % 60;
                    return `${String(minutes).padStart(2, '0')}:${String(remainingSeconds).padStart(2, '0')}`;
                }
            }
        }
    </script>
    <script>
        document.addEventListener('livewire:initialized', () => {
            {{--if (window.Echo) {--}}
            {{--    window.Echo.channel('auctionEndTimer.{{ $auction->id }}')--}}
            {{--        .listen('AuctionEnded', (e) => {--}}
            {{--            Livewire.on('swal', data => {--}}
            {{--                Swal.fire({--}}
            {{--                    icon: e.icon,--}}
            {{--                    title: e.title,--}}
            {{--                    text: e.text--}}
            {{--                });--}}
            {{--            });--}}
            {{--        });--}}


            {{--} else {--}}
            {{--    console.error('Echo no está inicializado');--}}
            {{--}--}}

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
