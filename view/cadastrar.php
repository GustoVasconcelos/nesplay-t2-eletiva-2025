<?php
session_start();
$erro_cadastro = isset($_SESSION['erro_cadastro']) ? $_SESSION['erro_cadastro'] : "";
unset($_SESSION['erro_cadastro']);
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="icon" type="image/png" href="../assets/img/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="../assets/img/favicon/favicon.svg" />
    <title>NESPlay - Cadastrar</title>
</head>

<body>
    <div class="background">

        <header class="gradiente py-3">
            <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
                <a href="/" class="d-flex align-items-center text-decoration-none">
                    <img class="logotipo img-fluid" src="../assets/img/logo.svg" alt="NESPlay Logo">
                    <h1 id="texto-logotipo" class="ms-2 mb-0">
                        <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                    </h1>
                </a>
                <div class="d-flex">
                    <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                    <a class="btn-animated btn btn-outline-secondary me-2" href="./login.php">Login</a>
                    <a class="btn-animated btn btn-secondary" href="./cadastrar.php">Cadastrar</a>
                </div>
            </div>
        </header>

        <nav class="gradiente">
            <div class="container-fluid px-3 px-md-5">
                <ul class="nav nav-underline justify-content-center">
                    <li class="nav-item"><a class="nav-link px-2" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            <?php
            if ($erro_cadastro != "") {
                echo '<div class="row justify-content-center mb-3">';
                echo '<div class="col-12 col-md-8 col-lg-5">';
                echo '<div id="successMessage" class="gradiente p-4 rounded-3 shadow-sm success-message">';
                echo '<h1 class="h3 mb-4 fw-normal text-center">' . $erro_cadastro . '</h1>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $_SESSION['cadastro_Ok'] = false;
            }
            ?>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-5">
                    <div class="gradiente p-4 rounded-3 shadow-sm">
                        <form method="POST" action="../proc/procCadUsuario.php">
                            <h1 class="h3 mb-4 fw-normal text-center">Cadastro</h1>
                            <!-- Par Nome / Sobrenome -->
                            <div class="row mb-3">
                                <div class="col px-1 form-floating">
                                    <input type="text" class="form-control" name="nomeUser" placeholder="Nome">
                                    <label for="nomeUser">Nome</label>
                                </div>
                                <div class="col px-1 form-floating">
                                    <input type="text" class="form-control" name="sobrenomeUser" placeholder="Sobrenome">
                                    <label for="sobrenomeUser">Sobrenome</label>
                                </div>
                            </div>
                            <!-- Data -->
                            <div class="row mb-3">
                                <div class="col px-1 form-floating">
                                    <input type="date" class="form-control" name="nascimentoUser"
                                        placeholder="Data de Nascimento">
                                    <label for="nascimentoUser">Data de Nascimento</label>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row mb-3">
                                <div class="col px-1 form-floating">
                                    <input type="email" class="form-control" name="emailUser" placeholder="Email">
                                    <label for="emailUser">Email</label>
                                </div>
                            </div>
                            <!-- Par Usuário / Senha -->
                            <div class="row mb-3">
                                <div class="col px-1 form-floating">
                                    <input type="text" class="form-control" name="apelidoUser"
                                        placeholder="Nome de usuário">
                                    <label for="apelidoUser">Nome de usuário</label>
                                </div>
                                <div class="col px-1 form-floating">
                                    <input type="password" class="form-control" name="passwordUser" placeholder="Senha">
                                    <label for="passwordUser">Senha</label>
                                </div>
                            </div>
                            <button class="btn-animated btn btn-secondary w-100 py-2" type="submit">Cadastrar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>