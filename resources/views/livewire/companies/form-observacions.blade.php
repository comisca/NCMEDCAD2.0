<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalShowObservacion" role="dialog"
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
                <div wire:poll.visible>
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                        <tr>

                            <th>ID</th>
                            <th>Observaciones</th>
                            <th>Fecha</th>

                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($observacionesGlobals))
                            @foreach($observacionesGlobals as $itemsObservacion)

                                <tr wire:key="{{ $itemsObservacion->id}}">
                                    <td>
                                        {{ $itemsObservacion->id}}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $itemsObservacion->message }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $itemsObservacion->created_at}}
                                    </td>


                                </tr>
                                <div>

                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
