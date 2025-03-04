<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #002855;
            padding-bottom: 20px;
        }

        .company-info {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #002855;
        }

        .evaluation-result {
            background-color: #e8f4ff;
            padding: 15px;
            margin: 20px 0;
            border: 2px solid #002855;
            text-align: center;
            font-weight: bold;
            font-size: 1.1em;
        }

        .requirements-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .requirements-table th,
        .requirements-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .requirements-table th {
            background-color: #002855;
            color: white;
        }

        .status {
            font-weight: bold;
        }

        .status.approved {
            color: green;
        }

        .status.pending {
            color: orange;
        }

        .signatures {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>SISTEMA DE LA INTEGRACIÓN CENTROAMERICANA</h1>
    <h2>Consejo de Ministros de Salud de Centroamérica y República Dominicana</h2>
    <h3>Secretaría Ejecutiva del COMISCA</h3>
    <h4>FICHA DE EVALUACIÓN TÉCNICA</h4>
</div>

<div class="company-info">
    <h3>Información de la Compañía</h3>
    <p><strong>Nombre:</strong> {{$applicationsData->legal_name}}.</p>
    <p><strong>Dirección:</strong> {{$applicationsData->address}},{{$applicationsData->city}},
        {{$applicationsData->country}}</p>
    <p><strong>Persona de contacto:</strong> {{$applicationsData->first_name}} {{$applicationsData->last_name}}</p>
    <p><strong>Tipo participante:</strong> DISTRIBUIDOR/REPRESENTANTE</p>
    <p><strong>Teléfono:</strong> {{$applicationsData->phone}}</p>
    <p><strong>E-mail:</strong> {{$applicationsData->email}}</p>
</div>

<div class="product-info">
    <h3>Información del Producto</h3>
    <p><strong>Código:</strong> {{$applicationsData->cod_medicamento}}</p>
    <p><strong>Producto:</strong> {{$applicationsData->descripcion}}</p>
    <p><strong>Id Aplicación:</strong> {{$applicationsData->id}}</p>
    <p><strong>Fecha:</strong> {{$applicationsData->created_at}}</p>
</div>

<div class="evaluation-result">
    EL RESULTADO DE LA EVALUACIÓN TÉCNICA ES: @if($applicationsData->calification_tec == 1)
        PRECALIFICADO
    @else
        NO PRECALIFICADO
    @endif
</div>
@if(!empty($dataApplication))
    @foreach ($dataApplication as $grupo => $items)
        <h3>    {{ $grupo }}</h3>
        <h3>REQUISITOS ADMINISTRATIVOS-LEGALES</h3>
        <table class="requirements-table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cumple</th>
                <th>Observación</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)

                <tr>
                    <td>{{ $item->codigo }} </td>
                    <td>{{ $item->descripcion }}</td>
                    <td class="status approved">
                        @if($item->states_req_applications == 1)
                            SI
                        @elseif($item->states_req_applications == 0)
                            NO
                        @else
                            N/A
                        @endif

                    </td>
                    <td></td>
                </tr>
            @endforeach
            <!-- Agregar más requisitos -->
            </tbody>
        </table>
    @endforeach
@endif


<!-- Sección de firmas -->
<div class="signatures">
    <p>_________________________</p>
    <p>Lic. Mauricio Bermúdez 123</p>
    <p>Representante de El Salvador</p>

    <p>_________________________</p>
    <p>Lic. Pastora de Martínez</p>
    <p>Representante de El Salvador</p>
</div>
</body>
</html>
