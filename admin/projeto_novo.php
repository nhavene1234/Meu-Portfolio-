<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
require_once '../includes/csrf.php';

$erros = [];
$dados = ['titulo' => '', 'descricao' => '', 'tecnologias' => '',
          'link_github' => '', 'link_demo' => '', 'destaque' => 0];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!csrf_valido($_POST['csrf'] ?? null)) {
        die('Pedido inválido.');
    }

    $dados['titulo']      = trim($_POST['titulo'] ?? '');
    $dados['descricao']   = trim($_POST['descricao'] ?? '');
    $dados['tecnologias'] = trim($_POST['tecnologias'] ?? '');
    $dados['link_github'] = trim($_POST['link_github'] ?? '');
    $dados['link_demo']   = trim($_POST['link_demo'] ?? '');
    $dados['destaque']    = isset($_POST['destaque']) ? 1 : 0;

    // Validações de texto
    if ($dados['titulo'] === '' || mb_strlen($dados['titulo']) > 150) {
        $erros[] = 'O título é obrigatório (máx. 150 caracteres).';
    }
    if ($dados['descricao'] === '') {
        $erros[] = 'A descrição é obrigatória.';
    }
    foreach (['link_github', 'link_demo'] as $campo) {
        if ($dados[$campo] !== '' && !filter_var($dados[$campo], FILTER_VALIDATE_URL)) {
            $erros[] = 'O link "' . $campo . '" não é um URL válido.';
        }
    }

    // Upload da imagem (opcional)
    $nomeImagem = null;

    if (!empty($_FILES['imagem']['name'])) {
        $f = $_FILES['imagem'];

        if ($f['error'] !== UPLOAD_ERR_OK) {
            $erros[] = 'Falha no envio da imagem.';
        } elseif ($f['size'] > 2 * 1024 * 1024) {
            $erros[] = 'A imagem não pode ter mais de 2 MB.';
        } else {
            // Verifica o tipo REAL do ficheiro, não só a extensão
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime  = $finfo->file($f['tmp_name']);
            $permitidos = [
                'image/jpeg' => 'jpg',
                'image/png'  => 'png',
                'image/webp' => 'webp',
            ];

            if (!isset($permitidos[$mime]) || !getimagesize($f['tmp_name'])) {
                $erros[] = 'Só são aceites imagens JPG, PNG ou WEBP.';
            } else {
                $nomeImagem = uniqid('proj_', true) . '.' . $permitidos[$mime];
                $destino = __DIR__ . '/../uploads/' . $nomeImagem;

                if (!move_uploaded_file($f['tmp_name'], $destino)) {
                    $erros[] = 'Não foi possível guardar a imagem.';
                    $nomeImagem = null;
                }
            }
        }
    }

    // Guardar na base de dados
    if (!$erros) {
        $stmt = $pdo->prepare(
            "INSERT INTO projetos (titulo, descricao, tecnologias, imagem, link_github, link_demo, destaque)
             VALUES (?, ?, ?, ?, ?, ?, ?)"
        );
        $stmt->execute([
            $dados['titulo'], $dados['descricao'], $dados['tecnologias'], $nomeImagem,
            $dados['link_github'] ?: null, $dados['link_demo'] ?: null, $dados['destaque'],
        ]);

        header('Location: dashboard.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Novo projeto | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
  <div class="container">
    <a href="dashboard.php" class="navbar-brand">← Voltar ao painel</a>
  </div>
</nav>

<div class="container py-4" style="max-width: 760px;">
  <h1 class="h3 mb-4">Novo projeto</h1>

  <?php if ($erros): ?>
    <div class="alert alert-danger">
      <ul class="mb-0">
        <?php foreach ($erros as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?>
      </ul>
    </div>
  <?php endif; ?>

  <form method="post" enctype="multipart/form-data" class="card shadow-sm p-4">
    <input type="hidden" name="csrf" value="<?= csrf_token() ?>">

    <div class="mb-3">
      <label class="form-label">Título *</label>
      <input type="text" name="titulo" class="form-control" maxlength="150"
             value="<?= htmlspecialchars($dados['titulo']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Descrição *</label>
      <textarea name="descricao" rows="5" class="form-control" required><?= htmlspecialchars($dados['descricao']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Tecnologias</label>
      <input type="text" name="tecnologias" class="form-control" placeholder="PHP, MySQL, Bootstrap"
             value="<?= htmlspecialchars($dados['tecnologias']) ?>">
    </div>

    <div class="row">
      <div class="col-md-6 mb-3">
        <label class="form-label">Link do GitHub</label>
        <input type="url" name="link_github" class="form-control" placeholder="https://github.com/..."
               value="<?= htmlspecialchars($dados['link_github']) ?>">
      </div>
      <div class="col-md-6 mb-3">
        <label class="form-label">Link da demo</label>
        <input type="url" name="link_demo" class="form-control" placeholder="https://..."
               value="<?= htmlspecialchars($dados['link_demo']) ?>">
      </div>
    </div>

    <div class="mb-3">
      <label class="form-label">Imagem do projeto (JPG, PNG ou WEBP, até 2 MB)</label>
      <input type="file" name="imagem" class="form-control" accept="image/jpeg,image/png,image/webp">
    </div>

    <div class="form-check mb-4">
      <input type="checkbox" name="destaque" id="destaque" class="form-check-input"
             <?= $dados['destaque'] ? 'checked' : '' ?>>
      <label for="destaque" class="form-check-label">Mostrar em destaque na página inicial</label>
    </div>

    <button class="btn btn-primary">Guardar projeto</button>
  </form>
</div>

</body>
</html>