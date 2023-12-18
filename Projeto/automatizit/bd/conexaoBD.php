<?php
//Conexão com banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "automatizit";

//criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// verificar se a criação da conexão foi bem sucedida
if ($conn->error) {
    die("Falha de conexão: " . $conn->error);
}
