<!DOCTYPE html>
<html>
<head>
    <title>Validación de Nueva Oferta</title>
</head>
<body>
<p>Hola, {{ $user->name }}</p>
<p>Hay una nueva oferta para el ciclo {{$cycle->title}} con los siguientes datos: </p>
<p>Descripcion: {{$offer->description}}</p>
<p>Duracion: {{$offer->duration}}</p>
<p>Nombre del responsable: {{$offer->responsible_name}}</p>
<p>Entra a la bolsa para ver mas datos</p>
<p>Gracias.</p>
</body>
</html>
