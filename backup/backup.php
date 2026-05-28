<?php
// Script para crear una copia de seguridad automática de la base de datos.
// Requiere que mysqldump esté disponible en el PATH del sistema.

require_once __DIR__ . '/../conexion.php';

// Asegurar carpeta de salida
$outDir = __DIR__ . '/../respaldos';
if (!is_dir($outDir)) {
    mkdir($outDir, 0775, true);
}

// Nombre del archivo con timestamp
$timestamp = date('Y-m-d_H-i-s');
$fileBase = "backup_{$timestamp}";
$fileSql = "{$fileBase}.sql";
$fileGz = "{$fileSql}.gz";

$targetSqlPath = $outDir . DIRECTORY_SEPARATOR . $fileSql;
$targetGzPath = $outDir . DIRECTORY_SEPARATOR . $fileGz;

// Leer credenciales desde conexion.php (PDO)
// conexion.php usa variables $host, $db, $user, $pass pero no las expone.
// Por eso, intentamos obtenerlas desde constantes configurables opcionalmente.
// Si no existen, mostramos error claro.

$host = defined('DB_HOST') ? DB_HOST : null;
$db   = defined('DB_NAME') ? DB_NAME : null;
$user = defined('DB_USER') ? DB_USER : null;
$pass = defined('DB_PASS') ? DB_PASS : null;

if (!$host || !$db || !$user) {
    // Fallback: no podemos recuperar credenciales de conexion.php, así que pedimos definirlas.
    http_response_code(500);
    echo "Error: define DB_HOST, DB_NAME, DB_USER y DB_PASS (opcional) en este proyecto para que el backup funcione.";
    exit;
}

// Construir comando mysqldump
$cmdParts = [];
$cmdParts[] = 'mysqldump';
$cmdParts[] = '--host=' . escapeshellarg($host);
$cmdParts[] = '--user=' . escapeshellarg($user);
if ($pass !== null && $pass !== '') {
    $cmdParts[] = '--password=' . escapeshellarg($pass);
}
$cmdParts[] = '--databases ' . escapeshellarg($db);

// Redirigir salida a archivo .sql
$cmd = implode(' ', $cmdParts) . ' > ' . escapeshellarg($targetSqlPath);

// Ejecutar
exec($cmd . ' 2>&1', $output, $exitCode);

if ($exitCode !== 0 || !file_exists($targetSqlPath)) {
    http_response_code(500);
    echo "Error generando dump. ExitCode: {$exitCode}.\n\n" . implode("\n", $output);
    exit;
}

// Comprimir con gzip
$gz = gzopen($targetGzPath, 'wb9');
if (!$gz) {
    http_response_code(500);
    echo "Error comprimiendo el archivo SQL.";
    exit;
}

$fp = fopen($targetSqlPath, 'rb');
while (!feof($fp)) {
    $data = fread($fp, 1024 * 1024);
    gzwrite($gz, $data);
}
fclose($fp);
gzclose($gz);

// Eliminar .sql sin comprimir para ahorrar espacio
@unlink($targetSqlPath);

// Opcional: conservar últimos 30 backups
$files = glob($outDir . DIRECTORY_SEPARATOR . 'backup_*.sql.gz');
rsort($files);
$keep = 30;
if (count($files) > $keep) {
    for ($i = $keep; $i < count($files); $i++) {
        @unlink($files[$i]);
    }
}

header('Content-Type: text/plain; charset=utf-8');
echo "Backup creado: {$fileGz}\n";

