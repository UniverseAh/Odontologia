<!DOCTYPE html>
<html>
<head>
    <title>Panel del Paciente</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>
    <h2>Mis Citas</h2>
    <?php if (!empty($citas)): ?>
        <table>
            <tr>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Médico</th>
                <th>Consultorio</th>
            </tr>
            <?php foreach ($citas as $cita): ?>
                <tr>
                    <td><?= htmlspecialchars($cita['Fecha']) ?></td>
                    <td><?= htmlspecialchars($cita['Hora']) ?></td>
                    <td><?= htmlspecialchars($cita['MedicoId']) ?></td>
                    <td><?= htmlspecialchars($cita['ConsultorioId']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tienes citas registradas.</p>
    <?php endif; ?>

    <h2>Mis Tratamientos</h2>
    <?php if (!empty($tratamientos)): ?>
        <table>
            <tr>
                <th>Tratamiento</th>
                <th>Descripción</th>
                <th>Fecha</th>
            </tr>
            <?php foreach ($tratamientos as $trat): ?>
                <tr>
                    <td><?= htmlspecialchars($trat['Nombre']) ?></td>
                    <td><?= htmlspecialchars($trat['Descripcion']) ?></td>
                    <td><?= htmlspecialchars($trat['Fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No tienes tratamientos registrados.</p>
    <?php endif; ?>

    <form action="index.php?accion=logout" method="post">
        <button type="submit" class="logout-btn">Cerrar sesión</button>
    </form>
</body>
</html>