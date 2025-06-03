<?php

require_once "funcoesBD.php";
session_start();

//Cadastro de Categorias
if(!empty($_POST['nomeCategoria'])){

      $nomeCategoria = $_POST['nomeCategoria'];

      //Chamada da função inserirCliente
      cadastrarCategoria($nomeCategoria);
      $_SESSION['cadastroCategoria_Ok'] = true;
      header('Location:../view/admin/ger-categorias.php');
      die();
   }
?>