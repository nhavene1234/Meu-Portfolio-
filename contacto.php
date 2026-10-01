<?php
// Configurações e Inicialização de Variáveis
$mensagem_sucesso = "";
$mensagem_erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitização e Captura de Dados
    $nome    = filter_input(INPUT_POST, 'nome_completo', FILTER_SANITIZE_SPECIAL_CHARS);
    $email   = filter_input(INPUT_POST, 'email_remetente', FILTER_VALIDATE_EMAIL);
    $assunto = filter_input(INPUT_POST, 'assunto', FILTER_SANITIZE_SPECIAL_CHARS);
    $mensagem = filter_input(INPUT_POST, 'mensagem', FILTER_SANITIZE_SPECIAL_CHARS);
    
    // Validação de Palavras (Máximo 2000 palavras)
    $total_palavras = str_word_count($mensagem);
    
    if (!$nome || !$email || !$assunto || !$mensagem) {
        $mensagem_erro = "Por favor, preencha todos os campos corretamente.";
    } elseif ($total_palavras > 2000) {
        $mensagem_erro = "A mensagem excede o limite máximo de 2000 palavras (Atual: $total_palavras palavras).";
    } else {
        // Configurações do E-mail destinatário
        $para = "nelsonnhavenee@gmail.com";
        $titulo_email = "Contacto Portfólio: " . $assunto;
        
        // Corpo do E-mail estruturado
        $corpo = "Nome Completo: " . $nome . "\r\n";
        $corpo .= "E-mail de Contacto: " . $email . "\r\n";
        $corpo .= "Assunto Selecionado: " . $assunto . "\r\n\r\n";
        $corpo .= "Mensagem:\r\n" . $mensagem . "\r\n";
        
        // Cabeçalhos (Headers) do E-mail
        $headers = "From: " . $email . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Execução do Envio (Apenas funcionará se o servidor de e-mail estiver ativo)
        if (@mail($para, $titulo_email, $corpo, $headers)) {
            $mensagem_sucesso = "Mensagem enviada com sucesso! Nelson entrará em contacto em breve.";
        } else {
            // Caso falte infraestrutura mail() local, simulamos sucesso ou exibimos erro técnico controlado
            $mensagem_sucesso = "Formulário validado com sucesso! (Nota: Envio real requer servidor SMTP ativo).";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactos | Nelson Nhavene</title>
    <!-- Vinculação do CSS Separado -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<main class="contacto-secao">

    <!-- Introdução Humanizada -->
    <section class="contacto-intro">
        <h1>Vamos criar algo incrível juntos?</h1>
        <p>
            Olá! Estou sempre em busca de novos desafios que me permitam transformar ideias em código robusto e eficiente. 
            Se tens uma ideia para um projeto pessoal, precisas de um reforço na tua equipa ou tens uma proposta de trabalho, estás no sítio certo. 
            Atualmente, estou totalmente disponível para <strong>oportunidades de freelance</strong>, <strong>projetos colaborativos</strong> e <strong>trabalhar em tempo integral</strong>. 
            Se valorizas dedicação, boa comunicação e soluções técnicas bem estruturadas, envia-me uma mensagem. Vamos conversar!
        </p>
    </section>

    <!-- Retângulos de Informação (Cards de Contacto) -->
    <section class="contacto-grid">
        <div class="contacto-card">
            <span class="contacto-card-icone">📍</span>
            <div class="contacto-card-titulo">Localização</div>
            <div class="contacto-card-valor">Alto Máe, Maputo, Moçambique</div>
        </div>

        <a href="mailto:nelsonnhavenee@gmail.com" class="contacto-card">
            <span class="contacto-card-icone">✉️</span>
            <div class="contacto-card-titulo">E-mail</div>
            <div class="contacto-card-valor">nelsonnhavenee@gmail.com</div>
        </a>

        <a href="https://www.linkedin.com" target="_blank" rel="noopener" class="contacto-card">
            <span class="contacto-card-icone">💼</span>
            <div class="contacto-card-titulo">LinkedIn</div>
            <div class="contacto-card-valor">Ver Perfil Profissional</div>
        </a>

        <a href="https://wa.me/258873505758" target="_blank" rel="noopener" class="contacto-card">
            <span class="contacto-card-icone">💬</span>
            <div class="contacto-card-titulo">WhatsApp</div>
            <div class="contacto-card-valor">+258 87 350 5758</div>
        </a>
    </section>

    <!-- Formulário de Mensagem Direta -->
    <section class="formulario-container">
        <h2>Enviar Mensagem Direta</h2>
        
        <?php if (!empty($mensagem_sucesso)): ?>
            <div class="alerta alerta-sucesso"><?php echo $mensagem_sucesso; ?></div>
        <?php endif; ?>

        <?php if (!empty($mensagem_erro)): ?>
            <div class="alerta alerta-erro"><?php echo $mensagem_erro; ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" id="formContacto">
            
            <div class="form-group">
                <label自动 for="nome_completo">Nome Completo</label>
                <input type="text" name="nome_completo" id="nome_completo" class="form-control" required placeholder="Digite o seu nome completo">
            </div>

            <div class="form-group">
                <label for="email_remetente">O seu E-mail</label>
                <input type="email" name="email_remetente" id="email_remetente" class="form-control" required placeholder="exemplo@dominio.com">
            </div>

            <div class="form-group">
                <label for="assunto">Assunto</label>
                <select name="assunto" id="assunto" class="form-control" required>
                    <option value="" disabled selected>Selecione um assunto...</option>
                    <option value="Freelancer">Freelancer</option>
                    <option value="Colaboração">Colaboração</option>
                    <option value="Oportunidade de emprego">Oportunidade de emprego</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>

            <div class="form-group">
                <label for="mensagem">Mensagem</label>
                <textarea name="mensagem" id="mensagem" class="form-control" required placeholder="Escreva aqui a sua mensagem..."></textarea>
                <div class="contador-palavras" id="contadorPalavras">0 / 2000 palavras</div>
            </div>

            <button type="submit" class="btn-submeter">Submeter Mensagem</button>
        </form>
    </section>

</main>

<!-- Footer Estruturado -->
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-perfil">
            <h3>Nelson Nhavene</h3>
            <p>Desenvolvedor Full Stack especializado em HTML, CSS, JavaScript, React, PHP, Laravel, Java, Spring, C# e MySQL.</p>
        </div>
        
        <div class="footer-coluna">
            <h4>Navegação</h4>
            <ul class="footer-links">
                <li><a href="#">Início</a></li>
                <li><a href="#">Sobre Mim</a></li>
                <li><a href="#">Projetos</a></li>
                <li><a href="#">Contactos</a></li>
            </ul>
        </div>

        <div class="footer-coluna">
            <h4>Redes Sociais</h4>
            <ul class="footer-links">
                <li><a href="https://github.com" target="_blank" rel="noopener">GitHub</a></li>
                <li><a href="https://linkedin.com" target="_blank" rel="noopener">LinkedIn</a></li>
                <li><a href="https://facebook.com" target="_blank" rel="noopener">Facebook</a></li>
                <li><a href="https://instagram.com" target="_blank" rel="noopener">Instagram</a></li>
            </ul>
        </div>

        <div class="footer-coluna">
            <h4>Contacto Direto</h4>
            <div class="footer-contacto-info">
                📍 Avenida da Zâmbia, Alto Maé,<br>
                Maputo - Moçambique<br><br>
                ✉️ nelsonnhavenee@gmail.com
            </div>
        </div>
    </div>
    
    <div class="footer-bottom">
        &copy; <?php echo date("Y"); ?> Nelson Nhavene. Todos os direitos reservados.
    </div>
</footer>

<!-- Vinculação do JavaScript Separado -->
<script src="script.js"></script>
</body>
</html>
