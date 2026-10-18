<?php
require_once __DIR__ . '/config.php';

function h(?string $texto): string {
    return htmlspecialchars((string)$texto, ENT_QUOTES, 'UTF-8');
}

// Só aceita endereços http:// ou https:// (bloqueia javascript:, data:, etc.)
function url_http(?string $url): ?string {
    $url = trim((string)$url);
    if (preg_match('#^https?://#i', $url) && filter_var($url, FILTER_VALIDATE_URL)) {
        return $url;
    }
    return null;
}

// Miniatura usada nos cartões (página inicial e lista de projetos)
function miniatura_projeto(array $p): string {
    $demo = url_http($p['link_demo'] ?? null);

    if ($demo && !empty($p['mostrar_preview'])) {
        return '<div class="preview-caixa" aria-hidden="true">'
             . '<iframe src="' . h($demo) . '" loading="lazy" tabindex="-1" '
             . 'sandbox="allow-scripts allow-same-origin" referrerpolicy="no-referrer" '
             . 'title="Pré-visualização de ' . h($p['titulo']) . '"></iframe>'
             . '</div>';
    }

    if (!empty($p['imagem'])) {
        return '<img src="' . SITE_URL . '/uploads/' . h($p['imagem']) . '" class="card-img-top" alt="">';
    }

    return '<div class="sem-preview" aria-hidden="true"><i class="bi bi-window-stack"></i></div>';
}