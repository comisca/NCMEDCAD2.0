<div>
@include('livewire.settings.formsearch')

@section('script')
    <script>
        document.addEventListener('livewire:initialized', function () {
            console.log('estoy inicializando desde el buscador');

            @this.
            on('open-modal', (event) => {
                console.log('estoy llegando al copmponente de busqueda')
                // $('#searchInput').focus();
                document.getElementById('searchInputs').focus();
              $('#modalUniversalfullwith').modal('show');



            })


        });

    </script>
@endsection
</div>
