<?php
require_once __DIR__ . '/../conexion.php';
header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    if ($method === 'GET') {
        if ($id) {
            $stmt = $conexion->prepare('SELECT productos.*, categorias.nombre AS categoria FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria WHERE productos.id_producto = :id');
            $stmt->execute([':id' => $id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conexion->query('SELECT productos.*, categorias.nombre AS categoria FROM productos INNER JOIN categorias ON productos.id_categoria = categorias.id_categoria ORDER BY productos.nombre ASC');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if ($method === 'POST') {
        $stmt = $conexion->prepare('INSERT INTO productos(nombre, precio, stock, id_categoria) VALUES(:nombre, :precio, :stock, :categoria)');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':precio' => $input['precio'] ?? 0,
            ':stock' => $input['stock'] ?? 0,
            ':categoria' => $input['id_categoria'] ?? 1,
        ]);
        echo json_encode(['success' => true, 'id' => $conexion->lastInsertId()]);
        exit;
    }

    if ($method === 'PUT' && $id) {
        $stmt = $conexion->prepare('UPDATE productos SET nombre = :nombre, precio = :precio, stock = :stock, id_categoria = :categoria WHERE id_producto = :id');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':precio' => $input['precio'] ?? 0,
            ':stock' => $input['stock'] ?? 0,
            ':categoria' => $input['id_categoria'] ?? 1,
            ':id' => $id,
        ]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($method === 'DELETE' && $id) {
        $stmt = $conexion->prepare('DELETE FROM productos WHERE id_producto = :id');
        $stmt->execute([':id' => $id]);
        echo json_encode(['success' => true]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
