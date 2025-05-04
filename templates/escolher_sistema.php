<?php
session_start();
require_once '../header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<h2>Escolher Sistema</h2>

<form action="criar_personagem.php" method="get">
    <label>
        <input type="radio" name="sistema" value="Ordem Paranormal" required>
        Ordem Paranormal
    </label><br>
    <label>
        <input type="radio" name="sistema" value="Tormenta 20">
        Tormenta 20
    </label><br><br>
    <button type="submit">Avançar</button>
</form>
