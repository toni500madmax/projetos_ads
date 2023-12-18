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
//redirecionar para a página de login
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
$novo_nome = "";
$novo_cpf = "";
$novo_telefone = "";
$novo_dtnasc = "";
$novo_genero = "";
$id_auto = "";
$novo_nome_carro = "";
$novo_placa = "";
$cad_cliente = $id_cliente;

if (isset($_GET['id_cliente'])) {
    $id_cliente = $_GET['id_cliente'];
    $slq_id = "SELECT * FROM 
                clientes, automoveis WHERE id_cliente = '$id_cliente' AND cad_cliente = '$id_cliente'";

    $resp = mysqli_query($conn, $slq_id);
    $row = mysqli_fetch_assoc($resp);

    $id_cliente = $_GET['id_cliente'];
    $novo_nome = $row['nome'];
    $novo_cpf = $row['cpf'];
    $novo_telefone = $row['telefone'];
    $novo_dtnasc = $row['dtnasc'];
    $novo_genero = $row['genero'];
    $id_auto = $row['id_auto'];
    $novo_nome_carro = $row['nome_carro'];
    $novo_placa = $row['placa'];
    $cad_cliente = $id_cliente;
    /* var_dump($row); */
} else {
    echo "Erro em captar o ID do Cliente! Entre em contato com suporte.";
}
?>
<!DOCTYPE html>
<html lang="en">

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
        </div>
    </header>
    <section>
        <div class="portal-menu">
            <h1>Escolha uma opção:</h1>
            <button onclick="document.getElementById('informações').style.display='block', 
            document.getElementById('atualizar').style.display='none',  
            document.getElementById('excluir').style.display='none';" class="active">
                Informações
            </button>
            <button onclick="document.getElementById('atualizar').style.display='block',
             document.getElementById('informações').style.display='none',
             document.getElementById('excluir').style.display='none'">
                Atualizar
            </button>
            <button onclick="document.getElementById('excluir').style.display='block',
             document.getElementById('informações').style.display='none',
             document.getElementById('atualizar').style.display='none';">
                Excluir
            </button>
        </div>
        <div class="portal-display" style="display: block;">
            <div id="informações" class="informações">
                <table border="2px;" style="background-color: #6d6d6d; 
                                                            color: black; font-weight: bolder;
                                                            width: 100%; text-align: center; 
                                                            border: 2px solid black">
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Automovel</th>
                    <th>Placa</th>
                    <th colspan="3">Serviços Prestados</th>
                    <?php
                    $sql_listagem = "SELECT *, CONCAT(nome_servico, ': ', descricao) AS 'servicos prestados' 
                        FROM clientes, automoveis, servicos 
                        WHERE id_cliente = '$id_cliente' 
                        AND automoveis.cad_cliente = '$id_cliente'
                        AND servicos.cad_cliente = '$id_cliente'";

                    $resp1 = mysqli_query($conn, $sql_listagem);
                    if ($resp1) {
                        while ($row = mysqli_fetch_assoc($resp1)) {
                            echo "<tr>
                                            <td>" . $row['id_cliente'] . "</td>
                                            <td>" . $row['nome'] . "</td>
                                            <td>" . $row['nome_carro'] . "</td>
                                            <td>" . $row['placa'] . "</td>
                                            <td colspan='3'>" . $row['servicos prestados'] . "</td>
                                                </tr>";
                        }
                    }
                    ?>
                </table>
            </div>
            <div id="atualizar" class="cadcliente" style="display: none;">
                <form action="atualizarCliente.php" method="post">
                    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                    <label for="nome">Digite o nome:</label>
                    <input type="text" name="nome" value="<?php echo $novo_nome ?>">
                    <label for="cpf">Digite o CPF:</label>
                    <input type="text" name="cpf" value="<?php echo $novo_cpf ?>">
                    <label for="telefone">Digite o telefone:</label>
                    <input type="text" name="telefone" value="<?php echo $novo_telefone ?>">
                    <div class="dt">
                        <label for="dtnasc">Digite a data de nascimento:</label>
                        <input type="date" name="dtnasc" value="<?php echo $novo_dtnasc ?>"><br>
                    </div>
                    <div class="gen">
                        <label for="genero">Escolha o Genero:</label>
                        <select name="genero">
                            <option value="Masculino" <?php if ($novo_genero == "Masculino") {
                                                            echo "selected";
                                                        } ?>>Masculino</option>
                            <option value="Feminino" <?php if ($novo_genero == "Feminino") {
                                                            echo "selected";
                                                        } ?>>Feminino</option>
                        </select>

                    </div>
                    <input type="hidden" name="id_auto">
                    <label for="auto">Adicionar automóvel:</label>
                    <input type="text" name="nome_carro" value="<?php echo $novo_nome_carro ?>">
                    <label for="placa">Placa</label>
                    <input type="text" name="placa" value="<?php echo $novo_placa ?>">
                    <input type="hidden" name="cad_cliente" value="<?php $id_cliente ?>">
                    <button type="submit">Enviar</button>
                </form>
            </div>
            <div id="excluir" class="excluir" style="display: none;">
                <h1>Excluir todas as Informações sobre: <strong><?php echo $novo_nome ?></strong></h1>
                <form action="excluirCliente.php" method="get" style="border: none; box-shadow: none; background-color: transparent;">
                    <input type="hidden" name="id_cliente" value="<?php echo $id_cliente ?>">
                    <button type="submit">Excluir todos os registros de <?php echo $novo_nome ?>.</button>
                </form>
                <div class="btncancel">
                    <a href="portal.php"><button class="cancelbtn">Cancelar e Sair do Editor</button></a>
                </div>
            </div>
        </div>
    </section>
    <footer><i class="fa-regular fa-copyright" style="color: #ffffff;">
        </i> - All rights reserved - recuse imitações!!!!</footer>
</body>


</html>