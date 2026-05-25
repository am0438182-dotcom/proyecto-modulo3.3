<?php require_once '../auth.php'; requireRole(['gerente','contador','auditor']); include '../conexion.php'; ?>


<?php
$ventas = $conexion->query(
    'SELECT ventas.*, clientes.nombre AS cliente_nombre, clientes.apellido AS cliente_apellido FROM ventas INNER JOIN clientes ON ventas.id_cliente = clientes.id_cliente ORDER BY ventas.fecha DESC'
)->fetchAll(PDO::FETCH_ASSOC);

$detalleStmt = $conexion->prepare(
    'SELECT detalle_ventas.*, productos.nombre AS producto_nombre FROM detalle_ventas INNER JOIN productos ON detalle_ventas.id_producto = productos.id_producto WHERE detalle_ventas.id_venta = :venta'
);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ventas</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<header>
    <h1>MarketPlace Express</h1>
    <nav>
        <a href="../dashboard.php">Dashboard</a>
        <a href="../clientes/listar.php">Clientes</a>
        <a href="../productos/listar.php">Productos</a>
        <a href="nueva_venta.php">Nueva Venta</a>
        <a href="../logout.php">Cerrar sesión</a>
    </nav>
</header>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Listado de Ventas</h1>
            <p class="subtitle">Historial y detalle de ventas registradas.</p>
        </div>
        <button type="button" class="btn back-button" onclick="history.back()">Volver</button>
    </div>

    <table>
        <tr>
            <th>ID Venta</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Detalle</th>
        </tr>
        <?php foreach ($ventas as $venta): ?>
        <tr>
            <td><?= $venta['id_venta'] ?></td>
            <td><?= htmlspecialchars($venta['cliente_nombre'] . ' ' . $venta['cliente_apellido']) ?></td>
            <td>$<?= number_format($venta['total'], 2) ?></td>
            <td><?= $venta['fecha'] ?></td>
            <td>
                <table class="nested-detail-table">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                    <?php
                    $detalleStmt->execute([':venta' => $venta['id_venta']]);
                    $detalles = $detalleStmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($detalles as $detalle):
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($detalle['producto_nombre']) ?></td>
                        <td><?= $detalle['cantidad'] ?></td>
                        <td>$<?= number_format($detalle['precio'], 2) ?></td>
                        <td>$<?= number_format($detalle['subtotal'], 2) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="nested-total-row">
                        <td colspan="3" style="text-align:right;font-weight:700;">Total</td>
                        <td style="font-weight:700;">$<?= number_format($venta['total'], 2) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>
