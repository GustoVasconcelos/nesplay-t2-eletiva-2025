<?php

#função para se conectar ao banco de dados
function conectarBD(){
    
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "nesplay";
    $conexao = mysqli_connect($host,$user,$pass,$db);
    return ($conexao);
}

#funções relacionadas ao CRUD dos usuários
function cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha){

    $conexao = conectarBD();
    $consulta = "INSERT INTO usuarios (nome, sobrenome, dataNascimento, email, apelido, senha, adm) VALUES ('$nome','$sobrenome','$dataNasc','$email','$apelido','$senha','0')";
    mysqli_query($conexao, $consulta);
}

function listarUsuarios(){

    $conexao = conectarBD();
    $consulta = "SELECT * FROM usuarios";
    $listaUsuarios = mysqli_query($conexao, $consulta);
    return $listaUsuarios;
}

function alterarUsuario($idUser, $nome, $sobrenome, $dataN, $email, $apelido, $senha, $adm){

    $conexao = conectarBD();
    $consulta = "
      UPDATE usuarios SET
        nome           = '$nome',
        sobrenome      = '$sobrenome',
        dataNascimento = '$dataN',
        email          = '$email',
        apelido        = '$apelido',
        senha          = '$senha',
        adm            = $adm
      WHERE idUser = $idUser
    ";
    mysqli_query($conexao, $consulta);
}

function excluirUsuario($idUser){

    $conexao = conectarBD();
    $consulta = "DELETE FROM usuarios WHERE idUser = '$idUser'";
    mysqli_query($conexao, $consulta);
}

#funções relacionadas ao CRUD das categorias
function cadastrarCategoria($nomeCategoria){

    $conexao = conectarBD();
    $consulta = "INSERT INTO categorias (nome) VALUES ('$nomeCategoria')";
    mysqli_query($conexao, $consulta);
}

function listarCategorias(){

    $conexao = conectarBD();
    $consulta = "SELECT * FROM categorias";
    $listaCategorias = mysqli_query($conexao, $consulta);
    return $listaCategorias;
}

function renomemarCategoria($idCategoria, $novoNomeCategoria){

    $conexao = conectarBD();
    $consulta = "UPDATE categorias SET nome = '$novoNomeCategoria' WHERE idCategoria = '$idCategoria'";
    mysqli_query($conexao, $consulta);
}

function apagarCategoria($idCategoria){

    $conexao = conectarBD();
    $consulta = "DELETE from categorias WHERE idCategoria = '$idCategoria'";
    mysqli_query($conexao, $consulta);
}

?>