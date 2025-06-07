<?php
require_once __DIR__ . '/funcoesBD.php';
session_start();

// Verifica se email e senha foram enviados
if (!empty($_POST['userEmail']) && !empty($_POST['userPassword'])) {
    $email = $_POST['userEmail'];
    $senha = $_POST['userPassword'];

    // Proteção contra SQL Injection
    $conexao = conectarBD();
    $emailEsc = mysqli_real_escape_string($conexao, $email);
    $senhaEsc = mysqli_real_escape_string($conexao, $senha);

    // Tenta logar
    $resultado = realizarLogin($emailEsc, $senhaEsc);
    if ($resultado && $resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        // Grava na sessão apenas os dados necessários
        $_SESSION['usuario']      = $usuario['apelido'];      
        $_SESSION['idUser']       = (int) $usuario['idUser'];  
        $_SESSION['usuario_adm']  = (int) $usuario['adm'];   

        header("Location: ../index.php");
        exit;
    } else {
        // Credenciais inválidas
        $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
    }
}

// Redireciona de volta ao formulário de login
header("Location: ../view/login.php");
exit;
?>