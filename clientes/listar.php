<?php require_once '../auth.php'; requireRole(['gerente','vendedor','contador','auditor']); include '../conexion.php'; ?>


<?php
$clientes = $conexion->query("SELECT * FROM clientes");
$error = $_GET['error'] ?? '';
$success = isset($_GET['success']);
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Listado de Clientes</h1>
            <p class="subtitle">Gestión de clientes registrados en el sistema.</p>
        </div>
        <button type="button" class="btn back-button" onclick="history.back()">Volver</button>
    </div>

    <a href="agregar.php" class="btn">Nuevo Cliente</a>

    <?php if ($error === 'has_sales'): ?>
        <p class="alert alert-error">No se puede eliminar el cliente porque tiene ventas registradas.</p>
    <?php elseif ($success): ?>
        <p class="alert alert-success">Cliente eliminado correctamente.</p>
    <?php endif; ?>

    <table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Email</th>
        <th>Teléfono</th>
        <th>Acciones</th>
    </tr>

    <?php foreach($clientes as $cliente): ?>
    <tr>
        <td><?= $cliente['id_cliente']; ?></td>
        <td><?= $cliente['nombre']; ?></td>
        <td><?= $cliente['apellido']; ?></td>
        <td><?= $cliente['email']; ?></td>
        <td><?= $cliente['telefono']; ?></td>
        <td class="action-cell">
            <a href="editar_clientes.php?id=<?= $cliente['id_cliente']; ?>" class="action-link" title="Editar cliente">
                <img src="../img/edit.png" alt="Editar" class="action-icon">
            </a>
            <a href="eliminar.php?id=<?= $cliente['id_cliente']; ?>" class="action-link" title="Eliminar cliente" onclick="return confirm('¿Confirmar eliminación del cliente?');">
                <img src="../img/delete.png" alt="Eliminar" class="action-icon">
            </a>
        </td>
    </tr>
    <?php endforeach; ?>

</table>
</main>

</body>
</html> 