<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Termos de Uso</title>
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
                            <h3 class="text-center mb-4">Termos de Uso – NESPlay</h3>
                            <p class="text-center">Última atualização: 12/06/2025</p>
                            <p>Bem-vindo ao NESPlay! Ao utilizar este site, você concorda com os seguintes termos:</p>
                            <span class="fs-4 fw-bolder">1. Sobre o NESPlay</span>
                            <p>O NESPlay é uma plataforma que permite aos usuários cadastrados jogarem e compartilharem jogos de NES (Nintendo Entertainment System) diretamente no navegador, utilizando o emulador de código aberto JSNES.</p>
                            <span class="fs-4 fw-bolder">2. Upload de ROMs</span>
                            <ul>
                                <li>Os usuários podem enviar suas próprias ROMs para uso pessoal ou compartilhamento com outros usuários cadastrados.</li>
                                <li>Ao fazer o upload, o usuário declara que possui os direitos legais sobre o arquivo ou que ele é de distribuição livre.</li>
                                <li>A equipe do NESPlay não se responsabiliza pelos arquivos enviados pelos usuários.</li>
                            </ul>
                            <span class="fs-4 fw-bolder">3. Compartilhamento de conteúdo</span>
                            <p>As ROMs enviadas ficam disponíveis para outros usuários da plataforma. O NESPlay não verifica previamente os conteúdos enviados, mas poderá remover arquivos que violem direitos autorais ou infrinjam estes termos.</p>
                            <span class="fs-4 fw-bolder">4. Responsabilidades</span>
                            <ul>
                                <li>O uso da plataforma é por sua conta e risco.</li>
                                <li>O NESPlay não garante que os jogos funcionarão perfeitamente em todos os navegadores ou dispositivos.</li>
                                <li>O NESPlay não hospeda nem distribui ROMs comerciais protegidas por direitos autorais.</li>
                            </ul>
                            <span class="fs-4 fw-bolder">5. Propriedade intelectual</span>
                            <p>JSNES é um emulador open-source utilizado sob os termos da respectiva licença. Marcas, logos e conteúdos da Nintendo ou de terceiros pertencem a seus respectivos proprietários.</p>
                            <span class="fs-4 fw-bolder">6. Conta de usuário</span>
                            <ul>
                                <li>O usuário é responsável por manter a segurança de sua conta.</li>
                                <li>O uso indevido da plataforma poderá resultar na exclusão da conta e conteúdo associado.</li>
                            </ul>
                            <span class="fs-4 fw-bolder">7. Alterações nos termos</span>
                            <p>Estes termos podem ser atualizados periodicamente. Ao continuar usando o NESPlay, você concorda com as eventuais mudanças.</p>
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