hola
<?php require_once 'auth.php'; requireAuth(); ?>
<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MarketPlace Express</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header>
    <h1>MarketPlace Express</h1>
    <nav>
        <a href="login.php">Iniciar sesión</a>
        <a href="registro.php">Registrarse</a>
    </nav>
</header>

<section class="banner">
    <h2>Sistema de Gestión Empresarial</h2>
    <p>Control de clientes, productos, ventas y reportes.</p>
</section>
    
<section class="cards">
    <div class="card">
        <h3>Clientes</h3>
        <a href="clientes/listar.php">Administrar clientes registrados.</a>
    </div>

    <div class="card">
        <h3>Productos</h3>
        <a href="productos/listar.php">Control de stock y categorías.</a>
    </div>

    <div class="card">
        <h3>Ventas</h3>
        <a href="ventas/listar.php">Registro y control de ventas.</a>
    </div>
</section>

</body>
</html>