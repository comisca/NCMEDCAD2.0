<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalCreateEvents" role="dialog"
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
                    <label for="inputNameCompany">Año del evento</label>
                    <select id="inputState" wire:model="yearsInput"
                            class="form-control @error('yearsInput') is-invalid @enderror">
                        <option selected>Selecciona un Año</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                        <option value="2027">2027</option>
                        <option value="2028">2028</option>

                    </select>
                    @error('yearsInput')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>

                <div class="form-group col-md-6">
                    <label for="inputNameCompany">Familia de productos</label>
                    <select id="inputState" wire:model="familySelecte"
                            class="form-control @error('familySelecte') is-invalid @enderror">
                        <option selected>Selecciona una Familia de productos</option>
                        @if(!empty($familyData))
                            @foreach($familyData as $family)

                                <option value="{{$family->id}}">{{$family->familia_producto}}</option>
                            @endforeach
                        @endif


                    </select>
                    @error('familySelecte')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


                <div class="col-md-12">
                    <label for="exampleInputEmail1" class="form-label">Nombre del Evento</label>
                    <textarea wire:model="nameEvent"
                              class="form-control @error('nameEvent') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('nameEvent')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="exampleInputEmail1" class="form-label">Observacion</label>
                    <textarea wire:model="observationEvent"
                              class="form-control @error('observationEvent') is-invalid @enderror"
                              rows="3"></textarea>
                    @error('observationEvent')
                    <span class="text-danger">{{$message}}</span>
                    @enderror
                </div>


            </div>
            <div class="modal-footer">
                <button wire:click="create()" type="button" class="btn btn-primary">Guardar Cambio
                </button>
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
