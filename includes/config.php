<?php
// includes/config.php
// Não tem passwords: os dados da base de dados vêm de variáveis de ambiente.
// No XAMPP usa os valores por defeito (MySQL local).
// No Render define DB_DRIVER=pgsql e os dados do Neon no painel.

function env_ou(string $chave, string $padrao = ''): string {
    $v = getenv($chave);
    return ($v !== false && $v !== '') ? $v : $padrao;
}

// ---- Base de dados ----
define('DB_DRIVER', env_ou('DB_DRIVER', 'mysql'));
define('DB_HOST',   env_ou('DB_HOST', 'localhost'));
define('DB_PORT',   env_ou('DB_PORT', DB_DRIVER === 'pgsql' ? '5432' : '3306'));
define('DB_NAME',   env_ou('DB_NAME', 'portfolio'));
define('DB_USER',   env_ou('DB_USER', 'root'));
define('DB_PASS',   env_ou('DB_PASS', ''));

// ---- Site ----
define('SITE_NOME', 'Nelson Nhavene');
define('SITE_URL', env_ou('SITE_URL', 'http://localhost/portfolio'));

define('EMAIL_CONTACTO', 'nelsonnhavenee@gmail.com');
define('LOCALIZACAO', 'Maputo, Moçambique');
define('ENDERECO', "Avenida da Zâmbia, Alto Maé, Maputo-Moçambique");

define('WHATSAPP_NUMERO', '258873505758');          // com o indicativo do país, sem + nem espaços
define('WHATSAPP_EXIBIR', '(+258) 873505758');

define('GITHUB_URL', 'https://github.com/nhavene1234');
define('LINKEDIN_URL', 'https://www.linkedin.com/in/nelson-nhavene-0a8a29304/');
define('FACEBOOK_URL', '');    // cola aqui o link do teu Facebook
define('INSTAGRAM_URL', '');   // cola aqui o link do teu Instagram