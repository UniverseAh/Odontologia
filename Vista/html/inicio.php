<!DOCTYPE html>
<html>

<head>
    <title>Información General</title>
    <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
</head>

<body>
    <div id="contenedor">
        <div id="encabezado">
            <h1>Sistema de Gestión Odontológica</h1>
        </div>
        <ul id="menu">
            <li><a href="index.php">inicio</a> </li>
            <li><a href="index.php?accion=asignar">Asignar</a> </li>
            <li><a href="index.php?accion=consultar">Consultar Cita</a> </li>
            <li><a href="index.php?accion=cancelar">Cancelar Cita</a> </li>
            <li><a href="index.php?accion=medicos">Consultar Médicos</a> </li>
            <li><a href="index.php?accion=tratamientos">Tratamientos</a> </li>
        </ul>
        <div id="contenido">
            <h2>Información General</h2>
            <p>El Sistema de Gestión Odontológica permite administrar la información de los pacientes, tratamientos y citas a través de una interfaz web.</p>
            <p>El sistema cuenta con las siguientes secciones:
            <ul>
                <li>Asignar cita</li>
                <li>Consultar cita</li>
                <li>Cancelar cita</li>
            </ul>
            </p>
        </div>
    </div>
    <form action="index.php?accion=logout" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>
</body>

</html>