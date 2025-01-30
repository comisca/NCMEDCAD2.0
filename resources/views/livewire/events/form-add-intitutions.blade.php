<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalAddIntitutions" role="dialog"
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


                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Institucion</label>
                    <select id="selectedType" wire:model="selectedType"
                            class="form-control @error('selectedType') is-invalid @enderror">
                        <option selected>Selecciona la institucion</option>
                        @if(!empty($instotutionsData))
                            @foreach($instotutionsData as $itemsIntitutions)
                                <option
                                    value="{{$itemsIntitutions->id}}">{{$itemsIntitutions->name_institution}}</option>
                            @endforeach
                        @endif


                    </select>
                    @error('selectedType')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Cantidad de producto</label>
                    <input type="text" class="form-control" wire:model="qtyProductsReferent">
                    @error('qtyProductsReferent')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Precio Referencia</label>
                    <input type="text" class="form-control" wire:model="priceProductReferent">
                    @error('priceProductReferent')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <button wire:click="createIntitutions()" type="button" class="btn btn-primary">Guardar Institucion
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
