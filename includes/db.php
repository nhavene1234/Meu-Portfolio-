<?php
// Se o ficheiro config.php existir localmente (XAMPP), carrega-o
if (file_exists(__DIR__ . '/config.php')) {
    require_once __DIR__ . '/config.php';
} else {
    // Se não existir (Nuvem/Railway), lê as variáveis do painel de administração
    define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
    define('DB_NAME', $_ENV['DB_NAME'] ?? '');
    define('DB_USER', $_ENV['DB_USER'] ?? '');
    define('DB_PASS', $_ENV['DB_PASS'] ?? '');
    define('SITE_URL', $_ENV['SITE_URL'] ?? '');
    define('EMAIL_CONTACTO', $_ENV['EMAIL_CONTACTO'] ?? '');
}

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erro de ligação à base de dados.");
}
