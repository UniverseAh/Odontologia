<?php
function obtenerTratamientosPorPaciente($idPaciente) {
    $conn = new mysqli('localhost', 'root', '', 'citas');
    $stmt = $conn->prepare("SELECT * FROM tratamientos WHERE TraPaciente = ?");
    $stmt->bind_param("s", $idPaciente);
    $stmt->execute();
    $result = $stmt->get_result();
    $tratamientos = [];
    while ($row = $result->fetch_assoc()) {
        $tratamientos[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $tratamientos;
}
//////////////////////
function obtenerTodosLosTratamientos() {
    $conn = new mysqli('localhost', 'root', '', 'citas');
    $result = $conn->query("SELECT * FROM tratamientos");
    $tratamientos = [];
    while ($row = $result->fetch_assoc()) {
        $tratamientos[] = $row;
    }
    $conn->close();
    return $tratamientos;
}
?>