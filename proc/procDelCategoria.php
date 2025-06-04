<?php

require_once "funcoesBD.php";
session_start();

if(!empty($_POST['selectApagarCategoria'])){

   $idCategoria = $_POST['selectApagarCategoria'];

   apagarCategoria($idCategoria);
   $_SESSION['apagarCategoria_Ok'] = true;
   header('Location:../view/admin/ger-categorias.php');
   die();
}
?>