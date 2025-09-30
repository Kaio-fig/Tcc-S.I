<?php
// Iniciar sessão e verificar login
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Conexão com o banco de dados
require_once '../conection/db_connect.php';

// Processar exclusão de item
if (isset($_GET['excluir'])) {
    $item_id = intval($_GET['excluir']);
    $user_id = $_SESSION['user_id'];

    $stmt_check = $conn->prepare("SELECT id FROM itens WHERE id = ? AND user_id = ?");
    $stmt_check->bind_param("ii", $item_id, $user_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $stmt_delete = $conn->prepare("DELETE FROM itens WHERE id = ?");
        $stmt_delete->bind_param("i", $item_id);
        $stmt_delete->execute();
        header('Location: meus_itens.php?excluido=1');
        exit;
    }
}

// Buscar todos os itens de Ordem Paranormal do usuário logado
$user_id = $_SESSION['user_id'];
$sistema_filtro = 'Ordem Paranormal'; 
$stmt = $conn->prepare("SELECT * FROM itens WHERE user_id = ? AND sistema = ? ORDER BY nome ASC");
$stmt->bind_param("is", $user_id, $sistema_filtro);
$stmt->execute();
$result = $stmt->get_result();
$itens = $result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Itens - Arca do Aventureiro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --t20-color: #8a0303; /* Cor para o botão de Tormenta 20 */
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
        .btn-t20 { background-color: var(--t20-color); }
        .btn-t20:hover { background-color: #a10e0e; transform: translateY(-2px); }
        .btn-secondary { background-color: #6c757d; }
        .btn-secondary:hover { background-color: #5a6268; transform: translateY(-2px); }
        .btn-danger { background-color: var(--danger-color); color: white; }
        
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .item-card {
            background: white; border-radius: 10px; overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            display: flex; flex-direction: column;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .item-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15); }
        .item-card-header { padding: 20px; border-bottom: 1px solid #eee; }
        .item-card-header h3 { color: var(--primary-color); margin-bottom: 5px; font-size: 1.4rem; }
        .item-card-header p { color: #666; font-style: italic; }
        .item-card-body { padding: 20px; flex-grow: 1; color: #444; font-size: 0.9rem; }
        .item-card-body .details {
            display: flex; justify-content: space-around; text-align: center;
            background-color: #f9f9f9; padding: 10px; border-radius: 5px; margin-top: 15px;
        }
        .item-card-body .details div span { font-size: 0.8rem; color: #777; text-transform: uppercase; display: block; }
        .item-card-body .details div strong { font-size: 1.2rem; }
        .item-card-footer { padding: 15px 20px; background-color: #f9f9f9; display: flex; justify-content: flex-end; gap: 10px; }
        .alert { padding: 15px; border-radius: 5px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-scroll"></i> Meus Itens</h1>
            <p>Gerencie seus itens customizados</p>
        </header>

        <?php if (isset($_GET['excluido'])): ?>
            <div class="alert alert-success">Item excluído com sucesso!</div>
        <?php endif; ?>

        <div style="text-align: center; margin-bottom: 30px;">
            <a href="item_op.php?sistema=Ordem Paranormal" class="btn btn-primary"><i class="fas fa-plus"></i> Criar Item (Ordem)</a>
            <a href="item_t20.php?sistema=Tormenta 20" class="btn btn-t20"><i class="fas fa-plus"></i> Criar Item (T20)</a>
            <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Voltar ao Dashboard</a>
        </div>

        <div class="items-grid">
            <?php if (count($itens) > 0): ?>
                <?php foreach ($itens as $item): ?>
                    <div class="item-card">
                        <div class="item-card-header">
                            <h3><?= htmlspecialchars($item['nome']) ?></h3>
                            <p><?= htmlspecialchars($item['tipo']) ?></p>
                        </div>
                        <div class="item-card-body">
                            <p><?= htmlspecialchars($item['descricao']) ?></p>
                            <div class="details">
                                <div><span>Categoria</span><strong><?= $item['categoria_op'] ?></strong></div>
                                <div><span>Espaços</span><strong><?= $item['espacos_op'] ?></strong></div>
                            </div>
                        </div>
                        <div class="item-card-footer">
                            <a href="ficha_item.php?id=<?= $item['id'] ?>" class="btn btn-secondary" style="color: #2c2c2c;">Editar</a>
                            <a href="meus_itens.php?excluir=<?= $item['id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza?')">Excluir</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; padding: 40px; background: white; border-radius: 10px; grid-column: 1 / -1;">
                    <h3>Nenhum item de Ordem Paranormal encontrado</h3>
                    <p>Você ainda não criou nenhum item para este sistema. Clique nos botões acima para começar!</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    </body>
</html>