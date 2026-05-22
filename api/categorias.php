<?php
require_once __DIR__ . '/../conexion.php';
header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    if ($method === 'GET') {
        if ($id) {
            $stmt = $conexion->prepare('SELECT * FROM categorias WHERE id_categoria = :id');
            $stmt->execute([':id' => $id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conexion->query('SELECT * FROM categorias ORDER BY nombre ASC');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if ($method === 'POST') {
        $stmt = $conexion->prepare('INSERT INTO categorias(nombre, descripcion) VALUES(:nombre, :descripcion)');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':descripcion' => $input['descripcion'] ?? null,
        ]);
        echo json_encode(['success' => true, 'id' => $conexion->lastInsertId()]);
        exit;
    }

    if ($method === 'PUT' && $id) {
        $stmt = $conexion->prepare('UPDATE categorias SET nombre = :nombre, descripcion = :descripcion WHERE id_categoria = :id');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':descripcion' => $input['descripcion'] ?? null,
            ':id' => $id,
        ]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($method === 'DELETE' && $id) {
        $stmt = $conexion->prepare('DELETE FROM categorias WHERE id_categoria = :id');
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
