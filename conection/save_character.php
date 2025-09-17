<?php
// Inicia a sessão para podermos verificar o login do usuário
session_start();

// 1. CHECAGENS DE SEGURANÇA
// ======================================================

// Verifica se o usuário está logado. Se não, interrompe o script.
if (!isset($_SESSION['user_id'])) {
    die("Acesso negado. Você precisa estar logado para salvar um personagem.");
}

// Verifica se os dados foram enviados via método POST.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método de requisição inválido.");
}

// Inclui o arquivo de conexão com o banco de dados.
require_once 'db_connect.php';

// 2. COLETA E SANITIZAÇÃO DOS DADOS DO FORMULÁRIO
// ======================================================

$personagem_id = isset($_POST['personagem_id']) && !empty($_POST['personagem_id']) ? intval($_POST['personagem_id']) : null;
$user_id = $_SESSION['user_id'];

$nome = isset($_POST['nome']) ? strip_tags($_POST['nome']) : 'Sem Nome';
$nex = isset($_POST['nex']) ? intval($_POST['nex']) : 5;
$forca = isset($_POST['forca']) ? intval($_POST['forca']) : 1;
$agilidade = isset($_POST['agilidade']) ? intval($_POST['agilidade']) : 1;
$intelecto = isset($_POST['intelecto']) ? intval($_POST['intelecto']) : 1;
$vigor = isset($_POST['vigor']) ? intval($_POST['vigor']) : 1;
$presenca = isset($_POST['presenca']) ? intval($_POST['presenca']) : 1;

// 3. LÓGICA DE UPLOAD DA IMAGEM
// ======================================================

$nome_imagem_final = null;

if ($personagem_id) {
    $stmt_old_img = $conn->prepare("SELECT imagem FROM personagens_op WHERE id = ? AND user_id = ?");
    $stmt_old_img->bind_param("ii", $personagem_id, $user_id);
    $stmt_old_img->execute();
    $result = $stmt_old_img->get_result();
    if($result->num_rows > 0){
        $nome_imagem_final = $result->fetch_assoc()['imagem'];
    }
    $stmt_old_img->close();
} else {
    $nome_imagem_final = 'default.jpg';
}

if (isset($_FILES['imagem_personagem']) && $_FILES['imagem_personagem']['error'] === 0) {
    $upload_dir = '../uploads/';
    $arquivo_temporario = $_FILES['imagem_personagem']['tmp_name'];
    
    $extensao = pathinfo($_FILES['imagem_personagem']['name'], PATHINFO_EXTENSION);
    $novo_nome_imagem = uniqid('char_', true) . '.' . strtolower($extensao);
    $caminho_final = $upload_dir . $novo_nome_imagem;

    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    if (move_uploaded_file($arquivo_temporario, $caminho_final)) {
        $nome_imagem_final = $novo_nome_imagem;
    }
}

// 4. OPERAÇÃO NO BANCO DE DADOS (INSERT ou UPDATE)
// ======================================================

if ($personagem_id) {
    // ATUALIZAR PERSONAGEM EXISTENTE
    $sql = "UPDATE personagens_op SET nome = ?, nex = ?, forca = ?, agilidade = ?, intelecto = ?, vigor = ?, presenca = ?, imagem = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siiiiissii", $nome, $nex, $forca, $agilidade, $intelecto, $vigor, $presenca, $nome_imagem_final, $personagem_id, $user_id);

} else {
    // CRIAR NOVO PERSONAGEM
    $sql = "INSERT INTO personagens_op (user_id, nome, nex, forca, agilidade, intelecto, vigor, presenca, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isiiiiiss", $user_id, $nome, $nex, $forca, $agilidade, $intelecto, $vigor, $presenca, $nome_imagem_final);
}

if ($stmt->execute()) {
    if (!$personagem_id) {
        $personagem_id = $conn->insert_id;
    }
    header("Location: ../templates/ficha_op.php?personagem_id=" . $personagem_id . "&salvo=1");
} else {
    echo "Erro ao salvar o personagem: " . $stmt->error;
}

$stmt->close();
$conn->close();
exit();
?>