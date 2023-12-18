<?php
if (!isset($_SESSION)) {
    session_start();
}
if (!isset($_SESSION['id_usuario'])) {
    die("Você não está autorizado!<br> 
    Tente novamente ou entre em contato com o suporte.<br>
    <a href=\"/automatizit/index.php\">tentar novamente</a>");
}
