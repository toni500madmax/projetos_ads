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

if (empty($id_cliente)) {
    # CLIENTE ---------------------------------------------------------------------
    $id_cliente = "";
    $obt_id = "SELECT MAX(id_cliente) AS novo_id FROM clientes;";
    $resultado = $mysqli->query($obt_id);
    if ($resultado->num_rows > 0) {
        if ($row = $resultado->fetch_assoc()) {
            $id_cliente = $row['novo_id'] + 1;
        } else {
            $id_cliente = 1;
        }
    }
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $telefone = $_POST['telefone'];
    $dtnasc = $_POST['dtnasc'];
    $genero = $_POST['genero'];
    $id_auto = "";
    $obt_id_auto = "SELECT MAX(id_auto) AS novo_id_auto FROM automoveis;";
    $resultado = $mysqli->query($obt_id_auto);
    if ($resultado->num_rows > 0) {
        if ($row = $resultado->fetch_assoc()) {
            $id_auto = $row['novo_id_auto'] + 1;
        } else {
            $id_auto = 1;
        }
    }
    $nome_carro = $_POST['nome_carro'];
    $placa = $_POST['placa'];
    $cad_cliente = $id_cliente;

    $sql_insert = "INSERT INTO clientes (id_cliente, nome, cpf, telefone, dtnasc, genero) VALUES
                     ('$id_cliente', '$nome', '$cpf', '$telefone', '$dtnasc', '$genero');";

    $sql_insert .= "INSERT INTO automoveis (id_auto, nome_carro, placa, cad_cliente) VALUES 
                     ('$id_auto', '$nome_carro', '$placa', '$cad_cliente');";

    $res = $mysqli->multi_query($sql_insert);
    /* echo "<br><br><h1>A conexão e o codigo sql estão corretos.</h1><br><br>"; */
    if ($res) {
        /*     echo '<h1>deu certo!</h1>'; */
        header('Location: portal.php');
        exit();
    } else {
        echo '<h1>Houve um erro! Favor tentar novamente ou entrar em contato com apoio.</h1>';
        header("Location: portal.php");
        exit();
    }
}
