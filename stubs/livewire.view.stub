@section('title') @lang('NCMEDCAD | Oficina Virtual') @endsection

@section('content')
    @component('common-components.breadcrumb')
        @slot('pagetitle') NCMEDCAD @endslot
        @slot('title') Officina Virtual @endslot
    @endcomponent




@endsection
@section('script')
    <!-- apexcharts -->
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/dashboard.init.js')}}"></script>
    <script>
        document.addEventListener('livewire:initialized', function () {

            @this.
            on('message-exito', (event) => {

                new bs5.Toast({
                    header: `
    		<svg width="24" height="24" class="text-success me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    		</svg>
    		<h6 class="mb-0">Exito!</h6>
    		<small class="ms-auto">Ahora...</small>
    		`,
                    body: event.messages,
                    className: 'border-0 bg-primary text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            })

            @this.on('centers-exito', (event) => {

                new bs5.Toast({
                    header: `
    		<svg width="24" height="24" class="text-success me-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    			<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
    		</svg>
    		<h6 class="mb-0">Exito!</h6>
    		<small class="ms-auto">Ahora...</small>
    		`,
                    body: event.messages,
                    className: 'border-0 bg-primary text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            })

            @this.on('addcenters-error', (event) => {
                new bs5.Toast({
                    body: event.messages,
                    className: 'border-0 bg-danger text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            })

            @this.on('message-error', (event) => {
                new bs5.Toast({
                    body: event.messages,
                    className: 'border-0 bg-danger text-white',
                    btnCloseWhite: true,
                    placement: 'bottom-right',
                }).show()
            })



        });

        function confirm(id) {
            Swal.fire({
                title: 'Eliminar Usuario?',
                text: "Estas seguro de eliminar este Usuario?",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar'
            }).then((result) => {

                if (result.value) {
                    Livewire.dispatch('deletedata', {postId: id})
                    swal.close();
                }
            });

        }

        function confirmCenterD(id) {
            Livewire.dispatch('deleteCenterDelete', {idCenterD: id})
        }
    </script>
@endsection
