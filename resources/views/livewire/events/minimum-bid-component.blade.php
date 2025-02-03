<div class="col-md-4">
    {{--    <div class="card">--}}
    {{--        <div class="card-header">Panel de Oferta</div>--}}
    {{--        <div class="card-body">--}}
    {{--            <p>Última Oferta recibida (U$$): <span id="ultima-oferta">--}}
    {{--                    @if(!empty($lasBidData))--}}
    {{--                        {{ number_format($lasBidData->amount, 6) }}--}}
    {{--                    @else--}}
    {{--                        0.000000--}}
    {{--                    @endif--}}

    {{--                </span></p>--}}
    {{--            <p>Rebaja minima para la siguiente oferta (U$$): <span id="rebaja">{{$reductionAmount}}</span></p>--}}
    {{--            <p>Próxima oferta minima valida (U$$): <span id="proxima">{{ number_format($maxAmount, 6) }}</span></p>--}}
    {{--            <div class="input-group">--}}
    {{--                <input type="number" class="form-control"--}}
    {{--                       max="{{ $maxAmount }}"--}}
    {{--                       step="0.01"--}}
    {{--                       placeholder="Ingrese su puja" wire:model="bidAmount">--}}
    {{--                @error('bidAmount')--}}
    {{--                <span class="text-danger">{{ $message }}</span>--}}
    {{--                @enderror--}}
    {{--                <div class="input-group-append">--}}
    {{--                    <button wire:click="placeBid()" class="btn btn-success">ENVIAR</button>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="card">
        <div class="card-header">Panel de Oferta</div>
        <div class="card-body">
            @if($auction->type_auction === 'Inversa')
                <p>Última Oferta recibida (U$$):
                    <span id="ultima-oferta">
                    @if(!empty($lasBidData))
                            {{ number_format($lasBidData->amount, 6) }}
                        @else
                            0.000000
                        @endif
                </span>
                </p>
                <p>Rebaja minima para la siguiente oferta (U$$):
                    <span id="rebaja">{{$reductionAmount}}</span>
                </p>
            @else
                <p>Precio de Referencia (U$$):
                    <span>{{ number_format($auction->price_reference, 6) }}</span>
                </p>
                <p>Porcentaje de Tolerancia:
                    <span>{{ $auction->porcentage_tolerance }}%</span>
                </p>
                <p>Pujas restantes:
                    <span>{{ $remainingBids }}</span>
                </p>
            @endif

            <p>{{ $auction->type_auction === 'Inversa' ? 'Próxima oferta minima valida' : 'Oferta máxima permitida' }}
                (U$$):
                <span id="proxima">{{ number_format($maxAmount, 6) }}</span>
            </p>

            <div class="input-group">
                <input type="number"
                       wire:model="bidAmount"
                       class="form-control"
                       step="0.01"
                       placeholder="Ingrese su puja"
                       @if($auction->type_auction === 'Inversa')
                           max="{{ $maxAmount }}"
                       @endif
                       @if($auction->type_auction === 'Directa' && $remainingBids <= 0)
                           disabled
                    @endif
                >
                @error('bidAmount')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="input-group-append">
                    <button wire:click="placeBid()"
                            class="btn btn-success"
                            @if($auction->type_auction === 'Directa' && $remainingBids <= 0)
                                disabled
                        @endif
                    >ENVIAR
                    </button>
                </div>
            </div>

            @if($auction->type_auction === 'Directa')
                <div class="mt-2">
                    <p>Pujas restantes: {{ $remainingBids }}</p>
                </div>
            @endif
        </div>
    </div>
</div>
