<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';

$projetos = $pdo->query("SELECT id, titulo, tecnologias, destaque, criado_em
                         FROM projetos ORDER BY criado_em DESC")->fetchAll();

$naoLidas = (int)$pdo->query("SELECT COUNT(*) FROM mensagens WHERE lida = 0")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Painel | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <span class="navbar-brand">Painel · <?= htmlspecialchars($_SESSION['admin_nome']) ?></span>
    <div class="d-flex flex-wrap gap-2">
      <a href="mensagens.php" class="btn btn-sm btn-outline-light position-relative">
        Mensagens
        <?php if ($naoLidas > 0): ?>
          <span class="badge bg-danger ms-1"><?= $naoLidas ?></span>
        <?php endif; ?>
      </a>
      <a href="<?= SITE_URL ?>/index.php" class="btn btn-sm btn-outline-light" target="_blank">Ver site</a>
      <a href="logout.php" class="btn btn-sm btn-danger">Sair</a>
    </div>
  </div>
</nav>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Os meus projetos</h1>
    <a href="projeto_novo.php" class="btn btn-primary">+ Novo projeto</a>
  </div>

  <div class="card shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>Título</th>
            <th>Tecnologias</th>
            <th>Destaque</th>
            <th>Data</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($projetos as $p): ?>
            <tr>
              <td><?= htmlspecialchars($p['titulo']) ?></td>
              <td><?= htmlspecialchars($p['tecnologias'] ?? '') ?></td>
              <td><?= $p['destaque'] ? '⭐' : '' ?></td>
              <td><?= date('d/m/Y', strtotime($p['criado_em'])) ?></td>
              <td class="text-end">
                <a href="projeto_editar.php?id=<?= (int)$p['id'] ?>"
                   class="btn btn-sm btn-outline-secondary">Editar</a>

                <form method="post" action="projeto_apagar.php" class="d-inline"
                      onsubmit="return confirm('Apagar este projeto?')">
                  <input type="hidden" name="csrf" value="<?= csrf_token() ?>">
                  <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                  <button class="btn btn-sm btn-outline-danger">Apagar</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>

          <?php if (!$projetos): ?>
            <tr>
              <td colspan="5" class="text-center text-muted py-4">
                Ainda não tens projetos. Adiciona o primeiro!
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>