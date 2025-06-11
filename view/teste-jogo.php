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
    <title>NESPlay - Teste de Jogos</title>
    <link rel="shortcut icon" href="../assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
    <script src="https://unpkg.com/jsnes/dist/jsnes.min.js"></script>
    <script src="../assets/nes-embed.js"></script>
</head>

<body>
    <?php include __DIR__ . '/partials/header.php'; ?>
    <?php include __DIR__ . '/partials/nav.php'; ?>

    <div class="background">

        <main class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="border-animated-glass">
                        <div class="frosted content gradiente card p-4 rounded-3 shadow-sm border">
                            <div class="mb-3 text-center">
                                <?php
                                $roms = mysqli_query(conectarBD(), "SELECT nome, nomeArquivo FROM roms ORDER BY idRom DESC LIMIT 3");
                                $romPadrao = mysqli_fetch_assoc($roms);
                                ?>
                                <label for="rom-select" class="form-label texto-gradiente fw-bold">Selecione uma das 3 ROM recentemente adicionadas:</label>
                                <select id="rom-select" class="form-select text-center">
                                    <option value="<?= htmlspecialchars($romPadrao['nomeArquivo']) ?>" selected>
                                        <?= htmlspecialchars($romPadrao['nome']) ?> (Mais recentemente adicionado)
                                    </option>
                                    <?php while ($rom = mysqli_fetch_assoc($roms)): ?>
                                        <option value="<?= htmlspecialchars($rom['nomeArquivo']) ?>">
                                            <?= htmlspecialchars($rom['nome']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div style="margin: auto; width: 100%;">
                                <!-- Canvas do emulador -->
                                <div id="canvas-wrapper" class="d-flex align-items-center justify-content-center canvas-animated-border" style="margin: auto; width: 100%;">
                                    <canvas id="nes-canvas" width="256" height="240"></canvas>
                                </div>
                                <!-- FIM--Canvas do emulador--FIM -->
                                <button id="btn-fullscreen" class="btn btn-animated btn-outline-secondary mt-2 w-100">Tela cheia</button>
                                <div class="text-center mt-3">
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
                            <p class="mt-3 texto-gradiente text-center">DPad: ←↑→↓ &nbsp; Start: Enter &nbsp; Select: Tab &nbsp; A: A/Q &nbsp; B: S/O</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/partials/footer.php'; ?>

    </div> <!--background-->

    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/script.js"></script>
</body>

</html>