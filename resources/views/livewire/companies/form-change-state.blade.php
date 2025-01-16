<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalChangeState" role="dialog"
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
                    <label for="exampleInputEmail1" class="form-label">Mensaje de Observacion</label>
                    <textarea wire:model="messagesSends"
                              class="form-control @error('messagesSends') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('messagesSends')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-12">
                    <label for="inputNameCompany">Estado de Requisitos</label>
                    <select id="inputState" wire:model="selectStates"
                            class="form-control @error('selectStates') is-invalid @enderror">
                        <option selected>Selecciona un estado</option>
                        <option value="9">Observacion</option>
                        <option value="5">Recibido</option>

                    </select>
                    @error('selectStates')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <button wire:click="chageStateRequeriment()" type="button" class="btn btn-primary">Guardar Cambio
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
