<?php
session_start();
require_once '../proc/funcoesBD.php';
$roms = mysqli_query(conectarBD(), "SELECT nome, nomeArquivo FROM roms ORDER BY idRom DESC LIMIT 3");
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
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="gradiente p-4 rounded-3 shadow-sm">
                        <div class="mb-3 text-center">
                            <?php
                            $roms = mysqli_query(conectarBD(), "SELECT nome, nomeArquivo FROM roms ORDER BY idRom DESC LIMIT 3");
                            $romPadrao = mysqli_fetch_assoc($roms);
                            ?>
                            <label for="rom-select" class="form-label texto-gradiente fw-bold">Selecione uma das 3 ROM recentemente adicionadas:</label>
                            <select id="rom-select" class="form-select text-center">
                                <option value="<?= htmlspecialchars($romPadrao['nomeArquivo']) ?>" selected>
                                    <?= htmlspecialchars($romPadrao['nome']) ?> (Padrão)
                                </option>
                                <?php while ($rom = mysqli_fetch_assoc($roms)): ?>
                                    <option value="<?= htmlspecialchars($rom['nomeArquivo']) ?>">
                                        <?= htmlspecialchars($rom['nome']) ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div style="margin: auto; width: 100%;">
                            <div id="canvas-wrapper" class="d-flex align-items-center justify-content-center" style="margin: auto; width: 94%; background: #000;">
                                <canvas id="nes-canvas" width="256" height="240"></canvas>
                            </div>
                            <button id="btn-fullscreen" class="btn btn-animated btn-outline-secondary mt-2 w-100">Tela cheia</button>
                        </div>
                        <p class="mt-3 texto-gradiente text-center">DPad: ←↑→↓ &nbsp; Start: Enter &nbsp; Select: Tab &nbsp; A: A/Q &nbsp; B: S/O</p>
                    </div>
                </div>
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

    </div><!--background-->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="../assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const canvasId = 'nes-canvas';
        const basePath = '../roms/';

        function carregarRom(nomeArquivo) {
            nes_load_url(canvasId, basePath + nomeArquivo);
        }

        function salvarROMEmCookie(nomeROM) {
            document.cookie = `ultimaROM=${nomeROM}; path=/; max-age=31536000`; // 1 ano
        }

        function lerCookie(nome) {
            const cookies = document.cookie.split(';');
            for (let cookie of cookies) {
                const [chave, valor] = cookie.trim().split('=');
                if (chave === nome) return valor;
            }
            return null;
        }

        window.addEventListener('load', () => {
            const select = document.getElementById('rom-select');
            const romSalva = lerCookie('ultimaROM');
            const romInicial = romSalva || select.value;

            select.value = romInicial;
            carregarRom(romInicial);
        });

        document.getElementById('rom-select').addEventListener('change', function() {
            const rom = this.value;
            carregarRom(rom);
            salvarROMEmCookie(rom);
        });

        const wrapper = document.getElementById('canvas-wrapper');
        document.getElementById('btn-fullscreen').addEventListener('click', () => {
            if (wrapper.requestFullscreen) wrapper.requestFullscreen();
            else if (wrapper.webkitRequestFullscreen) wrapper.webkitRequestFullscreen();
            else if (wrapper.msRequestFullscreen) wrapper.msRequestFullscreen();
        });

        const teclasBloqueadas = [
            'ArrowUp',
            'ArrowDown',
            'ArrowLeft',
            'ArrowRight',
            'a', 'q', 's', 'o',
            'A', 'Q', 'S', 'O',
            'Tab', 'Enter'
        ];

        document.addEventListener('keydown', function(e) {
            if (teclasBloqueadas.includes(e.key)) {
                e.preventDefault();
            }
        });
    </script>

</body>

</html>