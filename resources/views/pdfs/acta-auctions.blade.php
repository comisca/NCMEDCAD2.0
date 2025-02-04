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
                <span class="text-bold">Evento:</span> [NÚMERO_EVENTO]<br>
                <span class="text-bold">Sesión No.:</span> [NÚMERO_SESIÓN]<br>
                <span class="text-bold">Inició:</span> [FECHA_INICIO]<br>
                <span class="text-bold">Finalizó:</span> [FECHA_FIN]
            </td>
            <td>
                <span class="text-bold">Resultado:</span> [RESULTADO]<br>
                <span class="text-bold">Tiempo de duración:</span> [DURACIÓN] minutos<br>
                <span class="text-bold">Tiempo de recuperación:</span> [RECUPERACIÓN] minutos<br>
                <span class="text-bold">Porcentaje de rebaja:</span> [PORCENTAJE]%
            </td>
        </tr>
    </table>
</div>

<div class="title">Detalles del Producto</div>
<div class="info-box">
    <span class="text-bold">Descripción:</span> [DESCRIPCIÓN_PRODUCTO]<br>
    <span class="text-bold">Código:</span> [CÓDIGO]<br>
    <span class="text-bold">Cantidad a subastar:</span> [CANTIDAD]<br>
    <span class="text-bold">Precio de referencia:</span> $[PRECIO]
</div>

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
    <!-- Las filas se agregarían dinámicamente -->
    </tbody>
</table>

<div class="footer">
    <p>Documento generado por el Sistema de Negociación COMISCA</p>
</div>
</body>
</html>
