<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Tratamientos</title>
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
                <!-- boton para descargar el excel -->
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
            <h2>Tratamientos</h2>
            <?php if ($_SESSION['rol'] != 3): // cosito de agregar Solo para Admin y Médico ?>
                <button onclick="abrirModal('agregar')">Agregar Tratamiento</button>
            <?php endif; ?>
            <?php if ($_SESSION['rol'] != 3)://pa que al paciente no le salga el buscador?>
            <form method="get" action="index.php" style="margin-bottom: 15px;">
                <input type="hidden" name="accion" value="tratamientos">
                <input type="text" name="buscar_paciente" placeholder="Buscar por ID de paciente" value="<?= isset($_GET['buscar_paciente']) ? htmlspecialchars($_GET['buscar_paciente']) : '' ?>">
                <button type="submit">Buscar</button>
            </form>
            <?php endif; ?>
            <table border="1">
                <tr>
                    <th>ID Paciente</th>
                    <th>Fecha Asignado</th>
                    <th>Descripción</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Observaciones</th>
                    <?php if ($_SESSION['rol'] != 3): //////// mostrar columna si NO es paciente ?>
                        <th>Acciones</th>
                    <?php endif; ?>
                </tr>
                <?php foreach ($tratamientos as $trat): ?>
                <tr>
                    <td><?= htmlspecialchars($trat['TraPaciente']) ?></td>
                    <td><?= htmlspecialchars($trat['TraFechaAsignado']) ?></td>
                    <td><?= htmlspecialchars($trat['TraDescripcion']) ?></td>
                    <td><?= htmlspecialchars($trat['TraFechaInicio']) ?></td>
                    <td><?= htmlspecialchars($trat['TraFechaFin']) ?></td>
                    <td><?= htmlspecialchars($trat['TraObservaciones']) ?></td>
                    <?php if ($_SESSION['rol'] != 3): //////////  mostrar botones si NO es paciente ?>
                        <td>
                            <button onclick="abrirModal('editar', <?= $trat['TraNumero'] ?>)">Editar</button>
                            <button onclick="eliminarTratamiento(<?= $trat['TraNumero'] ?>)">Eliminar</button>
                        </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
    <form action="index.php?accion=logout" method="post" style="display:inline;">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>

    <!-- Modal -->
    <div id="modalTratamiento" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <div id="modal-body">
            </div>
        </div>
    </div>
    

    <script>
    function abrirModal(tipo, id = null) {
        let url = '';
        if (tipo == 'agregar') {
            url = 'index.php?accion=mostrarAgregarTratamiento';
        } else if (tipo == 'editar') {
            url = 'index.php?accion=mostrarEditarTratamiento&id=' + id;
        }
        fetch(url)
            .then(response => response.text())
            .then(html => {
                document.getElementById('modal-body').innerHTML = html;
                document.getElementById('modalTratamiento').style.display = 'block';
            });
    }

    function cerrarModal() {
        document.getElementById('modalTratamiento').style.display = 'none';
    }

    function eliminarTratamiento(id) {
        if (confirm('¿Eliminar este tratamiento?')) {
            window.location.href = 'index.php?accion=eliminarTratamiento&id=' + id;
        }
    }
    ///////// cosito del excel
    function confirmarDescarga(event) {
        event.preventDefault();
        if (confirm('¿Desea descargar el archivo Excel con todas las citas?')) {
            window.location.href = 'index.php?accion=descargarExcelCitas';
        }
    }

    window.onclick = function(event) {
        var modal = document.getElementById('modalTratamiento');
        if (event.target == modal) {
            cerrarModal();
        }
    }
    </script>
    
</body>
</html>