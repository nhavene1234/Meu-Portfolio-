<?php require_once __DIR__ . '/dados.php'; ?>

<section class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-2">Tecnologias que uso</h2>
    <p class="text-center text-muted mb-4">As ferramentas com que construo as minhas aplicações.</p>

    <?php foreach ($tecnologias as $grupo => $itens): ?>
      <h3 class="h6 text-uppercase text-muted text-center mt-4 mb-3"><?= htmlspecialchars($grupo) ?></h3>
      <div class="row g-3 justify-content-center">
        <?php foreach ($itens as [$nome, $icone]): ?>
          <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <div class="tech-card">
              <?php if ($icone): ?>
                <i class="<?= htmlspecialchars($icone) ?> tech-icone"></i>
              <?php else: ?>
                <span class="tech-icone">🧪</span>
              <?php endif; ?>
              <span class="tech-nome"><?= htmlspecialchars($nome) ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>