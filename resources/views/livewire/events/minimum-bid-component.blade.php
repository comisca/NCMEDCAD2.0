<div class="col-md-4">
    <div class="card">
        <div class="card-header">Panel de Oferta</div>
        <div class="card-body">
            <p>Última Oferta recibida (U$$): <span id="ultima-oferta">
                    @if(!empty($lasBidData))
                        {{ number_format($lasBidData->amount, 6) }}
                    @else
                        0.000000
                    @endif

                </span></p>
            <p>Rebaja minima para la siguiente oferta (U$$): <span id="rebaja">{{$reductionAmount}}</span></p>
            <p>Próxima oferta minima valida (U$$): <span id="proxima">{{ number_format($maxAmount, 6) }}</span></p>
            <div class="input-group">
                <input type="number" class="form-control"
                       max="{{ $maxAmount }}"
                       step="0.01"
                       placeholder="Ingrese su puja" wire:model="bidAmount">
                @error('bidAmount')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                <div class="input-group-append">
                    <button wire:click="placeBid()" class="btn btn-success">ENVIAR</button>
                </div>
            </div>
        </div>
    </div>
</div>
