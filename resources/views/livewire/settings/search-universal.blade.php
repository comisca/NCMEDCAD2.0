@include('components.headermodalfullwhit')

<div class="col-md-12">
    <div class="mb-3">
        <div class="position-relative">
            <input type="search"  class="form-control" wire:model.live="searchInput" name="searchInputs"  id="searchInputs" placeholder="@lang('actions.search')...">
            {{--            <span class="uil-search"></span>--}}
        </div>
    </div>
</div>

<div class="col-md-12">



        @foreach($data as $value)

            <a href="{{$value->route}}" class="btn w-100 text-reset notification-item focus-on"  title="{{$value->name}}">
                <div class="media mt-4" >
{{--                                <div class="avatar-xs mr-3">--}}
{{--                                    <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-22">--}}
{{--                                        <i class="uil uil-minus-path"></i>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                    <div class="media-body">
                        <h5 class="font-size-16 mt-1">{{$value->name}}</h5>
                        <p class="text-muted">{{$value->route}}</p>
                        <p class="text-muted">{{$value->description}}</p>
                    </div>
                </div>
            </a>


        @endforeach




</div>

@include('components.footermodalwith')

<script>

    document.addEventListener('livewire:initialized', function () {

        @this.
        on('open-modal', (event) => {

            $('#modalUniversalfullwith').modal('show');
            // document.getElementById('searchInputs').focus();
            $("#searchInput").focus();


        })

        $("#modalUniversalfullwith").on('shown.bs.modal', function(){
            $("#searchInput").focus();
        })


    });

</script>

