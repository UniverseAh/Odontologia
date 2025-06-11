<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1); /////cosito para mostrar errores
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

///////// Cerrar sesion
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

/////////////////// Login
if (isset($_GET['accion']) && $_GET['accion'] == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $clave = $_POST['clave'];
    $rolTexto = $_POST['rol'];

    $conn = new mysqli("localhost", "root", "", "citas");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

//////////////////// cosito para validar el rol
    switch ($rolTexto) {
        case 'Administrador':
            $sql = "SELECT * FROM administradores WHERE AdminId = ? AND AdminContra = ? AND AdminRol = 1";
            $rolNum = 1;
            break;
        case 'Medico':
            $sql = "SELECT * FROM medicos WHERE MedIdentificacion = ? AND MedContra = ? AND MedRol = 2";
            $rolNum = 2;
            break;
        case 'Paciente':
            $sql = "SELECT * FROM pacientes WHERE PacIdentificacion = ? AND PacContra = ? AND PacRol = 3";
            $rolNum = 3;
            break;
        default:
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
        $_SESSION['rol'] = $rolNum;
        $conn->close();
        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos";
        $conn->close();
        include 'Vista/html/login.php';
        exit;
    }
}

///////////////////// formulario de login
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

//////////////////cosito pa descargar el excel
    } elseif ($_GET["accion"] == "descargarExcelCitas" && $_SESSION['rol'] == 1) {
        require_once 'Modelo/ExportarExcel.php';
        exportarCitasExcel();
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

///////////////cosito pa descargar PDF de la cita
if (isset($_GET['accion']) && $_GET['accion'] == 'descargarCitaPDF' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    require('fpdf/fpdf.php');
    $citNumero = $_POST['CitNumero'];

    $conn = new mysqli("localhost", "root", "", "citas");
    $stmt = $conn->prepare("SELECT c.*, 
        p.PacNombres, p.PacApellidos, p.PacIdentificacion, 
        m.MedNombres, m.MedApellidos, m.MedIdentificacion, 
        con.ConNombre
        FROM citas c
        JOIN pacientes p ON c.CitPaciente = p.PacIdentificacion
        JOIN medicos m ON c.CitMedico = m.MedIdentificacion
        JOIN consultorios con ON c.CitConsultorio = con.ConNumero
        WHERE c.CitNumero = ?");
    $stmt->bind_param("i", $citNumero);
    $stmt->execute();
    $result = $stmt->get_result();
    $cita = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($cita) {
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $pdf->Cell(0,10,'Registro de Cita',0,1,'C');
        $pdf->SetFont('Arial','',12);
        $pdf->Ln(10);

        $pdf->Cell(0,10,'Datos del Paciente',0,1);
        $pdf->Cell(50,10,'Documento:',0,0); $pdf->Cell(0,10,$cita['PacIdentificacion'],0,1);
        $pdf->Cell(50,10,'Nombre:',0,0); $pdf->Cell(0,10,$cita['PacNombres'].' '.$cita['PacApellidos'],0,1);

        $pdf->Ln(5);
        $pdf->Cell(0,10,'Datos del Medico',0,1);
        $pdf->Cell(50,10,'Documento:',0,0); $pdf->Cell(0,10,$cita['MedIdentificacion'],0,1);
        $pdf->Cell(50,10,'Nombre:',0,0); $pdf->Cell(0,10,$cita['MedNombres'].' '.$cita['MedApellidos'],0,1);

        $pdf->Ln(5);
        $pdf->Cell(0,10,'Datos de la Cita',0,1);
        $pdf->Cell(50,10,'Numero:',0,0); $pdf->Cell(0,10,$cita['CitNumero'],0,1);
        $pdf->Cell(50,10,'Fecha:',0,0); $pdf->Cell(0,10,$cita['CitFecha'],0,1);
        $pdf->Cell(50,10,'Hora:',0,0); $pdf->Cell(0,10,$cita['CitHora'],0,1);
        $pdf->Cell(50,10,'Consultorio:',0,0); $pdf->Cell(0,10,$cita['ConNombre'],0,1);
        $pdf->Cell(50,10,'Estado:',0,0); $pdf->Cell(0,10,$cita['CitEstado'],0,1);
        $pdf->Cell(50,10,'Observaciones:',0,0); $pdf->Cell(0,10,$cita['CitObservaciones'],0,1);

        $pdf->Output('D', 'Cita_'.$cita['CitNumero'].'.pdf');
        exit;
    } else {
        echo "No se encontró la cita.";
        exit;
    }
}
////////////
if (isset($_SESSION['rol']) && $_SESSION['rol'] == 3 && $_GET['accion'] == 'tratamientos') {
    require_once 'Modelo/Tratamientos.php';
    $tratamientos = obtenerTratamientosPorPaciente($_SESSION['usuario']);
    include 'Vista/html/listarTratamientos.php';
    exit;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'enviarCorreoCita' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $citNumero = $_POST['CitNumero'];
    $correoDestino = $_POST['correo_destino'];

// Busca los datos de la cita
    $conn = new mysqli("localhost", "root", "", "citas");
    $stmt = $conn->prepare("SELECT c.*, 
        p.PacNombres, p.PacApellidos, p.PacIdentificacion, 
        m.MedNombres, m.MedApellidos, m.MedIdentificacion, 
        con.ConNombre
        FROM citas c
        JOIN pacientes p ON c.CitPaciente = p.PacIdentificacion
        JOIN medicos m ON c.CitMedico = m.MedIdentificacion
        JOIN consultorios con ON c.CitConsultorio = con.ConNumero
        WHERE c.CitNumero = ?");
    $stmt->bind_param("i", $citNumero);
    $stmt->execute();
    $result = $stmt->get_result();
    $cita = $result->fetch_assoc();
    $stmt->close();
    $conn->close();

    if ($cita) {
        // --- ENVÍO DE CORREO ---
        require_once __DIR__ . '/PHPMailer-master/src/PHPMailer.php';
        require_once __DIR__ . '/PHPMailer-master/src/SMTP.php';
        require_once __DIR__ . '/PHPMailer-master/src/Exception.php';

        $mail = new PHPMailer(true);
        try {
            // Configuración SMTP de Gmail(?
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arteagajuan782@gmail.com';
            $mail->Password = 'lwci psok xwcj ksdr';         
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('TUCORREO@gmail.com', 'Sistema Odontología');
            $mail->addAddress($correoDestino);

            $mail->isHTML(true);
            $mail->Subject = 'Registro de Cita';
            $mail->Body = "
                <h2>Registro de Cita</h2>
                <b>Paciente:</b> {$cita['PacNombres']} {$cita['PacApellidos']}<br>
                <b>Documento:</b> {$cita['PacIdentificacion']}<br>
                <b>Médico:</b> {$cita['MedNombres']} {$cita['MedApellidos']}<br>
                <b>Consultorio:</b> {$cita['ConNombre']}<br>
                <b>Fecha:</b> {$cita['CitFecha']}<br>
                <b>Hora:</b> {$cita['CitHora']}<br>
                <b>Estado:</b> {$cita['CitEstado']}<br>
                <b>Observaciones:</b> {$cita['CitObservaciones']}<br>
            ";

            $mail->send();
            echo "<script>
                alert('Correo enviado correctamente');
                window.location.href = 'index.php';
            </script>";
            exit;
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
        exit;
    } else {
        echo "No se encontró la cita.";
        exit;
    }
}

?>
