<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';
require_once '../includes/upload.php';

// Só aceita POST: um link simples já não consegue apagar nada
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !csrf_valido($_POST['csrf'] ?? null)) {
    http_response_code(405);
    die('Pedido inválido.');
}

$id = (int)($_POST['id'] ?? 0);

$stmt = $pdo->prepare("SELECT imagem FROM projetos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if ($p) {
    $pdo->prepare("DELETE FROM projetos WHERE id = ?")->execute([$id]);
    apagar_imagem($p['imagem']);
}

header('Location: dashboard.php');
exit;