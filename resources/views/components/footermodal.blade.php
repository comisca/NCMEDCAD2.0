</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

    @if($idSelecte == 0)
        <button wire:click="create()" class="btn btn-primary" type="button">Guardar</button>
    @else
        <button wire:click="update()" class="btn btn-primary" type="button">Actualizar</button>

    @endif
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
