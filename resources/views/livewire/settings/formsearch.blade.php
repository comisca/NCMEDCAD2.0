@include('components.headermodalfullwhit')

<div class="col-md-12">
    <div class="mb-3">
        <div class="position-relative">
            <input type="text" class="form-control" wire:model="searchInput" autofocus id="searchInputs" placeholder="@lang('actions.search')...">
{{--            <span class="uil-search"></span>--}}
        </div>
    </div>
</div>
@include('components.footermodalwith')



