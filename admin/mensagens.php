<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';

$filtro = (($_GET['filtro'] ?? '') === 'nao-lidas') ? 'nao-lidas' : 'todas';

// ---------- Ações (sempre por POST + token CSRF) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_valido($_POST['csrf'] ?? null)) {
        http_response_code(405);
        die('Pedido inválido.');
    }

    $id   = (int)($_POST['id'] ?? 0);
    $acao = $_POST['acao'] ?? '';

    if ($id > 0) {
        if ($acao === 'lida') {
            $pdo->prepare("UPDATE mensagens SET lida = 1 WHERE id = ?")->execute([$id]);
        } elseif ($acao === 'nao_lida') {
            $pdo->prepare("UPDATE mensagens SET lida = 0 WHERE id = ?")->execute([$id]);
        } elseif ($acao === 'apagar') {
            $pdo->prepare("DELETE FROM mensagens WHERE id = ?")->execute([$id]);
        }
    }

    header('Location: mensagens.php?filtro=' . $filtro);
    exit;
}

// ---------- Dados ----------
$total     = (int)$pdo->query("SELECT COUNT(*) FROM mensagens")->fetchColumn();
$naoLidas  = (int)$pdo->query("SELECT COUNT(*) FROM mensagens WHERE lida = 0")->fetchColumn();

$sql = "SELECT id, nome, email, assunto, mensagem, lida, criado_em FROM mensagens";
if ($filtro === 'nao-lidas') {
    $sql .= " WHERE lida = 0";
}
$sql .= " ORDER BY criado_em DESC LIMIT 100";
$mensagens = $pdo->query($sql)->fetchAll();

// Cor do selo conforme o assunto
$cores = [
    'Freelancer'              => 'success',
    'Colaboração'             => 'info',
    'Oportunidade de emprego' => 'primary',
    'Outro'                   => 'secondary',
];
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Mensagens | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="dashboard.php" class="navbar-brand">← Voltar ao painel</a>
    <a href="logout.php" class="btn btn-sm btn-danger">Sair</a>
  </div>
</nav>

<div class="container py-4" style="max-width: 900px;">

  <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <h1 class="h3 mb-0">Mensagens recebidas</h1>
    <div class="btn-group">
      <a href="mensagens.php"
         class="btn btn-sm <?= $filtro === 'todas' ? 'btn-primary' : 'btn-outline-primary' ?>">
        Todas (<?= $total ?>)
      </a>
      <a href="mensagens.php?filtro=nao-lidas"
         class="btn btn-sm <?= $filtro === 'nao-lidas' ? 'btn-primary' : 'btn-outline-primary' ?>">
        Por ler (<?= $naoLidas ?>)
      </a>
    </div>
  </div>

  <?php if (!$mensagens): ?>
    <div class="card shadow-sm">
      <div class="card-body text-center text-muted py-5">
        <?= $filtro === 'nao-lidas' ? 'Não tens mensagens por ler. 🎉' : 'Ainda não recebeste mensagens.' ?>
      </div>
    </div>
  <?php endif; ?>

  <?php foreach ($mensagens as $m): ?>
    <div class="card shadow-sm mb-3 <?= $m['lida'] ? '' : 'border-primary border-2' ?>">
      <div class="card-header bg-white d-flex flex-wrap justify-content-between align-items-center gap-2">
        <div>
          <strong><?= htmlspecialchars($m['nome']) ?></strong>
          <?php if (!$m['lida']): ?><span class="badge bg-primary ms-1">Nova</span><?php endif; ?>
          <br>
          <a href="mailto:<?= htmlspecialchars($m['email']) ?>" class="small text-decoration-none">
            <?= htmlspecialchars($m['email']) ?>
          </a>
        </div>
        <div class="text-end">
          <span class="badge bg-<?= $cores[$m['assunto']] ?? 'secondary' ?>">
            <?= htmlspecialchars($m['assunto']) ?>
          </span>
          <div class="small text-muted mt-1">
            <?= date('d/m/Y H:i', strtotime($m['criado_em'])) ?>
          </div>
        </div>
      </div>

      <div class="card-body">
        <p class="mb-0" style="white-space: pre-line;"><?= htmlspecialchars($m['mensagem']) ?></p>
      </div>

      <div class="card-footer bg-white d-flex flex-wrap gap-2">
        <a href="mailto:<?= htmlspecialchars($m['email']) ?>?subject=<?= rawurlencode('Re: ' . $m['assunto']) ?>"
           class="btn btn-sm btn-primary">
          <i class="bi bi-reply me-1"></i>Responder
        </a>

        <form method="post" class="d-inline">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
          <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
          <input type="hidden" name="acao" value="<?= $m['lida'] ? 'nao_lida' : 'lida' ?>">
          <button class="btn btn-sm btn-outline-secondary">
            <?= $m['lida'] ? 'Marcar como não lida' : 'Marcar como lida' ?>
          </button>
        </form>

        <form method="post" class="d-inline ms-auto"
              onsubmit="return confirm('Apagar esta mensagem de forma definitiva?')">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
          <input type="hidden" name="id" value="<?= (int)$m['id'] ?>">
          <input type="hidden" name="acao" value="apagar">
          <button class="btn btn-sm btn-outline-danger">
            <i class="bi bi-trash me-1"></i>Apagar
          </button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>

  <?php if ($total > 100): ?>
    <p class="text-muted small text-center">A mostrar as 100 mensagens mais recentes.</p>
  <?php endif; ?>
</div>

</body>
</html>