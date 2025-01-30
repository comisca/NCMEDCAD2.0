<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalNeedesInstitutions" role="dialog"
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


                {{--                <div class="form-group col-md-6">--}}
                {{--                    <label for="inputNameCompany">Buscar Postor</label>--}}
                {{--                    <input type="search" wire:model="searchQuerty" class="form-control" placeholder="Buscar Postor">--}}
                {{--                    @error('selectedType')--}}
                {{--                    <span class="text-danger">{{$message}}</span>--}}
                {{--                    @enderror--}}
                {{--                </div>--}}
                <div class="row">
                    <div class="form-group col-md-6">
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
                                    <th scope="col">Pais</th>
                                    <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($countriesData))

                                    @foreach($countriesData as $itemsCountry)
                                        <tr>
                                            <th scope="row">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           id="contacusercheck1">
                                                    <label class="custom-control-label" for="contacusercheck1"></label>
                                                </div>
                                            </th>
                                            <td>

                                                <a href="#" class="text-body">{{ $itemsCountry->id }}</a>
                                            </td>
                                            <td wire:click="viewsInstituteCountry({{$itemsCountry->id}})">{{ $itemsCountry->name }}</td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#"
                                                           wire:click="viewIntitutions({{$itemsCountry->id}})"
                                                           class="px-2 text-primary" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="Agregar Productos"><i
                                                                class="uil uil-plus font-size-18"></i></a>
                                                    </li>
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

                    <div class="form-group col-md-6">
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
                                    <th scope="col">Intituciones</th>
                                    <th scope="col">Total</th>
                                    <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($instotutionCountryData))

                                    @foreach($instotutionCountryData as $itemsInstituteViews)
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
                                                   class="text-body">{{ $itemsInstituteViews->id_intitute_country }}</a>
                                            </td>
                                            <td>{{ $itemsInstituteViews->name_institution }}</td>
                                            <td>{{ $itemsInstituteViews->qty }}</td>
                                            <td>
                                                <ul class="list-inline mb-0">
                                                    <li class="list-inline-item">
                                                        <a href="#"
                                                           wire:click="addPostorMethod({{$itemsInstituteViews->id_intitute_country}})"
                                                           class="px-2 text-danger" data-toggle="tooltip"
                                                           data-placement="top"
                                                           title="Eliminar Necesidades"><i
                                                                class="uil uil-trash font-size-18"></i></a>
                                                    </li>
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
            <div class="modal-footer">

                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
