<?php
$titulo = 'Habilidades';
require_once 'includes/dados.php';
require_once 'includes/header.php';
?>

<section class="py-5">
  <div class="container" style="max-width: 1000px;">

    <h1 class="fw-bold text-center mb-3">Habilidades</h1>
    <p class="lead text-center mx-auto mb-5" style="max-width: 700px;">
      Do desenho da interface à lógica por trás dela: estas são as áreas em que trabalho
      e as ferramentas que uso para construir aplicações completas.
    </p>

    <!-- Áreas técnicas -->
    <div class="row g-4 mb-5">
      <?php foreach ($areas as $area): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body p-4">
              <i class="bi <?= $area['icone'] ?> fs-1 text-primary"></i>
              <h2 class="h5 fw-bold mt-2"><?= htmlspecialchars($area['titulo']) ?></h2>
              <p class="text-muted"><?= htmlspecialchars($area['texto']) ?></p>
              <div>
                <?php foreach ($area['itens'] as $item): ?>
                  <span class="badge bg-primary-subtle text-primary-emphasis fs-6 fw-normal me-1 mb-2">
                    <?= htmlspecialchars($item) ?>
                  </span>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Competências profissionais e certificações -->
    <div class="row g-4">
      <div class="col-md-5">
        <h2 class="h4 fw-bold mb-3">Competências profissionais</h2>
        <ul class="list-group list-group-flush">
          <?php foreach ($competencias as $c): ?>
            <li class="list-group-item bg-transparent px-0">
              <i class="bi bi-check-circle-fill text-success me-2"></i><?= htmlspecialchars($c) ?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="col-md-7">
        <h2 class="h4 fw-bold mb-3">Certificações e formações</h2>
        <ul class="list-unstyled mb-0">
          <?php foreach ($certificacoes as [$nome, $entidade, $ano]): ?>
            <li class="mb-3 d-flex gap-3">
              <i class="bi bi-award-fill fs-4 text-primary"></i>
              <div>
                <strong><?= htmlspecialchars($nome) ?></strong><br>
                <span class="text-muted"><?= htmlspecialchars($entidade) ?> · <?= $ano ?></span>
              </div>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>

  </div>
</section>

<section class="bg-light">
  <?php require_once 'includes/tecnologias.php'; ?>
</section>

<section class="text-center py-5">
  <div class="container">
    <h2 class="h4 fw-bold mb-3">Vamos pôr estas habilidades a trabalhar no teu projeto?</h2>
    <a href="projetos.php" class="btn btn-primary me-2">Ver projetos</a>
    <a href="contacto.php" class="btn btn-outline-primary">Fala comigo</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>