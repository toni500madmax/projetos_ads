<?php
// Iniciar a sessão no início do arquivo
if (!isset($_SESSION)) {
    session_start();
}

// Se o usuário clicou em "Logout"
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login ou qualquer outra página desejada
    header("Location: /automatizit/index.php");
    exit();
}

// Se a sessão não foi iniciada ou o ID do usuário não está definido, redirecionar para a página de login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /automatizit/index.php");
    exit();
}

if (!isset($_SESSION)) {
    session_start();
}

session_destroy();
header("Location: /automatizit/index.php");
exit();
