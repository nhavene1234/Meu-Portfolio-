<?php
$titulo = 'Projetos';
require_once 'includes/db.php';
require_once 'includes/funcoes.php';
require_once 'includes/header.php';

// Filtro por estado (?estado=concluido ou ?estado=desenvolvimento)
$filtro = $_GET['estado'] ?? '';
if (!array_key_exists($filtro, ESTADOS)) {
    $filtro = '';
}

$colunas = "id, titulo, descricao, tecnologias, estado, link_github, link_demo";

if ($filtro !== '') {
    $stmt = $pdo->prepare("SELECT $colunas FROM projetos WHERE estado = ? ORDER BY criado_em DESC");
    $stmt->execute([$filtro]);
    $projetos = $stmt->fetchAll();
} else {
    $projetos = $pdo->query("SELECT $colunas FROM projetos ORDER BY criado_em DESC")->fetchAll();
}
?>

<section class="py-5">
  <div class="container">
    <h1 class="fw-bold text-center mb-2">Os meus projetos</h1>
    <p class="text-center text-muted mb-4 mx-auto" style="max-width: 640px;">
      Cada projeto nasceu de um problema real. Explora, experimenta a versão online
      e espreita o código no GitHub.
    </p>

    

    <div class="row g-4">
      <?php foreach ($projetos as $p): ?>
        <?= cartao_projeto($p, 160) ?>
      <?php endforeach; ?>

      <?php if (!$projetos): ?>
        <p class="text-center text-muted">
          <?= $filtro !== ''
              ? 'Ainda não há projetos neste estado.'
              : 'Estou a preparar os primeiros projetos para mostrar aqui. Volta em breve!' ?>
        </p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>