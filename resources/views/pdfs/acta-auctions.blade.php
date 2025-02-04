<?php
header('Content-Type: text/html; charset=UTF-8');
?>
    <!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <title>Acta de Negociación</title>
    <style>
        body {
            font-family: helvetica, arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #002855;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 5px 0;
        }

        .header h2 {
            font-size: 14px;
            margin: 5px 0;
        }

        .header h3, .header h4 {
            font-size: 13px;
            margin: 5px 0;
        }

        .title {
            font-size: 14px;
            font-weight: bold;
            margin: 15px 0;
            color: #002855;
        }

        .info-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            background-color: #f9f9f9;
        }

        /* Reemplazo del grid por tabla */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .info-table td {
            width: 50%;
            padding: 5px;
            vertical-align: top;
        }

        /* Tabla de detalles */
        .detail-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }

        .detail-table th,
        .detail-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }

        .detail-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ccc;
            text-align: center;
            font-size: 11px;
        }

        /* Utilidades */
        .text-bold {
            font-weight: bold;
        }

        .signature {
            margin-top: 30px;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>SISTEMA DE LA INTEGRACIÓN CENTROAMERICANA</h1>
    <h2>Consejo de Ministros de Salud de Centroamérica y República Dominicana</h2>
    <h3>Secretaría Ejecutiva del COMISCA</h3>
    <h4>ACTA DEL EVENTO DE NEGOCIACIÓN DE PRECIOS</h4>
</div>

<div class="info-box">
    <table class="info-table">
        <tr>
            <td>
                <span class="text-bold">Evento:</span> {{$actaData->event_name}}<br>
                <span class="text-bold">Sesión No.:</span>{{$actaData->auction_id}}<br>
                <span class="text-bold">Inició:</span> {{$actaData->date_start}} {{$actaData->hour_start}}<br>
                <span class="text-bold">Finalizó:</span> {{$actaData->date_end}}
            </td>
            <td>
                <span class="text-bold">Resultado:</span> {{$actaData->auction_result}}<br>
                <span class="text-bold">Tiempo de duración:</span> {{$actaData->duration_time}} minutos<br>
                <span class="text-bold">Tiempo de recuperación:</span> {{$actaData->recovery_time}} minutos<br>
                <span class="text-bold">Porcentaje de rebaja:</span> {{$actaData->porcentage_reductions}}%
            </td>
        </tr>
    </table>
</div>

<div class="title">Producto Subastado</div>
<div class="info-box">
    <span class="text-bold">Descripción:</span> {{$productData->descripcion}}<br>
    <span class="text-bold">Código:</span> {{$productData->cod_medicamento}}<br>
    <span class="text-bold">Cantidad a subastar:</span> {{ number_format($actaData->total, 0, '', ',')}}<br>
    <span class="text-bold">Precio de referencia:</span> ${{ number_format($actaData->price_reference, 4, '.', ',') }}
    <br>
</div>

<div class="title">Proveedores Invitados</div>
<table class="detail-table">
    <thead>
    <tr>
        <th>Id. Anónimo</th>
        <th>Nombre</th>

    </tr>
    </thead>
    <tbody>
    @foreach($suplierData as $itemSuplier)
        <tr>
            <td>{{$itemSuplier->code_postor}}</td>
            <td>{{$itemSuplier->legal_name}}</td>
        </tr>
    @endforeach
    <!-- Las filas se agregarían dinámicamente -->
    </tbody>
</table>

<div class="title">Detalle de Pujas</div>
<table class="detail-table">
    <thead>
    <tr>
        <th>Id. Anónimo</th>
        <th>Nombre</th>
        <th>Recibida</th>
        <th>Valor (US$)</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pujasDatas as $itempujas)
        <tr>

            <td>{{$itempujas->id}}</td>
            <td>{{$itempujas->code_postor}}</td>
            <td>{{$itempujas->puja_time}}</td>
            <td>{{ number_format($itempujas->amount, 4, '.', ',') }}</td>
        </tr>
    @endforeach
    <!-- Las filas se agregarían dinámicamente -->
    </tbody>
</table>
<p>Habiendo finalizado con el proceso de negociación bajo la modalidad de SUBASTA A LA {{$actaData->type_auction}} y
    obteniendo un
    precio
    favorable a la región, se da por adjudicado a la empresa farmacéutica: {{$pujaWinner->legal_name}}, con un precio de
    USD:
    {{ number_format($pujaWinner->amount, 4, '.', ',') }}, el cual incluye: costo, seguro y flete; debiendo legalizarlo
    con cada país e institución
    participante,
    mediante la
    suscripción del contrato correspondiente.</p>

<table class="detail-table">
    <thead>
    <tr>
        <th>IEmpresa
            Farmaceútica
        </th>
        <th>Ficha técnica N°</th>
        <th>Descripción</th>
        <th>Producto Adjudicado (Nombre
            comercial, Fabricante,
            Origen)
        </th>
        <th>Cantidad
            Total
            Negociada
        </th>
        <th>Precio
            Unitario US$
        </th>
    </tr>
    </thead>
    <tbody>

    <tr>

        <td>{{$pujaWinner->legal_name}}</td>
        <td>{{$productData->cod_medicamento}}</td>
        <td>{{$productData->descripcion}}</td>
        <td></td>
        <td>{{ number_format($actaData->total, 0, '', ',')}}</td>
        <td>  {{ number_format($pujaWinner->amount, 4, '.', ',') }}</td>
    </tr>

    <!-- Las filas se agregarían dinámicamente -->
    </tbody>
</table>

<table class="detail-table">
    <thead>
    <tr>
        <th>Pais</th>
        <th>Cantidad a Adquirir</th>

    </tr>
    </thead>
    <tbody>
    @foreach($intitutionData as $itemIntitute)
        <tr>
            <td>{{$itemIntitute->name_institution}} - {{$itemIntitute->name}}</td>
            <td>{{ number_format($itemIntitute->qty, 0, '', ',')}}</td>
        </tr>
    @endforeach
    <tr>
        <td><b>TOTAL</b></td>
        <td>{{ number_format($actaData->total, 0, '', ',')}}</td>
    </tr>
    <!-- Las filas se agregarían dinámicamente -->
    </tbody>
</table>
<p>Las cantidades de compra pueden modificarse a petición de cada una de las Instituciones de Salud participantes, de
    acuerdo a
    lo establecido en el Art. 58 del Reglamento de la Negociación Conjunta COMISCA, así mismo cualquier otro
    país/institución de
    la región puede incorporarse al proceso de compra en cualquier momento. El período de vigencia del precio de
    adjudicación se
    detallará en el acta de adjudicación del evento de negociación de precios, a partir de esa fecha se podrá proveer
    los bienes
    adjudicados y en los dos años siguientes al efectuado el evento de negociación de precios, con prórroga facultativa
    del precio
    adjudicado a voluntad de las parte</p>

<p>La empresa adjudicada se compromete a realizar las gestiones administrativas legales correspondientes con su
    representante o
    distribuidor local con el fin que se haga efectivo el precio negociado en la ejecución de las compras a nivel local
    por cada una de
    las instituciones. Dicha información deberá ser comunicada a la SE-COMISCA a más tardar 15 días posterior a la
    suscripción
    de esta acta. La SE-COMISCA a su vez la hará del conocimiento de los países para los efectos pertinentes.</p>

<p>No habiendo más que hacer constar se da por terminada la Sesión No. {{$actaData->auction_id}}, para el producto
    {{$productData->cod_medicamento}}
    {{$productData->descripcion}}, firmando de conformidad el suscrito.</p>

<div class="signature">
    <p>_____________________________________________________________</p>
    <p>Dra. Alejandra Acuña Navarro</p>
    <p>Firma como Coordinador del Proceso SE-COMISCA</p>
</div>
<div class="signature">
    <p>_____________________________________________________________</p>
    <p> {{$pujaWinner->legal_name}}</p>
    <p>Empresa adjudicada</p>
</div>
<div class="footer">
    <p>Documento generado por el Sistema de Negociación COMISCA</p>
</div>
</body>
</html>
