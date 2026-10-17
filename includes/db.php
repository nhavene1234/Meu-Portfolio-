<?php
// includes/db.php
// Liga à base de dados: MySQL no XAMPP, PostgreSQL (Neon) no Render.
require_once __DIR__ . '/config.php';

try {
    if (DB_DRIVER === 'pgsql') {
        $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";sslmode=require";
    } else {
        $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    }

    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // O detalhe vai para os logs do Render; o visitante só vê a mensagem genérica.
    error_log('Erro de ligação à BD: ' . $e->getMessage());
    die("Erro de ligação à base de dados.");
}