<?php
session_start();
require_once __DIR__ . '/funcoesBD.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../view/login.php');
    exit;
}

if (!isset($_SESSION['idUser'])) {
    die('Erro interno: usuário não identificado. Faça login novamente.');
}
$user_id = (int) $_SESSION['idUser'];

$nome      = $_POST['nome']      ?? '';
$descricao = $_POST['descricao'] ?? '';
$ano       = $_POST['ano']       ?? '';
$categoria = $_POST['categoria'] ?? '';

// Função para sanitizar nomes de arquivos
function nomeArquivoSeguro(string $nome): string
{
    // Remove todos os caracteres perigosos e substitui por "_"
    $seguro = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $nome);
    // Evita que múltiplos "_" fiquem juntos
    return preg_replace('/_+/', '_', $seguro);
}

$uploadDir = __DIR__ . '/../roms/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

if (
    isset($_FILES['romFile']) &&
    $_FILES['romFile']['error'] === UPLOAD_ERR_OK
) {
    $tmpPath      = $_FILES['romFile']['tmp_name'];
    $originalName = basename($_FILES['romFile']['name']);
    $ext          = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

    if ($ext !== 'nes') {
        $_SESSION['romEnviada_Ok']   = false;
        $_SESSION['romEnviada_Erro'] = 'Só arquivos .nes são permitidos.';
        header('Location: ../view/cadastrar-rom.php');
        exit;
    }

    // Aplicar nome seguro ao arquivo
    $baseName  = nomeArquivoSeguro(pathinfo($originalName, PATHINFO_FILENAME));
    $safeName  = $baseName . '.' . $ext;

    $destPath      = $uploadDir . $safeName;
    $relativePath  = 'roms/' . $safeName;
    $counter       = 1;

    // Evita sobrescrever arquivos existentes
    while (file_exists($destPath)) {
        $safeName     = $baseName . "_{$counter}." . $ext;
        $destPath     = $uploadDir . $safeName;
        $relativePath = 'roms/' . $safeName;
        $counter++;
    }

    // Move o arquivo enviado
    if (!move_uploaded_file($tmpPath, $destPath)) {
        $_SESSION['romEnviada_Ok']   = false;
        $_SESSION['romEnviada_Erro'] = 'Falha ao salvar arquivo no servidor.';
        header('Location: ../view/cadastrar-rom.php');
        exit;
    }

    // Usa nome seguro na base também
    if (cadastrarRom(
        $nome,
        $descricao,
        $ano,
        $safeName,        // <- nome do arquivo seguro salvo no banco
        $relativePath,
        $categoria,
        $user_id
    )) {
        $_SESSION['romEnviada_Ok'] = true;
    } else {
        $_SESSION['romEnviada_Ok']   = false;
        $_SESSION['romEnviada_Erro'] = 'Erro ao gravar informações no banco.';
    }

    header('Location: ../view/cadastrar-rom.php');
    exit;
}

$_SESSION['romEnviada_Ok']   = false;
$_SESSION['romEnviada_Erro'] = 'Nenhum arquivo enviado.';
header('Location: ../view/cadastrar-rom.php');
exit;