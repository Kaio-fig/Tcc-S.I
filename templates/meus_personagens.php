<?php
// meus_personagens.php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}

require_once '../conection/db_connect.php';

if (isset($_GET['excluir'])) {
    $personagem_id = intval($_GET['excluir']);
    $stmt_check = $conn->prepare("SELECT user_id FROM personagens_op WHERE id = ?");
    $stmt_check->bind_param("i", $personagem_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $personagem = $result_check->fetch_assoc();

    if ($personagem && $personagem['user_id'] == $_SESSION['user_id']) {
        $stmt_delete = $conn->prepare("DELETE FROM personagens_op WHERE id = ?");
        $stmt_delete->bind_param("i", $personagem_id);
        $stmt_delete->execute();
        header('Location: meus_personagens.php?excluido=1');
        exit;
    }
}

$stmt_select = $conn->prepare("SELECT id, nome, imagem, nex FROM personagens_op WHERE user_id = ? ORDER BY nome");
$stmt_select->bind_param("i", $_SESSION['user_id']);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$personagens = $result_select->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personagens de Ordem Paranormal - Arca do Aventureiro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Estilos CSS (sem alterações, igual à versão anterior) */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --success-color: #4caf50;
            --danger-color: #f44336;
        }

        body {
            background-color: #f9f9f9;
            color: var(--dark-color);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
        }

        header {
            text-align: center;
            padding: 20px 0;
            margin-bottom: 30px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-primary:hover {
            background-color: #7b1fa2;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
        }

        .btn-secondary:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .btn-danger:hover {
            background-color: #d32f2f;
            transform: translateY(-2px);
        }

        .characters-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .character-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
        }

        .character-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .character-image {
            height: 200px;
            background-color: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .character-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .character-image i {
            font-size: 4rem;
            color: #9e9e9e;
        }

        .character-info {
            padding: 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .character-info h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .character-details {
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .character-details p {
            margin-bottom: 5px;
            color: #555;
        }

        .character-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            border: 1px solid transparent;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border-color: #d6e9c6;
        }

        /* --- ESTILOS PARA O MODAL --- */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background: white;
            border-radius: 10px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            text-align: center;
        }

        .modal-header {
            margin-bottom: 20px;
        }

        .modal-header h2 {
            color: var(--primary-color);
        }

        .systems-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .system-card {
            background: var(--light-color);
            padding: 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .system-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-3px);
        }

        .system-card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .system-card p {
            color: #555;
            font-size: 0.9em;
        }

        .close-modal {
            background: var(--danger-color);
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .characters-grid {
                grid-template-columns: 1fr;
            }

            .character-actions {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-book-dead"></i> Meus Personagens</h1>
            <p>Gerencie seus Personagens</p>
        </header>

        <?php if (isset($_GET['excluido']) && $_GET['excluido'] == 1): ?>
            <div class="alert alert-success">Personagem excluído com sucesso!</div>
        <?php endif; ?>
        <?php if (isset($_GET['criado']) && $_GET['criado'] == 1): ?>
            <div class="alert alert-success">Personagem criado com sucesso!</div>
        <?php endif; ?>

        <div style="text-align: center; margin-bottom: 30px;">
            <button class="btn btn-primary" onclick="abrirModalSistemas()">
                <i class="fas fa-plus"></i> Criar Novo Personagem
            </button>
            <a href="dashboard.php" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar ao Dashboard
            </a>
        </div>

        <?php if (count($personagens) > 0): ?>
            <div class="characters-grid">
                <?php foreach ($personagens as $personagem): ?>
                    <div class="character-card">
                        <div class="character-image">
                            <?php if (!empty($personagem['imagem']) && $personagem['imagem'] != 'default.jpg' && file_exists("../uploads/" . $personagem['imagem'])): ?>
                                <img src="../uploads/<?php echo htmlspecialchars($personagem['imagem']); ?>" alt="<?php echo htmlspecialchars($personagem['nome']); ?>">
                            <?php else: ?>
                                <i class="fas fa-user-secret"></i>
                            <?php endif; ?>
                        </div>
                        <div class="character-info">
                            <h3><?php echo htmlspecialchars($personagem['nome']); ?></h3>
                            <div class="character-details">
                                <p><strong>Sistema:</strong> Ordem Paranormal</p>
                                <p><strong>NEX:</strong> <?php echo $personagem['nex']; ?>%</p>
                            </div>
                            <div class="character-actions">
                                <a href="../templates/ficha_op.php?personagem_id=<?php echo $personagem['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Ver / Editar
                                </a>
                                <a href="meus_personagens.php?excluir=<?php echo $personagem['id']; ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir este personagem?')">
                                    <i class="fas fa-trash"></i> Excluir
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 40px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                <i class="fas fa-folder-open" style="font-size: 4rem; color: #9e9e9e; margin-bottom: 20px;"></i>
                <h3>Nenhum personagem de Ordem Paranormal encontrado</h3>
                <p>Você ainda não criou nenhum agente. Clique no botão acima para começar sua jornada!</p>
            </div>
        <?php endif; ?>
    </div>

    <div class="modal" id="sistema-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Escolha o Sistema de RPG</h2>
                <p>Selecione o universo para seu novo personagem</p>
            </div>

            <div class="systems-grid">
                <div class="system-card" onclick="criarPersonagem('Ordem Paranormal')">
                    <h3><i class="fas fa-book-dead"></i> Ordem Paranormal</h3>
                    <p>Enfrente o oculto em um mundo de investigação e horror.</p>
                </div>

                <div class="system-card" onclick="criarPersonagem('Tormenta 20')">
                    <h3><i class="fas fa-dragon"></i> Tormenta 20</h3>
                    <p>Viva grandes aventuras em um cenário de fantasia épica.</p>
                </div>
            </div>

            <button class="btn close-modal" onclick="fecharModalSistemas()">Cancelar</button>
        </div>
    </div>

    <script>
        const modal = document.getElementById('sistema-modal');

        function abrirModalSistemas() {
            modal.style.display = 'flex';
        }

        function fecharModalSistemas() {
            modal.style.display = 'none';
        }

        function criarPersonagem(sistema) {
            if (sistema === 'Ordem Paranormal') {
                window.location.href = `../templates/ficha_op.php?criar_novo=1`;
            } else if (sistema === 'Tormenta 20') {
                window.location.href = `../templates/ficha_t20.php?criar_novo=1`;
            }
        }

        // Fecha o modal se o usuário clicar fora do conteúdo
        window.onclick = function(event) {
            if (event.target === modal) {
                fecharModalSistemas();
            }
        }
    </script>
</body>

</html>