<?php
session_start();

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

    if ($usuario === 'admin' && $clave === 'admin123') {
        $_SESSION['usuario'] = $usuario;
        header('Location: index.php');
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos";
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
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'medicos') {
        $controlador->listarMedicos();
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'agregarMedico' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->agregarMedico(
            $_POST["MedIdentificacion"],
            $_POST["MedNombres"],
            $_POST["MedApellidos"]
        );
        header('Location: index.php?accion=medicos');
        exit;
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'eliminarMedico' && isset($_GET['id'])) {
        $controlador->eliminarMedico($_GET["id"]);
        header('Location: index.php?accion=medicos');
        exit;
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'editarMedico' && isset($_GET['id'])) {
        $controlador->editarMedico($_GET["id"]);
        header('Location: index.php?accion=medicos');
        exit;
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'actualizarMedico' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        $controlador->actualizarMedico(
            $_POST["MedIdentificacion"],
            $_POST["MedNombres"],
            $_POST["MedApellidos"]
        );
    }
} else {
    $controlador->verPagina('Vista/html/inicio.php');
}
?>
