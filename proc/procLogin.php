<?php

require_once "funcoesBD.php";
session_start();

if (!empty($_POST['userEmail']) && !empty($_POST['userPassword'])) {

    $email = $_POST['userEmail'];
    $senha = $_POST['userPassword'];
    $resultado = realizarLogin($email, $senha);
    if ($resultado->num_rows === 1){
        $usuario = $resultado->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['usuario_adm'] = (int) $usuario['adm'];
        header("Location: ../index.php");
        exit;
    } else {
        var_dump($_POST);
        $_SESSION['erro_login'] = "Usuário ou senha inválidos."; // Mensagem de erro
    }
}
header("Location: ../view/login.php"); // Volta para o login
exit;
?>