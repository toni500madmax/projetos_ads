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

$id_cliente = $_GET['id_cliente'];
$id_servico = $_GET['id_servico'];

$sql_excluir_servico = "DELETE FROM servicos WHERE cad_cliente = '$id_cliente'";
$sql_excluir_auto = "DELETE FROM automoveis WHERE cad_cliente = '$id_cliente'";
$sql_excluir_cliente = "DELETE FROM clientes WHERE id_cliente = '$id_cliente'";

$res = mysqli_query($conn, $sql_excluir_servico);
$res1 = mysqli_query($conn, $sql_excluir_auto);
$res2 = mysqli_query($conn, $sql_excluir_cliente);
if ($res) {
    if ($res1) {
        if ($res2) {
            /* echo "deu certo!!!"; */
            header("Location: portal.php");
            exit();
        }
    }
} else {
    echo "Houve um erro, por favor, entre em contato com o suporte.";
    header("Location: logout.php");
    $conn->close();
    exit();
}
