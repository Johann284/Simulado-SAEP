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
    $stmt = $conn->prepare("SELECT * FROM solicitacoes INNER JOIN usuarios ON usuarios.id_usuario = solicitacoes.fk_usuario");
    $stmt->execute();
    $resultado = $stmt->get_result();



if ($resultado->num_rows > 0) {
    echo "
        <table border='1'>
            <tr>
                <th> ID do solicitacao </th>
                <th> ID do cliente </th>
                <th> Email do cliente </th>
                <th> Telefone do cliente </th>
                <th> CPF do cliente </th>
                <th> ID do colaborador (Pode estar vazio) </th>
                <th> Descrição do solicitacao </th>
                <th> Status do solicitacao </th>
                <th> Criticidade do solicitacao </th>
                <th> Data de abertura do solicitacao </th>
                <th> Opções </th>                
            </tr>
        ";
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>
                    <td> {$row['id_solicitacao']} </td>
                    <td> {$row['fk_usuario']} </td>
                    <td> {$row['email_usuario']} </td>
                    <td> {$row['telefone_usuario']} </td>
                    <td> {$row['cpf_usuario']} </td>
                    <td> {$row['fk_colaborador']} </td>
                    <td> {$row['descricao_solicitacao']} </td>
                    <td> {$row['status_solicitacao']} </td>
                    <td> {$row['criticidade_solicitacao']} </td>
                    <td> {$row['data_abertura_solicitacao']}</td>
                    <td> <form method='POST' action=''>
                            <input type='hidden' name='id_solicitacao' value='{$row['id_solicitacao']}'>
                            <input type='submit' name='deletar' value='Deletar solicitação'>
                        </form>
                        <form method='POST' action=''>
                            <input type='hidden' name='id_solicitacao' value='{$row['id_solicitacao']}'>
                            <input type='submit' name='pegar' value='Pegar solicitação'>
                        </form>
                        </td>
                </tr>";
    }
    echo "</tbody></table>";
} else {
    echo '
        Nenhum solicitação encontrado para solicitação.';
}
if (isset($_POST["deletar"])){
    $id_solicitacao = $_POST['id_solicitacao'];
    $sql = "DELETE FROM solicitacoes WHERE id_solicitacao = ?";

    $stmt_deletar = $conn->prepare($sql);
    $stmt_deletar->bind_param('i', $id_solicitacao);
    $stmt_deletar->execute();

    if ($stmt_deletar->affected_rows > 0) {
        echo "Registro deletado com sucesso!";
        echo "<br>Talvez seja necessário atualizar a página!";
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao deletar o registro.";
    }
};

if (isset($_POST["pegar"])){
    $id_solicitacao = $_POST['id_solicitacao'];
    $sql = "UPDATE solicitacoes SET fk_colaborador = ? WHERE id_solicitacao = ?";

    $stmt_alterar = $conn->prepare($sql);
    $stmt_alterar->bind_param('ii', $id_usuario, $id_solicitacao);
    $stmt_alterar->execute();

    if ($stmt_alterar->affected_rows > 0) {
        echo "Chamado coletado pelo seu ID!";
        echo "<br>Talvez seja necessário atualizar a página!";
        header("Location: index.php");
        exit();
    } else {
        echo "Erro ao coletar registro.";
    }
};

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

</head>
<body>
    <br>
    <a href="criar_solicitacao.php"><button>Criar solicitação</button></a>
    <br>
    <a href="login.php"><button>Voltar</button></a>


</body>
</html> 