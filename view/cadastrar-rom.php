<?php
require_once "../proc/funcoesBD.php";
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: ../view/login.php');
    exit;
}
$_SESSION['romEnviada_Ok'] = $_SESSION['romEnviada_Ok'] ?? false;
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay</title>
    <link rel="shortcut icon" type="image/png" href="../assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <div class="background">

        <header class="gradiente py-3">
            <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
                <a href="index.php" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="../assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="d-flex">
                    <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                    <?php
                    if (!isset($_SESSION['usuario'])) {
                        echo '<a class="btn-animated btn btn-outline-secondary me-2" href="./login.php">Login</a>';
                        echo '<a class="btn-animated btn btn-secondary" href="./cadastrar.php">Cadastrar</a>';
                    } else {
                        echo '<a class="btn-animated btn btn-outline-secondary me-2" href="./logout.php">Sair</a>';
                    }
                    ?>
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
                    <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            <?php
            if ($_SESSION['romEnviada_Ok'] === true) {
                echo '<div class="row justify-content-center mb-3">';
                echo '  <div class="col-12 col-md-8 col-lg-5">';
                echo '    <div id="successMessage" class="gradiente p-4 rounded-3 shadow-sm success-message">';
                echo '      <h1 class="h3 mb-4 fw-normal text-center">ROM enviada com sucesso!</h1>';
                echo '    </div>';
                echo '  </div>';
                echo '</div>';
                $_SESSION['romEnviada_Ok'] = false;
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="gradiente p-4 rounded-3 shadow-sm">
                        <h2 class="h3 mb-4 text-center">Enviar ROM</h2>
                        <form method="POST" action="../proc/procCadRom.php"
                            enctype="multipart/form-data">
                            <!--nome-->
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome do jogo</label>
                                <input type="text" id="nome" name="nome"
                                    class="form-control" required>
                            </div>
                            <!--descrição-->
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea id="descricao" name="descricao" rows="3"
                                    class="form-control" required></textarea>
                            </div>
                            <!--ano-->
                            <div class="mb-3">
                                <label for="ano" class="form-label">Ano</label>
                                <input type="number" id="ano" name="ano"
                                    class="form-control" min="1983" max="2099" required>
                            </div>
                            <!--categoria-->
                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoria</label>
                                <select id="categoria" name="categoria"
                                    class="form-select" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    <?php
                                    $lista = listarCategorias();
                                    while ($cat = mysqli_fetch_assoc($lista)):
                                    ?>
                                        <option value="<?= $cat['idCategoria'] ?>">
                                            <?= htmlspecialchars($cat['nome']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <!--upload-->
                            <fieldset class="mb-3">
                                <legend class="fs-5 mb-2">Arquivo ROM (.nes)</legend>
                                <div class="input-file-animated w-100">
                                    <input type="file" id="romFile" name="romFile"
                                        accept=".nes" required class="file-input">
                                    <label for="romFile"
                                        class="btn-animated btn btn-secondary w-100 py-2">
                                        Escolher arquivo
                                    </label>
                                    <div id="romFileName" class="file-name mt-2 text-center">
                                        Nenhum arquivo escolhido
                                    </div>
                                </div>
                            </fieldset>
                            <button type="submit"
                                class="btn-animated btn btn-secondary w-100 ">
                                Enviar ROM
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </main>

        <footer class="gradiente py-3">
            <div class="container-fluid px-3 px-md-5 text-center">
                <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                    <li class="nav-item"><a class="nav-link px-2" href="./duvidas.php">Dúvidas?</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./privacidade.php">Privacidade</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./termos.php">Termos</a></li>
                </ul>
                <p class="text-body-secondary mb-0">© 2025 NESPlay</p>
            </div>
        </footer>

    </div> <!--background-->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="../assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>