<?php
require_once "../proc/funcoesBD.php";
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../view/login.php');
    exit;
}
$roms = listarRomsAcervo();
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
                        <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                        <?php if (!isset($_SESSION['usuario'])): ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./login.php">Login</a>
                            <a class="btn-animated btn btn-secondary" href="./cadastrar.php">Cadastrar</a>
                        <?php else: ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="./logout.php">Sair</a>
                        <?php endif; ?>
                    </div>
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
                        ?>
                        <li class="nav-item"><a class="nav-link px-2" href="./cadastrar-rom.php">Enviar ROM</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./acervo-jogos.php">Jogos Disponíveis</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./teste-jogo.php">Testar ROMs</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php while ($rom = mysqli_fetch_assoc($roms)): ?>
                    <div class="col">
                        <div class="border-animated-glass">
                            <div class="frosted content gradiente card p-4 rounded-3 shadow-sm border card-body d-flex flex-column align-items-center text-center">
                                <div class="card-body d-flex flex-column align-items-center text-center">
                                    <h1 class="texto-gradiente game-text">
                                        <?= htmlspecialchars($rom['nomeRom']) ?>
                                    </h1>
                                    <p class="card-text scroll-marquee" data-marquee-duration="15s">
                                        <span class="marquee-text"><?= htmlspecialchars($rom['descricao']) ?></span>
                                    </p>
                                    <small class="texto-gradiente text-comment mb-1">
                                        Ano: <?= htmlspecialchars($rom['ano']) ?>
                                    </small>
                                    <small class="texto-gradiente text-comment mb-3">
                                        Categoria: <?= htmlspecialchars($rom['nomeCategoria']) ?>
                                    </small>
                                    <a href="./jogar-jogo.php?rom=<?= urlencode($rom['nomeArquivo']) ?>"
                                        class="btn-animated btn btn-sm btn-outline-secondary">
                                        Jogar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
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