<?php
require_once 'includes/db.php';
require_once 'includes/preview.php';

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
  <div class="container" style="max-width: 1000px;">
    <a href="projetos.php" class="text-decoration-none">← Todos os projetos</a>

    <h1 class="fw-bold mt-3"><?= h($p['titulo']) ?></h1>

    <?php if ($p['tecnologias']): ?>
      <div class="mb-4">
        <?php foreach (explode(',', $p['tecnologias']) as $tec): ?>
          <span class="badge bg-primary me-1"><?= h(trim($tec)) ?></span>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <?php if ($demo && $p['mostrar_preview']): ?>
      <div class="preview-janela mb-2">
        <div class="preview-barra">
          <span class="ponto bg-danger"></span><span class="ponto bg-warning"></span><span class="ponto bg-success"></span>
          <span class="preview-url text-truncate"><?= h($demo) ?></span>
          <a href="<?= h($demo) ?>" class="btn btn-sm btn-outline-secondary ms-auto"
             target="_blank" rel="noopener noreferrer">Abrir em nova janela</a>
        </div>
        <iframe src="<?= h($demo) ?>" loading="lazy"
                sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                referrerpolicy="no-referrer"
                title="Pré-visualização de <?= h($p['titulo']) ?>"></iframe>
      </div>
      <p class="small text-muted mb-4">
        Se a pré-visualização não carregar, usa o botão "Abrir em nova janela" ou "Ver site online".
      </p>
    <?php elseif ($p['imagem']): ?>
      <img src="<?= SITE_URL ?>/uploads/<?= h($p['imagem']) ?>"
           class="img-fluid rounded shadow-sm mb-4" alt="Imagem do projeto <?= h($p['titulo']) ?>">
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