<div class="col-md-4">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.Echo) {
                window.Echo.channel('auction.2')
                    .listen('NewPuja', (e) => {
                        Livewire.dispatch('newBid');
                    });
            } else {
                console.error('Echo no está inicializado');
            }
        });
    </script>
@endsection
