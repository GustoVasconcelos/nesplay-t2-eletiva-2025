<?php

require_once "funcoesBD.php";
session_start();

//Cadastro de Usuários
if(!empty($_POST['nomeUser']) && !empty($_POST['sobrenomeUser']) && 
   !empty($_POST['nascimentoUser']) && !empty($_POST['emailUser']) && 
   !empty($_POST['apelidoUser']) && !empty($_POST['passwordUser'])){

      $nome = $_POST['nomeUser'];
      $sobrenome = $_POST['sobrenomeUser'];
      $dataNasc = $_POST['nascimentoUser'];
      $email = $_POST['emailUser'];
      $apelido = $_POST['apelidoUser'];
      $senha = $_POST['passwordUser'];

      //Chamada da função inserirCliente
      cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha);
      $_SESSION['cadastro_Ok'] = true;
      header('Location:../view/login.php');
      die();
   }
?>