<?php
// Iniciar a sessão no início do arquivo
if (!isset($_SESSION)) {
    session_start();
}

// Se o usuário clicou em "Logout"
if (isset($_GET['logout']) && $_GET['logout'] == 1) {
    // Destruir a sessão
    session_destroy();

    // Redirecionar para a página de login ou qualquer outra página desejada
    header("Location: /automatizit/index.php");
    exit();
}

// Se a sessão não foi iniciada ou o ID do usuário não está definido, 
// redirecionar para a página de login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: /automatizit/index.php");
    exit();
}
include('bd/conexaoBD.php');
// Cria conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão 
if ($conn->connect_error) {
    die(" Falha de conexão: " . $conn->connect_error);
}

$video_url = "bd\defesa_pagina.mkv";
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/111cc2b36b.js" crossorigin="anonymous"></script>
    <title>Portal do Mecânico</title>
</head>

<body>
    <header class="header">
        <div class="logo">
            <img src="./fotos/icon-logo.png" alt="logo"><span>Automatizit App.</span>
        </div>
        <div class="titulo-pagina">
            <div>
                <h1>Portal do Mecânico.</h1>
                <p>Bem vindo ao seu assistente de serviços.<br></p>
                <span class="username">
                    <h3>Usuário:
                        <?php echo $_SESSION['username']; ?></h3>
                </span>
            </div>
            <div class="btncancel"><a href="logout.php">
                    <button class="cancelbtn">Logout</button></a></div>
        </div>
    </header>
    <section>
        <div class="portal-menu">
            <h1>Escolha uma opção:</h1>
            <button onclick="document.getElementById('home').style.display='block', 
            document.getElementById('cadastro').style.display='none',  
            document.getElementById('listagem').style.display='none',
            document.getElementById('servicos').style.display='none';" class="active">
                Home
            </button>
            <button onclick="document.getElementById('cadastro').style.display='block',
             document.getElementById('home').style.display='none',
             document.getElementById('listagem').style.display='none',
             document.getElementById('servicos').style.display='none'">
                Cadastro de cliente
            </button>
            <button onclick="document.getElementById('servicos').style.display='block',
             document.getElementById('home').style.display='none',
             document.getElementById('listagem').style.display='none',
             document.getElementById('cadastro').style.display='none'">
                Serviços
            </button>
            <button onclick="document.getElementById('listagem').style.display='block',
              document.getElementById('home').style.display='none', 
              document.getElementById('cadastro').style.display='none',
              document.getElementById('servicos').style.display='none'">
                Listar Clientes
            </button>
        </div>
        <!-------------------------- HOME ---------------------------->
        <div class="portal-display">
            <div id="home" class="home" style="display: block;">
                <video width="620" height="320" controls>
                    <source src="./bd/defesa_pagina.mkv" type="video/mp4">
                    Seu navegador não suporta o elemento de vídeo.
                    <h1>Se precisar tem o video na pasta BD.</h1>
                </video>
            </div>
            <!---------------------------- CADASTRO  ---------------------------->
            <div id="cadastro" class="cadcliente" style="display: none;">
                <form action="inserir.php" method="post">
                    <input type="hidden" name="id_cliente">
                    <label for="nome">Digite o nome:</label>
                    <input type="text" name="nome">
                    <label for="cpf">Digite o CPF:</label>
                    <input type="text" name="cpf">
                    <label for="telefone">Digite o telefone:</label>
                    <input type="text" name="telefone">
                    <div class="dt">
                        <label for="dtnasc">Digite a data de nascimento:</label>
                        <input type="date" name="dtnasc"><br>
                    </div>
                    <div class="gen">
                        <label for="genero">Escolha o Genero:</label>
                        <select name="genero">
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                        </select>
                    </div>
                    <input type="hidden" name="id_auto">
                    <label for="auto">Adicionar automóvel:</label>
                    <input type="text" name="nome_carro">
                    <label for="placa">Placa</label>
                    <input type="text" name="placa">
                    <input type="hidden" name="cad_cliente">
                    <button type="submit">Enviar</button>
                </form>
            </div>
            <!---------------------------- SERVIÇOS  ------------------------------>
            <div id="servicos" class="servicos" style="display: none; height: 320px; overflow-y: scroll;">
                <div id="tabela" class="tabela">
                    <form action="servicos.php" method="get">
                        <div id="tabela" class="tabela" style="display: block;">
                            <table border="1px solid black" style="text-align: center;">
                                <th border="1px solid black">ID</th>
                                <th border="1px solid black">ID Serviço</th>
                                <th border="1px solid black">Nome Cliente</th>
                                <th border="1px solid black">Serviço</th>
                                <th border="1px solid black">Descrição do Serviço</th>
                                <th border="1px solid black">Custo</th>
                                <th border="1px solid black">Info</th>
                                <tr>
                                    <?php
                                    $sql_listar = "SELECT clientes.id_cliente, clientes.nome, 
                                    servicos.id_servico, servicos.cad_cliente, 
                                    servicos.nome_servico, servicos.descricao, 
                                    servicos.custo 
                                    FROM servicos INNER JOIN clientes 
                                    ON clientes.id_cliente = servicos.cad_cliente 
                                    ORDER BY servicos.cad_cliente;";
                                    $res = mysqli_query($conn, $sql_listar);
                                    if ($res) {
                                        while ($row = mysqli_fetch_assoc($res)) {
                                            echo "<tr>
                                    <td>" . $row['id_cliente'] . "</td>
                                    <td>" . $row['id_servico'] . "</td>
                                    <td>" . $row['nome'] . "</td>
                                    <td>" . $row['nome_servico'] . "</td>
                                    <td>" . $row['descricao'] . "</td>
                                    <td>" . $row['custo'] . "</td>
                                    <td><a href='servicos.php?id_cliente="
                                                . $row['id_cliente'] . "&cad_cliente="
                                                . $row['cad_cliente'] . "&id_servico="
                                                . $row['id_servico'] . "'>Informações</a></td>
                                            </tr>";
                                        }
                                    } ?>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
            <!---------------------------- LISTAGEM DE USUÁRIOS ------------------------------>
            <div id="listagem" class="listaClientes" style="display: none;
                                                            text-align: center;
                                                            padding-top: 20px;
                                                            padding-left: 20px;
                                                            background-color: #04aa6d;
                                                            width: 97.7%;
                                                            height: 290px;
                                                            overflow-y: scroll;">
                <form action="" method="get">
                    <table border="1px solid black">
                        <th border="1px solid black">ID</th>
                        <th border="1px solid black">Nome</th>
                        <th border="1px solid black">CPF</th>
                        <th border="1px solid black" colspan="3">Página de Edição</th>
                        <tr>
                            <?php
                            $sql_listagem = "SELECT id_cliente, nome, cpf FROM clientes";
                            $res = mysqli_query($conn, $sql_listagem);
                            if ($res) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    echo "<tr>
                    <td>" . $row['id_cliente'] . "</td>
                    <td>" . $row['nome'] . "</td>
                    <td>" . $row['cpf'] . "</td>
                    <td colspan='3'><a href='listarClientes.php?id_cliente="
                                        . $row['id_cliente'] . "'>Informações</a></td>
                                        </tr>";
                                }
                            }
                            ?>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </section>
    <footer><i class="fa-regular fa-copyright" style="color: #ffffff;">
        </i> - All rights reserved - recuse imitações!!!!</footer>
</body>
<?php $conn->close(); ?>

</html>