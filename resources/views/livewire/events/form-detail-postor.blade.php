<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalViewPostor" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">Detalles del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">


                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Buscar Postor</label>
                    <input type="search" wire:model="searchQuery" placeholder="Buscar" class="form-control">
                    @error('searchQuery')
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
                                <th scope="col">Proveedor</th>
                                <th scope="col">Cod. Ingreso</th>
                                <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($viewPostorDataVar))

                                @foreach($viewPostorDataVar as $itemViewPostorDataVar)
                                    <tr>
                                        <th scope="row">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                       id="contacusercheck1">
                                                <label class="custom-control-label" for="contacusercheck1"></label>
                                            </div>
                                        </th>
                                        <td>

                                            <a href="#"
                                               class="text-body">{{ $itemViewPostorDataVar->id_postor_event }}</a>
                                        </td>
                                        <td>{{ $itemViewPostorDataVar->legal_name }}</td>
                                        <td>{{ $itemViewPostorDataVar->name_anonimous }}</td>

                                        <td>
                                            <ul class="list-inline mb-0">
                                                <li class="list-inline-item">
                                                    <a href="#"
                                                       wire:click="addProductsEvents({{$itemViewPostorDataVar->id}})"
                                                       class="px-2 text-danger" data-toggle="tooltip"
                                                       data-placement="top"
                                                       title="Eliminar Postor"><i
                                                            class="uil uil-trash font-size-18"></i></a>
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

                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
