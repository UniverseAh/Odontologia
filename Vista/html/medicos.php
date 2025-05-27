<h2>Consultar Médicos</h2>

<!-- Formulario para agregar médico -->
<form method="post" action="index.php?accion=agregar_medico">
    <input type="text" name="identificacion" placeholder="Identificación" required>
    <input type="text" name="nombre" placeholder="Nombre" required>
    <input type="text" name="apellido" placeholder="Apellido" required>
    <button type="submit">Agregar Médico</button>
</form>

<!-- Lista de médicos -->
<table border="1">
    <tr>
        <th>Identificación</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Acciones</th>
    </tr>
    <?php foreach($medicos as $medico): ?>
    <tr>
        <td><?php echo htmlspecialchars($medico['identificacion']); ?></td>
        <td><?php echo htmlspecialchars($medico['nombre']); ?></td>
        <td><?php echo htmlspecialchars($medico['apellido']); ?></td>
        <td>
            <span style="display:inline-block; background:#e0e0e0; padding:4px 8px; margin-right:5px; border-radius:4px;">
                <a href="index.php?accion=editar_medico&id=<?php echo $medico['id']; ?>">Editar</a>
            </span>
            <span style="display:inline-block; background:#ffcccc; padding:4px 8px; border-radius:4px;">
                <a href="index.php?accion=eliminar_medico&id=<?php echo $medico['id']; ?>" onclick="return confirm('¿Seguro que deseas eliminar este médico?');">Eliminar</a>
            </span>
        </td>
    </tr>
    <?php endforeach; ?>
</table>