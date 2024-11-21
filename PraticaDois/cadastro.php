<?php
include "db_connect.php";
echo "tela cadastro";
session_start();
if (isset($_POST["cadastrar"])) {
    $login_usuario = $_POST['login'];
    $senha_usuario = $_POST['senha'];
    $email_usuario = $_POST['email'];
    $telefone_usuario = $_POST['telefone'];
    $cpf_usuario = $_POST['cpf'];


    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE nome_usuario = ? OR email_usuario = ? OR cpf_usuario = ?");
    $stmt->bind_param("sss",  $login_usuario, $email_usuario, $cpf_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    if ($resultado->num_rows > 0) {
        echo "<br>Um usuário com este nome ou email já existe";
      } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nome_usuario, senha_usuario, email_usuario, telefone_usuario, tipo_usuario, cpf_usuario) VALUES (?, ?, ?, ?, 'cliente', ?)");
        $stmt->bind_param("sssis", $login_usuario, $senha_usuario, $email_usuario, $telefone_usuario, $cpf_usuario);
        $stmt->execute();
        $sql = "INSERT INTO usuarios (nome_usuario, senha_usuario, email_usuario, telefone_usuario, tipo_usuario, cpf_usuario) VALUES ('$login_usuario', '$senha_usuario', '$email_usuario', $telefone_usuario, 'cliente', '$cpf_usuario');";
        
        if ($conn->query($sql) === TRUE) {
            echo "<div style='color: green;'>Cadastro realizado com sucesso!</div>";
            header("Location: login.php");
            exit();
        } else {
            echo "<div style='color: red;'>Erro: " . $conn->error . "</div>";
        }
       
    };
   
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

</head>
<body>
    <form method="POST">
        <div>
            <label for="login">Digite seu nome de usuário</label>
            <input type="text" name="login">
        </div>
        <div>
            <label for="email">Digite seu email</label>
            <input type="text" name="email" id="">
        </div>
        <div>
            <label for="telefone">Digite seu telefone</label>
            <input type="number" name="telefone" id="">
        </div>
        <div>
            <label for="cpf">Digite seu CPF</label>
            <input type="text" name="cpf" id="">
        </div>
        <div>
            <label for="senha">Digite sua senha</label>
            <input type="text" name="senha" id="">
        </div>
        
        <input type="submit" value="cadastrar" name="cadastrar">
    </form>

    <a href="index.php"><button>Voltar</button></a>

</body>
</html> 