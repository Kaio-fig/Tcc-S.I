<?php
// meus_personagens.php
// Iniciar sessão e verificar login
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}


// Correção do caminho da conexão
require_once '../conection/db_connect.php';

// Processar exclusão de personagem
if (isset($_GET['excluir'])) {
    $personagem_id = intval($_GET['excluir']);
    
    // Verificar se o personagem pertence ao usuário
    $stmt = $conn->prepare("SELECT user_id FROM personagens WHERE id = ?");
    $stmt->bind_param("i", $personagem_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $personagem = $result->fetch_assoc();
    
    if ($personagem && $personagem['user_id'] == $_SESSION['user_id']) {
        $stmt = $conn->prepare("DELETE FROM personagens WHERE id = ?");
        $stmt->bind_param("i", $personagem_id);
        $stmt->execute();
        
        // Redirecionar para evitar reenvio do formulário
        header('Location: meus_personagens.php?excluido=1');
        exit;
    }
}

// Buscar personagens do usuário
$stmt = $conn->prepare("SELECT * FROM personagens WHERE user_id = ? ORDER BY nome");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$personagens = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meus Personagens - Arca do Aventureiro</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Reset e Estilos Globais */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        :root {
            --primary-color: #6a1b9a;
            --secondary-color: #9c27b0;
            --dark-color: #2c2c2c;
            --light-color: #f5f5f5;
            --success-color: #4caf50;
            --warning-color: #ff9800;
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

        /* Grid de Personagens */
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
        }

        .character-info h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 1.4rem;
        }

        .character-details {
            margin-bottom: 15px;
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

        /* Modal de Sistemas */
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
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        }

        .close-modal {
            background: var(--danger-color);
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }

        /* Mensagens de alerta */
        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .characters-grid {
                grid-template-columns: 1fr;
            }
            
            .character-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .systems-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-dragon"></i> Meus Personagens</h1>
            <p>Gerencie seus personagens de RPG</p>
        </header>

        <?php if (isset($_GET['excluido']) && $_GET['excluido'] == 1): ?>
            <div class="alert alert-success">
                Personagem excluído com sucesso!
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['criado']) && $_GET['criado'] == 1): ?>
            <div class="alert alert-success">
                Personagem criado com sucesso!
            </div>
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
                            <?php if ($personagem['imagem'] && $personagem['imagem'] != 'default.jpg'): ?>
                                <img src="../uploads/<?php echo $personagem['imagem']; ?>" alt="<?php echo htmlspecialchars($personagem['nome']); ?>">
                            <?php else: ?>
                                <i class="fas fa-user-circle"></i>
                            <?php endif; ?>
                        </div>
                        <div class="character-info">
                            <h3><?php echo htmlspecialchars($personagem['nome']); ?></h3>
                            <div class="character-details">
                                <p><strong>Sistema:</strong> <?php echo htmlspecialchars($personagem['sistema']); ?></p>
                                <p><strong>Nível:</strong> <?php echo $personagem['nivel']; ?> (NEX: <?php echo $personagem['nivel'] * 5; ?>%)</p>
                                <p><strong>Criado em:</strong> <?php echo date('d/m/Y', strtotime($personagem['data_criacao'])); ?></p>
                            </div>
                            <div class="character-actions">
                                <!-- CORREÇÃO: Caminho para ficha_op.php -->
                                <a href="../templates/ficha_op.php?personagem_id=<?php echo $personagem['id']; ?>" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Editar
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
            <div style="text-align: center; padding: 40px; background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);">
                <i class="fas fa-users" style="font-size: 4rem; color: #9e9e9e; margin-bottom: 20px;"></i>
                <h3>Nenhum personagem encontrado</h3>
                <p>Você ainda não criou nenhum personagem. Clique no botão abaixo para começar!</p>
                <button class="btn btn-primary" onclick="abrirModalSistemas()" style="margin-top: 20px;">
                    <i class="fas fa-plus"></i> Criar Primeiro Personagem
                </button>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal de seleção de sistema -->
    <div class="modal" id="sistema-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Escolha o Sistema</h2>
                <p>Selecione o sistema de RPG para seu novo personagem</p>
            </div>
            
            <div class="systems-grid">
                <div class="system-card" onclick="criarPersonagem('Ordem Paranormal')">
                    <h3>Ordem Paranormal</h3>
                    <p>Sistema de investigação paranormal e horror</p>
                </div>
                
                <div class="system-card" onclick="criarPersonagem('Tormenta 20')">
                    <h3>Tormenta 20</h3>
                    <p>Sistema de fantasia heroica brasileiro</p>
                </div>
            </div>
            
            <button class="close-modal" onclick="fecharModalSistemas()">Fechar</button>
        </div>
    </div>

    <script>
        function abrirModalSistemas() {
            document.getElementById('sistema-modal').style.display = 'flex';
        }
        
        function fecharModalSistemas() {
            document.getElementById('sistema-modal').style.display = 'none';
        }
        
        function criarPersonagem(sistema) {
            // Redirecionar para a página de criação do personagem
            // CORREÇÃO: Caminho para criar_personagem.php
            window.location.href = `criar_personagem.php?sistema=${encodeURIComponent(sistema)}`;
        }
        
        // Fechar modal ao clicar fora dele
        window.onclick = function(event) {
            const modal = document.getElementById('sistema-modal');
            if (event.target === modal) {
                fecharModalSistemas();
            }
        }
    </script>
</body>
</html>