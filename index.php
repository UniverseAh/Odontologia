<?php
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
        require_once 'Modelo/Medico.php';
        $medicos = obtenerMedicos();
        include 'Vista/html/medicos.php';
        exit;
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'agregar_medico' && $_SERVER['REQUEST_METHOD'] == 'POST') {
        require_once 'Modelo/Medico.php';
        agregarMedico($_POST['nombre'], $_POST['especialidad']);
        header('Location: index.php?accion=medicos');
        exit;
    } elseif (isset($_GET['accion']) && $_GET['accion'] == 'eliminar_medico' && isset($_GET['id'])) {
        require_once 'Modelo/Medico.php';
        eliminarMedico($_GET['id']);
        header('Location: index.php?accion=medicos');
        exit;
    }
} else {
    $controlador->verPagina('Vista/html/inicio.php');
}
