<?php
require_once "../../proc/funcoesBD.php";
session_start();

if (!isset($_SESSION['usuario_adm']) || $_SESSION['usuario_adm'] != 1) {
    header("Location: ../../index.php");
    exit;
}

$listaUsuariosResult = listarUsuarios();
$listaUsuarios = [];
while ($usuario = mysqli_fetch_assoc($listaUsuariosResult)) {
    $listaUsuarios[] = $usuario;
}

$listaNoticias = listarNoticiasAdmin();
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NESPlay - Admin - Gerenciar Notícias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
        crossorigin="anonymous">
    <link rel="stylesheet" href="../../assets/style.css">
    <link rel="icon" type="image/png" href="../../assets/img/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/svg+xml" href="../../assets/img/favicon/favicon.svg">
</head>

<body>

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

    <div class="background">
        <main class="container my-5">
            <!-- Mensagens de sucesso/erro -->
            <?php if (isset($_SESSION['inserirNoticia_Ok']) || isset($_SESSION['atualizarNoticia_Ok']) || isset($_SESSION['deletarNoticia_Ok'])): ?>
                <div class="row justify-content-center mb-3">
                    <div class="col-12 col-md-8 col-lg-6">
                        <div class="border-animated-glass">
                            <div id="successMessage" class="frosted-content gradiente p-4 rounded-3 shadow-sm border success-message d-flex justify-content-center">
                                <?php if (isset($_SESSION['inserirNoticia_Ok'])): ?>
                                    <?php if ($_SESSION['inserirNoticia_Ok']): ?>
                                        <h1 class="h4 mb-0 text-center">Notícia criada com sucesso!</h1>
                                    <?php else: ?>
                                        <h1 class="h4 mb-0 text-center">Erro ao criar notícia.</h1>
                                <?php endif;
                                    unset($_SESSION['inserirNoticia_Ok']);
                                endif; ?>

                                <?php if (isset($_SESSION['atualizarNoticia_Ok'])): ?>
                                    <?php if ($_SESSION['atualizarNoticia_Ok']): ?>
                                        <h1 class="h4 mb-0 text-center">Notícia atualizada com sucesso!</h1>
                                    <?php else: ?>
                                        <h1 class="h4 mb-0 text-center">Erro ao atualizar notícia.</h1>
                                <?php endif;
                                    unset($_SESSION['atualizarNoticia_Ok']);
                                endif; ?>

                                <?php if (isset($_SESSION['deletarNoticia_Ok'])): ?>
                                    <?php if ($_SESSION['deletarNoticia_Ok']): ?>
                                        <h1 class="h4 mb-0 text-center">Notícia excluída com sucesso!</h1>
                                    <?php else: ?>
                                        <h1 class="h4 mb-0 text-center">Erro ao excluir notícia.</h1>
                                <?php endif;
                                    unset($_SESSION['deletarNoticia_Ok']);
                                endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Formulário de criação -->
            <div class="row justify-content-center mb-4">
                <div class="col-12 col-lg-8">
                    <div class="border-animated-glass">
                        <div class="frosted-content gradiente card p-4 rounded-3 shadow-sm border">
                            <h2 class="h3 mb-4 text-center w-100">Criar Nova Notícia</h2>
                            <form class="d-flex flex-column w-100" method="POST" action="../../proc/procCadNoticia.php">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label text-light">Título</label>
                                    <input type="text" name="titulo" id="titulo" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="subtitulo" class="form-label text-light">Subtítulo (opcional)</label>
                                    <input type="text" name="subtitulo" id="subtitulo" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="texto" class="form-label text-light">Texto</label>
                                    <textarea
                                        name="texto"
                                        id="texto-create"
                                        class="form-control descricao-textarea"
                                        data-id="create"
                                        rows="4"
                                        maxlength="250"
                                        required></textarea>
                                    <small class="form-text text-end text-muted">
                                        Restam <span class="char-count" id="contador-create">250</span> caracteres para o limite
                                    </small>

                                </div>
                                <div class="mb-3">
                                    <label for="idUsuario" class="form-label text-light">Administrador responsável</label>
                                    <select name="idUsuario" id="idUsuarioCreate" class="form-select" required>
                                        <option value="" disabled selected>Selecione um administrador</option>
                                        <?php foreach ($listaUsuarios as $adm): ?>
                                            <?php if ($adm['adm'] == 1): ?>
                                                <option value="<?= $adm['idUser'] ?>">
                                                    <?= htmlspecialchars($adm['nome'] . ' ' . $adm['sobrenome']) ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn-animated btn btn-success">Salvar Notícia</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lista de Notícias para editar/excluir -->
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="border-animated-glass">
                        <div class="frosted-content gradiente card p-4 rounded-3 shadow-sm border">
                            <h2 class="h3 mb-4 text-center w-100">Gerenciar Notícias</h2>
                            <?php while ($not = mysqli_fetch_assoc($listaNoticias)):
                                $id = $not['idNoticia'];
                                // $not['data'] vem do listarNoticiasAdmin()
                            ?>
                                <div id="noticia-<?= $id ?>" class="mb-4 p-3 border rounded gradiente">
                                    <div class="noticia-view">
                                        <p><strong>Título:</strong> <?= htmlspecialchars($not['titulo']) ?></p>
                                        <?php if (!empty($not['subtitulo'])): ?>
                                            <p><strong>Subtítulo:</strong> <?= htmlspecialchars($not['subtitulo']) ?></p>
                                        <?php endif; ?>
                                        <p><strong>Texto:</strong><br><?= nl2br(htmlspecialchars($not['texto'])) ?></p>
                                        <p><strong>Postado/Atualizado por:</strong> <?= htmlspecialchars($not['adminNome']) ?></p>
                                        <?php
                                        // Formata data/hora
                                        $dt = new DateTime($not['data']);
                                        ?>
                                        <p><small class="text-comment">Última atualização: <?= $dt->format('d/m/Y H:i') ?></small></p>
                                        <button type="button"
                                            class="btn-animated btn btn-sm btn-outline-primary me-2"
                                            onclick="editarNoticia(<?= $id ?>)">
                                            Alterar
                                        </button>
                                        <form class="d-inline" method="POST" action="../../proc/procDelNoticia.php">
                                            <input type="hidden" name="idNoticia" value="<?= $id ?>">
                                            <button type="submit"
                                                class="btn-animated btn btn-sm btn-outline-danger"
                                                onclick="return confirm('Confirma exclusão desta notícia?')">
                                                Apagar
                                            </button>
                                        </form>
                                    </div>

                                    <!-- Formulário de Edição (inicialmente oculto) -->
                                    <form class="noticia-edit d-none" id="form-noticia-<?= $id ?>"
                                        method="POST" action="../../proc/procUpdNoticia.php">
                                        <input type="hidden" name="idNoticia" value="<?= $id ?>">
                                        <div class="mb-2">
                                            <label for="titulo-<?= $id ?>" class="form-label text-light">Título</label>
                                            <input type="text" id="titulo-<?= $id ?>" name="titulo"
                                                class="form-control"
                                                value="<?= htmlspecialchars($not['titulo']) ?>" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="subtitulo-<?= $id ?>" class="form-label text-light">Subtítulo</label>
                                            <input type="text" id="subtitulo-<?= $id ?>" name="subtitulo"
                                                class="form-control"
                                                value="<?= htmlspecialchars($not['subtitulo']) ?>">
                                        </div>
                                        <div class="mb-2">
                                            <label for="texto-<?= $id ?>" class="form-label text-light">Texto</label>
                                            <textarea
                                                id="texto-<?= $id ?>"
                                                name="texto"
                                                class="form-control descricao-textarea"
                                                data-id="<?= $id ?>"
                                                rows="4"
                                                maxlength="250"
                                                required><?= htmlspecialchars($not['texto']) ?></textarea>
                                            <small class="form-text text-end text-muted">
                                                Restam <span class="char-count" id="contador-<?= $id ?>">250</span> caracteres para o limite
                                            </small>
                                        </div>
                                        <div class="mb-3">
                                            <label for="idUsuario" class="form-label text-light">Administrador responsável</label>
                                            <select name="idUsuario" id="idUsuarioEdit-<?= $id ?>" class="form-select" required>
                                                <option value="" disabled>Selecione um administrador</option>
                                                <?php foreach ($listaUsuarios as $adm): ?>
                                                    <?php if ($adm['adm'] == 1): ?>
                                                        <option value="<?= $adm['idUser'] ?>"
                                                            <?= ($adm['idUser'] == $not['idUser'] ? 'selected' : '') ?>>
                                                            <?= htmlspecialchars($adm['nome'] . ' ' . $adm['sobrenome']) ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn-animated btn btn-sm btn-success me-2 mt-2">
                                            Confirmar Alteração
                                        </button>
                                        <button type="button" class="btn-animated btn btn-sm btn-secondary mt-2"
                                            onclick="cancelarEdicaoNoticia(<?= $id ?>)">
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