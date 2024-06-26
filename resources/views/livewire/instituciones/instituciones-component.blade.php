@section('title') @lang('NCMEDCAD | Tiitle') @endsection
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="button-items">
                        <button type="button" id="modalusers" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#modalUniversal">
                            <i class="fa fa-user-o"></i> Adicionar
                        </button>
                    
                        
                    </div>  
                    <div class="col-md-3">

                        {{-- <div class="mb-3">
                            @if($idSelecte > 0)
                                <a href="#" wire:click="update" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> {{__('actions.update')}}</a>
                            @else
                                <a href="#" wire:click="create" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> {{ __('actions.save') }}</a>
                            @endif

                        </div> --}}
                    </div>
                    
                    <div class="col-md-3">
                        <select wire:model="searchPais" class="custom-select custom-select-lg mb-3">
                            <option selected>Buscar Pais</option>
                            @foreach ($dataPaises as $item)
                                    <option value="{{$item->id_pais}}">{{$item->pais}}</option>
                                @endforeach
                            
                          </select>
                    </div>
                    <div class="col-md-3">
                        <div class="form-inline float-md-right mb-3">
                            <div class="search-box ml-2">
                                <div class="position-relative">
                                    <input type="text" wire:model.live="searchQuety" class="form-control rounded bg-light border-0" placeholder="{{__('actions.search')}} Roles">
                                    <i class="mdi mdi-magnify search-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end row -->
                <div class="table-responsive">
                    <table id="instituciones" class="table table-bordered dt-responsive nowrap"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Institución</th>
                                <th scope="col">País</th>
                                <th scope="col" style="width: 200px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!empty($data))

                            @foreach($data as $items)
                                <tr>
    
                                    <td>
                                        <a href="#" class="text-body">{{ $items->id }}</a>
                                    </td>
                                    <td wire:click="setBeneficiario({{$items->id}})">{{ $items->institucion }}</td>
                                    <td wire:click="setBeneficiario({{$items->id}})">{{$items->paises->pais}}</td>
                                    <td>
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                <a href="#" @click="$dispatch('add-beneficiario',{id:{{$items->id}}})" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Agregar Institución"><i class="uil uil-plus-circle font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" wire:click="edit({{$items->id}})" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="{{__('Editar Institución')}}"><i class="uil uil-pen font-size-18"></i></a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" onclick="confirm({{ $items->id }})"  class="px-2 text-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Institución"><i class="uil uil-trash-alt font-size-18"></i></a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>

                    @if(!empty($data))
                        {{ $data->links() }}
                    @endif
                </div>
                @if ($showBeneficiario == true)
                    <div class="table-responsive">
                        <table id="institucionesBeneficiario" class="table table-bordered dt-responsive nowrap"  style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Institución2</th>
                                    <th scope="col">País</th>
                                    <th scope="col" style="width: 200px;">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(!empty($institucionBeneficiaria))

                                @foreach($institucionBeneficiaria as $items)
                                    <tr>
        
                                        <td>
                                            <a href="#" class="text-body">{{ $items->id }}</a>
                                        </td>
                                        <td>{{ $items->institucion }}</td>
                                        <td>{{$items->paises->pais}}</td>
                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="#" wire:click="edit({{$items->id}})" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="{{__('Editar Institución')}}"><i class="uil uil-pen font-size-18"></i></a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <a href="javascript:void(0);" onclick="confirm({{ $items->id }})"  class="px-2 text-danger" data-toggle="tooltip" data-placement="top" title="Eliminar Institución"><i class="uil uil-trash-alt font-size-18"></i></a>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                            </tbody>
                        </table>

                        {{-- @if(!empty($institucionBeneficiaria))
                            {{ $institucionBeneficiaria->links() }}
                        @endif --}}
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('livewire.instituciones.instituciones-create')
    {{-- <livewire:search-universal></livewire:search-universal> --}}
</div>
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('messages-succes', (event) => {
                toastr.success(event.messages, 'Exito',{
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
                // Swal.fire({
                //     position: 'top-end',
                //     icon: 'success',
                //     title: event.messages,
                //     text: "Exito!!",
                //     showConfirmButton: false,
                //     timer: 2500
                // })

            })
            @this.on('messages-error', (event) => {
                toastr.error(event.messages, 'Exito',{
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
            @this.on('institucion-edit', (event) => {
                $('#modalUniversal').modal('show');
            })
            @this.on('message-exito', (event) => {
                $('#modalUniversal').modal('hide');
            
                new bs5.Toast({
                    header: `
                        <svg width="24" height="24" class="text-success me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <h6 class="mb-0">Exito!</h6>
                        <small class="ms-auto">Ahora...</small>
                        `,
                    body: event.messages,
                    className: 'border-0 bg-primary text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            });


        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Institución?',
                text: "Estas seguro de eliminar esta institución?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {
                if (result.value) {
                    Livewire.dispatch('deletedata', {institucionId: id})
                    swal.close();
                }
            });

        }
        var table;
        $(document).ready(function() {


            table = $('#instituciones').DataTable({
                select: true,
                "order": [[ 0, "desc" ]],
                
                language:{url:'https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json'},
                
                //Configuracion Inicial
                    
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'Todos  * ']]
            });
        });
        // function seleccion(id){
		//     var cell=l_Item = table.row(".selected").data()[0];
        // }
        
    </script>
@endsection
