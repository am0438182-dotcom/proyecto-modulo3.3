<?php include '../conexion.php'; ?>

<?php
if($_POST){

    $sql = "INSERT INTO clientes(nombre, apellido, email, telefono, direccion)
            VALUES(:nombre, :apellido, :email, :telefono, :direccion)";

    $stmt = $conexion->prepare($sql);

    $stmt->execute([
        ':nombre' => $_POST['nombre'],
        ':apellido' => $_POST['apellido'],
        ':email' => $_POST['email'],
        ':telefono' => $_POST['telefono'],
        ':direccion' => $_POST['direccion']
    ]);

    header('Location: listar.php');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Cliente</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Agregar Cliente</h1>
            <p class="subtitle">Registra un nuevo cliente en el sistema.</p>
        </div>
        <button type="button" class="btn back-button" onclick="history.back()">Volver</button>
    </div>

    <form method="POST">
        <input type="text" name="nombre" placeholder="Nombre" required>
        <input type="text" name="apellido" placeholder="Apellido" required>
        <input type="email" name="email" placeholder="Correo" required>
        <input type="text" name="telefono" placeholder="Teléfono">
        <input type="text" name="direccion" placeholder="Dirección">
        <button type="submit">Guardar Cliente</button>
    </form>
</main>
</body>
</html>