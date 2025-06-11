<nav class="scroll-horizontal sticky-nav border-bottom-animated-glass">
    <div class="frosted-content gradiente p-1 shadow-sm">
        <div class="container-fluid px-3 px-md-5">
            <ul class="nav nav-underline justify-content-center">
                <li class="nav-item"><a class="nav-link px-2" href="./index.php">Home</a></li>
                <?php
                if (isset($_SESSION['usuario_adm']) && $_SESSION['usuario_adm'] == 1) {
                    echo '<li class="nav-item"><a class="nav-link px-2" href="./view/admin/admin.php">Admin</a></li>';
                }
                if (isset($_SESSION['usuario'])) {
                    echo '<li class="nav-item"><a class="nav-link px-2" href="./view/cadastrar-rom.php">Enviar ROM</a></li>';
                    echo '<li class="nav-item"><a class="nav-link px-2" href="./view/acervo-jogos.php">Jogos Disponíveis</a></li>';
                } ?>
                <li class="nav-item"><a class="nav-link px-2" href="./view/teste-jogo.php">Testar ROMs</a></li>
                <li class="nav-item"><a class="nav-link px-2" href="./view/sobre.php">Sobre</a></li>
            </ul>
        </div>
    </div>
</nav>