@php use Carbon\Carbon; @endphp
@section('title')
    @lang('SINERPGIA | Historial de Subastas')
@endsection



<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">

                <div class="row mb-2">


                    <div class="col-md-12">

                        <div class="form-inline float-md-right mb-3">
                            {{--                            <label for="inputNameCompany">Tipo de Productos</label>--}}
                            <select id="selectedType" wire:model.live="SelecthistoryAuction"
                                    class="form-control @error('SelecthistoryAuction') is-invalid @enderror">
                                <option selected>Seleccion historial</option>
                                <option value="Pendientes">Pendientes</option>
                                <option value="Cerradas">Cerradas</option>
                                <option value="Canceladas">Canceladas</option>
                                <option value="Todo">Mostrar todo</option>


                            </select>
                            @error('SelecthistoryAuction')
                            <span class="text-danger">{{$message}}</span>
                            @enderror

                        </div>
                    </div>


                </div>
                <!-- end row -->
                <div class="table-responsive mb-4">
                    <table class="table table-centered table-nowrap mb-0">
                        <thead>
                        <tr>
                            <th scope="col" style="width: 50px;">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="contacusercheck">
                                    <label class="custom-control-label" for="contacusercheck"></label>
                                </div>
                            </th>
                            <th scope="col">ID</th>
                            <th scope="col">Codigo Producto</th>
                            <th scope="col">Producto</th>
                            <th scope="col">Fecha Programada</th>
                            <th scope="col">Resultado</th>
                            <th scope="col">Acta</th>
                            <th scope="col">Falta</th>
                            <th scope="col" style="width: 200px;">Entrar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($auctionsData))

                            @foreach($auctionsData as $eventItems)
                                <tr>
                                    <th scope="row">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="contacusercheck1">
                                            <label class="custom-control-label" for="contacusercheck1"></label>
                                        </div>
                                    </th>
                                    <td>

                                        <a href="#" class="text-body">{{ $eventItems->auction_id }}</a>
                                    </td>
                                    <td>{{ $eventItems->cod_medic }}</td>
                                    <td>{{ $eventItems->product_name }}</td>
                                    <td>{{ $eventItems->date_start}} - {{$eventItems->hour_start}}</td>
                                    <td>{{ $eventItems->auction_result}} </td>
                                    <td><a href="#"
                                           wire:click="viewPostorData({{$eventItems->id_product_event}})"
                                           class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                           title="Descargar Actas"><i
                                                class="uil uil-cloud-download font-size-24"></i></a></td>
                                    <td><span style="font-size: 24px;
        font-weight: bold;" id="countdown-{{ $eventItems->auction_id }}"></span>

                                        @php
                                            $now = Carbon::now('America/El_Salvador');
                                            $startTime = Carbon::parse("{$eventItems->date_start} {$eventItems->hour_start}", 'America/El_Salvador');
                                            $difference = $now->diffInSeconds($startTime, false);
                                        @endphp

                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                var countdownElement = document.getElementById('countdown-{{ $eventItems->auction_id }}');
                                                var distance = {{ $difference }} * 1000; // Convertir a milisegundos

                                                function updateCountdown() {
                                                    if (distance <= 0) {
                                                        countdownElement.innerHTML = 'Started';
                                                        return;
                                                    }

                                                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                                                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                                                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                                    var countdownText =
                                                        (days > 0 ? days + 'd ' : '') +
                                                        (hours > 0 ? hours + 'h ' : '') +
                                                        (minutes > 0 ? minutes + 'm ' : '') +
                                                        seconds + 's';

                                                    countdownElement.innerHTML = countdownText || 'Started';
                                                }

                                                var countdownInterval = setInterval(function () {
                                                    updateCountdown();
                                                    distance -= 1000;

                                                    if (distance <= 0) {
                                                        clearInterval(countdownInterval);
                                                        countdownElement.innerHTML = 'Started';
                                                    }
                                                }, 1000);
                                            });
                                        </script>
                                        {{--                                        <script>--}}
                                        {{--                                            document.addEventListener('DOMContentLoaded', function () {--}}
                                        {{--                                                var countdownElement = document.getElementById('countdown-{{ $eventItems->auction_id }}');--}}
                                        {{--                                                var startTime = new Date("{{ $eventItems->date_start }} {{ $eventItems->hour_start }}").getTime();--}}

                                        {{--                                                var countdownInterval = setInterval(function () {--}}
                                        {{--                                                    var now = new Date().getTime();--}}
                                        {{--                                                    var distance = startTime - now;--}}

                                        {{--                                                    if (distance < 0) {--}}
                                        {{--                                                        clearInterval(countdownInterval);--}}
                                        {{--                                                        countdownElement.innerHTML = "Started";--}}
                                        {{--                                                    } else {--}}
                                        {{--                                                        var days = Math.floor(distance / (1000 * 60 * 60 * 24));--}}
                                        {{--                                                        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));--}}
                                        {{--                                                        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));--}}
                                        {{--                                                        var seconds = Math.floor((distance % (1000 * 60)) / 1000);--}}

                                        {{--                                                        countdownElement.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";--}}
                                        {{--                                                    }--}}
                                        {{--                                                }, 1000);--}}
                                        {{--                                            });--}}
                                        {{--                                        </script>--}}
                                    </td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#"
                                                   wire:click="viewPostorData({{$eventItems->id_product_event}})"
                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"
                                                   title="Entrar a Negociacion"><i
                                                        class="uil uil-play font-size-24"></i></a>
                                            </li>


                                            {{--                                                                                    <li class="list-inline-item dropdown">--}}
                                            {{--                                                                                        <a class="text-muted dropdown-toggle font-size-18 px-2" onclick="confirm({{ $permisoitems->id }})" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">--}}
                                            {{--                                                                                            <i class="uil uil-ellipsis-v"></i>--}}
                                            {{--                                                                                        </a>--}}

                                            {{--                                                                                        <div class="dropdown-menu dropdown-menu-right">--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Action</a>--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Another action</a>--}}
                                            {{--                                                                                            <a class="dropdown-item" href="#">Something else here</a>--}}
                                            {{--                                                                                        </div>--}}
                                            {{--                                                                                    </li>--}}
                                        </ul>
                                    </td>
                                </tr>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                    @if(!empty($users))
                        {{ $users->links() }}
                    @endif
                </div>

            </div>
        </div>
    </div>


    {{--    @include('livewire.events.form-add-postor')--}}
    {{--    @include('livewire.events.form-detail-postor')--}}
    {{--    @include('livewire.events.form-subasta-config')--}}
    {{--    <livewire:search-universal></livewire:search-universal>--}}

</div>



@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {


            @this.
            on('auctions-create-susses', (event) => {

                $('#modalConfigSubasta').modal('hide');

                toastr.success(event.messages, 'Exito', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })


            })


            @this.on('postor-add_create-susses', (event) => {

                $('#modalAddPostor').modal('hide');

                toastr.success(event.messages, 'Exito', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })


            })

            @this.on('view-postor-data', (event) => {
                $('#modalViewPostor').modal('show');


            })




            @this.on('roles-error', (event) => {
                toastr.error(event.messages, 'Exito', {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-full-width",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": 300,
                    "hideDuration": 1000,
                    "timeOut": 5000,
                    "extendedTimeOut": 1000,
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                })
            })

            @this.on('roles-selected', (event) => {
                document.getElementById("roles").focus();

            })

            @this.on('selectedProductEventDispach', (event) => {
                $('#modalAddPostor').modal('show');

            })

            @this.on('modal-config-subasta', (event) => {
                $('#modalConfigSubasta').modal('show');

            })


            @this.on('modal-detail-products', (event) => {
                $('#modalDetailProducts').modal('show');

            })

        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Usuario?',
                text: "Estas seguro de eliminar este Usuario?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('deleteroles', {postId: id})
                    swal.close();
                }
            });

        }
    </script>

@endsection
