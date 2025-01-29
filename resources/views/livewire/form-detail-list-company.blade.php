<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalDetailCompany" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- ... header ... -->
            <div class="modal-body">
                <table class="table align-middle mb-0 bg-white">
                    <thead class="bg-light">
                    <tr>
                        <th>Documento</th>
                        <th>Nombre del archivo</th>
                        <th>Fecha de Creacion</th>
                        <th>Detalles</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($documentDataDetail))
                        @foreach($documentDataDetail as $itemsDocuments)
                            <tr>
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
                                    <p class="fw-normal mb-1">
                                        {{$itemsDocuments->created_at}}
                                    </p>
                                </td>
                                <td>
                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm btn-rounded"
                                        onclick="viewPdf('{{Storage::url('document/companies/'.$itemsDocuments->attachment)}}')"
                                    >
                                        Ver detalle
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
