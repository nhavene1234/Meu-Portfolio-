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

// Cartão de um projeto (usado na página inicial e na lista de projetos)
function cartao_projeto(array $p, int $limite = 140): string {
    $id     = (int)$p['id'];
    $demo   = url_http($p['link_demo'] ?? null);
    $github = url_http($p['link_github'] ?? null);

    $etiquetas = '';
    if (!empty($p['tecnologias'])) {
        foreach (explode(',', $p['tecnologias']) as $tec) {
            if (trim($tec) !== '') {
                $etiquetas .= '<span class="badge bg-secondary me-1 mb-1">' . h(trim($tec)) . '</span>';
            }
        }
    }

    $links = '<a href="projeto.php?id=' . $id . '" class="btn btn-sm btn-primary">Ver detalhes</a>';
    if ($demo) {
        $links .= '<a href="' . h($demo) . '" class="btn btn-sm btn-outline-success" '
                . 'target="_blank" rel="noopener noreferrer">Ver site</a>';
    }
    if ($github) {
        $links .= '<a href="' . h($github) . '" class="btn btn-sm btn-outline-dark" '
                . 'target="_blank" rel="noopener noreferrer">GitHub</a>';
    }

    return '<div class="col-md-6 col-lg-4">'
         . '<div class="card card-projeto h-100 shadow-sm">'
         . '<div class="card-body">'
         . '<h5 class="card-title">' . h($p['titulo']) . '</h5>'
         . '<p class="card-text">' . h(mb_strimwidth($p['descricao'], 0, $limite, '...')) . '</p>'
         . $etiquetas
         . '</div>'
         . '<div class="card-footer bg-transparent border-0 pb-3 d-flex flex-wrap gap-2">' . $links . '</div>'
         . '</div></div>';
}