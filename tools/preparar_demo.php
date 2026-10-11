<?php
// Historia: H-11, H-01, H-04, H-07, H-09
// Preparación B0 explícita. Nunca invocado por la web, Composer ni las pruebas.

if (PHP_SAPI !== 'cli' || ! in_array('--crear-base-aislada', $argv, true)) {
    exit("Uso: php tools/preparar_demo.php --crear-base-aislada\nSolo crea asistente_cni_s7 si aún no existe.\n");
}
$raiz = dirname(__DIR__);
$env = $raiz.'/web/.env';
$credenciales = $raiz.'/web/storage/app/private/demo-credentials.json';
if (file_exists($env) || file_exists($credenciales)) {
    fwrite(STDERR, "No se sobrescriben .env ni credenciales existentes. Usa la BD que ya está configurada.\n");
    exit(1);
}
$puerto = getenv('S7_DB_PORT') ?: '3306';
if (! ctype_digit($puerto) || (int) $puerto < 1 || (int) $puerto > 65535) {
    exit("Puerto inválido.\n");
}
$admin = getenv('S7_DB_ADMIN') ?: 'root';
$claveAdmin = getenv('S7_DB_ADMIN_PASSWORD') ?: '';
$pdo = new PDO("mysql:host=127.0.0.1;port=$puerto;charset=utf8mb4", $admin, $claveAdmin, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$consulta = $pdo->prepare('SELECT SCHEMA_NAME FROM information_schema.SCHEMATA WHERE SCHEMA_NAME = ?');
$consulta->execute(['asistente_cni_s7']);
if ($consulta->fetch()) {
    fwrite(STDERR, "La base asistente_cni_s7 ya existe. Se cancela sin modificarla.\n");
    exit(1);
}
$cuenta = 'cni_s7_'.bin2hex(random_bytes(4));
$claveSql = bin2hex(random_bytes(24));
$claveDemo = 'Cni-'.bin2hex(random_bytes(6));
$pdo->exec('CREATE DATABASE asistente_cni_s7 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
$pdo->exec('USE asistente_cni_s7');
$pdo->exec(file_get_contents($raiz.'/data/s7/estructura.sql'));
$pdo->prepare('SET @demo_hash = ?')->execute([password_hash($claveDemo, PASSWORD_BCRYPT, ['cost' => 12])]);
$pdo->beginTransaction();
$pdo->exec(file_get_contents($raiz.'/data/s7/datos_demostracion.sql'));
$pdo->commit();
// Valores aleatorios internos; nunca se interpolan datos recibidos de la web.
$pdo->exec('CREATE USER '.$pdo->quote($cuenta)."@'127.0.0.1' IDENTIFIED BY ".$pdo->quote($claveSql));
$pdo->exec('GRANT SELECT ON asistente_cni_s7.* TO '.$pdo->quote($cuenta)."@'127.0.0.1'");
$contenido = file_get_contents($raiz.'/web/.env.example');
$contenido = str_replace(['APP_KEY=', 'DB_PORT=3306', 'DB_USERNAME=cni_s7_lector', 'DB_PASSWORD='],
    ['APP_KEY=base64:'.base64_encode(random_bytes(32)), 'DB_PORT='.$puerto, 'DB_USERNAME='.$cuenta, 'DB_PASSWORD='.$claveSql], $contenido);
file_put_contents($env, $contenido);
if (! is_dir(dirname($credenciales))) {
    mkdir(dirname($credenciales), 0700, true);
}
file_put_contents($credenciales, json_encode(['password' => $claveDemo, 'cuentas' => ['est_0001', 'est_0002', 'est_0003', 'est_0004', 'doc_0001', 'doc_0002', 'doc_sin_grupos', 'dir_0001']], JSON_PRETTY_PRINT));
echo "Base aislada preparada. Credenciales de demostración en web/storage/app/private/demo-credentials.json (no versionado).\n";
