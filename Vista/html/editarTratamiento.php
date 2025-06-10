<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Tratamiento</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>
    <h2>Editar Tratamiento</h2>
    <form action="index.php?accion=editarTratamiento" method="post">
        <input type="hidden" name="TraNumero" value="<?= htmlspecialchars($tratamiento['TraNumero']) ?>">

        <label>ID Paciente:</label>
        <input type="text" name="TraPaciente" value="<?= htmlspecialchars($trat['TraPaciente']) ?>" required><br><br>

        <label>Fecha Asignado:</label>
        <input type="date" name="TraFechaAsignado" value="<?= htmlspecialchars($tratamiento['TraFechaAsignado']) ?>" required><br><br>

        <label>Descripción:</label>
        <input type="text" name="TraDescripcion" value="<?= htmlspecialchars($tratamiento['TraDescripcion']) ?>" required><br><br>

        <label>Fecha Inicio:</label>
        <input type="date" name="TraFechaInicio" value="<?= htmlspecialchars($tratamiento['TraFechaInicio']) ?>" required><br><br>

        <label>Fecha Fin:</label>
        <input type="date" name="TraFechaFin" value="<?= htmlspecialchars($tratamiento['TraFechaFin']) ?>"><br><br>

        <label>Observaciones:</label>
        <textarea name="TraObservaciones"><?= htmlspecialchars($tratamiento['TraObservaciones']) ?></textarea><br><br>

        <button type="submit">Actualizar</button>
        <a href="index.php?accion=tratamientos">Cancelar</a>
    </form>
</body>
</html>