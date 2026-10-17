<?php
// Ano em que começaste a programar (aprox.). Os anos de experiência calculam-se sozinhos.
$inicioProgramacao = 2023;
$anosExperiencia   = max(1, (int)date('Y') - $inicioProgramacao);

// Serviços mostrados na página inicial
$servicos = [
    [
        'bi-window-stack',
        'Aplicações web completas',
        'Do protótipo visual à publicação: sites e sistemas web com front-end dinâmico e back-end sólido.',
    ],
    [
        'bi-hdd-network',
        'APIs e back-end',
        'REST APIs e lógica de negócio com Java (Spring Boot), PHP (Laravel) e C#, ligadas a bases de dados.',
    ],
    [
        'bi-palette',
        'Interfaces e design',
        'Interfaces responsivas e fáceis de usar, com o apoio de design gráfico (Photoshop e CorelDraw).',
    ],
];