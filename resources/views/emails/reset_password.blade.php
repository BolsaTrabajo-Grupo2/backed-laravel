<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer contraseña</title>
</head>
<body>
<p>Hola {{ $user->name }},</p>
<p>Haz clic en el siguiente enlace para restablecer tu contraseña:</p>
<p><a href="{{ $resetUrl }}">Restablecer contraseña</a></p>
<p>Si no solicitaste un restablecimiento de contraseña, puedes ignorar este correo electrónico.</p>
</body>
</html>
