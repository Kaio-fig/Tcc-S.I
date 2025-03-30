<?php
session_start();
if (!isset($_SESSION["usuario"])) {
    header("Location: ../templates/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Arca do Aventureiro</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav>
                <a href="#" class="logo">Arca do Aventureiro</a>
                <ul class="nav-links">
                    <li><a class="a" href="#personagens">Personagens</a></li>
                    <li><a class="a" href="#mundos">Mundos</a></li>
                    <li><a class="a" href="#itens">Itens</a></li>
                    <li><a class="a" href="#historias">Histórias</a></li>
                    <li><a class="a" href="../conection/logout.php" class="btn btn-secondary">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main>
        <section class="dashboard">
            <h1>Bem-vindo, <?php echo $_SESSION["usuario"]; ?>!</h1>
            <p>Aqui você pode gerenciar suas campanhas de RPG.</p>
            <div class="dashboard-grid">
                <div class="dashboard-card" id="personagens">
                    <h2>Personagens</h2>
                    <p>Gerencie suas fichas e atributos.</p>
                </div>
                <div class="dashboard-card" id="mundos">
                    <h2>Mundos</h2>
                    <p>Crie e compartilhe cenários de campanha.</p>
                </div>
                <div class="dashboard-card" id="itens">
                    <h2>Itens</h2>
                    <p>Catalogue equipamentos e tesouros.</p>
                </div>
                <div class="dashboard-card" id="historias">
                    <h2>Histórias</h2>
                    <p>Documente as aventuras dos jogadores.</p>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
