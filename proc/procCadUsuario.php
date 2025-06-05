<?php

require_once "funcoesBD.php";
session_start();

if(!empty($_POST['nomeUser']) && !empty($_POST['sobrenomeUser']) && 
   !empty($_POST['nascimentoUser']) && !empty($_POST['emailUser']) && 
   !empty($_POST['apelidoUser']) && !empty($_POST['passwordUser'])){

   $nome = $_POST['nomeUser'];
   $sobrenome = $_POST['sobrenomeUser'];
   $dataNasc = $_POST['nascimentoUser'];
   $email = $_POST['emailUser'];
   $apelido = $_POST['apelidoUser'];
   $senha = $_POST['passwordUser'];

   $existe_email = checarEmail($email);
   if ($existe_email->num_rows === 1){
      $_SESSION['erro_cadastro'] = "Email já cadastrado.";
      header('Location:../view/cadastrar.php');
      exit;
   }

   $existe_apelido = checarApelido($apelido);
   if ($existe_apelido->num_rows === 1){
      $_SESSION['erro_cadastro'] = "Apelido já em uso.";
      header('Location:../view/cadastrar.php');
      exit;
   }

   cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha);
   $_SESSION['cadastro_Ok'] = true;
}
header('Location:../view/login.php');
exit;
?>