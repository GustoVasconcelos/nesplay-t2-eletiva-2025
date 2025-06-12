<?php
require_once "../../proc/funcoesBD.php";
session_start();
if ($_SESSION['usuario_adm'] != 1) {
    header("Location: ../../index.php");
    exit;
}
$listaRoms = listarRoms();
$listaCategorias = listarCategorias();
$listaUsuarios = listarUsuarios();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Admin - Gerenciar ROMs</title>
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

        <header class="border-bottom-animated-glass">
            <div class="container-fluid d-flex align-items-center justify-content-between frosted-content gradiente p-4 shadow-sm">
                <div class="container-fluid d-flex flex-wrap align-items-center justify-content-between">
                    <a href="../../index.php" class="d-flex align-items-center text-decoration-none">
                        <img class="logotipo img-fluid" src="../../assets/img/logo.svg" alt="NESPlay Logo">
                        <h1 id="texto-logotipo" class="ms-2 mb-0">
                            <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                        </h1>
                    </a>
                    <div class="d-flex">
                        <button id="toggle-bordas" class="btn-animated btn btn-outline-secondary me-2">Desativar Bordas Neon</button>
                        <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar animações</button>
                        <?php if (!isset($_SESSION['usuario'])): ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="../../view/login.php">Login</a>
                            <a class="btn-animated btn btn-secondary" href="../../view/cadastrar.php">Cadastrar</a>
                        <?php else: ?>
                            <a class="btn-animated btn btn-outline-secondary me-2" href="../../view/logout.php">Sair</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </header>

        <nav class="border-bottom-animated-glass">
            <div class="frosted-content gradiente p-1 shadow-sm">
                <div class="container-fluid px-3 px-md-5">
                    <ul class="nav nav-underline justify-content-center">
                        <li class="nav-item"><a class="nav-link px-2" href="../../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./ger-noticias.php">Gerenciar Notícias</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./ger-usuarios.php">Gerenciar Usuários</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./ger-categorias.php">Gerenciar Categorias</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="./ger-roms.php">Gerenciar ROMs</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="container my-5">
            <!-- Mensagens de sucesso -->
            <?php if (
                ($_SESSION['cadastroRom_Ok'] ?? false) ||
                ($_SESSION['apagarRom_Ok']   ?? false) ||
                ($_SESSION['renomearRom_Ok'] ?? false)
            ): ?>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-md-8 col-lg-5">
                        <div class="border-animated-glass">
                            <div id="successMessage" class="frosted content gradiente p-4 rounded-3 shadow-sm border success-message">
                                <?php if ($_SESSION['cadastroRom_Ok'] ?? false): ?>
                                    <h1 class="h3 mb-0 text-center">ROM cadastrada com sucesso!</h1>
                                    <?php $_SESSION['cadastroRom_Ok'] = false; ?>
                                <?php endif; ?>
                                <?php if ($_SESSION['apagarRom_Ok'] ?? false): ?>
                                    <h1 class="h3 mb-0 text-center">ROM apagada com sucesso!</h1>
                                    <?php $_SESSION['apagarRom_Ok'] = false; ?>
                                <?php endif; ?>
                                <?php if ($_SESSION['renomearRom_Ok'] ?? false): ?>
                                    <h1 class="h3 mb-0 text-center">ROM alterada com sucesso!</h1>
                                    <?php $_SESSION['renomearRom_Ok'] = false; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Lista de ROMs -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="border-animated-glass">
                        <div class="frosted content gradiente card p-4 rounded-3 shadow-sm border">
                            <h2 class="h3 mb-4 fw-normal text-center">Gerenciar ROMs</h2>

                            <?php while ($r = mysqli_fetch_assoc($listaRoms)):
                                $id = $r['idRom'];
                            ?>
                                <div id="rom-<?= $id ?>" class="mb-4 p-3 border rounded gradiente">
                                    <div class="rom-view">
                                        <p><strong>Nome: <?= htmlspecialchars($r['nome']) ?></strong></p>
                                        <p>Descrição: <?= nl2br(htmlspecialchars($r['descricao'])) ?></p>
                                        <p>Ano: <?= htmlspecialchars($r['ano']) ?></p>
                                        <p>Arquivo: <?= htmlspecialchars($r['nomeArquivo']) ?></p>
                                        <p>
                                            Categoria:
                                            <?= htmlspecialchars($r['categoria_id']) ?>
                                            — “<?= htmlspecialchars($r['categoria_nome']) ?>”
                                        </p>
                                        <p>
                                            Usuário (ID): <?= htmlspecialchars($r['user_id']) ?>
                                            — “<?= htmlspecialchars($r['usuario_apelido']) ?>”
                                            <!-- ou: — “<?= htmlspecialchars($r['usuario_nome_completo']) ?>” -->
                                        </p>

                                        <button
                                            type="button"
                                            class="btn-animated btn btn-sm btn-outline-primary me-2"
                                            onclick="editarRom(<?= $id ?>)">
                                            Alterar
                                        </button>
                                        <form class="d-inline" method="POST" action="../../proc/procDelRom.php">
                                            <input type="hidden" name="idRom" value="<?= $id ?>">
                                            <button
                                                type="submit"
                                                class="btn-animated btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Confirma exclusão desta ROM?')">
                                                Apagar
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Formulário de Edição (inicialmente oculto) -->
                                    <form class="rom-edit d-none" id="form-<?= $id ?>"
                                        method="POST" action="../../proc/procUpdRom.php">
                                        <input type="hidden" name="idRom" value="<?= $id ?>">
                                        <input type="text" class="form-control my-1" name="nome"
                                            value="<?= htmlspecialchars($r['nome']) ?>">
                                        <small class="form-text text-end text-muted">
                                            Restam <span class="char-count" id="contador-<?= $id ?>">100</span> caracteres para o limite:
                                        </small>
                                        <textarea class="form-control my-1 descricao-textarea" name="descricao" maxlength="100" data-id="<?= $id ?>"><?= htmlspecialchars($r['descricao']) ?></textarea>
                                        <input type="number" class="form-control my-1" name="ano"
                                            value="<?= htmlspecialchars($r['ano']) ?>">
                                        <input type="text" class="form-control my-1" name="nomeArquivo"
                                            value="<?= htmlspecialchars($r['nomeArquivo']) ?>">
                                        <!-- Select de Categorias -->
                                        <select name="categoria_id" class="form-select my-1">
                                            <?php
                                            mysqli_data_seek($listaCategorias, 0);
                                            while ($cat = mysqli_fetch_assoc($listaCategorias)):
                                                $sel = ($cat['idCategoria'] == $r['categoria_id']) ? ' selected' : '';
                                            ?>
                                                <option value="<?= $cat['idCategoria'] ?>" <?= $sel ?>>
                                                    <?= htmlspecialchars($cat['nome']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <!-- Select de Usuários -->
                                        <select name="user_id" class="form-select my-1">
                                            <?php
                                            mysqli_data_seek($listaUsuarios, 0);
                                            while ($usr = mysqli_fetch_assoc($listaUsuarios)):
                                                $idUsr = $usr['idUser'];                  // <-- reparou aqui
                                                $sel   = ($idUsr == $r['user_id']) ? ' selected' : '';
                                            ?>
                                                <option
                                                    value="<?= htmlspecialchars($idUsr, ENT_QUOTES) ?>"
                                                    <?= $sel ?>>
                                                    <?= htmlspecialchars($usr['apelido']) ?>
                                                </option>
                                            <?php endwhile; ?>
                                        </select>
                                        <button
                                            type="submit"
                                            class="btn-animated btn btn-sm btn-success me-2 mt-2">
                                            Confirmar Alteração
                                        </button>
                                        <button
                                            type="button"
                                            class="btn-animated btn btn-sm btn-secondary mt-2"
                                            onclick="cancelarEdicaoRom(<?= $id ?>)">
                                            Cancelar
                                        </button>
                                    </form>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="border-top-animated-glass">
            <div class="frosted-content gradiente p-4 shadow-sm">
                <div class="container-fluid px-3 px-md-5 text-center">
                    <ul class="nav nav-underline justify-content-center pb-3 mb-3">
                        <li class="nav-item"><a class="nav-link px-2" href="../duvidas.php">Dúvidas?</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="../privacidade.php">Privacidade</a></li>
                        <li class="nav-item"><a class="nav-link px-2" href="../termos.php">Termos</a></li>
                    </ul>
                    <p class="text-body-secondary mb-0">© 2025 NESPlay</p>
                </div>
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