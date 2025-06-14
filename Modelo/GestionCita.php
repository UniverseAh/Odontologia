<?php
class GestorCita
{
    public function agregarCita(Cita $cita)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $fecha = $cita->obtenerFecha();
        $hora = $cita->obtenerHora();
        $paciente = $cita->obtenerPaciente();
        $medico = $cita->obtenerMedico();
        $consultorio = $cita->obtenerConsultorio();
        $estado = $cita->obtenerEstado();
        $observaciones = $cita->obtenerObservaciones();
        $sql = "INSERT INTO Citas VALUES ( null,'$fecha','$hora',
'$paciente','$medico','$consultorio','$estado','$observaciones')";
        $conexion->consulta($sql);
        $citaId = $conexion->obtenerCitaId();
        $conexion->cerrar();
        return $citaId;
    }
    public function consultarCitasPorDocumento($doc)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM citas "
            . "WHERE CitPaciente = '$doc' "
            . " AND CitEstado = 'Solicitada' ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function consultarPaciente($doc)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM Pacientes WHERE PacIdentificacion = '$doc' ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function consultarCitaPorId($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT pacientes.* , medicos.*, consultorios.*, citas.*"
            . "FROM Pacientes as pacientes, Medicos as medicos, Consultorios  as consultorios ,citas "
            . "WHERE citas.CitPaciente = pacientes.PacIdentificacion "
            . " AND citas.CitMedico = medicos.MedIdentificacion "
            . " AND citas.CitNumero = $id";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function agregarPaciente(Paciente $paciente)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $identificacion = $paciente->obtenerIdentificacion();
        $nombres = $paciente->obtenerNombres();
        $apellidos = $paciente->obtenerApellidos();
        $fechaNacimiento = $paciente->obtenerFechaNacimiento();
        $sexo = $paciente->obtenerSexo();
        $sql = "INSERT INTO Pacientes VALUES (
'$identificacion','$nombres','$apellidos',"
            . "'$fechaNacimiento','$sexo')";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $filasAfectadas;
    }
    public function consultarMedicos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM Medicos ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function consultarHorasDisponibles($medico, $fecha)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT hora FROM horas WHERE hora NOT IN "
            . "( SELECT CitHora FROM citas WHERE CitMedico = '$medico' AND CitFecha = '$fecha'"
            . " AND CitEstado = 'Solicitada') ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function consultarConsultorios()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM consultorios ";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function cancelarCita($cita)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE citas SET CitEstado = 'Cancelada' "
            . " WHERE CitNumero = $cita ";
        $conexion->consulta($sql);
        $filasAfectadas = $conexion->obtenerFilasAfectadas();
        $conexion->cerrar();
        return $filasAfectadas;
    }
    public function agregarMedico($doc, $nom, $ape)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO medicos (MedIdentificacion, MedNombres, MedApellidos) VALUES ('$doc', '$nom', '$ape')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function consultarMedicoPorId($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM medicos WHERE MedIdentificacion = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result->fetch_object();
    }
    public function actualizarMedico($doc, $nom, $ape)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE medicos SET MedNombres = '$nom', MedApellidos = '$ape' WHERE MedIdentificacion = '$doc'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function eliminarMedico($id)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM medicos WHERE MedIdentificacion = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    //Cosito de panel de pacientes
    public function obtenerCitasPorPaciente($pacienteId)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM citas WHERE CitPaciente = '$pacienteId'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    public function obtenerTratamientosPorPaciente($pacienteId)
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM tratamientos WHERE PacIdentificacion = '$pacienteId'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
    
    ///////////////////// tratamientos
    public function obtenerTodosLosTratamientos() {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM tratamientos";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }

    public function agregarTratamiento($datos) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO tratamientos (TraPaciente, TraFechaAsignado, TraDescripcion, TraFechaInicio, TraFechaFin, TraObservaciones)
                VALUES (
                    '{$datos['TraPaciente']}',
                    '{$datos['TraFechaAsignado']}',
                    '{$datos['TraDescripcion']}',
                    '{$datos['TraFechaInicio']}',
                    '{$datos['TraFechaFin']}',
                    '{$datos['TraObservaciones']}'
                )";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function editarTratamiento($id, $datos) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE tratamientos SET
                TraPaciente = '{$datos['TraPaciente']}',
                TraFechaAsignado = '{$datos['TraFechaAsignado']}',
                TraDescripcion = '{$datos['TraDescripcion']}',
                TraFechaInicio = '{$datos['TraFechaInicio']}',
                TraFechaFin = '{$datos['TraFechaFin']}',
                TraObservaciones = '{$datos['TraObservaciones']}'
            WHERE TraNumero = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function eliminarTratamiento($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM tratamientos WHERE TraNumero = '$id'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }

    public function obtenerTratamientoPorId($id) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM tratamientos WHERE TraNumero = '$id'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        if ($result instanceof mysqli_result) {
            return $result->fetch_assoc();
        }
        if (is_array($result) && count($result) > 0) {
            return $result[0];
        }
        return [];
    }
    /////////////////////cosito de consultorios
    public function consultarConsultorioPorNumero($numero) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM consultorios WHERE ConNumero = '$numero'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();

        if ($result instanceof mysqli_result) {
            return $result->fetch_object(); // Devuelve un objeto consultorio
        }
        if (is_array($result) && count($result) > 0) {
            return (object)$result[0]; // Convierte array a objeto
        }
        return null;
    }
    public function tieneCitasAgendadas($consultorioNumero) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) as total FROM citas WHERE CitConsultorio = '$consultorioNumero'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        /////////////// Si hay al menos una cita devuelve true
        if (is_array($result) && isset($result[0]['total'])) {
            return $result[0]['total'] > 0;
        }
        if ($result instanceof mysqli_result) {
            $row = $result->fetch_assoc();
            return $row['total'] > 0;
        }
        return false;
    }
    public function eliminarConsultorio($numero) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "DELETE FROM consultorios WHERE ConNumero = '$numero'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function actualizarConsultorio($numero, $nombre) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "UPDATE consultorios SET ConNombre = '$nombre' WHERE ConNumero = '$numero'";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
    public function existeConsultorioPorNumero($numero) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT COUNT(*) as total FROM consultorios WHERE ConNumero = '$numero'";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        ///////////// Si obtenerResult devuelve un array
        if (is_array($result) && isset($result[0]['total'])) {
            return $result[0]['total'] > 0;
        }
        if ($result instanceof mysqli_result) {
            $row = $result->fetch_assoc();
            return $row['total'] > 0;
        }
        return false;
    }
    public function agregarConsultorio($numero, $nombre) {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "INSERT INTO consultorios (ConNumero, ConNombre) VALUES ('$numero', '$nombre')";
        $conexion->consulta($sql);
        $conexion->cerrar();
    }
}
