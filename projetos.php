<?php
$titulo = 'Projetos';
require_once 'includes/db.php';
require_once 'includes/funcoes.php';
require_once 'includes/header.php';

$projetos = $pdo->query("SELECT id, titulo, descricao, tecnologias, link_github, link_demo
                         FROM projetos ORDER BY criado_em DESC")->fetchAll();
?>

<section class="py-5">
  <div class="container">
    <h1 class="fw-bold text-center mb-2">Os meus projetos</h1>
    <p class="text-center text-muted mb-5">Um pouco do que tenho construído: aplicações web feitas para serem simples de usar e fáceis de entender.</p>

    <div class="row g-4">
      <?php foreach ($projetos as $p): ?>
        <?= cartao_projeto($p, 160) ?>
      <?php endforeach; ?>

      <?php if (!$projetos): ?>
        <p class="text-center text-muted">Em breve, novos projetos por aqui.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>