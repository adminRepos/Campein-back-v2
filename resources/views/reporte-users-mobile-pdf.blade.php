<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte usuarios</title>
</head>
<body>

    <table>
        <thead>
            <tr>
                <th></th>
                <th colspan="3">Datos Usuario</th>
                <th colspan="15">Datos prospecto (ciudadano)</th>
            </tr>
            <tr>
                <th>#</th>
                <th>Nombre usuario</th>
                <th>Email usuario</th>
                <th>Rol</th>
                <th>Tipo de documento de identificacion</th>
                <th>Numero de documento de identificacion</th>
                <th>Genero</th>
                <th>Primer nombre</th>
                <th>Segundo nombre</th>
                <th>Primer apellido</th>
                <th>Segundo apellido</th>
                <th>Dirección</th>
                <th>Localidad</th>
                <th>Telefono</th>
                <th>Whatsapp</th>
                <th>Fecha registro</th>
                <th>Rango edad</th>
                <th>Longitud</th>
                <th>Latitud</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->nombre_user }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->rol }}</td>
                    <td>{{ $item->tipo_documento }}</td>
                    <td>{{ $item->identificacion }}</td>
                    <td>{{ $item->genero }}</td>
                    <td>{{ $item->primer_nombre }}</td>
                    <td>{{ $item->segundo_nombre }}</td>
                    <td>{{ $item->primer_apellido }}</td>
                    <td>{{ $item->segundo_apellido }}</td>
                    <td>{{ $item->direccion }}</td>
                    <td>{{ $item->localidad }}</td>
                    <td>{{ $item->email_p }}</td>
                    <td>{{ $item->telefono }}</td>
                    <td>{{ $item->whatsapp }}</td>
                    <td>{{ $item->fecha_registro }}</td>
                    <td>{{ $item->rango_edad }}</td>
                    <td>{{ $item->longitud }}</td>
                    <td>{{ $item->latitud }}</td>
                </tr>
            @endforeach
        </tbody>
        <!-- nombre_user, email, tipo_documento, identificacion, genero, primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, direccion, localidad, email, telefono, whatsapp, fecha_registro, rango_edad, longitud, latitud -->
    </table>
</body>
</html>