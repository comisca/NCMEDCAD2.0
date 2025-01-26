<div class="col-md-4">

    <div class="card">
        <div class="card-header">Panel de Puja</div>
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
                <!-- Filas de la tabla -->
                @if(!empty($bids))
                    @foreach($bids as $bid)
                        <tr>
                            <td>{{ $bid->code_postor }}</td>
                            <td>{{ $bid->puja_time }}</td>
                            <td>{{ $bid->amount }}</td>
                        </tr>
                    @endforeach

                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
