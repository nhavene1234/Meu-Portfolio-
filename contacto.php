<?php
require_once 'includes/db.php';
require_once 'includes/csrf.php';     // também inicia a sessão

$assuntos = ['Freelancer', 'Colaboração', 'Oportunidade de emprego', 'Outro'];
$erros    = [];
$dados    = ['nome' => '', 'email' => '', 'assunto' => '', 'mensagem' => ''];

// Mensagem de sucesso (vem do redirecionamento após enviar)
$sucesso = !empty($_SESSION['contacto_ok']);
unset($_SESSION['contacto_ok']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valido($_POST['csrf'] ?? null)) {
        $erros[] = 'Pedido inválido. Recarrega a página e tenta de novo.';
    }

    // Campo-armadilha para robôs: humanos não o veem nem preenchem
    if (!empty($_POST['website'])) {
        $_SESSION['contacto_ok'] = true;
        header('Location: contacto.php#formulario');
        exit;
    }

    $dados['nome']     = trim($_POST['nome'] ?? '');
    $dados['email']    = trim($_POST['email'] ?? '');
    $dados['assunto']  = $_POST['assunto'] ?? '';
    $dados['mensagem'] = trim($_POST['mensagem'] ?? '');

    // Limite de tempo entre envios (evita spam)
    if (isset($_SESSION['ultimo_envio']) && time() - $_SESSION['ultimo_envio'] < 30) {
        $erros[] = 'Aguarda alguns segundos antes de enviar outra mensagem.';
    }

    if (mb_strlen($dados['nome']) < 3 || mb_strlen($dados['nome']) > 100) {
        $erros[] = 'Escreve o teu nome completo (entre 3 e 100 caracteres).';
    }
    if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL) || mb_strlen($dados['email']) > 150) {
        $erros[] = 'Escreve um email válido.';
    }
    if (!in_array($dados['assunto'], $assuntos, true)) {
        $erros[] = 'Escolhe um assunto.';
    }

    $palavras = preg_split('/\s+/u', $dados['mensagem'], -1, PREG_SPLIT_NO_EMPTY);
    if (mb_strlen($dados['mensagem']) < 10) {
        $erros[] = 'A mensagem é demasiado curta.';
    } elseif (count($palavras) > 2000 || mb_strlen($dados['mensagem']) > 15000) {
        $erros[] = 'A mensagem não pode ter mais de 2000 palavras.';
    }

    if (!$erros) {
        // 1) Guarda na base de dados (assim nunca perdes uma mensagem)
        $stmt = $pdo->prepare("INSERT INTO mensagens (nome, email, assunto, mensagem) VALUES (?, ?, ?, ?)");
        $stmt->execute([$dados['nome'], $dados['email'], $dados['assunto'], $dados['mensagem']]);

        // 2) Tenta enviar para o teu email
        $nomeLimpo = preg_replace('/[\r\n]+/', ' ', $dados['nome']);
        $assuntoEmail = mb_encode_mimeheader('[Portfólio] ' . $dados['assunto'] . ' - ' . $nomeLimpo, 'UTF-8');
        $corpo = "Nova mensagem pelo portfólio\n\n"
               . "Nome: {$nomeLimpo}\n"
               . "Email: {$dados['email']}\n"
               . "Assunto: {$dados['assunto']}\n\n"
               . $dados['mensagem'] . "\n";
        $cabecalhos = "MIME-Version: 1.0\r\n"
                    . "Content-Type: text/plain; charset=UTF-8\r\n"
                    . "From: " . EMAIL_CONTACTO . "\r\n"
                    . "Reply-To: " . $dados['email'] . "\r\n";

        @mail(EMAIL_CONTACTO, $assuntoEmail, $corpo, $cabecalhos);

        $_SESSION['ultimo_envio'] = time();
        $_SESSION['contacto_ok']  = true;
        header('Location: contacto.php#formulario');   // evita reenvio ao recarregar
        exit;
    }
}

$titulo = 'Contacto';
require_once 'includes/header.php';
?>

<section class="py-5">
  <div class="container" style="max-width: 960px;">

    <h1 class="fw-bold text-center mb-3">Vamos conversar?</h1>
    <p class="lead text-center mx-auto mb-5" style="max-width: 720px;">
      Estou disponível para oportunidades de freelance, projetos colaborativos e para trabalhar
      a tempo integral. Se tens uma ideia para tirar do papel, uma equipa à procura de um
      desenvolvedor, ou simplesmente queres trocar ideias sobre tecnologia, escreve-me.
      Respondo assim que possível.
    </p>

    <!-- Cartões de contacto -->
    <div class="row g-3 mb-5">
      <div class="col-sm-6 col-lg-3">
        <div class="cartao-contacto">
          <i class="bi bi-geo-alt-fill"></i>
          <h2 class="h6">Localização</h2>
          <p class="mb-0"><?= htmlspecialchars(LOCALIZACAO) ?></p>
        </div>
      </div>

      <div class="col-sm-6 col-lg-3">
        <a href="mailto:<?= EMAIL_CONTACTO ?>" class="cartao-contacto">
          <i class="bi bi-envelope-fill"></i>
          <h2 class="h6">Email</h2>
          <p class="mb-0 text-break"><?= EMAIL_CONTACTO ?></p>
        </a>
      </div>

      <div class="col-sm-6 col-lg-3">
        <a href="<?= LINKEDIN_URL ?>" class="cartao-contacto" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-linkedin"></i>
          <h2 class="h6">LinkedIn</h2>
          <p class="mb-0">Ver o meu perfil</p>
        </a>
      </div>

      <div class="col-sm-6 col-lg-3">
        <a href="https://wa.me/<?= WHATSAPP_NUMERO ?>" class="cartao-contacto" target="_blank" rel="noopener noreferrer">
          <i class="bi bi-whatsapp"></i>
          <h2 class="h6">WhatsApp</h2>
          <p class="mb-0"><?= WHATSAPP_EXIBIR ?></p>
        </a>
      </div>
    </div>

    <!-- Formulário -->
    <div id="formulario" class="card shadow-sm mx-auto" style="max-width: 720px;">
      <div class="card-body p-4 p-md-5">
        <h2 class="h4 fw-bold mb-4">Envia-me uma mensagem</h2>

        <?php if ($sucesso): ?>
          <div class="alert alert-success">
            Mensagem enviada com sucesso! Obrigado pelo contacto, responderei em breve.
          </div>
        <?php endif; ?>

        <?php if ($erros): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($erros as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="post" action="contacto.php#formulario">
          <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

          <!-- Campo-armadilha (escondido) -->
          <div style="position:absolute; left:-9999px;" aria-hidden="true">
            <label>Não preenchas este campo</label>
            <input type="text" name="website" tabindex="-1" autocomplete="off">
          </div>

          <div class="mb-3">
            <label for="nome" class="form-label">Nome completo *</label>
            <input type="text" id="nome" name="nome" class="form-control" maxlength="100" required
                   value="<?= htmlspecialchars($dados['nome']) ?>">
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">O teu email *</label>
            <input type="email" id="email" name="email" class="form-control" maxlength="150" required
                   value="<?= htmlspecialchars($dados['email']) ?>">
          </div>

          <div class="mb-3">
            <label for="assunto" class="form-label">Assunto *</label>
            <select id="assunto" name="assunto" class="form-select" required>
              <option value="" disabled <?= $dados['assunto'] === '' ? 'selected' : '' ?>>Escolhe um assunto</option>
              <?php foreach ($assuntos as $a): ?>
                <option value="<?= htmlspecialchars($a) ?>" <?= $dados['assunto'] === $a ? 'selected' : '' ?>>
                  <?= htmlspecialchars($a) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="mb-4">
            <label for="mensagem" class="form-label">Mensagem *</label>
            <textarea id="mensagem" name="mensagem" rows="7" class="form-control" required
                      placeholder="Conta-me um pouco sobre o que precisas..."><?= htmlspecialchars($dados['mensagem']) ?></textarea>
            <div class="form-text text-end"><span id="contador">0 / 2000 palavras</span></div>
          </div>

          <button type="submit" id="botao-enviar" class="btn btn-primary btn-lg w-100">
            <i class="bi bi-send me-2"></i>Enviar mensagem
          </button>
        </form>
      </div>
    </div>

  </div>
</section>

<script>
  // Contador de palavras (limite de 2000)
  const campo    = document.getElementById('mensagem');
  const contador = document.getElementById('contador');
  const botao    = document.getElementById('botao-enviar');

  function contarPalavras() {
    const texto = campo.value.trim();
    const n = texto ? texto.split(/\s+/).length : 0;
    contador.textContent = n + ' / 2000 palavras';
    contador.classList.toggle('text-danger', n > 2000);
    botao.disabled = n > 2000;
  }

  campo.addEventListener('input', contarPalavras);
  contarPalavras();
</script>

<?php require_once 'includes/footer.php'; ?>