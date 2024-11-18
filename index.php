<?php
include "db_connect.php";
session_start();
echo "tela index";
if (!isset($_SESSION["nome"])){
    session_destroy();  
    header("Location: login.php");
    exit();
};
    $id_usuario = $_SESSION['id_usuario'];
    $stmt = $conn->prepare("SELECT * FROM chamados INNER JOIN usuarios ON usuarios.id_usuario = chamados.fk_usuario"); //WHERE usuarios.id_usuario = ?
   //  $stmt->bind_param("i",  $id_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "
        <table class='table'>
            <tr>
                <th> ID do Chamado </th>
                <th> ID do cliente </th>
                <th> Email do cliente </th>
                <th> Telefone do cliente </th>
                <th> ID do colaborador (Pode estar vazio) </th>
                <th> Descrição do chamado </th>
                <th> Status do chamado </th>
                <th> Criticidade do chamado </th>
                <th> Data de abertura do chamado </th>
            </tr>
        ";
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
                    <td id='id-tabela'> {$row['id_chamado']} </td>
                    <td> {$row['fk_usuario']} </td>
                    <td> {$row['email_usuario']} </td>
                    <td> {$row['telefone_usuario']} </td>
                    <td> {$row['fk_colaborador']} </td>
                    <td> {$row['descricao_chamado']} </td>
                    <td> {$row['status_chamado']} </td>
                    <td> {$row['criticidade_chamado']} </td>
                    <td> {$row['data_abertura_chamado']}</td>
                </tr>";
    }
    echo "</tbody></table>";
} else {
    echo '
        Nenhum chamado encontrado para solicitação.';
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

</head>
<body>
    <form method="POST">
    <a href="/criar_chamado.php"><button>Criar chamado</button></a>
        <button name="atualizar">Atualizar lista</button>
        <button name="sair">Sair</button>
    </form>
</body>
</html> 