<?php
require_once "funcoesBD.php";
session_start();

if (!empty($_POST['idRom'])) {
    $id        = (int) $_POST['idRom'];
    $nome      = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $ano       = (int) $_POST['ano'];
    $arquivo   = $_POST['nomeArquivo'];
    $catId     = (int) $_POST['categoria_id'];
    $userId    = (int) $_POST['user_id'];

    alterarRom($id, $nome, $descricao, $ano, $arquivo, $catId, $userId);

    $_SESSION['renomearRom_Ok'] = true;
}

header("Location: ../view/admin/ger-roms.php");
exit;
?>