<?php
require_once "../../proc/funcoesBD.php";
session_start();
if ($_SESSION['usuario_adm'] != 1){
    header("Location: ../../index.php");
    exit;
}
$listaUsuarios = listarUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Admin - Gerenciar Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" type="image/png" href="../../assets/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="../../assets/img/favicon/favicon.svg">
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
                    <li class="nav-item"><a class="nav-link px-2" href="#">Gerenciar Comentários</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="./ger-roms.php">Gerenciar ROMs</a></li>
                    <li class="nav-item"><a class="nav-link px-2" href="#">Sobre</a></li>
                </ul>
            </div>
        </nav>

        <main class="container my-5">
            <!-- Mensagens de sucesso -->
            <?php if (
                ($_SESSION['cadastroUsuario_Ok'] ?? false) ||
                ($_SESSION['apagarUsuario_Ok']   ?? false) ||
                ($_SESSION['renomearUsuario_Ok'] ?? false)
            ): ?>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-md-8 col-lg-5">
                        <div class="gradiente p-4 rounded-3 shadow-sm text-center">
                            <?php if ($_SESSION['cadastroUsuario_Ok'] ?? false): ?>
                                <h1 class="h3 mb-0">Usuário cadastrado com sucesso!</h1>
                                <?php $_SESSION['cadastroUsuario_Ok'] = false; ?>
                            <?php endif; ?>
                            <?php if ($_SESSION['apagarUsuario_Ok'] ?? false): ?>
                                <h1 class="h3 mb-0">Usuário apagado com sucesso!</h1>
                                <?php $_SESSION['apagarUsuario_Ok'] = false; ?>
                            <?php endif; ?>
                            <?php if ($_SESSION['renomearUsuario_Ok'] ?? false): ?>
                                <h1 class="h3 mb-0">Usuário alterado com sucesso!</h1>
                                <?php $_SESSION['renomearUsuario_Ok'] = false; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Lista de usuários -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="gradiente p-4 rounded-3 shadow-sm">
                        <h2 class="h3 mb-4 fw-normal text-center">Gerenciar Usuários</h2>

                        <?php
                        while ($u = mysqli_fetch_assoc($listaUsuarios)):
                            $id = $u['idUser'];
                        ?>
                            <div id="user-<?= $id ?>" class="mb-4 p-3 border rounded gradiente">
                                <div class="user-view">
                                    <p><strong>Nome: <?= htmlspecialchars($u['nome']) ?> <?= htmlspecialchars($u['sobrenome']) ?></strong></p>
                                    <p>Data de Nascimento: <?= htmlspecialchars($u['dataNascimento']) ?></p>
                                    <p>E-mail: <?= htmlspecialchars($u['email']) ?></p>
                                    <p>Apelido: <?= htmlspecialchars($u['apelido']) ?></p>
                                    <p>Senha: <?= htmlspecialchars($u['senha']) ?></p>
                                    <p>
                                        <label>
                                            <input type="checkbox" disabled <?= $u['adm'] ? 'checked' : '' ?>>
                                            Administrador
                                        </label>
                                    </p>
                                    <button class="btn-animated btn btn-sm btn-outline-primary me-2" onclick="editarUsuario(<?= $id ?>)">
                                        Alterar
                                    </button>
                                    <form class="d-inline" method="POST" action="../../proc/procDelUsuario.php">
                                        <input type="hidden" name="idUser" value="<?= $id ?>">
                                        <button
                                            class="btn-animated btn btn-sm btn-outline-danger"
                                            type="submit"
                                            onclick="return confirm('Confirma exclusão deste usuário?')">
                                            Apagar
                                        </button>
                                    </form>
                                </div>

                                <!-- Formulário de Edição (inicialmente oculto) -->
                                <form class="user-edit d-none" id="form-<?= $id ?>"
                                    method="POST" action="../../proc/procUpdUsuario.php">
                                    <input type="hidden" name="idUser" value="<?= $id ?>">
                                    <input type="text" class="form-control my-1" name="nome" value="<?= htmlspecialchars($u['nome']) ?>">
                                    <input type="text" class="form-control my-1" name="sobrenome" value="<?= htmlspecialchars($u['sobrenome']) ?>">
                                    <input type="date" class="form-control my-1" name="dataNascimento" value="<?= htmlspecialchars($u['dataNascimento']) ?>">
                                    <input type="email" class="form-control my-1" name="email" value="<?= htmlspecialchars($u['email']) ?>">
                                    <input type="text" class="form-control my-1" name="apelido" value="<?= htmlspecialchars($u['apelido']) ?>">
                                    <input type="text" class="form-control my-1" name="senha" value="<?= htmlspecialchars($u['senha']) ?>">
                                    <label class="my-1">
                                        <input type="checkbox" name="adm" <?= $u['adm'] ? 'checked' : '' ?>>
                                        Administrador
                                    </label><br>
                                    <button type="submit"
                                        class="btn-animated btn btn-sm btn-success me-2 mt-2">
                                        Confirmar Alteração
                                    </button>
                                    <button type="button"
                                        class="btn-animated btn btn-sm btn-secondary mt-2"
                                        onclick="cancelarEdicao(<?= $id ?>)">
                                        Cancelar
                                    </button>
                                </form>
                            </div>
                        <?php endwhile; ?><!-- Fim do while -->
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

    </div> <!-- /background -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script src="../../assets/script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>
</body>

</html>