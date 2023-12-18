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

# CLIENTE ---------------------------------------------------------------------
$id_cliente = $_GET['id_cliente'];
$id_servico = $_GET['id_servico'];
$cad_cliente = $_GET['cad_cliente'];
$novo_nome_servico = $_GET['nome_servico'];
$novo_descricao = $_GET['descricao'];
$novo_custo = $_GET['custo'];

$sql_upd_servico = "UPDATE servicos SET nome_servico = '$novo_nome_servico', 
                                        descricao = '$novo_descricao', 
                                        custo = '$novo_custo' 
                                        WHERE cad_cliente = '$cad_cliente'
                                        AND id_servico = '$id_servico';";

$res = mysqli_query($conn, $sql_upd_servico);

if ($res) {
    header("Location: portal.php");
    exit();
} else {
    echo '<h1>Houve um erro! Favor tentar novamente ou entrar em contato com apoio.</h1>';
    header("Location: logout.php");
    exit();
}
