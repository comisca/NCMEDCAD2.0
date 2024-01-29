@include('components.headermodalfullwhit')

<div class="col-md-12">
    <div class="mb-3">
        <div class="position-relative">
            <input type="text" class="form-control" wire:model.live="searchInput" autofocus id="searchInputs" placeholder="@lang('actions.search')...">
{{--            <span class="uil-search"></span>--}}
        </div>
    </div>
</div>

<div class="col-md-12">


        @if(!empty($data))
            @foreach($data as $value)
                <a href="{{$value->route}}" class="text-reset notification-item" data-toggle="tooltip" data-placement="top" title="{{$value->name}}">
        <div class="media mt-4" >
{{--            <div class="avatar-xs mr-3">--}}
{{--                <div class="avatar-title rounded-circle bg-soft-primary text-primary font-size-22">--}}
{{--                    <i class="uil uil-question-circle"></i>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="media-body">
                <h5 class="font-size-16 mt-1">{{$value->name}}</h5>
                <p class="text-muted">{{$value->route}}</p>
                <p class="text-muted">{{$value->description}}</p>
            </div>
         </div>
                </a>
            @endforeach
        @endif



</div>

@include('components.footermodalwith')



