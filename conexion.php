<?php
// Configuración de conexión a MySQL
$host = "localhost";
$db = "marketplace_express";
$user = "root";
$pass = "";

// Constantes para que otros scripts (backup, etc.) puedan reutilizar la configuración.
// No afecta la conexión actual.
define('DB_HOST', $host);
define('DB_NAME', $db);
define('DB_USER', $user);
// DB_PASS es opcional (en XAMPP suele ser vacío)
define('DB_PASS', $pass);

try {
    $conexion = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
