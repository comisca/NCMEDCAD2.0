{{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous"> --}}
<div class="modal fade bs-example-modal-xl" wire:ignore.self id="modalDetailGroup" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">Grupos Asignados</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


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
                            <th scope="col">Grupo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col" style="width: 200px;">{{__('actions.action')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($dataGroup))

                            @foreach($dataGroup as $groupitems)
                                <tr>
                                    {{--                                <th scope="row">--}}
                                    {{--                                    <div class="custom-control custom-checkbox">--}}
                                    {{--                                        <input type="checkbox" class="custom-control-input" id="contacusercheck1">--}}
                                    {{--                                        <label class="custom-control-label" for="contacusercheck1"></label>--}}
                                    {{--                                    </div>--}}
                                    {{--                                </th>--}}
                                    <td>
                                        {{--                                    <img src="{{ URL::asset('assets/images/users/avatar-2.jpg')}}" alt="" class="avatar-xs rounded-circle mr-2">--}}
                                        <a href="#" class="text-body">{{ $groupitems->id }}</a>
                                    </td>
                                    <td>{{ $groupitems->grupo }}</td>
                                    <td>{{ $groupitems->descripcion }}</td>

                                    <td>
                                        <ul class="list-inline mb-0">
                                            {{--                                            <li class="list-inline-item">--}}
                                            {{--                                                <a href="#" wire:click="addGroups({{$groupitems->id}})"--}}
                                            {{--                                                   class="px-2 text-primary" data-toggle="tooltip" data-placement="top"--}}
                                            {{--                                                   title="Agregar Grupos"><i--}}
                                            {{--                                                        class="bx bx-plus font-size-18"></i></a>--}}
                                            {{--                                            </li>--}}
                                            <li class="list-inline-item">
                                                <a href="javascript:void(0);" onclick="confirm({{ $groupitems->id }})"
                                                   class="px-2 text-success" data-toggle="tooltip" data-placement="top"
                                                   title="Eliminar"><i
                                                        class="bx bx-trash font-size-18"></i></a>
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

                </div>


                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                        crossorigin="anonymous"></script>


            </div>
            <div class="modal-footer">

                <button type="button" class="btn bg-primary">SALIR</button>


            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
