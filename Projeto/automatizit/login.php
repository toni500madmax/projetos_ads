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

$username = $_POST['username'];
$password = $_POST['senha'];

$hashed_password = md5('' . $password . '');
/* 
$stmt = $mysqli->prepare("SELECT * FROM usuarios WHERE username = $username AND senha = $hashed_password;");

$stmt->bind_param("ss", $username, $hashed_password);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "passou mas deu errado";
    /* header("Location: portal.php"); */

$username = $_POST['username'];
$senha = $_POST['senha'];
$sql_login = mysqli_query($mysqli, "SELECT * FROM usuarios WHERE username = '$username';");
$row = mysqli_fetch_array($sql_login);
$id_usuario = $row['id_usuario'];
echo "hash_senha: " . md5($id_usuario . $username . $senha) . "<br>";

if (md5('' . $senha . '') === $row['senha']) {
    echo "Senha correta:<br>enviada: '" . $recebe . " e '" . $senha . "
    '<br>Senha do BD: '" . $row['senha'] . "' <br>e o id: " . $id_usuario . "<br>";
    if (!isset($_SESSION)) {
        session_start();
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['username'] = $row['username'];
        header("Location: portal.php");
    } else {
        session_start();
        $_SESSION['id_usuario'] = $id_usuario;
        $_SESSION['username'] = $row['username'];
        header("Location: portal.php");
    }
} else {
    var_dump($senha, '<br>');

    var_dump($row, '<br>');
    var_dump($sql_login, '<br>');
    echo "<h1>Falha ao logar! Username ou senha incorretos.</h1>";
    /* exit(); */
}
