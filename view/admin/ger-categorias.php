<?php
require_once "../../proc/funcoesBD.php";
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" type="image/png" href="../../assets/img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../../assets/img/favicon/favicon.svg" />
    <title>NESPlay - Admin - Gerenciar Categorias</title>
</head>

<body>
    <div class="background">

        <header class="gradiente py-3">
            <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
                <a href="../../index.php" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="../../assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="d-flex">
                    <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                    <?php
                    if (!isset($_SESSION['usuario'])) {
                        echo '<a class="btn-animated btn btn-outline-secondary me-2" href="../../view/login.php">Login</a>';
                        echo '<a class="btn-animated btn btn-secondary" href="../../view/cadastrar.php">Cadastrar</a>';
                    } else {
                        echo '<a class="btn-animated btn btn-outline-secondary me-2" href="../../view/logout.php">Sair</a>';
                    }
                    ?>
                </div>
            </div>
        </header>

        <nav class="gradiente">
            <div class="container-fluid px-3 px-md-5">
                <ul class="nav nav-underline justify-content-center">
                    <li class="nav-item"><a class="nav-link px-2" href="../../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-usuarios.php">Gerenciar Usuários</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-categorias.php">Gerenciar
                            Categorias</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Gerenciar Comentários</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-roms.php">Gerenciar ROMs</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            <?php
            if (
                (isset($_SESSION['cadastroCategoria_Ok']) && $_SESSION['cadastroCategoria_Ok'] == true) ||
                (isset($_SESSION['apagarCategoria_Ok']) && $_SESSION['apagarCategoria_Ok'] == true) ||
                (isset($_SESSION['renomearCategoria_Ok']) && $_SESSION['renomearCategoria_Ok'] == true)
            ) {
                echo '<div class="row justify-content-center mb-3">';
                echo '<div class="col-12 col-md-8 col-lg-5">';
                echo '<div class="gradiente p-4 rounded-3 shadow-sm">';
                if ($_SESSION['cadastroCategoria_Ok'] == true) {
                    echo '<h1 class="h3 mb-4 fw-normal text-center">Categoria cadastrada com sucesso!</h1>';
                    $_SESSION['cadastroCategoria_Ok'] = false;
                }
                if ($_SESSION['apagarCategoria_Ok'] == true) {
                    echo '<h1 class="h3 mb-4 fw-normal text-center">Categoria apagada com sucesso!</h1>';
                    $_SESSION['apagarCategoria_Ok'] = false;
                }
                if ($_SESSION['renomearCategoria_Ok'] == true) {
                    echo '<h1 class="h3 mb-4 fw-normal text-center">Categoria renomeada com sucesso!</h1>';
                    $_SESSION['renomearCategoria_Ok'] = false;
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="gradiente p-4 rounded-3 shadow-sm">
                        <h2 class="h3 mb-4 fw-normal text-center">Gerenciar Categorias</h2>
                        <!-- Formulário de Cadastrar Categoria -->
                        <form class="mb-4" method="POST" action="../../proc/procCadCategoria.php">
                            <fieldset>
                                <legend class="fs-5 mb-3">Cadastrar Categoria</legend>
                                <div class="d-flex">
                                    <input type="text" class="form-control me-2" name="nomeCategoria"
                                        placeholder="Categoria">
                                    <button class="btn-animated btn btn-secondary" style="padding-left: 3px;"
                                        type="submit">
                                        Cadastrar
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                        <!-- Formulário de Renomear Categoria -->
                        <form method="POST" action="../../proc/procUpdCategoria.php">
                            <fieldset>
                                <legend class="fs-5 mb-3">Renomear Categoria</legend>
                                <div class="d-flex flex-column">
                                    <select class="form-select mb-2" id="selectCategoriaRenomear"
                                        name="selectRenomearCategoria">
                                        <option selected>Escolher...</option>
                                        <?php
                                        $listaCategorias = listarCategorias();
                                        while ($categoria = mysqli_fetch_assoc($listaCategorias)) {
                                            echo "<option value=\"" . $categoria["idCategoria"] . "\">" . $categoria["nome"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <input type="text" class="form-control d-none" id="novoNomeCategoria"
                                        name="novoNomeCategoria" placeholder="Novo nome da categoria">
                                    <button class="btn-animated btn btn-secondary mt-2" type="submit">
                                        Renomear
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                        <!-- Formulário de Apagar Categoria -->
                        <form method="POST" action="../../proc/procDelCategoria.php">
                            <fieldset>
                                <legend class="fs-5 mb-3">Apagar Categoria</legend>
                                <div class="d-flex">
                                    <select class="form-select me-2" name="selectApagarCategoria">
                                        <option selected>Escolher...</option>
                                        <?php
                                        $listaCategorias = listarCategorias();
                                        while ($categoria = mysqli_fetch_assoc($listaCategorias)) {
                                            echo "<option value=\"" . $categoria["idCategoria"] . "\">" . $categoria["nome"] . "</option>";
                                        }
                                        ?>
                                    </select>
                                    <button class="btn-animated btn btn-secondary" style="padding-left: 8px;"
                                        type="submit">
                                        Deletar
                                    </button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <footer class="gradiente py-3">
            <div class="container-fluid px-3 px-md-5 text-center">
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
    <script src="../../assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>