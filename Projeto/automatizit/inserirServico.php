<?php
//Conexão com banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "automatizit";

//criar conexão
$mysqli = new mysqli($servername, $username, $password, $dbname);

// verificar se a criação da conexão foi bem sucedida
if ($mysqli->error) {
    die("Falha de conexão: " . $mysqli->error);
}

$id_servico = $_GET['id_servico'];
$cad_cliente = $_GET['cad_cliente'];
$nome_servico = $_GET['nome_servico'];
$descricao = $_GET['descricao'];
$custo = $_GET['custo'];
echo "id_s = '$id_servico'<br>cad_cliente = '$cad_cliente'<br>nome_servico = '$nome_servico'<br>
descrição = '$descricao'<br>custo = '$custo'";

$sql_insert_servico = "INSERT INTO servicos (cad_cliente, nome_servico,
                            descricao, custo) 
                           VALUES
                            ('$cad_cliente', '$nome_servico', 
                            '$descricao', '$custo');";

$res = mysqli_query($mysqli, $sql_insert_servico);
if ($res) {
    header('Location: portal.php');
    exit();
} else {
    echo '<h1>Houve um erro! Favor tentar novamente ou entrar em contato com apoio.</h1>';
    header("Location: logout.php");
    exit();
}
