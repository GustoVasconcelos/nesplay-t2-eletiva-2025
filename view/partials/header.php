<header class="sticky-header border-bottom-animated-glass">
    <div class="frosted-content gradiente p-4 shadow-sm">
        <div class="container-fluid">

            <!-- Logotipo fora do scroll -->
            <a id="div-logo" href="index.php" class="d-flex align-items-center text-decoration-none">
                <img class="logotipo img-fluid" src="assets/img/logo.svg" alt="NESPlay Logo">
                <h1 id="texto-logotipo" class="ms-2 mb-0">
                    <span>N</span><span>E</span><span>S</span><span>P</span><span>l</span><span>a</span><span>y</span>
                </h1>
            </a>

            <!-- Área de botões com scroll horizontal -->
            <div class="scroll-horizontal-buttons">
                <div class="d-flex">
                    <button id="toggle-bordas" class="btn-animated btn btn-outline-secondary me-2">Desativar Bordas Neon</button>
                    <button id="toggle-anim" class="btn-animated btn btn-outline-secondary me-2">Desativar Animações</button>
                    <?php if (!isset($_SESSION['usuario'])): ?>
                        <a class="btn-animated btn btn-outline-secondary me-2" href="view/login.php">Login</a>
                        <a class="btn-animated btn btn-secondary" href="view/cadastrar.php">Cadastrar</a>
                    <?php else: ?>
                        <a class="btn-animated btn btn-outline-secondary me-2" href="view/logout.php">Sair</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</header>