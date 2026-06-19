<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="{{ asset('images/user.png') }}" type="image/x-icon">
    <title>Registro - FlowAccess</title>
    @livewireStyles
</head>

<body style="
    margin:0;
    font-family: Arial, sans-serif;
    background: url('{{ asset('images/Fondo.png') }}') no-repeat center center;
    background-size: cover;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
">

    <div style="width:100%; max-width: 420px; text-align:center;">

        <h1 style="margin-bottom:5px;">FlowAccess</h1>
        <p style="margin-bottom:25px; color:#555;">Registro rápido de usuarios</p>

        <livewire:customer-form />

    </div>

    @livewireScripts
</body>
</html>
