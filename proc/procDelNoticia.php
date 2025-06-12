<?php
session_start();
require_once __DIR__ . '/funcoesBD.php';

if (!isset($_SESSION['usuario_adm']) || $_SESSION['usuario_adm'] != 1) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNoticia = $_POST['idNoticia'] ?? '';
    if ($idNoticia !== '') {
        $ok = deletarNoticia($idNoticia);
        $_SESSION['deletarNoticia_Ok'] = (bool)$ok;
    } else {
        $_SESSION['deletarNoticia_Ok'] = false;
    }
}

header('Location: ../view/admin/ger-noticias.php');
exit;
