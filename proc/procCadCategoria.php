<?php

require_once "funcoesBD.php";
session_start();

if(!empty($_POST['nomeCategoria'])){

      $nomeCategoria = $_POST['nomeCategoria'];

      cadastrarCategoria($nomeCategoria);
      $_SESSION['cadastroCategoria_Ok'] = true;
      header('Location:../view/admin/ger-categorias.php');
      die();
   }
?>