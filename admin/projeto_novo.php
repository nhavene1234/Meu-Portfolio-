<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';
require_once '../includes/funcoes.php';

$erros = [];
$dados = ['titulo' => '', 'descricao' => '', 'tecnologias' => '',
          'link_github' => '', 'link_demo' => '', 'destaque' => 0, 'estado' => 'concluido'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valido($_POST['csrf'] ?? null)) {
        die('Pedido inválido.');
    }

    $dados['titulo']      = trim($_POST['titulo'] ?? '');
    $dados['descricao']   = trim($_POST['descricao'] ?? '');
    $dados['tecnologias'] = trim($_POST['tecnologias'] ?? '');
    $dados['link_github'] = trim($_POST['link_github'] ?? '');
    $dados['link_demo']   = trim($_POST['link_demo'] ?? '');
    $dados['destaque']    = isset($_POST['destaque']) ? 1 : 0;
    $dados['estado']      = $_POST['estado'] ?? '';

    if ($dados['titulo'] === '' || mb_strlen($dados['titulo']) > 150) {
        $erros[] = 'O título é obrigatório (máx. 150 caracteres).';
    }
    if ($dados['descricao'] === '') {
        $erros[] = 'A descrição é obrigatória.';
    }
    if (!array_key_exists($dados['estado'], ESTADOS)) {
        $erros[] = 'Escolhe o estado do projeto.';
    }
    foreach (['link_github' => 'GitHub', 'link_demo' => 'do site online'] as $campo => $nome) {
        if ($dados[$campo] !== '' && !url_http($dados[$campo])) {
            $erros[] = "O link $nome tem de começar por http:// ou https://.";
        }
    }

    if (!$erros) {
        $stmt = $pdo->prepare(
            "INSERT INTO projetos (titulo, descricao, tecnologias, link_github, link_demo, destaque, estado)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $dados['titulo'], $dados['descricao'], $dados['tecnologias'],
            $dados['link_github'] ?: null, $dados['link_demo'] ?: null,
            $dados['destaque'], $dados['estado'],
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
  <title>Novo projeto | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="dashboard.php" class="navbar-brand">← Voltar ao painel</a>
  </div>
</nav>

<div class="container py-4" style="max-width: 760px;">
  <h1 class="h3 mb-4">Novo projeto</h1>

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
             value="<?= h($dados['titulo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descrição *</label>
      <textarea name="descricao" rows="5" class="form-control" required><?= h($dados['descricao']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Estado do projeto *</label>
      <select name="estado" class="form-select" required>
        <?php foreach (ESTADOS as $valor => $nome): ?>
          <option value="<?= h($valor) ?>" <?= $dados['estado'] === $valor ? 'selected' : '' ?>>
            <?= h($nome) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Tecnologias</label>
      <input type="text" name="tecnologias" class="form-control" placeholder="PHP, MySQL, Bootstrap"
             value="<?= h($dados['tecnologias']) ?>">
      <div class="form-text">Separadas por vírgulas.</div>
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Link do GitHub</label>
        <input type="url" name="link_github" class="form-control" placeholder="https://github.com/..."
               value="<?= h($dados['link_github']) ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Link do site online</label>
        <input type="url" name="link_demo" class="form-control" placeholder="https://..."
               value="<?= h($dados['link_demo']) ?>">
      </div>
    </div>

    <div class="form-check mb-4">
      <input type="checkbox" name="destaque" id="destaque" class="form-check-input"
             <?= $dados['destaque'] ? 'checked' : '' ?>>
      <label for="destaque" class="form-check-label">Mostrar em destaque na página inicial</label>
    </div>

    <button class="btn btn-primary">Guardar projeto</button>
  </form>
</div>

</body>
</html>