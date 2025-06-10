<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Sobre</title>
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
                        <?php
                        if (isset($_SESSION['usuario_adm']) && $_SESSION['usuario_adm'] == 1) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./admin/admin.php">Admin</a></li>';
                        }
                        if (isset($_SESSION['usuario'])) {
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./cadastrar-rom.php">Enviar ROM</a></li>';
                            echo '<li class="nav-item"><a class="nav-link px-2" href="./acervo-jogos.php">Jogos Disponíveis</a></li>';
                        } ?>
                        <li class="nav-item"><a class="nav-link px-2" href="./teste-jogo.php">Testar ROMs</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./sobre.php">Sobre</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8 col-lg-10">
                    <div class="border-animated-glass">
                        <div class="frosted content gradiente card p-4 rounded-3 shadow-sm border">
                            <h3 class="text-center mb-4">Sobre o NESPlay</h3>
                            <p>O NESPlay surgiu de uma idéia do aluno <a class="link-body-emphasis" href="https://github.com/John-Roberto">João Roberto</a>, em parceria com <a class="link-body-emphasis" href="https://github.com/GustoVasconcelos">Augusto Vasconcelos</a>, ambos estudantes de Análise e Desenvolvimento em Sistemas na Faculdade de Tecnologia de Presidente Prudente (Fatec PP), sendo o Trabalho Prático 2 - Sistema WEB Integrado com Banco de dados, desenvolvido no 2° Bimestre da Matéria Eletiva - Linguagem de Programação IV INTERNET, ministrada pelo professor <a class="link-body-emphasis" href="https://github.com/brunoslima">Me. Bruno Santos de Lima</a>, no ano de 2025.</p>
                            <p>O NESPlay permite que qualquer usuário cadastrado possa jogar as <i>roms</i> que foram enviadas, inclusive por outros usuários, direto do navegador, criando assim uma comunidade onde qualquer um possa relembrar os velhos tempos dos jogos do amado Nintendinho.</p>
                            <p>O site usa um emulador opensource escrito interamente em Javascript por <a class="link-body-emphasis" href="https://github.com/bfirsh">Ben Firshman (bfirsh)</a> , chamado <a class="link-body-emphasis" href="https://github.com/bfirsh/jsnes">JSNES</a> para emular as <i>roms</i>.</p>
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