<?php
$titulo = 'Sobre';
require_once 'includes/perfil.php';
require_once 'includes/header.php';

$cvCaminho = 'assets/cv/CV_Nelson_Nhavene.pdf';
$temCv = file_exists(__DIR__ . '/' . $cvCaminho);
?>

<section class="py-5">
  <div class="container" style="max-width: 900px;">
    <h1 class="fw-bold text-center mb-5">Sobre mim</h1>

    <!-- História -->
    <div class="row align-items-center g-4 mb-5">
      <div class="col-md-4 text-center">
        <img src="<?= SITE_URL ?>/assets/img/perfil.jpeg" alt="Nelson Nhavene" class="foto-perfil foto-perfil-pequena">
      </div>
      <div class="col-md-8">
        <p>
          Sou o Nelson, estudante de Engenharia de Software na Universidade Joaquim Chissano.
          Programo há cerca de <?= $anosExperiencia ?> anos e, desde as primeiras linhas de código,
          o que mais me motiva é ver uma ideia ganhar vida num ecrã e ajudar alguém a resolver
          algo no dia a dia.
        </p>
        <p>
          Gosto de acompanhar um projeto do início ao fim: perceber o problema, desenhar a solução,
          programar, testar e melhorar. Para mim, um bom software não é só aquele que funciona,
          é o que é claro, organizado e agradável de usar.
        </p>
        <p>
          Estou a crescer como desenvolvedor full-stack, sempre a aprender e à procura de
          oportunidades onde possa contribuir e crescer com outras pessoas.
        </p>
        <div class="d-flex flex-wrap gap-2 mt-3">
          <a href="contacto.php" class="btn btn-primary">Fala comigo</a>
          <?php if ($temCv): ?>
            <a href="<?= $cvCaminho ?>" class="btn btn-outline-dark" download>
              <i class="bi bi-download me-1"></i>Descarregar CV
            </a>
          <?php endif; ?>
          <a href="<?= GITHUB_URL ?>" class="btn btn-outline-dark" target="_blank" rel="noopener noreferrer">GitHub</a>
          <a href="<?= LINKEDIN_URL ?>" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
      </div>
    </div>

    <!-- Percurso -->
    <h2 class="h4 fw-bold mb-4">O meu percurso</h2>
    <div class="mb-5">

      <div class="border-start border-3 border-primary ps-4 pb-4">
        <span class="badge text-bg-primary mb-1">2022</span>
        <h3 class="h6 fw-bold mb-1">Conclusão do Ensino Médio</h3>
      </div>

      <div class="border-start border-3 border-primary ps-4 pb-4">
        <span class="badge text-bg-primary mb-1">2023</span>
        <h3 class="h6 fw-bold mb-1">Início da licenciatura e dos primeiros passos na programação</h3>
        <p class="text-muted mb-0">
          Entrei em Engenharia em Tecnologias de Sistemas de Informação, com especialização em
          Engenharia de Software, na Universidade Joaquim Chissano. No mesmo ano fiz o curso
          profissional de Design Gráfico, que ainda hoje influencia a forma como desenho interfaces.
        </p>
      </div>

      <div class="border-start border-3 border-primary ps-4 pb-4">
        <span class="badge text-bg-primary mb-1">2024</span>
        <h3 class="h6 fw-bold mb-1">Redes e infraestrutura</h3>
        <p class="text-muted mb-0">
          Formações na Huawei ICT Academy, que me deram uma base sólida sobre como as aplicações
          comunicam por trás do ecrã.
        </p>
      </div>

      <div class="border-start border-3 border-success ps-4">
        <span class="badge text-bg-success mb-1">Hoje</span>
        <h3 class="h6 fw-bold mb-1">Desenvolvedor Full Stack em formação</h3>
        <p class="text-muted mb-0">
          A construir aplicações web com Java (Spring Boot), PHP (Laravel) e C#, e aberto a
          freelance, projetos colaborativos e trabalho a tempo integral.
        </p>
      </div>

    </div>

    <!-- Idiomas -->
    <h2 class="h4 fw-bold mb-3">Idiomas</h2>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100"><div class="card-body">
          <strong>Português</strong><br><span class="text-muted">Fluente</span>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100"><div class="card-body">
          <strong>Inglês</strong><br>
          <span class="text-muted">Razoável: leitura de documentação técnica, manuais de APIs e livros de programação</span>
        </div></div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100"><div class="card-body">
          <strong>Chagana</strong><br><span class="text-muted">Razoável</span>
        </div></div>
      </div>
    </div>

  </div>
</section>

<?php require_once 'includes/footer.php'; ?>