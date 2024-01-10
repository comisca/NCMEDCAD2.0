@section('title') @lang('NCMEDCAD | Roles') @endsection


{{--    @component('common-components.breadcrumb')--}}
{{--        @slot('pagetitle') NCMEDCAD @endslot--}}
{{--        @slot('title') Officina Virtual @endslot--}}
{{--    @endcomponent--}}


    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input type="text" class="form-control rounded bg-light border-0" wire:model="roles" placeholder="Escribe un nuevo rol">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <input type="text" class="form-control rounded bg-light border-0" wire:model="descripcion" placeholder="Escribe una descripcion">
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="mb-3">
                                @if($idSelecte > 0)
                                    <a href="#" wire:click="update" class="btn btn-primary waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> Actualizar Rol</a>
                                @else
                                    <a href="#" wire:click="create" class="btn btn-success waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i> Guardar Rol</a>
                                @endif

                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-inline float-md-right mb-3">
                                <div class="search-box ml-2">
                                    <div class="position-relative">
                                        <input type="text" wire:model.live="searchQuety" class="form-control rounded bg-light border-0" placeholder="Buscar roles...">
                                        <i class="mdi mdi-magnify search-icon"></i>
                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <!-- end row -->
                    <div class="table-responsive mb-4">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead>
                            <tr>
{{--                                <th scope="col" style="width: 50px;">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input type="checkbox" class="custom-control-input" id="contacusercheck">--}}
{{--                                        <label class="custom-control-label" for="contacusercheck"></label>--}}
{{--                                    </div>--}}
{{--                                </th>--}}
                                <th scope="col">ID</th>
                                <th scope="col">ROL</th>
                                <th scope="col">DESCRIPCIÓN DE ROL</th>
                                <th scope="col" style="width: 200px;">ACCIONES</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($data))

                                @foreach($data as $permisoitems)
                            <tr>
{{--                                <th scope="row">--}}
{{--                                    <div class="custom-control custom-checkbox">--}}
{{--                                        <input type="checkbox" class="custom-control-input" id="contacusercheck1">--}}
{{--                                        <label class="custom-control-label" for="contacusercheck1"></label>--}}
{{--                                    </div>--}}
{{--                                </th>--}}
                                <td>
{{--                                    <img src="{{ URL::asset('assets/images/users/avatar-2.jpg')}}" alt="" class="avatar-xs rounded-circle mr-2">--}}
                                    <a href="#" class="text-body">{{ $permisoitems->id }}</a>
                                </td>
                                <td>{{ $permisoitems->name }}</td>
                                <td>{{ $permisoitems->descriptions }}</td>

                                <td>
                                    <ul class="list-inline mb-0">
                                        <li class="list-inline-item">
                                            <a href="#" wire:click="editRoles({{$permisoitems->id}})" class="px-2 text-primary" data-toggle="tooltip" data-placement="top" title="Edit"><i class="uil uil-pen font-size-18"></i></a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="javascript:void(0);" onclick="confirm({{ $permisoitems->id }})"  class="px-2 text-danger" data-toggle="tooltip" data-placement="top" title="Delete"><i class="uil uil-trash-alt font-size-18"></i></a>
                                        </li>
{{--                                        <li class="list-inline-item dropdown">--}}
{{--                                            <a class="text-muted dropdown-toggle font-size-18 px-2" onclick="confirm({{ $permisoitems->id }})" href="#" role="button" data-toggle="dropdown" aria-haspopup="true">--}}
{{--                                                <i class="uil uil-ellipsis-v"></i>--}}
{{--                                            </a>--}}

{{--                                            <div class="dropdown-menu dropdown-menu-right">--}}
{{--                                                <a class="dropdown-item" href="#">Action</a>--}}
{{--                                                <a class="dropdown-item" href="#">Another action</a>--}}
{{--                                                <a class="dropdown-item" href="#">Something else here</a>--}}
{{--                                            </div>--}}
{{--                                        </li>--}}
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

                </div>
            </div>
        </div>
    </div>



@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script src="https://unpkg.com/bs5-toast/dist/bs5-toast.js"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {
            @this.
            on('roles-added', (event) => {
                // $('#add_users').modal('hide');
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: event.messages,
                    text: "Exito!!",
                    showConfirmButton: false,
                    timer: 2500
                })

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
            })
            @this.on('roles-error', (event) => {
                new bs5.Toast({
                    body: event.messages,
                    className: 'border-0 bg-danger text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            })

            @this.on('roles-selected', (event) => {
                document.getElementById("roles").focus();

            })

        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Rol?',
                text: "Estas seguro de eliminar este rol?",
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
