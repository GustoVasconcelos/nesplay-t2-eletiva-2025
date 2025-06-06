<?php
require_once "funcoesBD.php";
session_start();

// Verifica se o usuário é administrador
if (!isset($_SESSION['usuario_adm']) || $_SESSION['usuario_adm'] != 1) {
    header("Location: ../index.php");
    exit;
}

// Verifica se foi enviado o id da ROM
if (!isset($_POST['idRom'])) {
    header("Location: ../view/admin/ger-roms.php");
    exit;
}

$idRom = (int)$_POST['idRom'];

// Buscar dados da ROM
$rom = buscarRomPorId($idRom);

// Apaga o arquivo da pasta, se existir
if ($rom && !empty($rom['caminho'])) {
    $caminhoCompleto = __DIR__ . '/../' . $rom['caminho'];
    if (file_exists($caminhoCompleto)) {
        unlink($caminhoCompleto);
    }
}

// Agora remove do banco
$sucesso = deletarRom($idRom);

// Feedback
$_SESSION['apagarRom_Ok'] = $sucesso;

header("Location: ../view/admin/ger-roms.php");
exit;