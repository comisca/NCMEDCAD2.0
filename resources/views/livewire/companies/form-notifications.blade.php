<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalSendNotifications" role="dialog"
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
                <div class="col-md-12">
                    <label for="exampleInputEmail1" class="form-label">Mensaje de Notidicacion</label>
                    <textarea wire:model="messagesSendsAplications"
                              class="form-control @error('messagesSendsAplications') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('messagesSendsAplications')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <button wire:click="sendSendApplicationModal()" type="button" class="btn btn-primary">Guardar Cambio
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Cerrar</button>


            </div>
        </div>
    </div>
</div>
