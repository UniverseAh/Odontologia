<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
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
            <li><a href="index.php">inicio</a></li>
            <?php if ($_SESSION['rol'] == 1): // Admin ?>
                <li><a href="index.php?accion=asignar">Asignar</a></li>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=cancelar">Cancelar Cita</a></li>
                <li><a href="index.php?accion=medicos">Consultar Médicos</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
                <li><a href="index.php?accion=consultorio">Consultorios</a></li>
                <!-- Cambiar el enlace directo por un botón con onclick -->
            <li><a href="#" onclick="confirmarDescarga(event)" class="btn-excel">Descargar Excel</a></li>
            <?php elseif ($_SESSION['rol'] == 2): // Médico ?>
                <li><a href="index.php?accion=asignar">Asignar</a></li>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php elseif ($_SESSION['rol'] == 3): // Paciente ?>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php endif; ?>
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
            <form action="index.php?accion=descargarCitaPDF" method="post" target="_blank" style="margin-top:20px;">
                <input type="hidden" name="CitNumero" value="<?php echo $fila->CitNumero; ?>">
                <button type="submit">Descargar PDF de la Cita</button>
            </form>
            <?php if ($_SESSION['rol'] == 2): // Solo para Médico ?>
                <form action="index.php?accion=enviarCorreoCita" method="post" style="margin-top:20px;">
                    <input type="hidden" name="CitNumero" value="<?php echo $fila->CitNumero; ?>">
                    <label for="correo_destino">Correo destino:</label>
                    <input type="email" name="correo_destino" id="correo_destino" required>
                    <button type="submit">Enviar Gmail con datos de la cita</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <form action="index.php?accion=logout" method="post">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>

    <script>
    ///////// cosito del excel
    function confirmarDescarga(event) {
        event.preventDefault();
        if (confirm('¿Desea descargar el archivo Excel con todas las citas?')) {
            window.location.href = 'index.php?accion=descargarExcelCitas';
        }
    }
    </script>

</body>
</html>