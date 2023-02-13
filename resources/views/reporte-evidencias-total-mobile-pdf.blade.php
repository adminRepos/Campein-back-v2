<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/estilosPDF.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Reporte usuarios</title>
</head>
<body>
    <!-- <img src="../images/pdfImages/logo-campein.png" alt=""  style="position: relative; top: 15px;">
    <h6> <img src="imagen/pdfImages/circle-user.svg" style="width: 10%; "> DATOS USUARIO</h6> -->
    <img src="<?= $imagePDF1 ?>" alt=""  style="position: relative; top: 15px;">
    <h6> <img src="<?=  $imagePDF2 ?>" style="width: 10%; "> DATOS USUARIO</h6>
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