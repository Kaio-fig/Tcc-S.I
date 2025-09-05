<?php
session_start();
require_once 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar se o usuário está logado
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    $personagem_id = isset($_POST['personagem_id']) ? intval($_POST['personagem_id']) : 0;
    
    // Coletar dados do formulário
    $nome = $_POST['nome'];
    $nex = $_POST['nex'];
    $vida = $_POST['vida'];
    $pe = $_POST['pe'];
    $san = $_POST['san'];
    $forca = $_POST['forca'];
    $agilidade = $_POST['agilidade'];
    $intelecto = $_POST['intelecto'];
    $vigor = $_POST['vigor'];
    $presenca = $_POST['presenca'];
    $pericias = json_decode($_POST['pericias'], true);
    
    // Processar upload de imagem
    $imagem = 'default.jpg';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $imagem = uniqid() . '.' . $extensao;
        move_uploaded_file($_FILES['imagem']['tmp_name'], '../uploads/' . $imagem);
        
        // Se estiver atualizando e tinha imagem anterior, deletar a antiga
        if ($personagem_id > 0) {
            $stmt = $conn->prepare("SELECT imagem FROM personagens WHERE id = ?");
            $stmt->bind_param("i", $personagem_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $personagem = $result->fetch_assoc();
            
            if ($personagem['imagem'] != 'default.jpg' && file_exists('../uploads/' . $personagem['imagem'])) {
                unlink('../uploads/' . $personagem['imagem']);
            }
        }
    }
    
    if ($personagem_id > 0) {
        // Atualizar personagem existente
        $stmt = $conn->prepare("UPDATE personagens SET nome = ?, nex = ?, vida = ?, pe = ?, san = ?, forca = ?, agilidade = ?, intelecto = ?, vigor = ?, presenca = ?, pericias = ?, imagem = ? WHERE id = ? AND user_id = ?");
        $pericias_json = json_encode($pericias);
        $stmt->bind_param("siiiiiiiiissii", $nome, $nex, $vida, $pe, $san, $forca, $agilidade, $intelecto, $vigor, $presenca, $pericias_json, $imagem, $personagem_id, $user_id);
    } else {
        // Criar novo personagem
        $stmt = $conn->prepare("INSERT INTO personagens (user_id, nome, sistema, nex, vida, pe, san, forca, agilidade, intelecto, vigor, presenca, pericias, imagem) VALUES (?, ?, 'Ordem Paranormal', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $pericias_json = json_encode($pericias);
        $stmt->bind_param("isiiiiiiiiiss", $user_id, $nome, $nex, $vida, $pe, $san, $forca, $agilidade, $intelecto, $vigor, $presenca, $pericias_json, $imagem);
    }
    
    if ($stmt->execute()) {
        $novo_id = $personagem_id > 0 ? $personagem_id : $stmt->insert_id;
        echo json_encode(['success' => true, 'personagem_id' => $novo_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar no banco de dados']);
    }
    
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Metodo nao permitido']);
}