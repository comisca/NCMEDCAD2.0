<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalAddPostor" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                {{--                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">{{__('actions.search')}}</h5>--}}
                {{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--                    <span aria-hidden="true">&times;</span>--}}
                {{--                </button>--}}
            </div>

            <div class="modal-body">


                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Buscar Postor</label>
                    <input type="search" wire:model="searchQuerty" class="form-control" placeholder="Buscar Postor">
                    @error('selectedType')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-md-12">
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
                                <th scope="col">Participante</th>
                                <th scope="col">Fabricante</th>
                                <th scope="col">Aplicacion</th>
                                <th scope="col">Estado de Aplicacion</th>
                                <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($dataAplication))

                                @foreach($dataAplication as $itemsPostor)
                                    <tr>
                                        <th scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="contacusercheck1">
                                                <label class="custom-control-label" for="contacusercheck1"></label>
                                            </div>
                                        </th>
                                        <td>

                                            <a href="#" class="text-body">{{ $itemsPostor->id_application }}</a>
                                        </td>
                                        <td>{{ $itemsPostor->distribution_first_name }}</td>
                                        <td>{{ $itemsPostor->fabric_first_name }}</td>
                                        <td>{{ $itemsPostor->trade_name }}</td>
                                        <td>
                                            @if($itemsPostor->status_application == 10)
                                                <span class="badge badge-success">Precalificado</span>
                                            @else
                                                <span class="badge badge-danger">Con Observacion</span>
                                            @endif
                                        </td>

                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="#"
                                                       wire:click="addProductsEvents({{$itemsPostor->id_postor}})"
                                                       class="px-2 text-primary" data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="Agregar Productos"><i
                                                            class="uil uil-plus font-size-18"></i></a>
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
            <div class="modal-footer">
                <button wire:click="addProducts()" type="button" class="btn btn-primary">Guardar Cambio
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
