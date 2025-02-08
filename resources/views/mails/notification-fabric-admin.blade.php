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
        <h2>Notificacion de Fabricante con Multiple Aplicaciones con diferentes distribuidores</h2>
    </div>

    <p>Estimados equipo de la UTMO,</p>

    <p>por esta notificacion se les informa que la empresa distribuidora <strong>{{$nameD}}</strong> a realizado una
        aplicacion de un producto y a seleccionado como fabricante a <strong>{{$nameF}}</strong>, lo cual el sistema ha
        dectectado que este fabricante esta enrolado en otras aplicaciones con otros distribuidores, por lo cual les
        notidicamos con el proposito que ustedes tomen las medidas pertinentes en este caso.
    </p>


    <div class="footer">
        <p>Este es un correo automático, por favor no responda a este mensaje.</p>
        <p>Si tiene alguna pregunta, contacte a soporte.</p>
    </div>
</div>
</body>
</html>
