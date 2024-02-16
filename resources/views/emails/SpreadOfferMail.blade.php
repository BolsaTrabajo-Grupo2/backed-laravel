<!DOCTYPE html>
<html>
<head>
    <title>Propagar Oferta</title>
</head>
<body>
<p>Hola, {{$user->name}}</p>
<p>Hace un mes que creaste esta oferta: </p>
<p>Descripcion: {{ $offer->description }}</p>
<p>Duracion: {{$offer->duration}}</p>
<p>Nombre del responsable: {{$offer->responsible_name}}</p>
<p>Si deaseas propagarla un mes mas pulse el enlace, si no lo deseas ignora el mensaje</p>
<p><a href="{{ url('api/spread/'.$offer->id) }}">Propagar tiempo oferta</a></p>
</body>
</html>
