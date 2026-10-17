<?php
// Cada item: [nome, classe do ícone (ou null)]
$tecnologias = [
    'Back-end' => [
        ['PHP',         'devicon-php-plain colored'],
        ['Laravel',     'devicon-laravel-original colored'],
        ['Java',        'devicon-java-plain colored'],
        ['Spring Boot', 'devicon-spring-plain colored'],
        ['C#',          'devicon-csharp-plain colored'],
    ],
    'Front-end' => [
        ['HTML5',       'devicon-html5-plain colored'],
        ['CSS3',        'devicon-css3-plain colored'],
        ['JavaScript',  'devicon-javascript-plain colored'],
        ['React',       'devicon-react-original colored'],
    ],
    'Bases de dados' => [
        ['MySQL',       'devicon-mysql-plain colored'],
        ['MariaDB',     'devicon-mariadb-original colored'],
        ['PostgreSQL',  'devicon-postgresql-plain colored'],
        ['H2 (testes)', null],
    ],
    'Ferramentas' => [
        ['Docker',      'devicon-docker-plain colored'],
        ['Git',         'devicon-git-plain colored'],
        ['Linux',       'devicon-linux-plain'],
    ],
];

// Áreas de competência (página Habilidades)
$areas = [
    [
        'titulo' => 'Back-end e APIs',
        'icone'  => 'bi-hdd-network',
        'texto'  => 'Construção de arquiteturas back-end robustas e de APIs que ligam as aplicações aos dados.',
        'itens'  => ['Java', 'Spring Boot', 'PHP', 'Laravel', 'C#', 'REST APIs', 'HTTP', 'SQL'],
    ],
    [
        'titulo' => 'Front-end e UI/UX',
        'icone'  => 'bi-window-stack',
        'texto'  => 'Interfaces web dinâmicas, responsivas e agradáveis de usar, do protótipo visual ao código.',
        'itens'  => ['HTML5', 'CSS3', 'JavaScript', 'React', 'Photoshop', 'CorelDraw'],
    ],
    [
        'titulo' => 'DevOps e Testes',
        'icone'  => 'bi-gear-wide-connected',
        'texto'  => 'Ambientes consistentes, código versionado e qualidade garantida por testes.',
        'itens'  => ['Docker', 'Git', 'Linux CLI', 'Testes unitários', 'Testes de desempenho'],
    ],
];

$competencias = [
    'Trabalho sob pressão',
    'Proatividade',
    'Aprendizagem rápida',
    'Trabalho em equipa',
    'Organização',
];

$certificacoes = [
    ['HCIA-Datacom V1.0',                     'Huawei ICT Academy', '2024'],
    ['Data Communication & Network Technology', 'Huawei ICT Academy', '2024'],
    ['Curso Profissional de Design Gráfico',  'Centro de Formação Central Jovem', '2023'],
];