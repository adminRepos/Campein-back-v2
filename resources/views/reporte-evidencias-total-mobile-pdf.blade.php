<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="../css/estilosPDF.css"> -->
    <title>Reporte usuarios</title>
    <style type="text/css">

        @font-face {
            font-family : "Roboto";
            font-style: normal;
            font-weight : normal;
            src: url("http://localhost:6001/app/resources/fonts/Roboto-Black.ttf") format("truetype");
        }

        .t-header, .t-body{
            width: 100%;
            margin-bottom: 30px;
            font-family: 'Roboto', sans-serif;
        }

        .t-body{
            border-collapse: separate;
            border-spacing: 0px 30px;
        }

        #idTbody tr{
            background-color: #FFFFFF;
            /* min-height: 30px */
        }
        
        #idTbody tr:nth-child(odd)  {
            background-color: #F1F1F1;
            /* background-color: #FFFFFF; */
        }

        .title{
            color: #DB356D;
            text-align: center;
            top: 0;
        }

    </style>
</head>
<body>
    <table class="t-header">
        <thead>
            <tr>
                <th><img src="<?= $imagePDF1 ?>" alt="" style="position: relative;" ></th>
                <th>
                    <h3 class="title"><img src="<?=  $imagePDF2 ?>">DATOS USUARIO</h3>
                </th>
                <th style="font-family: 'Roboto', sans-serif;"><?= $date ?></th>
            </tr>
        </thead>
    </table>
    <!-- @foreach($user as $item)
        <p>Nombre usuario: {{ $item->nombre }} </p>
        <p>Tipo usuario: {{ $item->rol }} </p>
        <p>Total de evidencias en el reporte: {{ $item->evidencias }} </p>
    @endforeach -->

    <table class="t-body">
        <thead>
            <tr>
                <th style="width: 50px !important;">#</th>
                <th style="width: 150px !important;">Nombre usuario</th>
                <th style="width: 100px !important;">Tipo usuario</th>
                <th style="width: 100px !important;">Red Social</th>
                <th style="max-width: 150px !important;">URL</th>
                <th style="width: 150px !important;">Fecha creación</th>
            </tr>
        </thead>
        <tbody id="idTbody">
            @foreach($data as $item)
                <!-- <tr style="min-height: 100px !important;"> -->
                <tr>
                    <td style="width: 50px !important; word-wrap: break-word; text-align:center; font-size:15px;">{{ ++$i }}</td>
                    <td style="width: 150px !important; word-wrap: break-word; font-size:15px;">{{ $item->nombre }}</td>
                    <td style="width: 100px !important; word-wrap: break-word; font-size:15px;">{{ $item->rol }}</td>
                    <td style="width: 100px !important; word-wrap: break-word; font-size:15px;">{{ $item->red_social }}</td>
                    <td style="padding:0 3px; max-width: 150px !important; word-wrap: break-word; font-size:15px;">{{ $item->url }}</td>
                    <td style="width: 100px !important; word-wrap: break-word; font-size:15px;">{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>