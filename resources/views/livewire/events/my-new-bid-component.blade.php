<div class="col-md-4">
    <div class="card">
        <div class="card-header">Mis Ofertas</div>
        <div class="card-body">
            <table class="table">
                <thead>
                <tr>
                    <th>ID ANONIMO</th>
                    <th>ENVIADA</th>
                    <th>VALOR</th>
                </tr>
                </thead>
                <tbody>
                @if(!empty($varNewMyBid))
                    @foreach($varNewMyBid as $itemsMyBid)
                        <tr>
                            <td>{{ $itemsMyBid->code_postor }}</td>
                            <td>{{ $itemsMyBid->puja_time }}</td>
                            <td>{{ $itemsMyBid->amount }}</td>
                        </tr>
                    @endforeach

                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
