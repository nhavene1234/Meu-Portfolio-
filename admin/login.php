<?php
session_start();
require_once '../includes/db.php';

// Se já está autenticado, vai direto ao painel
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';

    $stmt = $pdo->prepare("SELECT id, nome, senha_hash FROM utilizadores WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($senha, $user['senha_hash'])) {
        session_regenerate_id(true);          // evita fixação de sessão
        $_SESSION['admin_id']   = $user['id'];
        $_SESSION['admin_nome'] = $user['nome'];
        header('Location: dashboard.php');
        exit;
    }

    $erro = 'Email ou senha incorretos.';
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            <h1 class="h4 text-center mb-4">Área de administração</h1>

            <?php if ($erro): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="post">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required autofocus>
              </div>
              <div class="mb-3">
                <label class="form-label">Senha</label>
                <input type="password" name="senha" class="form-control" required>
              </div>
              <button class="btn btn-primary w-100">Entrar</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>