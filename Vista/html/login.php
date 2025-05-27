<!DOCTYPE html>
<html>
<head>
    <title>Login - Sistema de Gestión Odontológica</title>
    <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
</head>
<body>
    <div class="login-box">
        <h2>Iniciar Sesión</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post" action="index.php?accion=login">
            <input type="text" name="usuario" placeholder="Usuario" required>
            <input type="password" name="clave" placeholder="Contraseña" required>
            <select name="rol" required>
                <option value="">Seleccione su rol</option>
                <option value="Paciente">Paciente</option>
                <option value="Medico">Médico</option>
                <option value="Administrador">Administrador</option>
            </select>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>
</html>