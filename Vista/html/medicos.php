<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consultar Médicos</title>
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
            <?php elseif ($_SESSION['rol'] == 2): // Médico ?>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php elseif ($_SESSION['rol'] == 3): // Paciente ?>
                <li><a href="index.php?accion=consultar">Consultar Cita</a></li>
                <li><a href="index.php?accion=tratamientos">Tratamientos</a></li>
            <?php endif; ?>
        </ul>
        <div id="contenido">
            <h2>Consultar Médicos</h2>
            <form method="post" action="index.php?accion=agregarMedico">
                <table>
                    <tr>
                        <td>Identificación</td>
                        <td><input type="text" name="MedIdentificacion" required></td>
                    </tr>
                    <tr>
                        <td>Nombre</td>
                        <td><input type="text" name="MedNombres" required></td>
                    </tr>
                    <tr>
                        <td>Apellido</td>
                        <td><input type="text" name="MedApellidos" required></td>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit">Agregar Médico</button></td>
                    </tr>
                </table>
            </form>
            <table border="1" style="margin-top:20px; width:100%;">
                <tr>
                    <th>Identificación</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Acciones</th>
                </tr>
                <?php while($medico = $result->fetch_object()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($medico->MedIdentificacion); ?></td>
                    <td><?php echo htmlspecialchars($medico->MedNombres); ?></td>
                    <td><?php echo htmlspecialchars($medico->MedApellidos); ?></td>
                    <td>
                        <a href="#" onclick="mostrarModal('<?php echo htmlspecialchars($medico->MedIdentificacion); ?>','<?php echo htmlspecialchars($medico->MedNombres); ?>','<?php echo htmlspecialchars($medico->MedApellidos); ?>');return false;">Editar</a>
                        |
                        <a href="index.php?accion=eliminarMedico&id=<?php echo $medico->MedIdentificacion; ?>" onclick="return confirm('¿Seguro que deseas eliminar este médico?');">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
            <div id="editarMedicoModal" style="display:none; position:fixed; top:20%; left:35%; background:#fff; border:1px solid #ccc; padding:20px; z-index:1000;">
                <h3>Editar Médico</h3>
                <form id="formEditarMedico" method="post" action="index.php?accion=actualizarMedico">
                    <input type="hidden" name="MedIdentificacion" id="editMedIdentificacion">
                    <label>Nombre:</label>
                    <input type="text" name="MedNombres" id="editMedNombres" required>
                    <label>Apellido:</label>
                    <input type="text" name="MedApellidos" id="editMedApellidos" required>
                    <button type="submit">Actualizar</button>
                    <button type="button" onclick="cerrarModal()">Cancelar</button>
                </form>
            </div>
            <div id="modalOverlay" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:999;" onclick="cerrarModal()"></div>
        </div>
    </div>
    <form action="index.php?accion=logout" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>
    <script>
    function mostrarModal(id, nombre, apellido) {
        document.getElementById('editMedIdentificacion').value = id;
        document.getElementById('editMedNombres').value = nombre;
        document.getElementById('editMedApellidos').value = apellido;
        document.getElementById('editarMedicoModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    }
    function cerrarModal() {
        document.getElementById('editarMedicoModal').style.display = 'none';
        document.getElementById('modalOverlay').style.display = 'none';
    }
    </script>
</body>
</html>