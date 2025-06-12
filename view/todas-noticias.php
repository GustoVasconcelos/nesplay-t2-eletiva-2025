<?php
session_start();
require_once "../proc/funcoesBD.php";
$listaNoticias = listarTodasNoticias();
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Jogos Disponíveis</title>
    <link rel="shortcut icon" href="../assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://unpkg.com/jsnes/dist/jsnes.min.js"></script>
    <script src="../assets/nes-embed.js"></script>
</head>

<body>
    <div class="background">

        <header class="border-bottom-animated-glass">
            <div class="container-fluid d-flex align-items-center justify-content-between frosted-content gradiente p-4 shadow-sm">
                <a href="../index.php" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="../assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="scroll-horizontal-buttons">
                    <div class="d-flex">
                        <button id="toggle-bordas" class="btn-animated btn btn-outline-secondary me-2">Desativar Bordas Neon</button>
                        <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar Animações</button>
                        <?php if (!isset($_SESSION['usuario'])): ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./login.php">Login</a>
                            <a class="btn-animated btn btn-secondary" href="./cadastrar.php">Cadastrar</a>
                        <?php else: ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./logout.php">Sair</a>
                        <?php endif; ?>
                    </div>
                </div>
        </header>

        <nav class="scroll-horizontal border-bottom-animated-glass">
            <div class="frosted-content gradiente p-1 shadow-sm">
                <div class="container-fluid px-3 px-md-5">
                    <ul class="nav nav-underline justify-content-center">
                        <li class="nav-item"><a class="nav-link px-2" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./todas-noticias.php">Notícias</a></li>
                        <?php
                        if (isset($_SESSION['usuario_adm']) && $_SESSION['usuario_adm'] == 1) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./admin/admin.php">Admin</a></li>';
                        }
                        if (isset($_SESSION['usuario'])) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./cadastrar-rom.php">Enviar ROM</a></li>';
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./acervo-jogos.php">Jogos Disponíveis</a></li>';
                        } ?>
                        <li class="nav-item"><a class="nav-link px-2" href="./teste-jogo.php">Testar ROMs</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container px-3 px-md-5 py-5" id="hanging-icons">
            <div class="text-center mb-4">
                <div class="border-animated-glass d-inline-block">
                    <div class="frosted-content gradiente px-4 py-2 shadow-sm">
                        <h2 class="fs-3 mb-0 text-light">Todas as Notícias</h2>
                    </div>
                </div>
            </div>

            <?php if ($listaNoticias && $listaNoticias->num_rows > 0): ?>
                <?php while ($not = mysqli_fetch_assoc($listaNoticias)): ?>
                    <div class="news-full-item border-animated-glass mb-4">
                        <div class="frosted-content gradiente card p-4 rounded-3 shadow-sm border">
                            <div class="card-body">
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
        </main>

        <footer class="border-top-animated-glass">
            <div class="frosted-content gradiente p-4 shadow-sm">
                <div class="container-fluid px-3 px-md-5 text-center">
                    <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                        <li class="nav-item"><a class="nav-link px-2" href="duvidas.php">Dúvidas?</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="privacidade.php">Privacidade</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="termos.php">Termos</a></li>
                    </ul>
                    <p class="text-body-secondary mb-0">© 2025 NESPlay</p>
                </div>
            </div>
        </footer>

    </div> <!--background-->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script.js"></script>
</body>

</html>