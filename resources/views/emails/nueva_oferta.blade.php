<!DOCTYPE html>
<html>
<head>
    <title>Ver de Nueva Oferta</title>
</head>
<body>
<p>Hola, {{ $user->name }}</p>
<p>Hay una nueva oferta para el ciclo {{$cycle->title}} con los siguientes datos: </p>
<p>Descripcion: {{$offer->description}}</p>
<p>Duracion: {{$offer->duration}}</p>
<p>Nombre del responsable: {{$offer->responsible_name}}</p>
<p>Pulsa en el siguiente enlace para verificarla</p>
<p><a href="{{ url('api/verificateOffer/'.$offer->id) }}">Validar oferta</a></p>
<p>Gracias.</p>
</body>
</html>
