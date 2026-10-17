</main>

<?php
$redes = [
    ['GitHub',    GITHUB_URL,    'bi-github'],
    ['LinkedIn',  LINKEDIN_URL,  'bi-linkedin'],
    ['Facebook',  FACEBOOK_URL,  'bi-facebook'],
    ['Instagram', INSTAGRAM_URL, 'bi-instagram'],
];
?>

<footer class="rodape bg-dark text-light pt-5 pb-3 mt-5">
  <div class="container">
    <div class="row g-4">

      <div class="col-lg-5">
        <h5 class="fw-bold">Nelson Nhavene</h5>
        <p class="text-light-emphasis mb-3">
          Desenvolvedor Full Stack especializado em HTML, CSS, JavaScript, React,
          PHP, Laravel, Java, Spring, C# e MySQL.
        </p>
        <div class="d-flex gap-3">
          <?php foreach ($redes as [$nome, $url, $icone]): ?>
            <?php if ($url): ?>
              <a href="<?= htmlspecialchars($url) ?>" class="rede-social" target="_blank"
                 rel="noopener noreferrer" aria-label="<?= $nome ?>" title="<?= $nome ?>">
                <i class="bi <?= $icone ?>"></i>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <h6 class="fw-bold text-uppercase mb-3">Links rápidos</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><a href="<?= SITE_URL ?>/index.php" class="link-rodape">Início</a></li>
          <li class="mb-2"><a href="<?= SITE_URL ?>/sobre.php" class="link-rodape">Sobre</a></li>
          <li class="mb-2"><a href="<?= SITE_URL ?>/habilidades.php" class="link-rodape">Habilidades</a></li>
          <li class="mb-2"><a href="<?= SITE_URL ?>/projetos.php" class="link-rodape">Projetos</a></li>
          <li class="mb-2"><a href="<?= SITE_URL ?>/contacto.php" class="link-rodape">Contacto</a></li>
        </ul>
      </div>

      <div class="col-sm-6 col-lg-4">
        <h6 class="fw-bold text-uppercase mb-3">Contacto</h6>
        <ul class="list-unstyled mb-0">
          <li class="mb-2"><i class="bi bi-geo-alt me-2"></i><?= htmlspecialchars(ENDERECO) ?></li>
          <li class="mb-2">
            <i class="bi bi-envelope me-2"></i>
            <a href="mailto:<?= EMAIL_CONTACTO ?>" class="link-rodape"><?= EMAIL_CONTACTO ?></a>
          </li>
        </ul>
      </div>

    </div>

    <hr class="border-secondary mt-4">
    <div class="text-center">
      <small>&copy; <?= date('Y') ?> Nelson Nhavene. Todos os direitos reservados.</small>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= SITE_URL ?>/assets/js/main.js"></script>
</body>
</html>