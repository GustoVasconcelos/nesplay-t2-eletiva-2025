<?php

require_once "funcoesBD.php";
session_start();

//Cadastro de Categorias
if(!empty($_POST['selectRenomearCategoria'])){

      $idCategoria = $_POST['selectRenomearCategoria'];
      $novoNomeCategoria = $_POST['novoNomeCategoria'];

      //Chamada da função inserirCliente
      renomemarCategoria($idCategoria, $novoNomeCategoria);
      $_SESSION['renomearCategoria_Ok'] = true;
      header('Location:../view/admin/ger-categorias.php');
      die();
   }
?>