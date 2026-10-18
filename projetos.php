<?php
$titulo = 'Projetos';
require_once 'includes/db.php';
require_once 'includes/preview.php';
require_once 'includes/header.php';

$projetos = $pdo->query("SELECT id, titulo, descricao, tecnologias, imagem, link_github, link_demo, mostrar_preview
                         FROM projetos ORDER BY criado_em DESC")->fetchAll();
?>

<section class="py-5">
  <div class="container">
    <h1 class="fw-bold text-center mb-2">Os meus projetos</h1>
    <p class="text-center text-muted mb-5">Aplicações web que desenvolvi, com o código e a versão online.</p>

    <div class="row g-4">
      <?php foreach ($projetos as $p): ?>
        <?php $demo = url_http($p['link_demo'] ?? null); $github = url_http($p['link_github'] ?? null); ?>
        <div class="col-md-6 col-lg-4">
          <div class="card card-projeto h-100 shadow-sm">
            <a href="projeto.php?id=<?= (int)$p['id'] ?>" class="d-block" tabindex="-1">
              <?= miniatura_projeto($p) ?>
            </a>

            <div class="card-body">
              <h5 class="card-title"><?= h($p['titulo']) ?></h5>
              <p class="card-text"><?= h(mb_strimwidth($p['descricao'], 0, 120, '...')) ?></p>

              <?php if ($p['tecnologias']): ?>
                <?php foreach (explode(',', $p['tecnologias']) as $tec): ?>
                  <span class="badge bg-secondary me-1"><?= h(trim($tec)) ?></span>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>

            <div class="card-footer bg-transparent border-0 pb-3 d-flex flex-wrap gap-2">
              <a href="projeto.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-primary">Detalhes</a>

              <?php if ($demo): ?>
                <a href="<?= h($demo) ?>" class="btn btn-sm btn-outline-success"
                   target="_blank" rel="noopener noreferrer">Ver site</a>
              <?php endif; ?>

              <?php if ($github): ?>
                <a href="<?= h($github) ?>" class="btn btn-sm btn-outline-dark"
                   target="_blank" rel="noopener noreferrer">GitHub</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

      <?php if (!$projetos): ?>
        <p class="text-center text-muted">Em breve, novos projetos por aqui.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>