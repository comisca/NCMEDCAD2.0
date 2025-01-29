{{--<div class="btn-group" role="group">--}}
{{--    <button type="button" class="btn btn-info btn-sm"--}}
{{--            onclick="window.location.href='{{ route('companies.show', $id) }}'"--}}
{{--            title="Ver">--}}
{{--        <i class="fas fa-eye"></i>--}}
{{--    </button>--}}

{{--    <button type="button" class="btn btn-primary btn-sm"--}}
{{--            onclick="window.location.href='{{ route('companies.edit', $id) }}'"--}}
{{--            title="Editar">--}}
{{--        <i class="fas fa-edit"></i>--}}
{{--    </button>--}}

{{--    <button type="button" class="btn btn-danger btn-sm"--}}
{{--            onclick="deleteCompany({{ $id }})"--}}
{{--            title="Eliminar">--}}
{{--        <i class="fas fa-trash"></i>--}}
{{--    </button>--}}
{{--</div>--}}


<div class="btn-group" role="group">
    <button type="button" class="btn btn-info btn-sm"
            onclick="window.location.href='#'"
            title="Ver">
        <i class="fas fa-eye"></i>
    </button>

    <button type="button" class="btn btn-primary btn-sm"
            onclick="window.location.href='#'"
            title="Editar">
        <i class="fas fa-edit"></i>
    </button>

    <button type="button" class="btn btn-danger btn-sm"
            onclick="deleteCompany({{ $id }})"
            title="Eliminar">
        <i class="fas fa-trash"></i>
    </button>
</div>
