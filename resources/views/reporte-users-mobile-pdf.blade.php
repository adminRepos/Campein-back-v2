<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        #idTbody tr td{
            background-color: #FFFFFF;
            /* min-height: 30px */
        }
        
        #idTbody tr:nth-child(odd) td {
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
                <th ><img src="<?= $imagePDF1 ?>" alt="" style="position: relative;" ></th>
                <th >
                    <h3 class="title"><img src="<?=  $imagePDF2 ?>">DATOS USUARIO</h3>
                </th>
                {{-- <th style="font-family: 'Roboto', sans-serif;"><?= $date ?></th> --}}
            </tr>
        </thead>
    </table>

    <table class="t-body">
        <thead>
            <!-- <tr>
                <th ></th>
                <th colspan="3">Datos Usuario</th>
                <th colspan="15">Datos prospecto (ciudadano)</th>
            </tr> -->
            <tr>
                <th style="word-wrap: break-word;">#</th>
                <th style="max-width: 100px !important; max-width: 100px !important; word-wrap: break-word;">Nombre usuario</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Email usuario</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Rol</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">T.I.</th>
                <th style="max-width: 100px !important; word-wrap: break-word;"># I.</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Genero</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Primer nombre</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Segundo nombre</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Primer apellido</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Segundo apellido</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Dirección</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Localidad</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Email</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Telefono</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Whatsapp</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Fecha registro</th>
                <th style="max-width: 100px !important; word-wrap: break-word;">Rango edad</th>
                {{-- <th style="max-width: 100px !important; word-wrap: break-word;">Longitud</th> --}}
                {{-- <th style="max-width: 100px !important; word-wrap: break-word;">Latitud</th> --}}
            </tr>
        </thead>
        <tbody id="idTbody">
            @foreach($data as $item)
                <tr>
                    <td style="word-wrap: break-word; font-size:10px;">{{ ++$i }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->nombre_user }}</td>
                    <td style="word-wrap: break-word; font-size:10px;">{{ $item->email }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->rol }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->tipo_documento }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->identificacion }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->genero }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->primer_nombre }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->segundo_nombre }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->primer_apellido }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->segundo_apellido }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->direccion }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->localidad }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->email_p }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->telefono }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->whatsapp }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->fecha_registro }}</td>
                    <td style="max-width: 100px !important; word-wrap: break-word; font-size:10px;">{{ $item->rango_edad }}</td>
                    {{-- <td style="max-width: 100px !important; word-wrap: break-word; font-size:15px;">{{ $item->longitud }}</td> --}}
                    {{-- <td style="max-width: 100px !important; word-wrap: break-word; font-size:15px;">{{ $item->latitud }}</td> --}}
                </tr>
            @endforeach
        </tbody>
        <!-- nombre_user, email, tipo_documento, identificacion, genero, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, localidad, email, telefono, whatsapp, fecha_registro, rango_edad, longitud, latitud -->
    </table>
</body>
</html>