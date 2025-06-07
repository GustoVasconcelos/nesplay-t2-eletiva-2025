<?php

require_once "funcoesBD.php";
session_start();

if(!empty($_POST['selectRenomearCategoria'])) {

      $idCategoria = $_POST['selectRenomearCategoria'];
      $novoNomeCategoria = $_POST['novoNomeCategoria'];

      renomearCategoria($idCategoria, $novoNomeCategoria);
      $_SESSION['renomearCategoria_Ok'] = true;
}
header('Location:../view/admin/ger-categorias.php');
exit;
?>