<?php
session_start();
require_once 'funcoesBD.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../view/admin/ger-noticias.php');
    exit;
}

$idNoticia = (int)$_POST['idNoticia'];
$titulo    = trim($_POST['titulo']    ?? '');
$subtitulo = trim($_POST['subtitulo'] ?? '');
$texto     = trim($_POST['texto']     ?? '');
$idUser    = (int)($_POST['idUsuario'] ?? 0);

// Aqui é onde precisamos buscar o nome do admin selecionado
$con = conectarBD();
$res = mysqli_query($con, "SELECT nome, sobrenome FROM usuarios WHERE idUser = $idUser LIMIT 1");
if ($row = mysqli_fetch_assoc($res)) {
    $adminNome = $row['nome'] . ' ' . $row['sobrenome'];
} else {
    $adminNome = '';
}

// Agora chamamos a função atualizada
$ok = atualizarNoticia($idNoticia, $titulo, $subtitulo, $texto, $adminNome, $idUser);
$_SESSION['atualizarNoticia_Ok'] = (bool)$ok;

header('Location: ../view/admin/ger-noticias.php');
exit;
