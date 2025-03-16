<?php
$host = "localhost";
$user = "root"; 
$pass = "usbw"; 
$dbname = "arca_do_aventureiro";

// Criar conexão
$conn = new mysqli($host, $user, $pass, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
