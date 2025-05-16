<!DOCTYPE html>
<html>

<head>
    <title>Sistema de Gestión Odontológica</title>
    <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
</head>

<body>
    <div id="contenedor">
        <div id="encabezado">
            <h1>Sistema de Gestión Odontológica</h1>
        </div>
        <ul id="menu">
            <li class="activa"><a href="index.php">inicio</a> </li>
            <li><a href="index.php?accion=asignar">Asignar</a> </li>
            <li><a href="index.php?accion=consultar">Consultar Cita</a> </li>
            <li><a href="index.php?accion=cancelar">Cancelar Cita</a> </li>
        </ul>
        <div id="contenido">
            <?php $fila = $result->fetch_object(); ?>
            <h2>Información Cita</h2>
            <table>
                <tr>
                    <th colspan="2">Datos del Paciente</th>
                </tr>
                <tr>
                    <td>Documento</td>
                    <td><?php echo $fila->PacIdentificacion; ?></td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td><?php echo $fila->PacNombres . " " . $fila->PacApellidos; ?></td>
                </tr>
                <tr>
                    <th colspan="2">Datos del Médico</th>
                </tr>
                <tr>
                    <td>Documento</td>
                    <td><?php echo $fila->MedIdentificacion; ?></td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td><?php echo $fila->MedNombres . " " . $fila->MedApellidos; ?></td>
                </tr>
                <tr>
                    <th colspan="2">Datos de la Cita</th>
                </tr>
                <tr>
                    <td>Número</td>
                    <td><?php echo $fila->CitNumero; ?></td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td><?php echo $fila->CitFecha; ?></td>
                </tr>
                <tr>
                    <td>Hora</td>
                    <td><?php echo $fila->CitHora; ?></td>
                </tr>
                <tr>
                    <td>Número de Consultorio</td>
                    <td><?php echo $fila->ConNombre; ?></td>
                </tr>
                <tr>
                    <td>Estado</td>
                    <td><?php echo $fila->CitEstado; ?></td>
                </tr>
                <tr>
                    <td>Observaciones</td>
                    <td><?php echo $fila->CitObservaciones; ?></td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>