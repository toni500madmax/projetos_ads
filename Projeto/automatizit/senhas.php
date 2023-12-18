<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post">
        <h2>Verificar senha: </h2>
        <label for="senha">Digite uma senha:</label>
        <input type="text" name="senha" value="">
        <button type="submit">Criptografar</button>
    </form>
    <form action="" method="post">
        <h2>Verificar Login</h2>
        <label for="username_v">Verificar username: </label>
        <input type="text" name="username_v" value="">
        <label for="senha_v">Verificar senha: </label>
        <input type="text" name="senha_v" value="">
        <button type="submit">Verificar</button>
    </form>
    <?php
    if (isset($_POST['senha'])) {
        $senha_N_crip = filter_input(INPUT_POST, 'senha', FILTER_DEFAULT);
        $senha_crip = password_hash($senha_N_crip, PASSWORD_DEFAULT);
        echo "<br>Senha Digitada: {$senha_N_crip}.<br>";
        echo "<br>Senha Segura: {$senha_crip}.<br>";
    }
    if (isset($_POST['username_v'])) {
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
        $user = $_POST['username_v'];
        $sql_senha = "SELECT senha FROM usuarios WHERE username = '$user';";
        $res = mysqli_query($mysqli, $sql_senha);
        if ($res) {
            if ($sql_senha == true) {
                
                /* if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['id_usuario'] = $usuario['id_usuario'];
                $_SESSION['username'] = $usuario['username'];
                header("Location: portal.php"); */
            
            }
        }
    }
    ?>
</body>

</html>