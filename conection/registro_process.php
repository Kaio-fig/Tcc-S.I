<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_usuario = $_POST["nome_usuario"];
    $email = $_POST["email"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome_usuario, email, senha_hash) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome_usuario, $email, $senha);

    if ($stmt->execute()) {
        echo "Registro realizado com sucesso!";
    } else {
        echo "Erro ao registrar: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
