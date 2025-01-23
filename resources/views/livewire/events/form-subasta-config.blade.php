<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalConfigSubasta" role="dialog"
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
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="inputNameCompany">Modalidad de Negociacion</label>
                        <select id="inputState" wire:model.live="typeSubasta"
                                class="form-control @error('typeSubasta') is-invalid @enderror">
                            <option selected>Selecciona una modalidad</option>
                            <option value="Inversa">Negociacion Inversa</option>
                            <option value="Directa">Negociacion Directa</option>
                            <option value="Paquetes">Negociacion Por Paquetes</option>

                        </select>
                        @error('typeSubasta')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Descripcion:</label>
                        <textarea disabled wire:model="productSubasta"
                                  class="form-control @error('messagesSends') is-invalid @enderror"
                                  rows="3"></textarea>
                        @error('productSubasta')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Id. Negociacion</label>
                        <input type="text" class="form-control" wire:model="idSubasta" disabled>
                        @error('selectStates')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Codigo</label>
                        <input type="text" class="form-control" wire:model="codProducts" disabled>
                        @error('codProducts')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Cantidad a Negociar</label>
                        <input type="text" class="form-control" wire:model="qtyProducts" disabled>
                        @error('qtyProducts')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Precio Referencia</label>
                        <input type="text" class="form-control" wire:model="priceRef">
                        @error('codProducts')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Fecha de Inicio</label>
                        <input type="date" class="form-control" wire:model="dateStart">
                        @error('dateStart')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Hora de Inicio</label>
                        <input type="time" class="form-control" wire:model="timeStart">
                        @error('timeStart')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="inputNameCompany">Tiempo Duracion (Minutos)</label>
                        <input type="text" class="form-control" wire:model="timeDuration">
                        @error('timeDuration')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        @if($typeSubasta == 'Inversa')
                            <label for="inputNameCompany">Porcentaje Rebaja(%)</label>
                        @elseif($typeSubasta == 'Directa')
                            <label for="inputNameCompany">Porcentaje De Tolerancia(%)</label>
                        @else
                            <label for="inputNameCompany">Porcentaje Rebaja(%)</label>
                        @endif
                        <input type="text" class="form-control" wire:model="porcReduce">
                        @error('porcReduce')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                    @if($typeSubasta == 'Inversa')
                        <div class="form-group col-md-6">
                            <label for="inputNameCompany">Tiempo de recuperacion(Minutos)</label>
                            <input type="text" class="form-control" wire:model="timeRecovery">
                            @error('timeRecovery')
                            <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                    @endif

                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Observacion de Subasta:</label>
                        <textarea wire:model="observacionSubasta"
                                  class="form-control @error('observacionSubasta') is-invalid @enderror"
                                  rows="3"></textarea>
                        @error('observacionSubasta')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="createAuctions()" type="button" class="btn btn-primary">Guardar Cambio
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
