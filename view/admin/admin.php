<?php
session_start();
if ($_SESSION['usuario_adm'] != 1){
    header("Location: ../../index.php");
    exit;
}
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
    <title>NESPlay - Admin</title>
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
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-categorias.php">Gerenciar Categorias</a></li>
                    <!-- <li class="nav-item"><a class="nav-link px-2" href="#">Gerenciar Comentários</a></li> -->
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-roms.php">Gerenciar ROMs</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="../sobre.php">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container px-3 px-md-5 py-5 d-flex flex-column" id="hanging-icons">
            <!-- Card -->
            <div class="gradiente p-4 h-100 d-flex align-items-center justify-content-center">
                <div>
                    <h3 class="fs-2">Administração</h3>
                    <p>Seja bem-vindo</p>
                </div>
            </div>
        </main>

        <footer class="gradiente py-3">
            <div class="container-fluid px-3 px-md-5 text-center">
                <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                    <li class="nav-item"><a class="nav-link px-2" href="../duvidas.php">Dúvidas?</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="../privacidade.php">Privacidade</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="../termos.php">Termos</a></li>
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