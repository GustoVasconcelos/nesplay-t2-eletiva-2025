<?php
session_start();      // Inicia a sessão
session_destroy();    // Destroi todos os dados da sessão
header("Location: login.php"); // Redireciona para login
exit;
?>