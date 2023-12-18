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
$id_cliente = $_POST['id_cliente'];
$novo_nome = $_POST['nome'];
$novo_cpf = $_POST['cpf'];
$novo_telefone = $_POST['telefone'];
$novo_dtnasc = $_POST['dtnasc'];
$novo_genero = $_POST['genero'];
$id_auto = $_POST['id_auto'];
$novo_nome_carro = $_POST['nome_carro'];
$novo_placa = $_POST['placa'];
$cad_cliente = $id_cliente;
echo "id='$id_cliente', nome='$novo_nome'<br>";
echo "<br>id='$id_cliente',<br>nome='$novo_nome'<br>";

$sql_upd_clienteauto = "UPDATE clientes SET nome = '$novo_nome', cpf = '$novo_cpf', 
                                        telefone = '$novo_telefone', dtnasc = '$novo_dtnasc', 
                                        genero = '$novo_genero' WHERE id_cliente = '$id_cliente';";
$sql_upd_clienteauto .= "UPDATE automoveis SET nome_carro = '$novo_nome_carro', placa = '$novo_placa' 
                                        WHERE cad_cliente = '$id_cliente';";

$res = $conn->multi_query($sql_upd_clienteauto);
if ($res) {
    header("Location: portal.php");
    exit();
} else {
    echo '<h1>Houve um erro! Favor tentar novamente ou entrar em contato com apoio.</h1>';
    header("Location: logout.php");
    exit();
}
