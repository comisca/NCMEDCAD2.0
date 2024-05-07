</div>
<div class="modal-footer">
    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>

    @if($idSelecte == 0 && $addInstitucion == null)
        <button wire:click="create()" class="btn btn-primary" type="button">Guardar</button>
    @elseif($idSelecte != 0 && $addInstitucion == null)
        <button wire:click="update()" class="btn btn-primary" type="button">Actualizar</button>
    @elseif($idSelecte == 0 && $addInstitucion != null)
        <button wire:click="createBeneficiario()" class="btn btn-primary" type="button">Guardar</button>
    @endif
</div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

