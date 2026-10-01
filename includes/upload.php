<?php
const UPLOAD_DIR = __DIR__ . '/../uploads/';

// Valida e guarda uma imagem. Devolve [nomeDoFicheiro, erro]
function guardar_imagem(array $f): array {
    if ($f['error'] !== UPLOAD_ERR_OK) {
        return [null, 'Falha no envio da imagem.'];
    }
    if ($f['size'] > 2 * 1024 * 1024) {
        return [null, 'A imagem não pode ter mais de 2 MB.'];
    }

    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
    $permitidos = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];

    if (!isset($permitidos[$mime]) || !getimagesize($f['tmp_name'])) {
        return [null, 'Só são aceites imagens JPG, PNG ou WEBP.'];
    }

    $nome = uniqid('proj_', true) . '.' . $permitidos[$mime];
    if (!move_uploaded_file($f['tmp_name'], UPLOAD_DIR . $nome)) {
        return [null, 'Não foi possível guardar a imagem.'];
    }
    return [$nome, null];
}

// Apaga uma imagem da pasta uploads (basename evita caminhos maliciosos)
function apagar_imagem(?string $nome): void {
    if (!$nome) return;
    $caminho = UPLOAD_DIR . basename($nome);
    if (is_file($caminho)) {
        unlink($caminho);
    }
}