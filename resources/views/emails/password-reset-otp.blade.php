<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Recuperación de contraseña</title>
</head>

<body style="
    margin:0;
    padding:0;
    background:#f4f6f9;
    font-family:Arial, Helvetica, sans-serif;
">

<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center" style="padding:40px 20px;">

<table width="600" cellpadding="0" cellspacing="0"
       style="
       background:#ffffff;
       border-radius:12px;
       overflow:hidden;
       box-shadow:0 4px 12px rgba(0,0,0,.08);
       ">

<tr>
<td style="
background:#0F172A;
padding:30px;
text-align:center;
">

<h1 style="
margin:0;
color:#ffffff;
font-size:28px;
">
InfraEnercom S.A.C.
</h1>

</td>
</tr>

<tr>
<td style="padding:40px;">

<h2 style="margin-top:0;color:#111827;">
Hola {{ $name }}
</h2>

<p style="
font-size:16px;
color:#4B5563;
line-height:1.7;
">
Hemos recibido una solicitud para restablecer la contraseña de tu cuenta.
</p>

<p style="
font-size:16px;
color:#4B5563;
line-height:1.7;
">
Utiliza el siguiente código de verificación:
</p>

<div style="
text-align:center;
margin:35px 0;
">

<span style="
display:inline-block;
padding:18px 40px;
font-size:34px;
font-weight:bold;
letter-spacing:10px;
background:#EEF2FF;
color:#1D4ED8;
border-radius:10px;
">
{{ $otp }} </span>

</div>

<p style="
font-size:15px;
color:#6B7280;
line-height:1.7;
">
Este código expirará en 10 minutos.
</p>

<p style="
font-size:15px;
color:#6B7280;
line-height:1.7;
">
Si no solicitaste este cambio, puedes ignorar este mensaje de forma segura.
</p>

</td>
</tr>

<tr>
<td style="
padding:25px;
background:#F9FAFB;
text-align:center;
font-size:13px;
color:#6B7280;
">

© {{ date('Y') }} InfraEnercom S.A.C.<br>
Sistema de Gestión e Inventario

</td>
</tr>

</table>

</td>
</tr>
</table>

</body>
</html>
