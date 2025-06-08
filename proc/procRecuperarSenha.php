<?php
require_once 'funcoesBD.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclui os arquivos da PHPMailer
require '../libs/phpmailer/src/Exception.php';
require '../libs/phpmailer/src/PHPMailer.php';
require '../libs/phpmailer/src/SMTP.php';
session_start();

if(empty($_POST['userEmail'])){
    header('Location:../view/recuperar-senha.php');
    exit;
}

$email = $_POST['userEmail'];
$senha = recuperarSenha($email);
$senha = $senha->fetch_assoc();
$senha = $senha['senha'];

if (empty($senha))
{
    $_SESSION['recuperarSenha'] = "Senha enviada ao email.";
    header('Location:../view/login.php');
    exit;
}

// Instancia PHPMailer
$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
try {
    // Configurações do servidor SMTP do Gmail
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'nesplay.emulador@gmail.com';
    $mail->Password   = '';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // ou PHPMailer::ENCRYPTION_SMTPS
    $mail->Port       = 587;

    // Remetente e destinatário
    $mail->setFrom('nesplay.emulador@gmail.com', 'NESPlay');
    $mail->addAddress($email); // e-mail de destino

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'NESPlay - Recuperação de Senha';
    $mail->Body    = "Esta é a <b>sua senha</b>: $senha";
    $mail->AltBody = "Esta é a sua senha: $senha";

    $mail->send();
    //echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    //echo "Erro ao enviar o e-mail: {$mail->ErrorInfo}";
}

$_SESSION['recuperarSenha'] = "Senha enviada ao email.";
header('Location:../view/login.php');
exit;
?>