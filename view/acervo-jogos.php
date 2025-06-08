<?php
session_start();
require_once '../proc/funcoesBD.php';
$roms = mysqli_query(conectarBD(), "
    SELECT 
        r.nome AS nomeRom, 
        r.descricao, 
        r.ano, 
        r.nomeArquivo, 
        c.nome AS nomeCategoria
    FROM roms r
    LEFT JOIN categorias c ON r.categoria_id = c.idCategoria
    ORDER BY r.idRom DESC
");
?>
<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay</title>
    <link rel="shortcut icon" href="../assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://unpkg.com/jsnes/dist/jsnes.min.js"></script>
    <script src="../assets/nes-embed.js"></script>
</head>

<body>
    <div class="background">
        <header class="gradiente py-3">
            <div class="container-fluid d-flex align-items-center justify-content-between">
                <a href="../index.php" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="../assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="d-flex">
                    <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                    <?php if (!isset($_SESSION['usuario'])): ?>
                        <a class="btn-animated btn btn-outline-secondary me-2" href="./login.php">Login</a>
                        <a class="btn-animated btn btn-secondary" href="./cadastrar.php">Cadastrar</a>
                    <?php else: ?>
                        <a class="btn-animated btn btn-outline-secondary me-2" href="./logout.php">Sair</a>
                    <?php endif; ?>
                </div>
            </div>
        </header>

        <nav class="gradiente">
            <div class="container-fluid px-3 px-md-5">
                <ul class="nav nav-underline justify-content-center">
                    <li class="nav-item"><a class="nav-link px-2" href="../index.php">Home</a></li>
                    <?php
                    if (isset($_SESSION['usuario_adm']) && $_SESSION['usuario_adm'] == 1) {
                        echo '<li class="nav-item"><a class="nav-link px-2" href="./admin/admin.php">Admin</a></li>';
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link px-2" href="./cadastrar-rom.php">Enviar ROM</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./teste-jogo.php">Testar ROM</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php while ($rom = mysqli_fetch_assoc($roms)): ?>
                    <div class="col">
                        <div class="gradiente card shadow-sm">
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
                                <a href="./teste-jogo.php?rom=<?= urlencode($rom['nomeArquivo']) ?>"
                                    class="btn-animated btn btn-sm btn-outline-secondary">
                                    Jogar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </main>

        <footer class="gradiente py-3">
            <div class="container-fluid text-center">
                <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                    <li class="nav-item"><a class="nav-link px-2" href="#">Dúvidas?</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Privacidade</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Termos</a></li>
                </ul>
                <p class="text-body-secondary mb-0">© 2025 NESPlay</p>
            </div>
        </footer>

    </div> <!--background-->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script.js"></script>
</body>

</html>