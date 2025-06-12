<?php
session_start();
require_once 'funcoesBD.php';

if (!isset($_SESSION['usuario_adm']) || $_SESSION['usuario_adm'] != 1) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo    = trim($_POST['titulo']    ?? '');
    $subtitulo = trim($_POST['subtitulo'] ?? '');
    $texto     = trim($_POST['texto']     ?? '');
    $idUser    = (int)($_POST['idUsuario'] ?? 0);

    if ($titulo !== '' && $texto !== '' && $idUser > 0) {
        // Busca nome completo do admin a partir do idUser
        $con = conectarBD();
        $rs  = mysqli_query($con, "SELECT nome, sobrenome FROM usuarios WHERE idUser = $idUser LIMIT 1");
        if ($row = mysqli_fetch_assoc($rs)) {
            $adminNome = $row['nome'] . ' ' . $row['sobrenome'];
        } else {
            $adminNome = '';
        }
        // Insere usando o adminNome correto
        $ok = inserirNoticia($titulo, $subtitulo, $texto, $adminNome, $idUser);
        $_SESSION['inserirNoticia_Ok'] = (bool)$ok;
    } else {
        $_SESSION['inserirNoticia_Ok'] = false;
    }
}

header('Location: ../view/admin/ger-noticias.php');
exit;
