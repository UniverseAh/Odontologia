<?php
class Controlador
{
    public function verPagina($ruta)
    {
        require_once $ruta;
    }
    public function agregarCita($doc, $med, $fec, $hor, $con)
    {
        $cita = new Cita(
            null,
            $fec,
            $hor,
            $doc,
            $med,
            $con,
            "Solicitada",
            "Ninguna"
        );
        $gestorCita = new GestorCita();
        $id = $gestorCita->agregarCita($cita);
        $result = $gestorCita->consultarCitaPorId($id);
        require_once 'Vista/html/confirmarCita.php';
    }
    public function consultarCitas($doc)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitasPorDocumento($doc);
        require_once 'Vista/html/consultarCitas.php';
    }
    public function cancelarCitas($doc)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitasPorDocumento($doc);
        require_once 'Vista/html/cancelarCitas.php';
    }
    public function consultarPaciente($doc)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarPaciente($doc);
        require_once 'Vista/html/consultarPaciente.php';
    }
    public function agregarPaciente($doc, $nom, $ape, $fec, $sex)
    {
        $paciente = new Paciente($doc, $nom, $ape, $fec, $sex);
        $gestorCita = new GestorCita();
        $registros = $gestorCita->agregarPaciente($paciente);
        if ($registros > 0) {
            echo "Se insertó el paciente con exito";
        } else {
            echo "Error al grabar el paciente";
        }
    }
    public function cargarAsignar()
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarMedicos();
        $result2 = $gestorCita->consultarConsultorios();
        require_once 'Vista/html/asignar.php';
    }
    public function consultarHorasDisponibles($medico, $fecha)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarHorasDisponibles(
            $medico,
            $fecha
        );
        require_once 'Vista/html/consultarHoras.php';
    }
    public function verCita($cita)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarCitaPorId($cita);
        require_once 'Vista/html/confirmarCita.php';
    }
    public function confirmarCancelarCita($cita)
    {
        $gestorCita = new GestorCita();
        $registros = $gestorCita->cancelarCita($cita);
        if ($registros > 0) {
            echo "La cita se ha cancelado con éxito";
        } else {
            echo "Hubo un error al cancelar la cita";
        }
    }
    public function listarMedicos()
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarMedicos();
        require 'Vista/html/medicos.php';
    }
    public function agregarMedico($doc, $nom, $ape)
    {
        $gestorCita = new GestorCita();
        $gestorCita->agregarMedico($doc, $nom, $ape);
    }
    public function editarMedico($id)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarMedicoPorId($id);
        require 'Vista/html/editarMedico.php';
    }
    public function actualizarMedico($doc, $nom, $ape)
    {
        $gestorCita = new GestorCita();
        $gestorCita->actualizarMedico($doc, $nom, $ape);
        header('Location: index.php?accion=medicos');
        exit;
    }
    public function eliminarMedico($id)
    {
        $gestorCita = new GestorCita();
        $gestorCita->eliminarMedico($id);
    }
    public function consultarMedicos()
    {
        $conexion = new Conexion();
        $conexion->abrir();
        $sql = "SELECT * FROM medicos";
        $conexion->consulta($sql);
        $result = $conexion->obtenerResult();
        $conexion->cerrar();
        return $result;
    }
}
