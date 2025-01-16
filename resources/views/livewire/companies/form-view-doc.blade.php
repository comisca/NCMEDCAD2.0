<div class="modal fade bs-example-modal-lg" tabindex="-1" wire:ignore.self id="modalViewDocModal" role="dialog"
     aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                {{--                <h5 class="modal-title mt-0" id="exampleModalScrollableTitle">{{__('actions.search')}}</h5>--}}
                {{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
                {{--                    <span aria-hidden="true">&times;</span>--}}
                {{--                </button>--}}
            </div>
            <div class="modal-body">
                <div>

                    @if(!empty($docGlobalView))
                        <iframe src="{{Storage::url('document/companies/'.$docGlobalView->attachment)}}" width="100%"
                                height="600px"></iframe>
                    @endif
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>


            </div>
        </div>
    </div>
</div>
