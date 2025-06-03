<?php

require_once "funcoesBD.php";
session_start();

if (!empty($_POST['idUser'])) {
    $idUser = (int) $_POST['idUser'];
    $con = conectarBD();
    mysqli_query($con, "DELETE FROM usuarios WHERE idUser = $idUser");
    $_SESSION['apagarUsuario_Ok'] = true;
}
header("Location: ../view/admin/ger-usuarios.php");
exit;
