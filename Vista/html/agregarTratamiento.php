<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Tratamiento</title>
    <link rel="stylesheet" href="Vista/css/estilos.css">
</head>
<body>
    <h2>Agregar Tratamiento</h2>
    <form action="index.php?accion=agregarTratamiento" method="post">
        <label>ID Paciente:</label>
        <input type="text" name="TraPaciente" required><br><br>

        <label>Fecha Asignado:</label>
        <input type="date" name="TraFechaAsignado" required><br><br>

        <label>Descripción:</label>
        <input type="text" name="TraDescripcion" required><br><br>

        <label>Fecha Inicio:</label>
        <input type="date" name="TraFechaInicio" required><br><br>

        <label>Fecha Fin:</label>
        <input type="date" name="TraFechaFin"><br><br>

        <label>Observaciones:</label>
        <textarea name="TraObservaciones"></textarea><br><br>

        <button type="submit">Guardar</button>
        <button type="button" onclick="cerrarModal()">Cancelar</button>
    </form>
</body>
</html>