<?php
require_once __DIR__ . '/../conexion.php';
header('Content-Type: application/json; charset=utf-8');
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

try {
    if ($method === 'GET') {
        if ($id) {
            $stmt = $conexion->prepare('SELECT * FROM clientes WHERE id_cliente = :id');
            $stmt->execute([':id' => $id]);
            echo json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        } else {
            $stmt = $conexion->query('SELECT * FROM clientes ORDER BY nombre ASC');
            echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        exit;
    }

    $input = json_decode(file_get_contents('php://input'), true);

    if ($method === 'POST') {
        $stmt = $conexion->prepare('INSERT INTO clientes(nombre, apellido, email, telefono, direccion) VALUES(:nombre, :apellido, :email, :telefono, :direccion)');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':apellido' => $input['apellido'] ?? '',
            ':email' => $input['email'] ?? '',
            ':telefono' => $input['telefono'] ?? null,
            ':direccion' => $input['direccion'] ?? null,
        ]);
        echo json_encode(['success' => true, 'id' => $conexion->lastInsertId()]);
        exit;
    }

    if ($method === 'PUT' && $id) {
        $stmt = $conexion->prepare('UPDATE clientes SET nombre = :nombre, apellido = :apellido, email = :email, telefono = :telefono, direccion = :direccion WHERE id_cliente = :id');
        $stmt->execute([
            ':nombre' => $input['nombre'] ?? '',
            ':apellido' => $input['apellido'] ?? '',
            ':email' => $input['email'] ?? '',
            ':telefono' => $input['telefono'] ?? null,
            ':direccion' => $input['direccion'] ?? null,
            ':id' => $id,
        ]);
        echo json_encode(['success' => true]);
        exit;
    }

    if ($method === 'DELETE' && $id) {
        $stmt = $conexion->prepare('DELETE FROM clientes WHERE id_cliente = :id');
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
