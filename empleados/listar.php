<?php
require_once '../auth.php';
requireAdmin();
include '../conexion.php';

$error = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_empleado'], $_POST['cargo'])) {
    $id = (int) $_POST['id_empleado'];
    $cargo = in_array($_POST['cargo'], ['admin', 'vendedor', 'usuario']) ? $_POST['cargo'] : 'usuario';

    $adminCount = $conexion->query("SELECT COUNT(*) FROM empleados WHERE cargo = 'admin'")->fetchColumn();
    $stmt = $conexion->prepare('SELECT cargo FROM empleados WHERE id_empleado = :id');
    $stmt->execute([':id' => $id]);
    $current = $stmt->fetchColumn();

    if ($current === 'admin' && $cargo !== 'admin' && $adminCount <= 1) {
        $error = 'Debe existir al menos un administrador.';
    } else {
        $update = $conexion->prepare('UPDATE empleados SET cargo = :cargo WHERE id_empleado = :id');
        $update->execute([':cargo' => $cargo, ':id' => $id]);
        $message = 'Permisos actualizados correctamente.';
    }
}

$empleados = $conexion->query('SELECT * FROM empleados ORDER BY id_empleado')->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Usuarios</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Administrar Usuarios</h1>
            <p class="subtitle">Administra cuentas y asigna permisos desde esta pantalla.</p>
        </div>
        <button type="button" class="btn back-button" onclick="location.href='../dashboard.php'">Volver</button>
    </div>

    <?php if ($error): ?>
        <div class="chart-card" style="border-color:#f87171;color:#b91c1c;"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($message): ?>
        <div class="chart-card" style="border-color:#34d399;color:#064e3b;"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <p style="margin-bottom:1rem;">Puedes registrar cuentas nuevas en <a href="../registro.php">Registro</a>.</p>
    <table>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acción</th>
        </tr>
        <?php foreach ($empleados as $empleado): ?>
            <tr>
                <td><?= htmlspecialchars($empleado['id_empleado']) ?></td>
                <td><?= htmlspecialchars($empleado['nombre']) ?></td>
                <td><?= htmlspecialchars($empleado['correo']) ?></td>
                <td>
                    <form method="POST" style="display:inline-flex; gap:0.5rem; align-items:center;">
                        <input type="hidden" name="id_empleado" value="<?= htmlspecialchars($empleado['id_empleado']) ?>">
                        <select name="cargo">
                            <option value="usuario" <?= $empleado['cargo'] === 'usuario' ? 'selected' : '' ?>>Usuario</option>
                            <option value="vendedor" <?= $empleado['cargo'] === 'vendedor' ? 'selected' : '' ?>>Vendedor</option>
                            <option value="admin" <?= $empleado['cargo'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                        </select>
                        <button type="submit" class="btn">Guardar</button>
                    </form>
                </td>
                <td><?= htmlspecialchars($empleado['cargo']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>