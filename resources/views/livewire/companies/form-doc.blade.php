<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalDocApplications" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                            <th>Documento</th>
                            <th>Nombre del archivo</th>
                            <th>Detalles</th>

                        </tr>
                        </thead>
                        <tbody>

                        @if(!empty($docDatas))
                            @foreach($docDatas as $itemsDocuments)

                                <tr wire:key="{{ $itemsDocuments->id}}">
                                    <td>
                                        <div class="d-flex align-items-center">

                                            <div class="ms-3">
                                                <p class="fw-bold mb-1">{{ $itemsDocuments->document_name }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="fw-normal mb-1">
                                            {{$itemsDocuments->attachment}}
                                        </p>
                                    </td>

                                    <td>
                                        <button wire:click="viewDocAdm({{$itemsDocuments->id}})" type="button"
                                                class="btn btn-link btn-sm
                        btn-rounded">
                                            Ver detalle
                                        </button>
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
