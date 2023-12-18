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


$id_cliente = $_GET['id_cliente'];
$cad_cliente = $_GET['cad_cliente'];
$id_servico = "";
$nome_servico = "";
$descricao = "";
$custo = "";
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
            <div class="btncancel">
                <a href="portal.php"><button class="cancelbtn">Voltar</button></a>
            </div>
    </header>
    <section>
        <div class="portal-menu">
            <h1>Escolha uma opção:</h1>
            <?php
            $id_cliente = $_GET['id_cliente'];
            $cad_cliente = $_GET['cad_cliente'];
            $id_servico = $_GET['id_servico'];
            ?>
            <h3>Id do cliente é >> <?php echo $id_cliente ?>.</h3>
            <button onclick="document.getElementById('inserir').style.display='block',
             document.getElementById('editar').style.display='none',
             document.getElementById('tabela').style.display='none',
             document.getElementById('excluir').style.display='none';">
                Cadastro de Serviços
            </button>
            <button onclick="document.getElementById('editar').style.display='block',
            document.getElementById('inserir').style.display='none',
            document.getElementById('tabela').style.display='none',
            document.getElementById('excluir').style.display='none';">
                Editar Serviços
            </button>
            <button onclick=" document.getElementById('excluir').style.display='block',
             document.getElementById('inserir').style.display='none',
             document.getElementById('tabela').style.display='none',
             document.getElementById('editar').style.display='none'">
                Excluir Serviços
            </button>
        </div>
        <div class=" portal-display">
            <div id="tabela" class="tabela" style="display: block;">
                <table border="1px solid black" style="text-align: center;">
                    <th border="1px solid black">ID</th>
                    <th border="1px solid black">ID Serviço</th>
                    <th border="1px solid black">Nome Cliente</th>
                    <th border="1px solid black">Serviço</th>
                    <th border="1px solid black">Descrição do Serviço</th>
                    <th border="1px solid black">Custo</th>
                    <tr>
                        <?php
                        $id_cliente = $_GET['id_cliente'];
                        $cad_cliente = $_GET['cad_cliente'];
                        $sql_listar = "SELECT clientes.id_cliente, clientes.nome,
                                    servicos.id_servico, servicos.cad_cliente,
                                    servicos.nome_servico, servicos.descricao,
                                    servicos.custo FROM servicos
                                    INNER JOIN clientes
                                    ON clientes.id_cliente = servicos.cad_cliente
                                    WHERE clientes.id_cliente = '$id_cliente'
                                    AND servicos.id_servico = '$id_servico';";
                        $res = mysqli_query($conn, $sql_listar);
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                echo "<tr>
                                    <td>" . $row['id_cliente'] . "</td>
                                    <td>" . $row['id_servico'] . "</td>
                                    <td>" . $row['nome'] . "</td>
                                    <td>" . $row['nome_servico'] . "</td>
                                    <td>" . $row['descricao'] . "</td>
                                    <td>" . $row['custo'] . "</td></tr>";
                            }
                        } ?>
                    </tr>
                </table>
            </div>
            <div id="inserir" class="inserir-servico" style="display: none; position: absolute; 
                                            width: 847px;
                                            height: 321px; overflow-y: scroll;">
                <form action="inserirServico.php" method="get">
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

                    $id_servico = "";
                    $obt_id = "SELECT MAX(id_servico) AS novo_id FROM servicos;";
                    $resultado = $mysqli->query($obt_id);
                    if ($resultado->num_rows > 0) {
                        if ($row = $resultado->fetch_assoc()) {
                            $id_servico = $row['novo_id'] + 1;
                        } else {
                            $id_servico = 1;
                        }
                    }
                    if (isset($_GET['id_cliente']) || isset($_GET['cad_cliente'])) {
                        $id_cliente = $_GET['id_cliente'];
                        $cad_cliente = $_GET['cad_cliente'];
                        $slq_id = "SELECT * FROM 
                                    clientes, servicos WHERE id_cliente = '$id_cliente' 
                                    AND cad_cliente = '$id_cliente'";

                        $resp = mysqli_query($conn, $slq_id);
                        if (
                            isset($_get['nome_servico']) || isset($_get['descricao'])
                            || isset($_get['custo'])
                        ) {
                            $row = mysqli_fetch_assoc($resp);
                            $id_cliente = $_GET['id_cliente'];
                            $cad_cliente = $row['cad_cliente'];
                            $nome_servico = $row['nome_servico'];
                            $descricao = $row['descricao'];
                            $custo = $row['custo'];
                        }
                        /* var_dump($row); */
                    } else {
                        echo "Erro em captar o ID do Cliente! Entre em contato com suporte.";
                    }
                    ?>
                    <input type="hidden" name="id_servico" value="">
                    <input type="hidden" name="cad_cliente" value="<?php echo $cad_cliente ?>">
                    <label for="nome_servico">Digite o nome do serviço:</label>
                    <input type="text" name="nome_servico" value="">
                    <label for="descricao">Descrição do serviço:</label>
                    <input type="text" name="descricao" value="">
                    <label for="id_cliente">Custo do serviço:</label>
                    <input type="text" name="custo" value="">
                    <button type="submit" onclick="document.getElementById('inserir').style.display='none',
                    document.getElementById('tabela').style.display = 'block';">Inserir Serviço</button>
                </form>
                <button class="cancelbtn" style="width: 100%;" onclick="document.getElementById('inserir').style.display='none',
                document.getElementById('tabela').style.display='block';">
                    Cancelar Inserção</button>
            </div>
            <div id="editar" class="editar-servico" style="display: none;
                                                       width: 100%;
                                                       height: 320px;
                                                       overflow-y: scroll;">
                <?php
                if (isset($_GET['cad_cliente'])) {
                    $cad_cliente = $_GET['cad_cliente'];
                    $id_servico = $_GET['id_servico'];
                    $slq_id = "SELECT * FROM
                servicos, clientes WHERE id_cliente = '$id_cliente' 
                AND cad_cliente = '$id_cliente'
                AND id_servico = '$id_servico'";

                    $resp = mysqli_query($conn, $slq_id);
                    $row = mysqli_fetch_assoc($resp);

                    $id_cliente = $_GET['id_cliente'];
                    $cad_cliente = $row['cad_cliente'];
                    $nome_servico = $row['nome_servico'];
                    $descricao = $row['descricao'];
                    $custo = $row['custo'];
                } else {
                    echo "Erro em captar o ID do Cliente! Entre em contato com suporte.";
                }
                ?>

                <form action="atualizarServico.php" method="get">
                    <label for="id_servico">Digite o ID do serviço para atualiza-lo:</label>
                    <input type="text" name="id_servico" value="<?php echo $id_servico ?>">
                    <input type="hidden" name="cad_cliente" value="<?php echo $cad_cliente ?>">
                    <label for="nome">Digite o nome do serviço:</label>
                    <input type="text" name="nome_servico" value="<?php echo $nome_servico ?>">
                    <label for="cpf">Digite a descrição do serviço:</label>
                    <input type="text" name="descricao" value="<?php echo $descricao ?>">
                    <label for="telefone">Digite o custo do serviço:</label>
                    <input type="text" name="custo" value="<?php echo $custo ?>">
                    <button type="submit">Atualizar Serviço</button>
                </form>
                <button class="cancelbtn" style="width: 100%;" onclick="document.getElementById('editar').style.display='none',
                document.getElementById('tabela').style.display='block';">
                    Cancelar Inserção</button>
            </div>
            <div id="excluir" class="excluir-servico"></div>
        </div>
    </section>
    <footer><i class="fa-regular fa-copyright" style="color: #ffffff;">
        </i> - All rights reserved - recuse imitações!!!!</footer>
</body>
<?php $conn->close(); ?>

</html>