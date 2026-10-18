<?php
require_once 'includes/db.php';
require_once 'includes/funcoes.php';

$id = (int)($_GET['id'] ?? 0);
$stmt = $pdo->prepare("SELECT * FROM projetos WHERE id = ?");
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    http_response_code(404);
    $titulo = 'Projeto não encontrado';
    require_once 'includes/header.php';
    echo '<div class="container py-5 text-center"><h1>Projeto não encontrado</h1>
          <a href="projetos.php" class="btn btn-primary mt-3">Ver todos os projetos</a></div>';
    require_once 'includes/footer.php';
    exit;
}

$titulo = $p['titulo'];
$demo   = url_http($p['link_demo'] ?? null);
$github = url_http($p['link_github'] ?? null);
require_once 'includes/header.php';
?>

<section class="py-5">
  <div class="container" style="max-width: 900px;">
    <a href="projetos.php" class="text-decoration-none">← Todos os projetos</a>

    <h1 class="fw-bold mt-3"><?= h($p['titulo']) ?></h1>

    <?php if ($p['tecnologias']): ?>
      <div class="mb-4">
        <?php foreach (explode(',', $p['tecnologias']) as $tec): ?>
          <span class="badge bg-primary me-1"><?= h(trim($tec)) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <p class="lead" style="white-space: pre-line;"><?= h($p['descricao']) ?></p>

    <div class="d-flex flex-wrap gap-3 mt-4">
      <?php if ($demo): ?>
        <a href="<?= h($demo) ?>" class="btn btn-success btn-lg"
           target="_blank" rel="noopener noreferrer">🌐 Ver site online</a>
      <?php endif; ?>

      <?php if ($github): ?>
        <a href="<?= h($github) ?>" class="btn btn-dark btn-lg"
           target="_blank" rel="noopener noreferrer">💻 Código no GitHub</a>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>