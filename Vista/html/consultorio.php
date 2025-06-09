<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultorios</title>
    <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
    <script src="Vista/jquery/jquery.js"></script>
    <script src="Vista/jquery/jquery-ui-1.14.1/jquery-ui.js" type="text/javascript"></script>
    <link href="Vista/jquery/jquery-ui-1.14.1/jquery-ui.min.css" rel="stylesheet" type="text/css"/>
    <script src="Vista/js/script.js"></script>

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
            <?php elseif ($_SESSION['rol'] == 2): // Médico ?>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php elseif ($_SESSION['rol'] == 3): // Paciente ?>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php endif; ?>
        </ul>

        <div id="contenido" class="consultorio-flex" >
            <div class="consultorio-main">
                <h2>Consultorios</h2>
                <?php if (isset($consultorioEditar) && is_object($consultorioEditar)): ?>
                    <form action="index.php" method="get" style="margin-bottom:20px;">

                        <input type="hidden" name="accion" value="actualizarConsultorio">

                        <input type="hidden" name="numero" value="<?php echo htmlspecialchars($consultorioEditar->ConNumero); ?>">
                        <label>Editar Consultorio:</label>
                        <input type="text" name="nombre" value="<?php echo htmlspecialchars($consultorioEditar->ConNombre); ?>" required>
                        <br> 
                        
                        <div class="botones-form">
                            <button type="submit" class="btn-guardar">Guardar</button>
                            <button type="button" class="btn-cancelar" onclick="window.location.href='index.php?accion=consultorio'">Cancelar</button>
                        </div>
                        
                    </form>
                <?php elseif (isset($consultorioEditar)): ?>
                    <div style="color:red;">No se encontró el consultorio a editar.</div>
                <?php endif; ?>

                    <?php
                    if (isset($mensaje)) { ?>
                        <div style="color:<?php echo (strpos($mensaje, 'Error') === 0) ? 'red' : 'green'; ?>;font-weight:none;margin-bottom:10px;font-size:14px;font-family:poppins;">
                            <?php echo $mensaje; ?>
                        </div>
                    <?php } ?>
                <?php if (!isset($result)) $result = []; ///cosito para el error de result ?> 
                <?php
                    if ($result && $result->num_rows > 0) {
                        echo "<table class='tabla-paciente'>";
                        echo "<tr><th>Número</th><th>Nombre</th><th>Eliminar</th><th>Editar</th></tr>";
                        while ($fila = $result->fetch_object()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($fila->ConNumero) . "</td>";
                            echo "<td>" . htmlspecialchars($fila->ConNombre) . "</td>";
                            echo "<td><a href='index.php?accion=eliminarConsultorio&numero=" . htmlspecialchars($fila->ConNumero) . "' onclick=\"return confirm('¿Seguro que desea eliminar este consultorio?')\">Eliminar</a></td>";
                        echo "<td><a href='index.php?accion=consultorio&editar=" . htmlspecialchars($fila->ConNumero) . "'>Editar</a></td>";
                        
                            echo "</tr>";   
                        }
                        echo "</table>";
                    } else {
                        echo "<p>No hay consultorios registrados.</p>";
                    }
                ?>
            </div>    
            <!-- Botón para mostrar el formulario -->
            <div class="lado-derecho">
                <button id="btnAgregarConsultorio" type="button" style="margin-bottom:15px;">Agregar consultorio</button>
                <!-- Panel derecho con formulario -->
                <div id="panel-derecho-consultorio">
                    
                    <!-- Formulario oculto para agregar consultorio -->
                    <form id="formAgregarConsultorio" action="index.php" method="get" style="display:none; margin-bottom:20px;">
                        <input type="hidden" name="accion" value="agregarConsultorio">
                        <label>Numero del consultorio:</label>
                        <select name="numero" required>
                            <option value="">Seleccione: </option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                        <br>

                        <label>Nombre del consultorio:</label>
                        <input type="text" name="nombre" required>
                        <button type="submit">Guardar</button>
                        <button type="button" onclick="document.getElementById('formAgregarConsultorio').style.display='none';document.getElementById('btnAgregarConsultorio').style.display='inline';">Cancelar</button>
                    </form>
                </div>

            </div>
            
        </div>
    </div>
    <form action="index.php?accion=logout" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>
</body>
</html>