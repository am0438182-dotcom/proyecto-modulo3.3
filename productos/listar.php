<?php require_once '../auth.php'; requireRole(['gerente','contador']); include '../conexion.php'; ?>

<?php
$search = trim($_GET['search'] ?? '');

$categoriaFiltro = $_GET['categoria'] ?? '';
$categorias = $conexion->query("SELECT * FROM categorias ORDER BY nombre ASC");

$where = [];
$params = [];
if ($search !== '') {
    $where[] = "(productos.nombre LIKE :search OR categorias.nombre LIKE :search)";
    $params[':search'] = "%{$search}%";
}
if ($categoriaFiltro !== '') {
    $where[] = "productos.id_categoria = :categoria";
    $params[':categoria'] = $categoriaFiltro;
}

$sql = "SELECT productos.*, categorias.nombre AS categoria
        FROM productos
        INNER JOIN categorias
        ON productos.id_categoria = categorias.id_categoria";

if (count($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}
$sql .= " ORDER BY productos.nombre ASC";

$stmt = $conexion->prepare($sql);
$stmt->execute($params);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Mensajes desde acciones (agregar/editar/eliminar)
$msg = $_GET['msg'] ?? '';
$nombreMsg = $_GET['nombre'] ?? '';
$messageText = '';
$messageClass = '';
if($msg === 'exists'){
    $messageText = 'El producto "' . htmlspecialchars($nombreMsg) . '" ya está registrado.';
    $messageClass = 'error';
} elseif($msg === 'created'){
    $messageText = 'Producto registrado correctamente.';
    $messageClass = 'success';
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>
<main class="section">
    <div class="page-header">
        <div>
            <h1>Listado de Productos</h1>
            <p class="subtitle">Información de stock y precios disponibles.</p>
        </div>
        <div class="page-actions">
            <a href="agregar.php" class="btn">Agregar Producto</a>
            <button type="button" class="btn back-button" onclick="history.back()">Volver</button>
        </div>
    </div>

    <?php if($messageText): ?>
        <p class="<?= $messageClass ?>"><?= $messageText ?></p>
    <?php endif; ?>

    <form method="GET" class="filters">
        <div class="filter-row">
            <input type="search" name="search" placeholder="Buscar producto..." value="<?= htmlspecialchars($search) ?>">

            <select name="categoria">
                <option value="">Todas las categorías</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria'] ?>" <?= $categoriaFiltro == $categoria['id_categoria'] ? 'selected' : '' ?>><?= htmlspecialchars($categoria['nombre']) ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="btn">Filtrar</button>
        </div>
    </form>

    <table>
        <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Stock</th>
            <th>Categoría</th>
            <th>Acciones</th>
        </tr>

        <?php foreach($productos as $producto): ?>
        <tr>
            <td><?= $producto['nombre']; ?></td>
            <td>$<?= $producto['precio']; ?></td>
            <td><?= $producto['stock']; ?></td>
            <td><?= $producto['categoria']; ?></td>
            <td class="action-cell">
                <a href="editar.php?id=<?= $producto['id_producto']; ?>" class="action-link" title="Editar producto">
                    <img src="../img/edit.png" alt="Editar" class="action-icon">
                </a>
                <a href="eliminar.php?id=<?= $producto['id_producto']; ?>" class="action-link" title="Eliminar producto">
                    <img src="../img/delete.png" alt="Eliminar" class="action-icon">
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</main>
</body>
</html>