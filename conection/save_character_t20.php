<?php
/*
 * save_character_t20.php
 * Script final para salvar os dados da ficha de Tormenta 20.
 * Compatível com PHP 5.4.
 */

session_start();

require_once '../conection/db_connect.php'; // Certifique-se que este é o caminho correto

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php?status=" . urlencode("Sessão expirada."));
    exit;
}
$user_id_logado = $_SESSION['user_id'];

if (!isset($conn)) {
    header("Location: meus_personagens.php?status=" . urlencode("Erro crítico: Conexão com DB falhou."));
    exit;
}

// Lista de perícias para binding
$pericias_lista = [
    'acrobacia', 'adestramento', 'atletismo', 'atuacao', 'cavalgar', 'conhecimento',
    'cura', 'diplomacia', 'enganacao', 'fortitude', 'furtividade', 'guerra',
    'iniciativa', 'intimidacao', 'intuicao', 'investigacao', 'jogatina', 'ladinagem',
    'luta', 'misticismo', 'nobreza', 'oficio', 'percepcao', 'pilotagem',
    'pontaria', 'reflexos', 'religiao', 'sobrevivencia', 'vontade'
];

// Inicia o controle de transação (estilo PHP 5.4)
$conn->autocommit(FALSE);
$message = "Ocorreu um erro desconhecido.";
$id_para_salvar = 0;

try {
    // --- 1. PEGAR DADOS PRINCIPAIS DO PERSONAGEM ---
    $id_para_salvar = isset($_POST['personagem_id']) ? (int)$_POST['personagem_id'] : 0;
    
    $nome = isset($_POST['nome']) ? $conn->real_escape_string($_POST['nome']) : 'Novo Aventureiro';
    $nivel = isset($_POST['nivel']) ? (int)$_POST['nivel'] : 1;
    $imagem = isset($_POST['imagem_url']) ? $conn->real_escape_string($_POST['imagem_url']) : 'default_t20.jpg';
    $tibares = isset($_POST['tibares']) ? (int)$_POST['tibares'] : 0;

    $raca_id = isset($_POST['raca_id']) && !empty($_POST['raca_id']) ? (int)$_POST['raca_id'] : null;
    $classe_id = isset($_POST['classe_id']) && !empty($_POST['classe_id']) ? (int)$_POST['classe_id'] : null;
    $origem_id = isset($_POST['origem_id']) && !empty($_POST['origem_id']) ? (int)$_POST['origem_id'] : null;
    $divindade_id = isset($_POST['divindade_id']) && !empty($_POST['divindade_id']) ? (int)$_POST['divindade_id'] : null;

    $forca = isset($_POST['forca']) ? (int)$_POST['forca'] : 0;
    $destreza = isset($_POST['destreza']) ? (int)$_POST['destreza'] : 0;
    $constituicao = isset($_POST['constituicao']) ? (int)$_POST['constituicao'] : 0;
    $inteligencia = isset($_POST['inteligencia']) ? (int)$_POST['inteligencia'] : 0;
    $sabedoria = isset($_POST['sabedoria']) ? (int)$_POST['sabedoria'] : 0;
    $carisma = isset($_POST['carisma']) ? (int)$_POST['carisma'] : 0;

    $treinos = array();
    $outros_valores = array();
    foreach ($pericias_lista as $pericia) {
        $treinos[$pericia] = isset($_POST['treino_'."$pericia"]) ? 1 : 0;
        $outros_valores[$pericia] = isset($_POST['outros_."$pericia']) ? (int)$_POST['outros_."$pericia'] : 0;
    }

    // --- 2. SALVAR PERSONAGEM (INSERT ou UPDATE) ---

    $colunas_treino_sql = implode(", ", array_map(function($p) { return "treino_$p"; }, $pericias_lista));
    $colunas_outros_sql = implode(", ", array_map(function($p) { return "outros_$p"; }, $pericias_lista));
    $tipos_bind_pericias = str_repeat("i", count($pericias_lista)) . str_repeat("i", count($pericias_lista));
    $valores_bind = array();
    
    if ($id_para_salvar > 0) {
        // --- UPDATE ---
        $sql_update_set = "nome = ?, nivel = ?, imagem = ?, tibares = ?, raca_id = ?, classe_id = ?, origem_id = ?, divindade_id = ?, forca = ?, destreza = ?, constituicao = ?, inteligencia = ?, sabedoria = ?, carisma = ?";
        
        $sql_treino_set = array();
        foreach ($pericias_lista as $p) $sql_treino_set[] = "treino_$p = ?";
        
        $sql_outros_set = array();
        foreach ($pericias_lista as $p) $sql_outros_set[] = "outros_$p = ?";

        $sql_char = "UPDATE personagens_t20 SET " . $sql_update_set . ", " . implode(", ", $sql_treino_set) . ", " . implode(", ", $sql_outros_set) . " WHERE id = ? AND user_id = ?";
        
        $tipos_bind = "sisi" . "iiii" . "iiiiii" . $tipos_bind_pericias . "ii";
        
        $valores_bind[] = $tipos_bind;
        $valores_bind[] = &$nome;
        $valores_bind[] = &$nivel;
        $valores_bind[] = &$imagem;
        $valores_bind[] = &$tibares;
        $valores_bind[] = &$raca_id;
        $valores_bind[] = &$classe_id;
        $valores_bind[] = &$origem_id;
        $valores_bind[] = &$divindade_id;
        $valores_bind[] = &$forca;
        $valores_bind[] = &$destreza;
        $valores_bind[] = &$constituicao;
        $valores_bind[] = &$inteligencia;
        $valores_bind[] = &$sabedoria;
        $valores_bind[] = &$carisma;
        
        foreach ($pericias_lista as $p) $valores_bind[] = &$treinos[$p];
        foreach ($pericias_lista as $p) $valores_bind[] = &$outros_valores[$p];
        
        $valores_bind[] = &$id_para_salvar;
        $valores_bind[] = &$user_id_logado;

    } else {
        // --- INSERT ---
        $colunas_principais = "user_id, nome, nivel, imagem, tibares, raca_id, classe_id, origem_id, divindade_id, forca, destreza, constituicao, inteligencia, sabedoria, carisma";
        $placeholders_principais = "?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?";
        
        $sql_char = "INSERT INTO personagens_t20 ($colunas_principais, $colunas_treino_sql, $colunas_outros_sql) VALUES ($placeholders_principais, " . implode(", ", array_fill(0, count($pericias_lista), "?")) . ", " . implode(", ", array_fill(0, count($pericias_lista), "?")) . ")";

        $tipos_bind = "isisi" . "iiii" . "iiiiii" . $tipos_bind_pericias;
        
        $valores_bind[] = $tipos_bind;
        $valores_bind[] = &$user_id_logado;
        $valores_bind[] = &$nome;
        $valores_bind[] = &$nivel;
        $valores_bind[] = &$imagem;
        $valores_bind[] = &$tibares;
        $valores_bind[] = &$raca_id;
        $valores_bind[] = &$classe_id;
        $valores_bind[] = &$origem_id;
        $valores_bind[] = &$divindade_id;
        $valores_bind[] = &$forca;
        $valores_bind[] = &$destreza;
        $valores_bind[] = &$constituicao;
        $valores_bind[] = &$inteligencia;
        $valores_bind[] = &$sabedoria;
        $valores_bind[] = &$carisma;
        
        foreach ($pericias_lista as $p) $valores_bind[] = &$treinos[$p];
        foreach ($pericias_lista as $p) $valores_bind[] = &$outros_valores[$p];
    }
    
    $stmt_char = $conn->prepare($sql_char);
    if ($stmt_char === false) {
        throw new Exception("Falha ao preparar a query do personagem: " . $conn->error);
    }
    
    call_user_func_array(array($stmt_char, 'bind_param'), $valores_bind);
    
    if (!$stmt_char->execute()) {
        throw new Exception("Falha ao salvar personagem: " . $stmt_char->error);
    }

    if ($id_para_salvar == 0) {
        $id_para_salvar = $conn->insert_id;
    }
    $stmt_char->close();

    // --- 3. LIMPAR E SALVAR PODERES ESCOLHIDOS ---
    $sql_delete_poderes = "DELETE FROM personagem_t20_poderes WHERE personagem_id = ?";
    $stmt_delete_poderes = $conn->prepare($sql_delete_poderes);
    $stmt_delete_poderes->bind_param("i", $id_para_salvar);
    $stmt_delete_poderes->execute();
    $stmt_delete_poderes->close();

    $poderes_ids = isset($_POST['poderes_escolhidos_id']) ? $_POST['poderes_escolhidos_id'] : array();
    $poderes_tipos = isset($_POST['poderes_escolhidos_tipo']) ? $_POST['poderes_escolhidos_tipo'] : array();

    if (!empty($poderes_ids)) {
        $sql_poder = "INSERT INTO personagem_t20_poderes (personagem_id, poder_id, tipo_poder) VALUES (?, ?, ?)";
        $stmt_poder = $conn->prepare($sql_poder);
        
        $poder_id_ref = 0;
        $tipo_poder_ref = '';
        $stmt_poder->bind_param("iis", $id_para_salvar, $poder_id_ref, $tipo_poder_ref);

        foreach ($poderes_ids as $index => $poder_id) {
            if (isset($poderes_tipos[$index])) {
                $poder_id_ref = (int)$poder_id;
                $tipo_poder_ref = $poderes_tipos[$index];
                if (!$stmt_poder->execute()) {
                    throw new Exception("Falha ao salvar poder ID $poder_id_ref: " . $stmt_poder->error);
                }
            }
        }
        $stmt_poder->close();
    }

    // --- 4. LIMPAR E SALVAR INVENTÁRIO ---
    $sql_delete_inv = "DELETE FROM personagem_t20_inventario WHERE personagem_id = ?";
    $stmt_delete_inv = $conn->prepare($sql_delete_inv);
    $stmt_delete_inv->bind_param("i", $id_para_salvar);
    $stmt_delete_inv->execute();
    $stmt_delete_inv->close();

    $inv_ids = isset($_POST['inv_item_id']) ? $_POST['inv_item_id'] : array();
    $inv_qtds = isset($_POST['inv_quantidade']) ? $_POST['inv_quantidade'] : array();
    $inv_equips = isset($_POST['inv_equipado']) ? $_POST['inv_equipado'] : array();
    
    if (!empty($inv_ids)) {
        $sql_inv = "INSERT INTO personagem_t20_inventario (personagem_id, item_id, quantidade, equipado) VALUES (?, ?, ?, ?)";
        $stmt_inv = $conn->prepare($sql_inv);
        
        $item_id_ref = 0;
        $qtd_ref = 0;
        $equip_ref = 0;
        $stmt_inv->bind_param("iiii", $id_para_salvar, $item_id_ref, $qtd_ref, $equip_ref);
        
        foreach ($inv_ids as $index => $item_id) {
            $item_id_ref = (int)$item_id;
            $qtd_ref = isset($inv_qtds[$index]) ? (int)$inv_qtds[$index] : 1;
            $equip_ref = isset($inv_equips[$index]) ? (int)$inv_equips[$index] : 0;
            
            if (!$stmt_inv->execute()) {
                throw new Exception("Falha ao salvar item ID $item_id_ref: " . $stmt_inv->error);
            }
        }
        $stmt_inv->close();
    }
    
    // Se chegou até aqui, tudo certo.
    $conn->commit();
    $message = "Ficha salva com sucesso!";

} catch (Exception $e) {
    $conn->rollback();
    $message = "ERRO: " . $e->getMessage();
}

// --- 5. FINALIZAÇÃO E REDIRECIONAMENTO ---
$conn->autocommit(TRUE);
$conn->close();

// Redireciona de volta para a lista de personagens
header("Location: ../templates/meus_personagens.php?status=" . urlencode($message));
exit;
?>

