<?php

// Conecta ao banco de dados
function conectarBD()
{
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db   = "nesplay";

    $c = mysqli_connect($host, $user, $pass, $db);
    if (!$c) {
        die('Erro ao conectar ao banco: ' . mysqli_connect_error());
    }
    return $c;
}

// Autentica usuário
function realizarLogin($email, $senha)
{
    $c = conectarBD();
    $e = mysqli_real_escape_string($c, $email);
    $s = mysqli_real_escape_string($c, $senha);
    $sql = "SELECT idUser, apelido, adm FROM usuarios WHERE email = '$e' AND senha = '$s'";
    return mysqli_query($c, $sql);
}

// CRUD Usuários
function cadastrarUsuario($nome, $sobrenome, $dataNasc, $email, $apelido, $senha)
{
    $c  = conectarBD();
    $n  = mysqli_real_escape_string($c, $nome);
    $sob = mysqli_real_escape_string($c, $sobrenome);
    $d  = mysqli_real_escape_string($c, $dataNasc);
    $e  = mysqli_real_escape_string($c, $email);
    $a  = mysqli_real_escape_string($c, $apelido);
    $s  = mysqli_real_escape_string($c, $senha);
    $sql = "INSERT INTO usuarios (nome, sobrenome, dataNascimento, email, apelido, senha, adm) 
            VALUES ('$n','$sob','$d','$e','$a','$s',0)";
    mysqli_query($c, $sql);
}

function listarUsuarios()
{
    $c = conectarBD();
    return mysqli_query($c, "SELECT * FROM usuarios ORDER BY nome");
}

function alterarUsuario($idUser, $nome, $sobrenome, $dataN, $email, $apelido, $senha, $adm)
{
    $c    = conectarBD();
    $id   = (int)$idUser;
    $n    = mysqli_real_escape_string($c, $nome);
    $sob  = mysqli_real_escape_string($c, $sobrenome);
    $d    = mysqli_real_escape_string($c, $dataN);
    $e    = mysqli_real_escape_string($c, $email);
    $a    = mysqli_real_escape_string($c, $apelido);
    $s    = mysqli_real_escape_string($c, $senha);
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
    mysqli_query($c, $sql);
}

function excluirUsuario($idUser)
{
    $c  = conectarBD();
    $id = (int)$idUser;
    mysqli_query($c, "DELETE FROM usuarios WHERE idUser = $id");
}

// Verificações únicas
function checarEmail($email)
{
    $c = conectarBD();
    $e = mysqli_real_escape_string($c, $email);
    return mysqli_query($c, "SELECT 1 FROM usuarios WHERE email = '$e' LIMIT 1");
}

function checarApelido($apelido)
{
    $c = conectarBD();
    $a = mysqli_real_escape_string($c, $apelido);
    return mysqli_query($c, "SELECT 1 FROM usuarios WHERE apelido = '$a' LIMIT 1");
}

// CRUD Categorias
function cadastrarCategoria($nomeCategoria)
{
    $c   = conectarBD();
    $n   = mysqli_real_escape_string($c, $nomeCategoria);
    mysqli_query($c, "INSERT INTO categorias (nome) VALUES ('$n')");
}

function listarCategorias()
{
    $c = conectarBD();
    return mysqli_query($c, "SELECT idCategoria, nome FROM categorias ORDER BY nome");
}

function renomearCategoria($idCategoria, $novoNomeCategoria)
{
    $c   = conectarBD();
    $id  = (int)$idCategoria;
    $n   = mysqli_real_escape_string($c, $novoNomeCategoria);
    mysqli_query($c, "UPDATE categorias SET nome = '$n' WHERE idCategoria = $id");
}

function apagarCategoria($idCategoria)
{
    $c  = conectarBD();
    $id = (int)$idCategoria;
    mysqli_query($c, "DELETE FROM categorias WHERE idCategoria = $id");
}

// CRUD Roms
function cadastrarRom($nome, $descricao, $ano, $nomeArquivo, $caminho, $categoria_id, $user_id)
{
    $c    = conectarBD();
    $n    = mysqli_real_escape_string($c, $nome);
    $d    = mysqli_real_escape_string($c, $descricao);
    $y    = (int)$ano;
    $orig = mysqli_real_escape_string($c, $nomeArquivo);
    $cam  = mysqli_real_escape_string($c, $caminho);
    $cat  = (int)$categoria_id;
    $usr  = (int)$user_id;
    $sql  = "INSERT INTO roms
                (nome, descricao, ano, nomeArquivo, caminho, categoria_id, user_id)
             VALUES
                ('$n','$d',$y,'$orig','$cam',$cat,$usr)";
    return mysqli_query($c, $sql);
}

function listarRoms()
{
    $c = conectarBD();
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
    return mysqli_query($c, $sql);
}

function alterarRom($idRom, $nome, $descricao, $ano, $nomeArquivo, $caminho, $categoria_id, $user_id)
{
    $c     = conectarBD();
    $id    = (int)$idRom;
    $n     = mysqli_real_escape_string($c, $nome);
    $d     = mysqli_real_escape_string($c, $descricao);
    $y     = (int)$ano;
    $orig  = mysqli_real_escape_string($c, $nomeArquivo);
    $cam   = mysqli_real_escape_string($c, $caminho);
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
    mysqli_query($c, $sql);
}

function deletarRom(int $idRom): bool {
    $c = conectarBD();
    $sql = "DELETE FROM roms WHERE idRom = ?";
    $stmt = mysqli_prepare($c, $sql);
    mysqli_stmt_bind_param($stmt, "i", $idRom);
    return mysqli_stmt_execute($stmt);
}

function buscarRomPorId($idRom) {
    $c = conectarBD();
    $id = (int)$idRom;
    $sql = "SELECT * FROM roms WHERE idRom = $id LIMIT 1";
    $resultado = mysqli_query($c, $sql);
    return mysqli_fetch_assoc($resultado);
}