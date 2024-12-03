<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalMessagesCompanies" role="dialog"
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
                    <label for="exampleInputEmail1" class="form-label">Mensaje para enviar</label>
                    <textarea wire:model="messagesSends"
                              class="form-control @error('messagesSends') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('messagesSends')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="changeStateCompany()" type="button" class="btn btn-primary">Realizar Cambio</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
