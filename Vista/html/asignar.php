<!DOCTYPE html>
<html>

<head>
    <title>Asignar Cita</title>
    <link rel="stylesheet" type="text/css" href="Vista/css/estilos.css">
    <link href="Vista/jquery/jquery-ui-1.14.1/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="Vista/jquery/jquery.js"></script>
    <script src="Vista/jquery/jquery-ui-1.14.1/jquery-ui.js" type="text/javascript"></script>
    <script src="Vista/js/script.js" type="text/javascript"></script>
    <script>
    </script>
</head>

<body>
    <div id="contenedor">
        <div id="encabezado">
            <h1>Sistema de Gestión Odontológica</h1>
        </div>
        <ul id="menu">
            <li><a href="index.php">inicio</a> </li>
            <li class="activa"><a href="index.php?accion=asignar">Asignar</a> </li>
            <li><a href="index.php?accion=consultar">Consultar Cita</a> </li>
            <li><a href="index.php?accion=cancelar">Cancelar Cita</a> </li>
        </ul>
        <div id="contenido">
            <h2>Asignar cita</h2>
            <p>Contenido de la página</p>
            <form id="frmasignar" action="index.php?accion=guardarCita" method="post">
                <table>
                    <tr>
                        <td>Documento del paciente</td>
                        <td><input type="text" name="asignarDocumento" id="asignarDocumento"></
                                td>
                    </tr>
                    <tr>
                        <td colspan="2"><input type="button" value="Consultar" name="asignarConsultar"
                                id="asignarConsultar" onclick="consultarPaciente()"></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="paciente"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>Médico</td>
                        <td>
                            <select id="medico" name="medico" onchange="cargarHoras()">
                                <option value="-1" selected="selected">---Selecione el
                                    Médico</option>
                                <?php

                                while ($fila = $result->fetch_object()) {
                                ?>

                                    <option value=<?php echo $fila->MedIdentificacion; ?>>
                                        <?php echo $fila->MedIdentificacion . " " . $fila->MedNombres . " " . $fila->MedApellidos; ?>


                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Fecha</td>
                        <td>
                            <input type="date" id="fecha" name="fecha" onchange="cargarHoras()">
                        </td>
                    </tr>
                    <tr>
                        <td>Consultorio</td>
                        <td>
                            <select id="consultorio" name="consultorio"
                                onchange="cargarHoras()">
                                <option value="-1" selected="selected">---Selecione el
                                    Consultorio</option>
                                <?php

                                while ($fila = $result2->fetch_object()) {
                                ?>

                                    <option value=<?php echo $fila->ConNumero; ?>>
                                        <?php echo $fila->ConNumero . " - " . $fila->ConNombre;

                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                      <tr>
                        <td>Hora</td>
                        <td>
                            <select id="hora" name="hora" onmousedown="seleccionarHora()">
                                <option value="-1" selected="selected">---Seleccione
                                    la hora ---</option>


                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" name="asignarEnviar" value="Enviar"
                                id="asignarEnviar">
                        </td>
                    </tr>
                </table>
            </form>
            <div id="frmPaciente" title="Agregar Nuevo Paciente">
                <form id="agregarPaciente">
                    <table>
                        <tr>
                            <td>Documento</td>

                            <td><input type="text" name="PacDocumento"

                                    id="PacDocumento"></td>
                        </tr>
                        <tr>

                            <td>Nombres</td>

                            <td><input type="text" name="PacNombres"

                                    id="PacNombres"></td>
                        </tr>
                        <tr>

                            <td>Apellidos</td>

                            <td><input type="text" name="PacApellidos"

                                    id="PacApellidos"></td>
                        </tr>
                        <tr>

                            <td>Fecha de Nacimiento</td>

                            <td><input type="date" name="PacNacimiento"

                                    id="PacNacimiento"></td>
                        </tr>
                        <tr>

                            <td>Sexo</td>

                            <td>

                                <select id="pacSexo" name="PacSexo">
                                    <option value="-1"
                                        selected="selected">--Selecione el sexo ---</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>

                                </select>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
</body>

</html>