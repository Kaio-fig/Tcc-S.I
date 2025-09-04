<?php
// criar_personagem.php
// Correção do caminho da conexão
require_once '../conection/db_connect.php';



// Verificar se o sistema foi selecionado
$sistema = isset($_GET['sistema']) ? $_GET['sistema'] : '';
if (!in_array($sistema, ['Ordem Paranormal', 'Tormenta 20'])) {
    header('Location: meus_personagens.php');
    exit;
}

// Processar criação do personagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome']);
    $nivel = intval($_POST['nivel']);
    
    if (!empty($nome) && $nivel >= 1 && $nivel <= 20) {
        // Processar upload de imagem
        $imagem = 'default.jpg';
        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
            $imagem = uniqid() . '.' . $extensao;
            move_uploaded_file($_FILES['imagem']['tmp_name'], '../uploads/' . $imagem);
        }
        
        // Inserir personagem no banco
        $stmt = $conn->prepare("INSERT INTO personagens (user_id, nome, sistema, nivel, imagem) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issis", $_SESSION['user_id'], $nome, $sistema, $nivel, $imagem);
        
        if ($stmt->execute()) {
            $personagem_id = $stmt->insert_id;
            
            // Redirecionar para a ficha do sistema
            // CORREÇÃO: Redirecionar para ficha_op.php para Ordem Paranormal
            if ($sistema === 'Ordem Paranormal') {
                header("Location: ../templates/ficha_op.php?personagem_id=$personagem_id&criado=1");
            } else {
                // Para Tormenta 20, redirecionar para ficha_t20.php (se existir)
                header("Location: ../templates/ficha_t20.php?personagem_id=$personagem_id&criado=1");
            }
            exit;
        } else {
            $erro = "Erro ao criar personagem. Tente novamente.";
        }
    } else {
        $erro = "Por favor, preencha todos os campos corretamente.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Personagem - Arca do Aventureiro</title>
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
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
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

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--dark-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1rem;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(106, 27, 154, 0.2);
        }

        .alert {
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }

        .image-preview {
            width: 150px;
            height: 150px;
            border: 2px dashed #ddd;
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            overflow: hidden;
        }

        .image-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-preview i {
            font-size: 3rem;
            color: #9e9e9e;
        }

        .form-actions {
            text-align: center;
            margin-top: 30px;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-plus-circle"></i> Criar Personagem</h1>
            <p>Sistema: <?php echo htmlspecialchars($sistema); ?></p>
        </header>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger">
                <?php echo $erro; ?>
            </div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome do Personagem</label>
                <input type="text" id="nome" name="nome" required maxlength="100">
            </div>

            <div class="form-group">
                <label for="nivel">Nível</label>
                <select id="nivel" name="nivel" required>
                    <option value="">Selecione o nível</option>
                    <?php for ($i = 1; $i <= 20; $i++): ?>
                        <option value="<?php echo $i; ?>">Nível <?php echo $i; ?> (NEX <?php echo $i * 5; ?>%)</option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="imagem">Imagem do Personagem (Opcional)</label>
                <div class="image-preview" id="image-preview">
                    <i class="fas fa-user-circle"></i>
                </div>
                <input type="file" id="imagem" name="imagem" accept="image/*">
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-check"></i> Criar Personagem
                </button>
                <a href="meus_personagens.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>

    <script>
        // Preview da imagem
        document.getElementById('imagem').addEventListener('change', function(e) {
            const preview = document.getElementById('image-preview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '<i class="fas fa-user-circle"></i>';
            }
        });
    </script>
</body>
</html>