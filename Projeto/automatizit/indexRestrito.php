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
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <script src="https://kit.fontawesome.com/111cc2b36b.js" crossorigin="anonymous"></script>
    <title>Inicio Usuário</title>
</head>

<body>
    <header class="header" id="header">
        <div class="logo">
            <img src="./fotos/icon-logo.png" alt="logo"><span>Automatizit App.</span>
        </div>
        <div class="titulo-pagina">
            <h1>Portal do Mecânico.</h1>
            <p>Faça seu Login para entar</p>
        </div>
    </header>
    <!--  ------------------------------LOGIN ---------------------------------------------- -->
    <div id="index" class="index" style="display: block;">
        <button onclick="document.getElementById('id01').style.display='flex',
        document.getElementById('id01').style.position = 'absolute';" style="width:100%;">Login</button>
        <button onclick="document.getElementById('criar-usuario').style.display='block',
        document.getElementById('id01').style.position = 'absolute';" style="width:100%;">Novo Usuário</button>
    </div>

    <div id="id01" class="modal" style="display: none;">
        <form class="modal-content animate" action="" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">
                    <h1 style="display: flex; margin-left: 20px;">&times;</h1>
                </span>
                <div class="logo"><img src="fotos/icon-logo.png" alt="Avatar" class="avatar"></div>
            </div>
            <div class="container">
                <label for="uname"><b>Seu nome de usuário:</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Sua senha:</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                <button type="submit">Login</button>

                <label>
                    <input type="checkbox" checked="checked" name="remember"> Lembrar-me.
                </label>
            </div>

            <div class="container" style="background-color: 'var(--color-dark2)';">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancelar</button>
                <span class="psw">Esqueceu a <a href="#">senha?</a></span>
            </div>
        </form>
    </div>
    <!-- ------------------------NOVO USUARIO ------------------------------------------- -->
    <div id="criar-usuario" class="criar-usuario" style="display: none;">
        <form action="" method="post" class="criar-usuario">
            <span onclick="document.getElementById('criar-usuario').style.display='none'" class="close" title="Close Modal">
                <h1>&times;</h1>
                <div class="logo2"><img src="fotos/icon-logo.png" alt="Avatar" class="avatar"></div>
            </span>
            <input type="hidden" name="id_usuario">
            <label for="usuario-userme">Digite um username</label>
            <input type="text" name="user-username" style="color: black;">
            <label for="usuario-password">Digite uma senha</label>
            <input type="password" name="user-password" style="color: black;">
            <label for="usuario-password">Repita a senha</label>
            <input type="password" name="user-password-check" style="color: black;">
            <button type="submit">Cadastrar usuário</button>

            <?php
            if (isset($_POST['user-username'])) {
                if (strlen($_POST['user-username']) == 0) {
                    echo "Preencha seu Nome de usuário!";
                } else if (strlen($_POST['user-password']) == 0) {
                    echo "Preencha sua senha!";
                } else if (strlen($_POST['user-password-check']) == 0) {
                    echo "preencha sua senha!";
                } else {
                    $username = $mysqli->real_escape_string(($_POST['user-username']));
                    $password = $mysqli->real_escape_string(($_POST['user-password']));
                    $passwordCheck = $mysqli->real_escape_string($_POST['user-password-check']);
                    if ($password !== $passwordCheck) {
                        echo "<h1>Por favor, repita a checagem de senha.</h1>";
                    }
                }
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


                $id_usuario = "";
                $obt_id = "SELECT MAX(id_usuario) AS novo_usuario FROM usuarios;";
                $resultado = $mysqli->query($obt_id);
                if ($resultado->num_rows > 0) {
                    if ($row = $resultado->fetch_assoc()) {
                        $id_usuario = $row['novo_usuario'] + 1;
                    } else {
                        $id_usuario = 1;
                    }
                }
                $username = $_POST['user-username'];
                $password = md5($_POST['user-password']);
                $sql_insert_usuario = "INSERT INTO usuarios (id_usuario, username, senha) VALUES 
            ('$id_usuario', '$username', '$password');";
                $resposta2 = mysqli_query($mysqli, $sql_insert_usuario);
                if ($resposta2) {
                    header("Location: index.php");
                    exit();
                } else {
                    echo "Houve um erro! favor entrar em contato com o suporte.";
                    header("Location: index.php");
                    exit();
                }
            }
            ?>
        </form>
    </div>
    <footer><i class="fa-regular fa-copyright" style="color: 'var(--color-dark2)';"></i> - All rights reserved - recuse imitações!!!!</footer>

    <script>
        // Get the modal
        var modal = document.getElementById('id01');

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "block";
            }
        }
    </script>

</body>

</html>