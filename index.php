<?php
session_start();

//cosito pa cerrar sesion
if (isset($_GET['accion']) && $_GET['accion'] == 'logout') {
    session_destroy();
    header('Location: index.php?accion=login');
    exit;
}

if (
    (!isset($_SESSION['usuario']) || empty($_SESSION['usuario'])) &&
    (!isset($_GET['accion']) || $_GET['accion'] != 'login')
) {
    header('Location: index.php?accion=login');
    exit;
}

// login
if (isset($_GET['accion']) && $_GET['accion'] == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rol = $_POST['rol'];

    $conn = new mysqli("localhost", "root", "", "citas");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($rol == 'Administrador' || $rol == '1') {
        $sql = "SELECT * FROM administradores WHERE AdminId = ? AND AdminContra = ? AND AdminRol = 1";
    } elseif ($rol == 'Medico' || $rol == '2') {
        $sql = "SELECT * FROM medicos WHERE MedIdentificacion = ? AND MedContra = ? AND MedRol = 2";
    } elseif ($rol == 'Paciente' || $rol == '3') {
        $sql = "SELECT * FROM pacientes WHERE PacIdentificacion = ? AND PacContra = ? AND PacRol = 3";
    } else {
        $error = "Rol no válido.";
        $conn->close();
        include 'Vista/html/login.php';
        exit;
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $usuario, $clave);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $rol;
        $conn->close();
        if ($rol == 'Paciente' || $rol == '3') {
            header('Location: index.php?accion=panelPaciente');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
        $conn->close();
        include 'Vista/html/login.php';
        exit;
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'login') {
    if (isset($error)) {
        include 'Vista/html/login.php';
    } else {
        $error = null;
        include 'Vista/html/login.php';
    }
    exit;
}

///////////////////////////////////////////////////////////
require_once 'Controlador/Controlador.php';
require_once 'Modelo/GestionCita.php';
require_once 'Modelo/Citas.php';
require_once 'Modelo/Paciente.php';
require_once 'Modelo/Conexion.php';
$controlador = new Controlador();
if (isset($_GET["accion"])) {
    if ($_GET["accion"] == "asignar") {
        $controlador->cargarAsignar();
    } elseif ($_GET["accion"] == "consultar") {
        $controlador->verPagina('Vista/html/consultar.php');
    } elseif ($_GET["accion"] == "cancelar") {
        $controlador->verPagina('Vista/html/cancelar.php');
    } elseif ($_GET["accion"] == "guardarCita") {
        $controlador->agregarCita(
            $_POST["asignarDocumento"],
            $_POST["medico"],
            $_POST["fecha"],
            $_POST["hora"],
            $_POST["consultorio"]
        );
    } elseif ($_GET["accion"] == "consultarCita") {
        $controlador->consultarCitas($_GET["consultarDocumento"]);
    } elseif ($_GET["accion"] == "cancelarCita") {
        $controlador->cancelarCitas($_GET["cancelarDocumento"]);
    } elseif ($_GET["accion"] == "ConsultarPaciente") {
        $controlador->consultarPaciente($_GET["documento"]);
    } elseif ($_GET["accion"] == "ingresarPaciente") {
        $controlador->agregarPaciente(
            $_GET["PacDocumento"],
            $_GET["PacNombres"],
            $_GET["PacApellidos"],
            $_GET["PacNacimiento"],
            $_GET["PacSexo"]
        );
    } elseif ($_GET["accion"] == "consultarHora") {
        $controlador->consultarHorasDisponibles($_GET["medico"], $_GET["fecha"]);
    } elseif ($_GET["accion"] == "verCita") {
        $controlador->verCita($_GET["numero"]);
    } elseif ($_GET["accion"] == "confirmarCancelar") {
        $controlador->confirmarCancelarCita($_GET["numero"]);
    } elseif ($_GET['accion'] == 'medicos') {
        $controlador->listarMedicos();
    } elseif ($_GET['accion'] == 'agregarMedico' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->agregarMedico(
            $_POST["MedIdentificacion"],
            $_POST["MedNombres"],
            $_POST["MedApellidos"]
        );
        header('Location: index.php?accion=medicos');
        exit;
    } elseif ($_GET['accion'] == 'eliminarMedico' && isset($_GET['id'])) {
        $controlador->eliminarMedico($_GET["id"]);
        header('Location: index.php?accion=medicos');
        exit;
    } elseif ($_GET['accion'] == 'editarMedico' && isset($_GET['id'])) {
        $controlador->editarMedico($_GET["id"]);
        header('Location: index.php?accion=medicos');
        exit;
    } elseif ($_GET['accion'] == 'actualizarMedico' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->actualizarMedico(
            $_POST["MedIdentificacion"],
            $_POST["MedNombres"],
            $_POST["MedApellidos"]
        );
        ///////consultorios y tratamientos
    } elseif ($_GET["accion"] == "consultorio") {
        $editarNumero = isset($_GET["editar"]) ? $_GET["editar"] : null;
        $controlador->mostrarConsultorio($editarNumero);
    } elseif ($_GET["accion"] == "eliminarConsultorio") {
        $controlador->eliminarConsultorio($_GET["numero"]);
    } elseif ($_GET["accion"] == "editarConsultorio") {
        $controlador->editarConsultorio($_GET["numero"]);
    } elseif ($_GET["accion"] == "actualizarConsultorio") {
        $controlador->actualizarConsultorio($_GET["numero"], $_GET["nombre"]);
    } elseif ($_GET["accion"] == "agregarConsultorio") {
        $controlador->agregarConsultorio($_GET["numero"], $_GET["nombre"]);
    } elseif ($_GET['accion'] == 'tratamientos') {
        $controlador->listarTratamientos();
    } elseif ($_GET['accion'] == 'mostrarAgregarTratamiento') {
        include 'Vista/html/agregarTratamiento.php';
    } elseif ($_GET['accion'] == 'agregarTratamiento' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->agregarTratamiento($_POST);
    } elseif ($_GET['accion'] == 'mostrarEditarTratamiento' && isset($_GET['id'])) {
        $gestorCita = new GestorCita();
        $tratamiento = $gestorCita->obtenerTratamientoPorId($_GET['id']);
        include 'Vista/html/editarTratamiento.php';
    } elseif ($_GET['accion'] == 'editarTratamiento' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->editarTratamiento($_POST['TraNumero'], $_POST);
    } elseif ($_GET['accion'] == 'eliminarTratamiento' && isset($_GET['id'])) {
        $controlador->eliminarTratamiento($_GET['id']);
    } elseif ($_GET['accion'] == 'agregarTratamiento') {
        include 'Vista/html/agregarTratamiento.php';
    } elseif ($_GET['accion'] == 'editarTratamiento') {
        include 'Vista/html/editarTratamiento.php';
    } elseif ($_GET['accion'] == 'consultorio') {
        include 'Vista/html/consultorio.php';
    }
} elseif (isset($_GET["accion"]) && $_GET["accion"] == "panelPaciente") {
    if ($_SESSION['rol'] == 'Paciente' || $_SESSION['rol'] == '3') {
        $controlador->panelPaciente($_SESSION['usuario']);
    } else {
        header('Location: index.php');
        exit;
    }
} else {
    $controlador->verPagina('Vista/html/inicio.php');
}
?>
