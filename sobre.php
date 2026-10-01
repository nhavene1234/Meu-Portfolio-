<?php
$titulo = 'Sobre';
require_once 'includes/header.php';
?>

<section class="py-5">
  <div class="container" style="max-width: 900px;">
    <h1 class="fw-bold text-center mb-4">Sobre mim</h1>

    <div class="row align-items-center g-4 mb-5">
      <div class="col-md-4 text-center">
        <img src="<?= SITE_URL ?>/assets/img/perfil.jpeg" alt="Nelson Nhavene" class="foto-perfil foto-perfil-pequena">
      </div>
      <div class="col-md-8">
        <p>
          Sou o Nelson, estudante de Engenharia de Software na Universidade Joaquim Chissano.
          Desde que escrevi as minhas primeiras linhas de código percebi que o que mais me motiva
          é ver uma ideia ganhar vida num ecrã e ajudar alguém a resolver algo no dia a dia.
        </p>
        <p>
          Gosto de acompanhar um projeto do início ao fim: perceber o problema, desenhar a solução,
          programar, testar e melhorar. Para mim, um bom software não é só aquele que funciona,
          é o que é claro, organizado e agradável de usar.
        </p>
        <p>
          Estou a crescer como desenvolvedor full-stack: construo back-ends com Java (Spring Boot),
          PHP (Laravel) e C#, ligados a interfaces web dinâmicas e responsivas. Também trabalho com
          Docker, Git, Linux e testes de sistemas, e estou sempre a aprender e à procura de
          oportunidades onde possa contribuir e crescer com outras pessoas.
        </p>
        <div class="d-flex flex-wrap gap-2 mt-3">
          <a href="contacto.php" class="btn btn-primary">Fala comigo</a>
          <a href="<?= GITHUB_URL ?>" class="btn btn-outline-dark" target="_blank" rel="noopener noreferrer">GitHub</a>
          <a href="<?= LINKEDIN_URL ?>" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-6">
        <h2 class="h4 fw-bold mb-3">Formação académica</h2>
        <ul class="list-unstyled">
          <li class="mb-3">
            <strong>Licenciatura em Engenharia em Tecnologias de Sistemas de Informação</strong><br>
            Especialização em Engenharia de Software<br>
            <span class="text-muted">Universidade Joaquim Chissano · 2023 – Presente</span>
          </li>
          <li>
            <strong>Ensino Médio</strong><br>
            <span class="text-muted">Concluído em 2022</span>
          </li>
        </ul>

        <h2 class="h4 fw-bold mb-3 mt-4">Formações complementares</h2>
        <ul class="list-unstyled">
          <li class="mb-2">
            <strong>Curso Profissional de Design Gráfico</strong><br>
            <span class="text-muted">Centro de Formação Central Jovem · 2023</span>
          </li>
          <li class="mb-2">
            <strong>Data Communication &amp; Network Technology</strong><br>
            <span class="text-muted">Huawei ICT Academy · 2024</span>
          </li>
          <li>
            <strong>HCIA-Datacom V1.0</strong><br>
            <span class="text-muted">Huawei ICT Academy · 2024</span>
          </li>
        </ul>
      </div>

      <div class="col-md-6">
        <h2 class="h4 fw-bold mb-3">Competências profissionais</h2>
        <div class="mb-4">
          <?php foreach (['Trabalho sob pressão', 'Proatividade', 'Aprendizagem rápida', 'Trabalho em equipa', 'Organização'] as $c): ?>
            <span class="badge bg-primary fs-6 fw-normal me-1 mb-2"><?= $c ?></span>
          <?php endforeach; ?>
        </div>

        <h2 class="h4 fw-bold mb-3">Idiomas</h2>
        <ul class="list-unstyled">
          <li><strong>Português:</strong> fluente</li>
          <li><strong>Inglês:</strong> razoável (leitura de documentação técnica, manuais de APIs e livros de programação)</li>
          <li><strong>Chagana:</strong> razoável</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="bg-light">
  <?php require_once 'includes/tecnologias.php'; ?>
</section>

<?php require_once 'includes/footer.php'; ?>