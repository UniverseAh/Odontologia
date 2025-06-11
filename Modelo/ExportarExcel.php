<?php
function exportarCitasExcel() {
    // Configurar header para Excel con HTML
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="Reporte_Citas_'.date('Y-m-d').'.xls"');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    $conn = new mysqli("localhost", "root", "", "citas");
    $conn->set_charset("utf8");
    
    $sql = "SELECT 
        c.CitNumero as 'Número de Cita',
        DATE_FORMAT(c.CitFecha, '%d/%m/%Y') as 'Fecha',
        c.CitHora as 'Hora',
        CONCAT(p.PacNombres, ' ', p.PacApellidos) as 'Paciente',
        p.PacIdentificacion as 'Documento Paciente',
        CONCAT(m.MedNombres, ' ', m.MedApellidos) as 'Médico',
        m.MedIdentificacion as 'Documento Médico',
        con.ConNombre as 'Consultorio',
        c.CitEstado as 'Estado',
        IFNULL(c.CitObservaciones, 'Sin observaciones') as 'Observaciones'
    FROM citas c
    JOIN pacientes p ON c.CitPaciente = p.PacIdentificacion
    JOIN medicos m ON c.CitMedico = m.MedIdentificacion
    JOIN consultorios con ON c.CitConsultorio = con.ConNumero
    ORDER BY c.CitFecha DESC, c.CitHora ASC";
    
    $result = $conn->query($sql);
    
    // Inicio del documento HTML
    echo '
    <html>
    <head>
        <meta charset="UTF-8">
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
                margin: 20px 0;
            }
            th {
                background-color: #4CAF50;
                color: white;
                font-weight: bold;
                padding: 12px;
                border: 1px solid #ddd;
                text-align: center;
            }
            td {
                padding: 8px;
                border: 1px solid #ddd;
                text-align: center;
            }
            tr:nth-child(even) {
                background-color: #f2f2f2;
            }
            .titulo {
                background-color: #2E7D32;
                color: white;
                text-align: center;
                padding: 15px;
                font-size: 20px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class="titulo">Reporte de Citas Médicas - ' . date('d/m/Y') . '</div>
        <table>
            <tr>
                <th>Número de Cita</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Documento Paciente</th>
                <th>Médico</th>
                <th>Documento Médico</th>
                <th>Consultorio</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>';
    
    // Escribir datos
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['Número de Cita'] . '</td>';
        echo '<td>' . $row['Fecha'] . '</td>';
        echo '<td>' . $row['Hora'] . '</td>';
        echo '<td>' . $row['Paciente'] . '</td>';
        echo '<td>' . $row['Documento Paciente'] . '</td>';
        echo '<td>' . $row['Médico'] . '</td>';
        echo '<td>' . $row['Documento Médico'] . '</td>';
        echo '<td>' . $row['Consultorio'] . '</td>';
        echo '<td>' . $row['Estado'] . '</td>';
        echo '<td>' . $row['Observaciones'] . '</td>';
        echo '</tr>';
    }
    
    echo '</table></body></html>';
    
    $conn->close();
    exit();
}