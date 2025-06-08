<?php

// Conecta ao banco de dados
function conectarBD()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "nesplay";

    $conexao = mysqli_connect($host, $user, $pass, $db);
    if (!$conexao) {
        die('Erro ao conectar ao banco: ' . mysqli_connect_error());
    }
    return $conexao;
}

// Autentica usuário
function realizarLogin($email, $senha)
{
    $conexao = conectarBD();
    $e = mysqli_real_escape_string($conexao, $email);
    $s = mysqli_real_escape_string($conexao, $senha);
    $sql = "SELECT idUser, apelido, adm FROM usuarios WHERE email = '$e' AND senha = '$s'";
    return mysqli_query($conexao, $sql);
}

// Recupera a senha do usuári
function recuperarSenha($email)
{
    $conexao = conectarBD();
    $e = mysqli_real_escape_string($conexao, $email);
    $sql = "SELECT senha FROM usuarios WHERE email = '$e' LIMIT 1";
    return mysqli_query($conexao, $sql);
}

// CRUD Usuários
function cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha)
{
    $conexao  = conectarBD();
    $n  = mysqli_real_escape_string($conexao, $nome);
    $sob = mysqli_real_escape_string($conexao, $sobrenome);
    $d  = mysqli_real_escape_string($conexao, $dataNasc);
    $e  = mysqli_real_escape_string($conexao, $email);
    $a  = mysqli_real_escape_string($conexao, $apelido);
    $s  = mysqli_real_escape_string($conexao, $senha);
    $sql = "INSERT INTO usuarios (nome, sobrenome, dataNascimento, email, apelido, senha, adm) 
            VALUES ('$n','$sob','$d','$e','$a','$s',0)";
    mysqli_query($conexao, $sql);
}

function listarUsuarios()
{
    $conexao = conectarBD();
    return mysqli_query($conexao, "SELECT * FROM usuarios ORDER BY nome");
}

function alterarUsuario($idUser, $nome, $sobrenome, $dataN, $email, $apelido, $senha, $adm)
{
    $conexao    = conectarBD();
    $id   = (int)$idUser;
    $n    = mysqli_real_escape_string($conexao, $nome);
    $sob  = mysqli_real_escape_string($conexao, $sobrenome);
    $d    = mysqli_real_escape_string($conexao, $dataN);
    $e    = mysqli_real_escape_string($conexao, $email);
    $a    = mysqli_real_escape_string($conexao, $apelido);
    $s    = mysqli_real_escape_string($conexao, $senha);
    $adm  = $adm ? 1 : 0;
    $sql = "UPDATE usuarios SET
                nome           = '$n',
                sobrenome      = '$sob',
                dataNascimento = '$d',
                email          = '$e',
                apelido        = '$a',
                senha          = '$s',
                adm            = $adm
            WHERE idUser = $id";
    mysqli_query($conexao, $sql);
}

function excluirUsuario($idUser)
{
    $conexao  = conectarBD();
    $id = (int)$idUser;
    mysqli_query($conexao, "DELETE FROM usuarios WHERE idUser = $id");
}

// Verificações únicas
function checarEmail($email)
{
    $conexao = conectarBD();
    $e = mysqli_real_escape_string($conexao, $email);
    return mysqli_query($conexao, "SELECT 1 FROM usuarios WHERE email = '$e' LIMIT 1");
}

function checarApelido($apelido)
{
    $conexao = conectarBD();
    $a = mysqli_real_escape_string($conexao, $apelido);
    return mysqli_query($conexao, "SELECT 1 FROM usuarios WHERE apelido = '$a' LIMIT 1");
}

// CRUD Categorias
function cadastrarCategoria($nomeCategoria)
{
    $conexao   = conectarBD();
    $n   = mysqli_real_escape_string($conexao, $nomeCategoria);
    mysqli_query($conexao, "INSERT INTO categorias (nome) VALUES ('$n')");
}

function listarCategorias()
{
    $conexao = conectarBD();
    return mysqli_query($conexao, "SELECT idCategoria, nome FROM categorias ORDER BY nome");
}

function renomearCategoria($idCategoria, $novoNomeCategoria)
{
    $conexao   = conectarBD();
    $id  = (int)$idCategoria;
    $n   = mysqli_real_escape_string($conexao, $novoNomeCategoria);
    mysqli_query($conexao, "UPDATE categorias SET nome = '$n' WHERE idCategoria = $id");
}

function apagarCategoria($idCategoria)
{
    $conexao  = conectarBD();
    $id = (int)$idCategoria;
    mysqli_query($conexao, "DELETE FROM categorias WHERE idCategoria = $id");
}

// CRUD Roms
function cadastrarRom($nome, $descricao, $ano, $nomeArquivo, $caminho, $categoria_id, $user_id)
{
    $conexao    = conectarBD();
    $n    = mysqli_real_escape_string($conexao, $nome);
    $d    = mysqli_real_escape_string($conexao, $descricao);
    $y    = (int)$ano;
    $orig = mysqli_real_escape_string($conexao, $nomeArquivo);
    $cam  = mysqli_real_escape_string($conexao, $caminho);
    $cat  = (int)$categoria_id;
    $usr  = (int)$user_id;
    $sql  = "INSERT INTO roms
                (nome, descricao, ano, nomeArquivo, caminho, categoria_id, user_id)
             VALUES
                ('$n','$d',$y,'$orig','$cam',$cat,$usr)";
    return mysqli_query($conexao, $sql);
}

function listarRoms()
{
    $conexao = conectarBD();
    $sql = "SELECT
                r.idRom,
                r.nome,
                r.descricao,
                r.ano,
                r.nomeArquivo,
                r.caminho,
                r.categoria_id,
                c.nome AS categoria_nome,
                r.user_id,
                u.apelido AS usuario_apelido,
                CONCAT(u.nome,' ',u.sobrenome) AS usuario_nome_completo
            FROM roms r
            LEFT JOIN categorias c ON r.categoria_id = c.idCategoria
            LEFT JOIN usuarios u  ON r.user_id      = u.idUser";
    return mysqli_query($conexao, $sql);
}

function alterarRom($idRom, $nome, $descricao, $ano, $nomeArquivo, $caminho, $categoria_id, $user_id)
{
    $conexao     = conectarBD();
    $id    = (int)$idRom;
    $n     = mysqli_real_escape_string($conexao, $nome);
    $d     = mysqli_real_escape_string($conexao, $descricao);
    $y     = (int)$ano;
    $orig  = mysqli_real_escape_string($conexao, $nomeArquivo);
    $cam   = mysqli_real_escape_string($conexao, $caminho);
    $cat   = (int)$categoria_id;
    $usr   = (int)$user_id;
    $sql   = "UPDATE roms SET
                 nome         = '$n',
                 descricao    = '$d',
                 ano          = $y,
                 nomeArquivo  = '$orig',
                 caminho      = '$cam',
                 categoria_id = $cat,
                 user_id      = $usr
              WHERE idRom = $id";
    mysqli_query($conexao, $sql);
}

function deletarRom(int $idRom): bool {
    $conexao = conectarBD();
    $sql = "DELETE FROM roms WHERE idRom = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idRom);
    return mysqli_stmt_execute($stmt);
}

function buscarRomPorId($idRom) {
    $conexao = conectarBD();
    $id = (int)$idRom;
    $sql = "SELECT * FROM roms WHERE idRom = $id LIMIT 1";
    $resultado = mysqli_query($conexao, $sql);
    return mysqli_fetch_assoc($resultado);
}