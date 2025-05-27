<?php
    function obtenerMedicos() {
        $conn = new mysqli('localhost', 'root', '', 'citas');
        $result = $conn->query("SELECT * FROM medicos");
        $medicos = [];
        while ($row = $result->fetch_assoc()) {
            $medicos[] = $row;
        }
        $conn->close();
        return $medicos;
    }

    function agregarMedico($nombre, $especialidad) {
        $conn = new mysqli('localhost', 'root', '', 'citas');
        $stmt = $conn->prepare("INSERT INTO medicos (nombre, especialidad) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $especialidad);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }

    function eliminarMedico($id) {
        $conn = new mysqli('localhost', 'root', '', 'citas');
        $stmt = $conn->prepare("DELETE FROM medicos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $conn->close();
    }