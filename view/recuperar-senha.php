<?php
session_start();
if (isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Recuperar Senha</title>
    <link rel="shortcut icon" type="image/png" href="../assets/img/favicon/favicon-96x96.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
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

        <nav class="border-bottom-animated-glass">
            <div class="frosted-content gradiente p-1 shadow-sm">
                <div class="container-fluid px-3 px-md-5">
                    <ul class="nav nav-underline justify-content-center">
                        <li class="nav-item"><a class="nav-link px-2" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./todas-noticias.php">Notícias</a></li>
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
                            <form method="POST" action="../proc/procRecuperarSenha.php">
                                <h1 class="h3 mb-4 fw-normal text-center">Recuperar Senha</h1>
                                <!-- Email -->
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" name="userEmail" placeholder="nome@email.com">
                                    <label for="userEmail">Endereço de E-mail</label>
                                </div>
                                <button class="btn-animated btn btn-secondary w-100 py-2 mb-3" type="submit">Enviar e-mail
                                    de recuperação</button>
                            </form>
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
    <script src="../assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>