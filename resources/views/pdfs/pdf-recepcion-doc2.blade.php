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

        .product-info {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #002855;
        }

        .section-title {
            background-color: #002855;
            color: white;
            padding: 10px;
            margin-top: 20px;
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
            background-color: #f5f5f5;
        }

        .validation-type {
            font-weight: bold;
            color: #002855;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>SISTEMA DE LA INTEGRACIÓN CENTROAMERICANA</h1>
    <h2>Consejo de Ministros de Salud de Centroamérica y República Dominicana</h2>
    <h3>Secretaría Ejecutiva del COMISCA</h3>
    <h4>FICHA DE REQUISITOS POR PRODUCTO</h4>
</div>

<div class="product-info">
    <h3>Producto: {{$dataApplicant->descripcion}}</h3>
    <p><strong>Código:</strong> {{$dataApplicant->cod_medicamento}}</p>
</div>

@if(!empty($dataRequiurementsD))
    @foreach ($dataRequiurementsD as $grupo => $items)
        <div class="section-title">  {{ $grupo }}</div>

        <table class="requirements-table">
            <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Tipo validación</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($items as $item)
                <tr>
                    <td>{{ $item->codigo }}</td>
                    <td>{{ $item->descripcion }}</td>
                    <td class="validation-type">
                        @if($item->states_req_applications  < 6)
                            Recibido/Conforme
                        @elseif($item->states_req_applications  == 10)
                            Pendiente de revision
                        @elseif($item->states_req_applications  == 9)
                            Observacion
                        @endif
                    </td>
                </tr>
            @endforeach
            <!-- Continuar con el resto de requisitos técnicos -->
            </tbody>
        </table>

    @endforeach
@endif

</body>
</html>
