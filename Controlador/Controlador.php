<?php
class Controlador
{
    public function verPagina($ruta)
    {
        require_once $ruta;
    }
    ////////Citas
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
    ///////pacientes
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
    //////////horas
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
    /////////////medicos
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
    
    //panel de paciente
    public function panelPaciente($pacienteId)
    {
        $gestorCita = new GestorCita();
        $citas = $gestorCita->obtenerCitasPorPaciente($pacienteId);
        $tratamientos = $gestorCita->obtenerTratamientosPorPaciente($pacienteId);
        require 'Vista/html/Paciente.php';
    }

    ///////////// tratamientos
    public function listarTratamientos() {
        $gestorCita = new GestorCita();
        $tratamientos = $gestorCita->obtenerTodosLosTratamientos();
        require 'Vista/html/listarTratamientos.php';
    }

    public function agregarTratamiento($datos) {
        $gestorCita = new GestorCita();
        $gestorCita->agregarTratamiento($datos);
        header('Location: index.php?accion=tratamientos');
        exit;
    }

    public function editarTratamiento($id, $datos) {
        $gestorCita = new GestorCita();
        $gestorCita->editarTratamiento($id, $datos);
        header('Location: index.php?accion=tratamientos');
        exit;
    }

    public function eliminarTratamiento($id) {
        $gestorCita = new GestorCita();
        $gestorCita->eliminarTratamiento($id);
        header('Location: index.php?accion=tratamientos');
        exit;
    }


    //////Consultorios
    public function mostrarConsultorio($editarNumero = null)
    {
        $gestorCita = new GestorCita();
        $result = $gestorCita->consultarConsultorios();
        $consultorioEditar = null;
        if ($editarNumero) {
            $consultorioEditar = $gestorCita->consultarConsultorioPorNumero($editarNumero);
        }
        require 'Vista/html/consultorio.php';
    }
    public function eliminarConsultorio($numero)
    {
        $gestorCita = new GestorCita();
        if ($gestorCita->tieneCitasAgendadas($numero)) {
            $mensaje = "Error, No se puede eliminar consultorio.";
        } else {
            $gestorCita->eliminarConsultorio($numero);
            $mensaje = "Consultorio eliminado";
        }
        $result = $gestorCita->consultarConsultorios();
        require 'Vista/html/consultorio.php';
    }
    public function editarConsultorio($numero)
    {
        $gestorCita = new GestorCita();
        $consultorio = $gestorCita->consultarConsultorioPorNumero($numero);
        require 'Vista/html/editarConsultorio.php';
    }

    public function actualizarConsultorio($numero, $nombre)
    {
        $gestorCita = new GestorCita();
        $gestorCita->actualizarConsultorio($numero, $nombre);
        $result = $gestorCita->consultarConsultorios();
        $mensaje = "Consultorio actualizado";
        require 'Vista/html/consultorio.php';
    }
    public function agregarConsultorio($numero, $nombre)
    {
        $gestorCita = new GestorCita();
        if ($gestorCita->existeConsultorioPorNumero($numero)) {
            $mensaje = "Error, ya existe un consultorio con ese número.";
        } else {
            $gestorCita->agregarConsultorio($numero, $nombre);
            $mensaje = "Consultorio agregado";
        }
        $result = $gestorCita->consultarConsultorios();
        require 'Vista/html/consultorio.php';
    }
}


//------------------------login de mrd-----------------------

if (
    $_SERVER['REQUEST_METHOD'] == 'POST' &&
    isset($_POST['usuario']) &&
    isset($_POST['clave']) &&
    isset($_POST['rol'])
) {
    $conn = new mysqli("localhost", "root", "", "citas");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];


    if ($rol === 'Administrador') {
        $sql = "SELECT * FROM administradores WHERE AdminId = ? AND AdminContra = ? AND AdminRol = 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) { die("Error en prepare: " . $conn->error); }
        $stmt->bind_param("ss", $usuario, $clave);
    } elseif ($rol === 'Medico') {
        $sql = "SELECT * FROM medicos WHERE MedIdentificacion = ? AND MedContra = ? AND MedRol = 2";
        $stmt = $conn->prepare($sql);
        if (!$stmt) { die("Error en prepare: " . $conn->error); }
        $stmt->bind_param("ss", $usuario, $clave);
    } elseif ($rol === 'Paciente') {
        $sql = "SELECT * FROM pacientes WHERE PacIdentificacion = ? AND PacContra = ? AND PacRol = 3";
        $stmt = $conn->prepare($sql);
        if (!$stmt) { die("Error en prepare: " . $conn->error); }
        $stmt->bind_param("ss", $usuario, $clave);
    } else {
        $error = "Rol no válido.";
        $conn->close();
        return;
    }

    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        session_start();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;
        $conn->close();
        if ($rol == 'Administrador') {
            header("Location: Vista/html/inicio.php");
        } elseif ($rol == 'Medico') {
            header("Location: Vista/html/inicio.php");
        } elseif ($rol == 'Paciente') {
            header("Location: Vista/html/inicio.php");
        }
        exit();
    } else {
        $error = "ID o contraseña incorrectos para $rol.";
        $conn->close();
        header("Location: Vista/html/login.php?error=" . urlencode($error));
        exit();
    }
}
/////////////// 
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3 && isset($_GET['accion']) && $_GET['accion'] == 'tratamientos') {
    require_once 'Modelo/Tratamientos.php';
    $tratamientos = obtenerTratamientosPorPaciente($_SESSION['usuario']);
    include 'Vista/html/listarTratamientos.php';
    exit;
}
?>
