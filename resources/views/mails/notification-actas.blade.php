<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            padding: 20px;
        }

        .header {
            background-color: #f8f9fa;
            padding: 15px;
            margin-bottom: 20px;
        }

        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Acta de Subasta</h2>
    </div>

    <p>Estimado usuario,</p>

    <p>Se adjunta el acta de la subasta correspondiente al evento:
        <strong>{{ $viewData['actaData']->event_name }}</strong>
    </p>

    <div class="details">
        <p><strong>Detalles de la Subasta:</strong></p>
        <ul>
            <li>Evento: {{ $viewData['actaData']->event_name }}</li>
            @if($viewData['productData'])
                <li>Producto: {{ $viewData['productData']->cod_medicamento }}
                    - {{ $viewData['productData']->descripcion }}</li>
            @endif
            @if($viewData['pujaWinner'])
                <li>Ganador: {{ $viewData['pujaWinner']->legal_name }}</li>
            @endif
        </ul>
    </div>

    <p>El documento PDF adjunto contiene todos los detalles de la subasta.</p>

    <div class="footer">
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        <p>Si tiene alguna pregunta, contacte a soporte.</p>
    </div>
</div>
</body>
</html>
