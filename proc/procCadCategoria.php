<?php

require_once "funcoesBD.php";
session_start();

if(!empty($_POST['nomeCategoria'])){

      $nomeCategoria = $_POST['nomeCategoria'];

      if (checarNomeCategoria($nomeCategoria)){
            $_SESSION['erro_editar_categoria'] = "Categoria já existe.";
            header('Location:../view/admin/ger-categorias.php');
            exit;
      }

      cadastrarCategoria($nomeCategoria);
      $_SESSION['cadastroCategoria_Ok'] = true;
}
header('Location:../view/admin/ger-categorias.php');
exit;
?>