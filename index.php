<?php
$titulo = 'Início';
require_once 'includes/db.php';
require_once 'includes/header.php';

$stmt = $pdo->query("SELECT id, titulo, descricao, tecnologias, imagem
                     FROM projetos WHERE destaque = 1
                     ORDER BY criado_em DESC LIMIT 3");
$destaques = $stmt->fetchAll();
?>

<section class="hero">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-lg-7 order-2 order-lg-1 text-center text-lg-start">
        <p class="text-primary fw-semibold mb-2">Olá, eu sou o</p>
        <h1 class="display-4 fw-bold mb-3">Nelson Francisco Nhavene</h1>
        <h2 class="h4 text-muted mb-4">Estudante de Engenharia de Software · Full Stack em formação</h2>
        <p class="lead">
          Estudo na Universidade Joaquim Chissano e a minha paixão é transformar problemas reais
          em soluções digitais que funcionam bem e que qualquer pessoa consiga usar sem complicação.
        </p>
        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mt-4">
          <a href="projetos.php" class="btn btn-primary btn-lg">Ver projetos</a>
          <a href="contacto.php" class="btn btn-outline-primary btn-lg">Fala comigo</a>
        </div>
      </div>

      <div class="col-lg-5 order-1 order-lg-2 text-center">
        <img src="<?= SITE_URL ?>/assets/img/perfil.jpeg"
             alt="Foto de perfil de Nelson Nhavene"
             class="foto-perfil">
      </div>

    </div>
  </div>
</section>

<?php require_once 'includes/tecnologias.php'; ?>

<?php if ($destaques): ?>
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Projetos em destaque</h2>
    <div class="row g-4">
      <?php foreach ($destaques as $p): ?>
        <div class="col-md-6 col-lg-4">
          <div class="card card-projeto h-100 shadow-sm">
            <?php if ($p['imagem']): ?>
              <img src="<?= SITE_URL ?>/uploads/<?= htmlspecialchars($p['imagem']) ?>" class="card-img-top" alt="">
            <?php endif; ?>
            <div class="card-body">
              <h5 class="card-title"><?= htmlspecialchars($p['titulo']) ?></h5>
              <p class="card-text"><?= htmlspecialchars(mb_strimwidth($p['descricao'], 0, 110, '...')) ?></p>
              <small class="text-muted"><?= htmlspecialchars($p['tecnologias'] ?? '') ?></small>
            </div>
            <div class="card-footer bg-transparent border-0 pb-3">
              <a href="projeto.php?id=<?= (int)$p['id'] ?>" class="btn btn-sm btn-outline-primary">Ver detalhes</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="projetos.php" class="btn btn-outline-primary">Ver todos os projetos</a>
    </div>
  </div>
</section>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>