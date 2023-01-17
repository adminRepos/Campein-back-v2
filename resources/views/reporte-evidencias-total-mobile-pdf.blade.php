<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte usuarios</title>
</head>
<body>
    @foreach($user as $item)
        <p>Nombre usuario: {{ $item->nombre }} </p>
        <p>Tipo usuario: {{ $item->rol }} </p>
        <p>Total de evidencias en el reporte: {{ $item->evidencias }} </p>
    @endforeach

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre usuario</th>
                <th>Tipo usuario</th>
                <th>Red Social</th>
                <th>URL</th>
                <th>Fecha creación</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $item)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->rol }}</td>
                    <td>{{ $item->red_social }}</td>
                    <td><a target="_blank">{{ $item->url }}<a></td>
                    <td>{{ $item->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>