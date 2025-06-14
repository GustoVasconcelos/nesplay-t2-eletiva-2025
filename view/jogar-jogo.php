<?php
session_start();
require_once '../proc/funcoesBD.php';

// Verifica se veio a ROM pela query string
if (empty($_GET['rom'])) {
    header('Location: ../view/acervo-jogos.php');
    exit;
}

$romFile = basename($_GET['rom']);
$romPath = '../roms/' . $romFile;

// Segurança extra: existe?
if (!file_exists($romPath)) {
    echo "<p>ROM não encontrada.</p>";
    exit;
}

// Conecta e busca o nome “amigável” (nomeRom) desta ROM
$conn = conectarBD();
$romFileEscaped = mysqli_real_escape_string($conn, $romFile);
$sql = "
    SELECT nome AS nomeRom
    FROM roms
    WHERE nomeArquivo = '$romFileEscaped'
    LIMIT 1
";
$res = mysqli_query($conn, $sql);
if (! $row = mysqli_fetch_assoc($res)) {
    echo "<p>Dados da ROM não encontrados.</p>";
    exit;
}
$nomeRom = $row['nomeRom'];
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
                        if (isset($_SESSION['usuario'])) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./cadastrar-rom.php">Enviar ROM</a></li>';
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./acervo-jogos.php">Jogos Disponíveis</a></li>';
                        }
                        ?>
                        <li class="nav-item"><a class="nav-link px-2" href="./teste-jogo.php">Testar ROMs</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="border-animated-glass">
                        <div class="frosted content gradiente card p-4 rounded-3 shadow-sm border">
                            <div style="margin: auto; width: 100%;">
                                <h2 class="texto-gradiente game-text text-center">
                                    Jogando: <?= htmlspecialchars($nomeRom) ?>
                                </h2>
                                <!-- Canvas do emulador -->
                                <div id="canvas-wrapper"
                                    class="canvas-animated-border d-flex align-items-center justify-content-center"
                                    data-rom-path="<?= htmlspecialchars($romPath, ENT_QUOTES) ?>"
                                    style="margin:auto; width:100%;">
                                    <canvas id="nes-canvas" width="256" height="240"></canvas>
                                    <div class="gamepad-section">
                                        <div class="nes-gamepad">
                                            <div class="d-pad">
                                                <div class="d-pad-center"></div>

                                                <!-- Botões direcionais como elementos button -->
                                                <button class="d-btn up" aria-label="Up">↑</button>
                                                <button class="d-btn down" aria-label="Down">↓</button>
                                                <button class="d-btn left" aria-label="Left">←</button>
                                                <button class="d-btn right" aria-label="Right">→</button>

                                                <!-- Botões diagonais -->
                                                <button class="d-btn diagonal up-left" aria-label="Up-Left">↖︎</button>
                                                <button class="d-btn diagonal up-right" aria-label="Up-Right">↗</button>
                                                <button class="d-btn diagonal down-left" aria-label="Down-Left">↙</button>
                                                <button class="d-btn diagonal down-right" aria-label="Down-Right">↘︎</button>
                                            </div>

                                            <div class="action-buttons">
                                                <button class="action-btn btn-b" aria-label="B Button">B</button>
                                                <button class="action-btn btn-a" aria-label="A Button">A</button>
                                            </div>

                                            <div class="menu-buttons">
                                                <button class="menu-btn btn-select" aria-label="Select">SELECT</button>
                                                <button class="menu-btn btn-start" aria-label="Start">START</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- FIM--Canvas do emulador--FIM -->
                                <button id="btn-fullscreen" class="btn btn-animated btn-outline-secondary mt-2 w-100">Tela cheia</button>
                                <div class="text-center mt-3">
                                    <p class="mt-3 texto-gradiente text-center">DPad: ←↑→↓ &nbsp; Start: Enter &nbsp; Select: Tab &nbsp; A: A/Q &nbsp; B: S/O</p>
                                    <button id="mute-btn" class="btn btn-animated btn-outline-secondary mt-2">
                                        Mudo
                                    </button>
                                    <div id="volume-display" class="small texto-gradiente mt-1">50%</div>
                                    <input
                                        id="volume-slider"
                                        type="range"
                                        min="0"
                                        max="100"
                                        step="1"
                                        value="50"
                                        class="form-range"
                                        style="width: 80%; margin: auto;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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