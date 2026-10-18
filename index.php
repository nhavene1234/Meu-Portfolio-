<?php
$titulo = 'Início';
require_once 'includes/db.php';
require_once 'includes/dados.php';
require_once 'includes/perfil.php';
require_once 'includes/funcoes.php';
require_once 'includes/header.php';

// Projetos em destaque (até 3) e número total de projetos
$destaques = $pdo->query("SELECT id, titulo, descricao, tecnologias, link_github, link_demo
                          FROM projetos WHERE destaque = 1
                          ORDER BY criado_em DESC LIMIT 3")->fetchAll();
$totalProjetos = (int)$pdo->query("SELECT COUNT(*) FROM projetos")->fetchColumn();

// Todas as tecnologias numa só lista (para a contagem e a faixa compacta)
$todasTecnologias = array_merge(...array_values($tecnologias));

// O botão do CV só aparece se o ficheiro existir
$cvCaminho = 'assets/cv/CV_Nelson_Nhavene.pdf';
$temCv = file_exists(__DIR__ . '/' . $cvCaminho);
?>

<!-- 1. Apresentação -->
<section class="hero">
  <div class="container">
    <div class="row align-items-center g-5">

      <div class="col-lg-7 order-2 order-lg-1 text-center text-lg-start">
        <span class="badge rounded-pill text-bg-success px-3 py-2 mb-3">
          <i class="bi bi-circle-fill me-1 small"></i> Disponível para novas oportunidades
        </span>
        <p class="text-primary fw-semibold mb-2">Olá, eu sou o</p>
        <h1 class="display-4 fw-bold mb-3">Nelson Francisco Nhavene</h1>
        <h2 class="h4 text-muted mb-4">Desenvolvedor Full Stack · Estudante de Engenharia de Software</h2>
        <p class="lead">
          Há cerca de <?= $anosExperiencia ?> anos que transformo problemas reais em soluções digitais
          que funcionam bem e que qualquer pessoa consegue usar sem complicação.
        </p>
        <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start mt-4">
          <a href="projetos.php" class="btn btn-primary btn-lg">Ver projetos</a>
          <a href="contacto.php" class="btn btn-outline-primary btn-lg">Fala comigo</a>
          <?php if ($temCv): ?>
            <a href="<?= $cvCaminho ?>" class="btn btn-outline-dark btn-lg" download>
              <i class="bi bi-download me-1"></i>CV
            </a>
          <?php endif; ?>
        </div>
      </div>

      <div class="col-lg-5 order-1 order-lg-2 text-center">
        <img src="<?= SITE_URL ?>/assets/img/perfil.jpg"
             alt="Foto de perfil de Nelson Nhavene"
             class="foto-perfil">
      </div>

    </div>
  </div>
</section>

<!-- 2. Números -->
<section class="py-4 bg-light border-top border-bottom">
  <div class="container">
    <div class="row text-center g-3">
      <div class="col-4">
        <div class="stat-numero">+<?= $anosExperiencia ?></div>
        <div class="stat-texto">anos a programar</div>
      </div>
      <div class="col-4">
        <div class="stat-numero"><?= $totalProjetos ?></div>
        <div class="stat-texto"><?= $totalProjetos === 1 ? 'projeto publicado' : 'projetos publicados' ?></div>
      </div>
      <div class="col-4">
        <div class="stat-numero"><?= count($todasTecnologias) ?></div>
        <div class="stat-texto">tecnologias</div>
      </div>
    </div>
  </div>
</section>

<!-- 3. O que posso fazer por ti -->
<section class="py-5">
  <div class="container" style="max-width: 1000px;">
    <h2 class="text-center fw-bold mb-2">O que posso fazer por ti</h2>
    <p class="text-center text-muted mb-4">Disponível para freelance, projetos colaborativos e trabalho a tempo integral.</p>

    <div class="row g-4">
      <?php foreach ($servicos as [$icone, $tituloServico, $textoServico]): ?>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm border-0 text-center">
            <div class="card-body p-4">
              <i class="bi <?= $icone ?> fs-1 text-primary"></i>
              <h3 class="h5 fw-bold mt-2"><?= h($tituloServico) ?></h3>
              <p class="text-muted mb-0"><?= h($textoServico) ?></p>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- 4. Stack compacta -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">Com que tecnologias trabalho</h2>
    <div class="d-flex flex-wrap justify-content-center gap-4 mb-4">
      <?php foreach ($todasTecnologias as [$nome, $icone]): ?>
        <?php if ($icone): ?>
          <span class="tech-mini" title="<?= h($nome) ?>">
            <i class="<?= h($icone) ?>"></i>
            <small><?= h($nome) ?></small>
          </span>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
    <a href="habilidades.php" class="btn btn-outline-primary">Ver todas as habilidades</a>
  </div>
</section>

<!-- 5. Projetos em destaque -->
<?php if ($destaques): ?>
<section class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Projetos em destaque</h2>
    <div class="row g-4">
      <?php foreach ($destaques as $p): ?>
        <?= cartao_projeto($p, 110) ?>
      <?php endforeach; ?>
    </div>
    <div class="text-center mt-4">
      <a href="projetos.php" class="btn btn-outline-primary">Ver todos os projetos</a>
    </div>
  </div>
</section>
<?php endif; ?>

<!-- 6. Convite final -->
<section class="py-5 bg-dark text-light text-center">
  <div class="container">
    <h2 class="fw-bold mb-3">Tens um projeto em mente?</h2>
    <p class="mb-4">Vamos conversar sobre como o posso tirar do papel.</p>
    <a href="contacto.php" class="btn btn-primary btn-lg">Entrar em contacto</a>
  </div>
</section>

<?php require_once 'includes/footer.php'; ?>