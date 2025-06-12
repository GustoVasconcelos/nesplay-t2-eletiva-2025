<?php
session_start();
require_once './proc/funcoesBD.php';
$resultRoms = listarUltimosRoms(5);
$listaNoticias = listarNoticias(3);
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay</title>
    <link rel="shortcut icon" type="image/png" href="./assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="background">

        <header class="border-bottom-animated-glass">
            <div class="container-fluid d-flex align-items-center justify-content-between frosted-content gradiente p-4 shadow-sm">
                <a id="div-logo" href="./index.php" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="./assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="scroll-horizontal-buttons">
                    <div class="d-flex">
                        <button id="toggle-bordas" class="btn-animated btn btn-outline-secondary me-2">Desativar Bordas Neon</button>
                        <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar Animações</button>
                        <?php if (!isset($_SESSION['usuario'])): ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./view/login.php">Login</a>
                            <a class="btn-animated btn btn-secondary" href="./view/cadastrar.php">Cadastrar</a>
                        <?php else: ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./view/logout.php">Sair</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <nav class="scroll-horizontal sticky-nav border-bottom-animated-glass">
            <div class="frosted-content gradiente p-1 shadow-sm">
                <div class="container-fluid px-3 px-md-5">
                    <ul class="nav nav-underline justify-content-center">
                        <li class="nav-item"><a class="nav-link px-2" href="./index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./view/todas-noticias.php">Notícias</a></li>
                        <?php
                        if (isset($_SESSION['usuario_adm']) && $_SESSION['usuario_adm'] == 1) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./view/admin/admin.php">Admin</a></li>';
                        }
                        if (isset($_SESSION['usuario'])) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./view/cadastrar-rom.php">Enviar ROM</a></li>';
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./view/acervo-jogos.php">Jogos Disponíveis</a></li>';
                        } ?>
                        <li class="nav-item"><a class="nav-link px-2" href="./view/teste-jogo.php">Testar ROMs</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./view/sobre.php">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container px-3 px-md-5 py-5" id="hanging-icons">
            <div class="text-center mb-4">
                <div class="border-animated-glass d-inline-block">
                    <div class="frosted-content gradiente px-4 py-2 shadow-sm">
                        <h2 class="fs-3 mb-0 text-light">Seja Bem-Vindo</h2>
                    </div>
                </div>
            </div>
            <!-- CARDS FIXOS -->
            <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-lg-3 mb-5">
                <!-- Crie sua conta -->
                <div class="col d-flex align-items-stretch">
                    <div class="border-animated-glass w-100">
                        <div class="frosted-content gradiente p-4 shadow-sm h-100">
                            <div class="text-center">
                                <img src="assets/img/tv_nes.svg" alt="TV" class="img-fluid mb-2 mx-auto d-block" style="height:120px;object-fit:contain;">
                                <h3 class="mb-1">Crie sua conta</h3>
                                <p>De maneira simples, rápida e objetiva, você cria sua conta em poucos passos e já começa a jogar sem complicações.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Faça upload -->
                <div class="col d-flex align-items-stretch">
                    <div class="border-animated-glass w-100">
                        <div class="frosted-content gradiente p-4 shadow-sm h-100">
                            <div class="text-center">
                                <img src="assets/img/cartucho_nes.svg" alt="Cartucho" class="img-fluid mb-2 mx-auto d-block" style="height:120px;object-fit:contain;">
                                <h3 class="mb-1">Faça upload das suas roms</h3>
                                <p>Disponibilizamos um espaço no servidor para você fazer o upload de suas roms favoritas.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Jogue direto -->
                <div class="col d-flex align-items-stretch">
                    <div class="border-animated-glass w-100">
                        <div class="frosted-content gradiente p-4 shadow-sm h-100">
                            <div class="text-center">
                                <img src="assets/img/console_nes.svg" alt="Console" class="img-fluid mb-2 mx-auto d-block" style="height:120px;object-fit:contain;">
                                <h3 class="mb-1">Jogue direto do navegador</h3>
                                <p>Sem downloads ou configurações complexas. Basta apenas escolher o jogo e se divertir.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BLOCO DE NOTÍCIAS -->
            <?php if ($listaNoticias && $listaNoticias->num_rows > 0): ?>
                <!-- TÍTULO -->
                <div class="text-center mb-4">
                    <div class="border-animated-glass d-inline-block">
                        <div class="frosted-content gradiente px-4 py-2 shadow-sm">
                            <h2 class="fs-3 mb-0 text-light">Notícias Recentes</h2>
                        </div>
                    </div>
                </div>

                <section class="mb-5">
                    <div id="news-slider">
                        <div id="news-container">
                            <?php $i = 0; ?>
                            <?php while ($not = mysqli_fetch_assoc($listaNoticias)): ?>
                                <div class="news-item border-animated-glass mb-4">
                                    <div class="frosted-content gradiente p-4 rounded-3 shadow-sm">
                                        <div class="d-flex flex-column align-items-center text-center">
                                            <h2 class="game-text mb-2"><?= htmlspecialchars($not['titulo']) ?></h2>
                                            <?php if (!empty($not['subtitulo'])): ?>
                                                <h5 class="text-white mb-3"><?= htmlspecialchars($not['subtitulo']) ?></h5>
                                            <?php endif; ?>
                                            <p class="card-text mb-3"><?= nl2br(htmlspecialchars($not['texto'])) ?></p>
                                            <small class="text-comment mb-1"><?= $not['data_formatada'] ?></small>
                                            <small class="text-comment mb-3">Por <?= htmlspecialchars($not['adminNome']) ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- CONTADOR -->
                        <div class="text-center mt-2 mb-3">
                            <div class="border-animated-glass d-inline-block">
                                <div class="frosted-content gradiente px-3 py-1 shadow-sm">
                                    <small id="news-counter" class="text-light mb-0">1/<?= $listaNoticias->num_rows ?></small>
                                </div>
                            </div>
                        </div>

                        <!-- BOTOES -->
                        <div class="d-flex justify-content-center align-items-center gap-3">
                            <button id="prev-news" class="btn-animated btn btn-outline-light btn-sm">Anterior</button>
                            <a href="./view/todas-noticias.php" class="btn-animated btn btn-outline-light btn-sm">Ver Todas as Notícias</a>
                            <button id="next-news" class="btn-animated btn btn-outline-light btn-sm">Próxima</button>
                        </div>
                    </div>
                </section>
            <?php else: ?>
                <!-- Mensagem quando não há notícias -->
                <div class="text-center text-light py-5">
                    <div class="border-animated-glass d-inline-block">
                        <div class="frosted-content gradiente px-4 py-2 shadow-sm">
                            <p class="mb-0">Não há notícias disponíveis no momento.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ÚLTIMOS JOGOS -->
            <?php if ($resultRoms && $resultRoms->num_rows > 0): ?>
                <section class="mt-5">
                    <div class="text-center mb-4">
                        <div class="border-animated-glass d-inline-block">
                            <div class="frosted-content gradiente px-4 py-2 shadow-sm">
                                <h2 class="fs-3 mb-0 text-light">Últimos Jogos Adicionados</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                        <?php while ($j = mysqli_fetch_assoc($resultRoms)): ?>
                            <div class="col d-flex">
                                <div class="cards-animated border-animated-glass w-100">
                                    <div class="frosted-content gradiente p-3 shadow-sm d-flex flex-column h-100 text-center">
                                        <!-- Imagem da ROM -->
                                        <img src="<?= !empty($j['capa']) ? htmlspecialchars($j['capa']) : './assets/img/cartucho_nes.svg' ?>"
                                            alt="<?= htmlspecialchars($j['nomeRom']) ?>"
                                            class="img-fluid mb-2 mx-auto"
                                            style="height: 70px; object-fit: contain;">

                                        <!-- Nome e Descrição -->
                                        <h5 class="texto-gradiente mb-1 text-center pb-2 w-100"><?= htmlspecialchars($j['nomeRom']) ?></h5>
                                        <p class="text-light small flex-grow-1">
                                            <?= htmlspecialchars($j['descricao']) ?>
                                        </p>

                                        <!-- Botão
                                        <a href="./view/jogar-jogo.php?rom=<?= urlencode($j['nomeArquivo']) ?>"
                                            class="btn-animated btn btn-sm btn-outline-light mt-auto w-100">Jogar</a> -->
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php endif; ?>
        </main>

        <footer class="border-top-animated-glass">
            <div class="frosted-content gradiente p-4 shadow-sm">
                <div class="container-fluid px-3 px-md-5 text-center">
                    <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                        <li class="nav-item"><a class="nav-link px-2" href="./view/duvidas.php">Dúvidas?</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./view/privacidade.php">Privacidade</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./view/termos.php">Termos</a></li>
                    </ul>
                    <p class="text-body-secondary mb-0">© 2025 NESPlay</p>
                </div>
            </div>
        </footer>

    </div> <!--background-->

    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="./assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>