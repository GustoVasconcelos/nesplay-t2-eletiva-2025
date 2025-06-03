<?php

require_once "funcoesBD.php";
session_start();

//Cadastro de Categorias
if(!empty($_POST['selectApagarCategoria'])){

      $idCategoria = $_POST['selectApagarCategoria'];

      //Chamada da função inserirCliente
      apagarCategoria($idCategoria);
      $_SESSION['apagarCategoria_Ok'] = true;
      header('Location:../view/admin/ger-categorias.php');
      die();
   }
?>