<?php require_once 'auth.php'; requireAuth(); include 'conexion.php'; ?>

<?php
$clientes = $conexion->query("SELECT COUNT(*) FROM clientes")->fetchColumn();
$productos = $conexion->query("SELECT COUNT(*) FROM productos")->fetchColumn();
$ventas = $conexion->query("SELECT COUNT(*) FROM ventas")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
<header>
    <h1>MarketPlace Express</h1>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="clientes/listar.php">Clientes</a>
        <a href="productos/listar.php">Productos</a>
        <a href="ventas/nueva_venta.php">Ventas</a>
        <a href="reportes/reportes.php">Reportes</a>
        <?php if (isAdmin()): ?>
            <a href="empleados/listar.php">Usuarios</a>
        <?php endif; ?>
        <a href="logout.php">Cerrar sesión</a>
    </nav>
</header>

<main class="section">
    <div class="page-header">
        <div>
            <h1>Dashboard Principal</h1>
            <p class="subtitle">Bienvenido <?= htmlspecialchars(currentUser()) ?>. Gestiona tus módulos desde aquí.</p>
        </div>
        <div class="button-group">
            <button type="button" class="btn" onclick="location.href='ventas/nueva_venta.php'">Registrar Venta</button>
            <?php if (isAdmin()): ?>
                <button type="button" class="btn" onclick="location.href='empleados/listar.php'">Administrar Usuarios</button>
            <?php endif; ?>
        </div>
    </div>

    <div class="dashboard">
        <div class="box">
            <h2><?php echo $clientes; ?></h2>
            <p>Clientes registrados</p>
            <a class="btn" href="clientes/listar.php">Ver clientes</a>
        </div>

        <div class="box">
            <h2><?php echo $productos; ?></h2>
            <p>Productos disponibles</p>
            <a class="btn" href="productos/listar.php">Ver productos</a>
        </div>

        <div class="box">
            <h2><?php echo $ventas; ?></h2>
            <p>Ventas registradas</p>
            <a class="btn" href="ventas/listar.php">Ver ventas</a>
        </div>
    </div>
</main>

</body>
</html>