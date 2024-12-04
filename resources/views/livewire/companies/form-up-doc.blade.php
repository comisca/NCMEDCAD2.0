<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalUpDoct" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {{--                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">{{__('actions.search')}}</h5>--}}
                {{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--                    <span aria-hidden="true">&times;</span>--}}
                {{--                </button>--}}
            </div>

            <div class="form-group col-12">
                <label for="inputNameCompany">Nombre del Documento</label>
                <input wire:model="nameDoc" type="text"
                       class="form-control @error('nameDoc') is-invalid @enderror" id="inputAddress"
                       placeholder="Registro Publico">
                @error('nameDoc')
                <span class="text-danger">{{$message}}</span>
                @enderror
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="exampleInputEmail1" class="form-label">Descripcion del documento</label>
                    <textarea wire:model="descriptionDoc"
                              class="form-control @error('descriptionDoc') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('descriptionDoc')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-12">
                    <label for="inputNameCompany">Seleccionar Archivo</label>
                    <input wire:model="docFile" type="file"
                           class="form-control @error('docFile') is-invalid @enderror" id="inputAddress"
                    >
                    @error('docFile')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="createDocUp()" type="button" class="btn btn-primary">Guardar Archivo</button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
