<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';
require_once '../includes/funcoes.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM projetos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    header('Location: dashboard.php');
    exit;
}

$erros = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valido($_POST['csrf'] ?? null)) {
        die('Pedido inválido.');
    }

    $p['titulo']      = trim($_POST['titulo'] ?? '');
    $p['descricao']   = trim($_POST['descricao'] ?? '');
    $p['tecnologias'] = trim($_POST['tecnologias'] ?? '');
    $p['link_github'] = trim($_POST['link_github'] ?? '');
    $p['link_demo']   = trim($_POST['link_demo'] ?? '');
    $p['destaque']    = isset($_POST['destaque']) ? 1 : 0;

    if ($p['titulo'] === '' || mb_strlen($p['titulo']) > 150) {
        $erros[] = 'O título é obrigatório (máx. 150 caracteres).';
    }
    if ($p['descricao'] === '') {
        $erros[] = 'A descrição é obrigatória.';
    }
    foreach (['link_github' => 'GitHub', 'link_demo' => 'do site online'] as $campo => $nome) {
        if ($p[$campo] !== '' && !url_http($p[$campo])) {
            $erros[] = "O link $nome tem de começar por http:// ou https://.";
        }
    }

    if (!$erros) {
        $stmt = $pdo->prepare(
            "UPDATE projetos SET titulo=?, descricao=?, tecnologias=?, link_github=?,
                    link_demo=?, destaque=? WHERE id=?"
        );
        $stmt->execute([
            $p['titulo'], $p['descricao'], $p['tecnologias'],
            $p['link_github'] ?: null, $p['link_demo'] ?: null,
            $p['destaque'], $id,
        ]);

        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Editar projeto | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="dashboard.php" class="navbar-brand">← Voltar ao painel</a>
  </div>
</nav>

<div class="container py-4" style="max-width: 760px;">
  <h1 class="h3 mb-4">Editar projeto</h1>

  <?php if ($erros): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($erros as $e): ?><li><?= h($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" class="card shadow-sm p-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <div class="mb-3">
      <label class="form-label">Título *</label>
      <input type="text" name="titulo" class="form-control" maxlength="150"
             value="<?= h($p['titulo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descrição *</label>
      <textarea name="descricao" rows="5" class="form-control" required><?= h($p['descricao']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Tecnologias</label>
      <input type="text" name="tecnologias" class="form-control"
             value="<?= h($p['tecnologias'] ?? '') ?>">
      <div class="form-text">Separadas por vírgulas.</div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Link do GitHub</label>
        <input type="url" name="link_github" class="form-control"
               value="<?= h($p['link_github'] ?? '') ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Link do site online</label>
        <input type="url" name="link_demo" class="form-control"
               value="<?= h($p['link_demo'] ?? '') ?>">
      </div>
    </div>

    <div class="form-check mb-4">
      <input type="checkbox" name="destaque" id="destaque" class="form-check-input"
             <?= $p['destaque'] ? 'checked' : '' ?>>
      <label for="destaque" class="form-check-label">Mostrar em destaque na página inicial</label>
    </div>

    <button class="btn btn-primary">Guardar alterações</button>
  </form>
</div>

</body>
</html>