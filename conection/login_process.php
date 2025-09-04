<?php
// login_process.php
include 'db_connect.php';

// Iniciar a sessão no início do script
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $senha = md5($_POST["senha"]); // Criptografar a senha para comparar

    $sql = "SELECT id, nome_usuario, senha FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome_usuario, $senha_armazenada);
        $stmt->fetch();

        if ($senha === $senha_armazenada) {
            // Configurar todas as variáveis de sessão necessárias
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nome_usuario;
            $_SESSION['user_email'] = $email;
            $_SESSION['logged_in'] = true;
            
            // Redirecionar para o dashboard
            header("Location: ../templates/dashboard.php");
            exit();
        } else {
            // Senha incorreta - redirecionar de volta para login com mensagem de erro
            header("Location: ../templates/login.php?erro=senha");
            exit();
        }
    } else {
        // Usuário não encontrado - redirecionar de volta para login com mensagem de erro
        header("Location: ../templates/login.php?erro=usuario");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    // Se não for POST, redirecionar para login
    header("Location: ../templates/login.php");
    exit();
}
?>