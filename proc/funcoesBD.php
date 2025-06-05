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

#função de logar no sistema
function realizarLogin($email, $senha){

    $conexao = conectarBD();
    $consulta = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $resposta = mysqli_query($conexao, $consulta);
    return $resposta;
}

#funções relacionadas ao CRUD dos usuários
function cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha){

    $conexao = conectarBD();
    $consulta = "INSERT INTO usuarios (nome, sobrenome, dataNascimento, email, apelido, senha, adm) 
                 VALUES ('$nome','$sobrenome','$dataNasc','$email','$apelido','$senha','0')";
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

#funções de checagem para não deixar cadastros duplos
#email é um campo unico
function checarEmail($email){

    $conexao = conectarBD();
    $consulta = "SELECT * from usuarios WHERE email = '$email'";
    $reposta = mysqli_query($conexao, $consulta);
    return $reposta;
}

#apelido é outro campo unico
function checarApelido($apelido){

    $conexao = conectarBD();
    $consulta = "SELECT * from usuarios WHERE apelido = '$apelido'";
    $reposta = mysqli_query($conexao, $consulta);
    return $reposta;
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

function listarRoms() {
    $conexao = conectarBD();
    $sql = "
      SELECT 
        r.idRom,
        r.nome,
        r.descricao,
        r.ano,
        r.nomeArquivo,
        r.categoria_id,
        c.nome        AS categoria_nome,
        r.user_id,
        u.apelido     AS usuario_apelido,
        CONCAT(u.nome,' ',u.sobrenome) AS usuario_nome_completo
      FROM roms r
      LEFT JOIN categorias c ON r.categoria_id = c.idCategoria
      LEFT JOIN usuarios    u ON r.user_id      = u.idUser
    ";
    return mysqli_query($conexao, $sql);
}

function alterarRom($idRom, $nome, $descricao, $ano, $nomeArquivo, $categoria_id, $user_id) {
    $conexao = conectarBD();
    $nomeEsc      = mysqli_real_escape_string($conexao, $nome);
    $descEsc      = mysqli_real_escape_string($conexao, $descricao);
    $arquivoEsc   = mysqli_real_escape_string($conexao, $nomeArquivo);
    $consulta = "
        UPDATE roms SET
            nome         = '$nomeEsc',
            descricao    = '$descEsc',
            ano          = $ano,
            nomeArquivo  = '$arquivoEsc',
            categoria_id = $categoria_id,
            user_id      = $user_id
        WHERE idRom = $idRom
    ";
    mysqli_query($conexao, $consulta);
}
?>