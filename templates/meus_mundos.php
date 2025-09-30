<?php
// Iniciar sessão e verificar login
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Conexão com o banco de dados
require_once '../conection/db_connect.php';

// Processar exclusão de mundo
if (isset($_GET['excluir'])) {
    $mundo_id = intval($_GET['excluir']);
    $user_id = $_SESSION['user_id'];

    // Verifica se o mundo pertence ao usuário antes de deletar
    $stmt_check = $conn->prepare("SELECT id FROM mundos WHERE id = ? AND user_id = ?");
    $stmt_check->bind_param("ii", $mundo_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $stmt_delete = $conn->prepare("DELETE FROM mundos WHERE id = ?");
        $stmt_delete->bind_param("i", $mundo_id);
        $stmt_delete->execute();
        header('Location: meus_mundos.php?excluido=1');
        exit;
    }
}

// Buscar todos os mundos do usuário logado
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM mundos WHERE user_id = ? ORDER BY nome ASC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$mundos = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Mundos - Arca do Aventureiro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilo consistente com as outras páginas "Meus..." */
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --danger-color: #f44336;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', sans-serif; }
        body { background-color: #f9f9f9; color: var(--dark-color); padding: 20px; }
        .container { width: 90%; max-width: 1200px; margin: 0 auto; }
        header { text-align: center; padding: 20px 0; margin-bottom: 30px; }
        h1 { font-size: 2.5rem; color: var(--primary-color); }
        .btn {
            display: inline-block; padding: 10px 20px; border-radius: 5px;
            font-weight: 600; transition: all 0.3s ease;
            margin: 5px; text-decoration: none; color: white;
            border: none; cursor: pointer;
        }
        .btn i { margin-right: 8px; }
        .btn-primary { background-color: var(--primary-color); }
        .btn-primary:hover { background-color: #7b1fa2; transform: translateY(-2px); }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #5a6268; transform: translateY(-2px); }
        .btn-danger { background-color: var(--danger-color); color: white; }
        
        .mundos-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }
        .mundo-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .mundo-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.12); }
        
        .mundo-imagem {
            height: 180px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
            font-size: 4rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .mundo-imagem img { width: 100%; height: 100%; object-fit: cover; }

        .mundo-info {
            padding: 20px;
            flex-grow: 1;
        }
        .mundo-info h3 { color: var(--primary-color); margin-bottom: 5px; font-size: 1.5rem; }
        .mundo-info .sistema {
            font-size: 0.9rem;
            font-weight: bold;
            color: #6c757d;
            margin-bottom: 15px;
        }
        .mundo-info .descricao { font-size: 1rem; color: #333; line-height: 1.6; }

        .mundo-footer {
            padding: 15px 20px;
            background-color: #f9f9f9;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-globe-americas"></i> Meus Mundos</h1>
            <p>Gerencie seus universos e cenários de campanha</p>
        </header>

        <?php if (isset($_GET['excluido'])): ?>
            <div class="alert alert-success">Mundo excluído com sucesso!</div>
        <?php endif; ?>

        <div style="text-align: center; margin-bottom: 30px;">
            <a href="novo_mundo.php" class="btn btn-primary"><i class="fas fa-plus"></i> Criar Novo Mundo</a>
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>
        </div>

        <?php if (count($mundos) > 0): ?>
            <div class="mundos-grid">
                <?php foreach ($mundos as $mundo): ?>
                    <div class="mundo-card">
                        <div class="mundo-imagem">
                            <?php if ($mundo['imagem_mundo'] && $mundo['imagem_mundo'] != 'default_mundo.jpg'): ?>
                                <img src="../uploads/<?= htmlspecialchars($mundo['imagem_mundo']) ?>" alt="Imagem do Mundo">
                            <?php else: ?>
                                <i class="fas fa-map-marked-alt"></i>
                            <?php endif; ?>
                        </div>
                        <div class="mundo-info">
                            <h3><?= htmlspecialchars($mundo['nome']) ?></h3>
                            <p class="sistema"><?= htmlspecialchars($mundo['sistema_jogo']) ?></p>
                            <p class="descricao"><?= htmlspecialchars($mundo['descricao']) ?></p>
                        </div>
                        <div class="mundo-footer">
                            <a href="ficha_mundo.php?id=<?= $mundo['id'] ?>" class="btn btn-secondary" style="color: #2c2c2c;">Editar</a>
                            <a href="meus_mundos.php?excluir=<?= $mundo['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este mundo?')">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: white; border-radius: 10px;">
                <h3>Nenhum mundo encontrado</h3>
                <p>Você ainda não criou nenhum mundo. Clique no botão "Criar Novo Mundo" para começar sua primeira saga!</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>