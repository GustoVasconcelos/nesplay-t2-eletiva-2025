<?php

require_once "funcoesBD.php";
session_start();

if (!empty($_POST['idUser'])) {
    $id     = (int) $_POST['idUser'];
    $nome   = mysqli_real_escape_string(conectarBD(), $_POST['nome']);
    $sobrenome = mysqli_real_escape_string(conectarBD(), $_POST['sobrenome']);
    $dataN  = $_POST['dataNascimento'];
    $email  = mysqli_real_escape_string(conectarBD(), $_POST['email']);
    $apelido = mysqli_real_escape_string(conectarBD(), $_POST['apelido']);
    $senha  = mysqli_real_escape_string(conectarBD(), $_POST['senha']);
    $adm    = isset($_POST['adm']) ? 1 : 0;

    alterarUsuario($id, $nome, $sobrenome, $dataN, $email, $apelido, $senha, $adm);
    $_SESSION['renomearUsuario_Ok'] = true;
}

header("Location: ../view/admin/ger-usuarios.php");
exit;
