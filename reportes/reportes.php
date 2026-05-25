<?php require_once '../auth.php'; requireRole(['gerente','contador','auditor']); include '../conexion.php'; ?>


<?php
$sqlCategorias = "SELECT c.nombre AS categoria, COUNT(p.id_producto) AS total
                  FROM categorias c
                  LEFT JOIN productos p ON p.id_categoria = c.id_categoria
                  GROUP BY c.id_categoria
                  ORDER BY total DESC";

$sqlClientes = "SELECT cl.nombre AS cliente, COUNT(v.id_venta) AS total
                FROM ventas v
                LEFT JOIN clientes cl ON v.id_cliente = cl.id_cliente
                GROUP BY cl.id_cliente
                ORDER BY total DESC";

$sqlProductos = "SELECT nombre, stock FROM productos ORDER BY nombre";

$sqlVentas = "SELECT v.id_venta, cl.nombre AS cliente, v.total
              FROM ventas v
              LEFT JOIN clientes cl ON v.id_cliente = cl.id_cliente
              ORDER BY v.id_venta";

$categorias = $conexion->query($sqlCategorias)->fetchAll(PDO::FETCH_ASSOC);
$clientesVentas = $conexion->query($sqlClientes)->fetchAll(PDO::FETCH_ASSOC);
$productos = $conexion->query($sqlProductos)->fetchAll(PDO::FETCH_ASSOC);
$ventas = $conexion->query($sqlVentas)->fetchAll(PDO::FETCH_ASSOC);

$catLabels = [];
$catData = [];
foreach ($categorias as $row) {
    $catLabels[] = $row['categoria'];
    $catData[] = (int) $row['total'];
}

$clienteLabels = [];
$clienteData = [];
foreach ($clientesVentas as $row) {
    $clienteLabels[] = $row['cliente'] ?: 'Cliente desconocido';
    $clienteData[] = (int) $row['total'];
}

$productoLabels = [];
$productoData = [];
foreach ($productos as $row) {
    $productoLabels[] = $row['nombre'];
    $productoData[] = (int) $row['stock'];
}

$ventaLabels = [];
$ventaData = [];
foreach ($ventas as $row) {
    $ventaLabels[] = 'Venta #' . $row['id_venta'];
    $ventaData[] = (float) $row['total'];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
    <link rel="stylesheet" href="../css/estilos.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Reportes</h1>
            <p class="subtitle">Visualiza métricas de categorías, clientes, productos y ventas.</p>
        </div>
        <button type="button" class="btn back-button" onclick="history.back()">Volver</button>
    </div>

    <div class="report-grid">
        <div class="chart-card">
            <h2>Categorías</h2>
            <canvas id="chartCategorias"></canvas>
        </div>
        <div class="chart-card">
            <h2>Clientes</h2>
            <canvas id="chartClientes"></canvas>
        </div>
        <div class="chart-card">
            <h2>Productos</h2>
            <canvas id="chartProductos"></canvas>
        </div>
        <div class="chart-card">
            <h2>Ventas</h2>
            <canvas id="chartVentas"></canvas>
        </div>
    </div>

    <script>
        const chartConfig = (ctx, labels, data, label, color) => new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label,
                    data,
                    backgroundColor: color,
                    borderColor: color.replace('0.75', '1'),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        chartConfig(
            document.getElementById('chartCategorias').getContext('2d'),
            <?= json_encode($catLabels); ?>,
            <?= json_encode($catData); ?>,
            'Productos por categoría',
            'rgba(37, 99, 235, 0.75)'
        );

        chartConfig(
            document.getElementById('chartClientes').getContext('2d'),
            <?= json_encode($clienteLabels); ?>,
            <?= json_encode($clienteData); ?>,
            'Ventas por cliente',
            'rgba(16, 185, 129, 0.75)'
        );

        chartConfig(
            document.getElementById('chartProductos').getContext('2d'),
            <?= json_encode($productoLabels); ?>,
            <?= json_encode($productoData); ?>,
            'Stock por producto',
            'rgba(234, 179, 8, 0.75)'
        );

        chartConfig(
            document.getElementById('chartVentas').getContext('2d'),
            <?= json_encode($ventaLabels); ?>,
            <?= json_encode($ventaData); ?>,
            'Total por venta',
            'rgba(239, 68, 68, 0.75)'
        );
    </script>
</main>
</body>
</html>