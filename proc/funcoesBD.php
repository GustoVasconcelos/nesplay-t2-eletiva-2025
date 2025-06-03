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

#funções relacionadas ao CRUD das categorias
function cadastrarCategoria($nome){

    $conexao = conectarBD();
    $consulta = "INSERT INTO categorias (nome) VALUES ('$nome')";
    mysqli_query($conexao, $consulta);
}

function listarCategorias(){

    $conexao = conectarBD();
    $consulta = "SELECT * FROM categorias";
    $listaCategorias = mysqli_query($conexao, $consulta);
    return $listaCategorias;
}

function renomarCategoria($id, $novoNomeCategoria){

    $conexao = conectarBD();
    $consulta = "UPDATE categorias SET nome = '$novoNomeCategoria' WHERE idCategoria = '$id'";
    mysqli_query($conexao, $consulta);
}

function apagarCategoria($id){

    $conexao = conectarBD();
    $consulta = "DELETE from categorias WHERE idCategoria = '$id'";
    mysqli_query($conexao, $consulta);
}

function listarUsuarios(){

    $conexao = conectarBD();
    $consulta = "SELECT * FROM usuarios";
    $listaUsuarios = mysqli_query($conexao, $consulta);
    return $listaUsuarios;
}

?>