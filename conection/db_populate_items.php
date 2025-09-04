<?php
// db_populate_items.php
require_once 'db_connect.php';

function popularTabelaArmas($conn) {
    $armas = [
        ["Faca", "1d4", "19", null, 0, 1, "C", "Curto", "Arma corpo a corpo leve"],
        ["Pistola", "1d12", "18", null, 1, 1, "B", "Curto", "Arma de fogo leve"],
        ["Revolver", "2d6", "19×3", null, 1, 1, "B", "Curto", "Arma de fogo leve"],
        ["Fuzil de caça", "2d8", "19×3", null, 1, 2, "B", "Médio", "Arma de fogo duas mãos"],
        ["Espada", "1d8/1d10", "19", null, 1, 1, "C", "-", "Arma corpo a corpo uma mão"],
        ["Machado", "1d8", "×3", null, 1, 1, "C", "-", "Arma corpo a corpo uma mão"],
        ["Submetralhadora", "2d6", "19/x3", null, 1, 1, "B", "Curto", "Arma de fogo automática"],
        ["Espingarda", "4d6", "×3", null, 1, 2, "B", "Curto", "Arma de fogo duas mãos"],
        ["Fuzil de assalto", "2d10", "19/x3", null, 2, 2, "B", "Médio", "Arma de fogo tática"],
        ["Fuzil de precisão", "2d10", "19/x3", null, 3, 2, "B", "Longo", "Arma de fogo de longo alcance"]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Op_armas (nome, dano, crit, ameaca, categoria, espaco, tipo, alcance, descricao) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($armas as $arma) {
        $stmt->bind_param("ssssiisss", $arma[0], $arma[1], $arma[2], $arma[3], $arma[4], $arma[5], $arma[6], $arma[7], $arma[8]);
        $stmt->execute();
    }
    
    echo "Tabela de armas populada com sucesso!\n";
}

function popularTabelaProtecoes($conn) {
    $protecoes = [
        ["Leve", "+5", 1, 2, "Armadura", "Proteção leve que permite boa mobilidade"],
        ["Pesada", "+10", 2, 5, "Armadura", "Proteção pesada que oferece maior defesa mas reduz mobilidade"],
        ["Escudo", "+2", 1, 2, "Escudo", "Proteção adicional que pode ser empunhada"]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Op_protecoes (nome, defesa, categoria, espaco, tipo, descricao) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($protecoes as $protecao) {
        $stmt->bind_param("ssiiss", $protecao[0], $protecao[1], $protecao[2], $protecao[3], $protecao[4], $protecao[5]);
        $stmt->execute();
    }
    
    echo "Tabela de proteções populada com sucesso!\n";
}

function popularTabelaGerais($conn) {
    $itens = [
        ["Kit Médico", "+5 em testes de Medicina", 0, 1, "Utensílio", "Equipamento médico para primeiros socorros"],
        ["Lanterna", "Iluminação em área média", 0, 1, "Ferramenta", "Fonte de luz portátil"],
        ["Rádio Comunicador", "Comunicação em até 1km", 0, 1, "Comunicação", "Dispositivo de comunicação por rádio"],
        ["Binóculos", "+2 em Percepção à distância", 0, 1, "Utensílio", "Dispositivo óptico para visão à distância"],
        ["Corda", "15m de corda resistente", 0, 1, "Utensílio", "Corda de nylon para escalada e amarração"],
        ["Máscara de gás", "Proteção contra gases", 0, 1, "Proteção", "Máscara de proteção respiratória"],
        ["Granada de Fragmentação", "4d6 de dano em área", 1, 1, "Explosivo", "Explosivo de fragmentação para múltiplos alvos"],
        ["Granada de Fumaça", "Cria área de cobertura", 0, 1, "Explosivo", "Granada que libera fumaça para ocultação"]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Op_gerais (nome, bonus, categoria, espaco, tipo, descricao) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($itens as $item) {
        $stmt->bind_param("ssiiss", $item[0], $item[1], $item[2], $item[3], $item[4], $item[5]);
        $stmt->execute();
    }
    
    echo "Tabela de itens gerais populada com sucesso!\n";
}

function popularTabelaParanormal($conn) {
    $itens = [
        ["Amuleto de Proteção", "Fornece +2 em Defesa", 1, 1, "Conhecimento", "Amuleto que oferece proteção contra ataques"],
        ["Anel do Elo Mental", "Permite comunicação telepática", 2, 1, "Conhecimento", "Par de anéis que conecta mentalmente os usuários"],
        ["Pérola de Sangue", "Fornece +5 em testes físicos temporariamente", 2, 1, "Sangue", "Esfera que injeta adrenalina no usuário"],
        ["Máscara das Sombras", "Permite teletransporte entre sombras", 3, 1, "Morte", "Máscara que concede habilidades de manipulação de sombras"],
        ["Coração Pulsante", "Reduz dano pela metade uma vez por cena", 2, 1, "Sangue", "Coração humano preservado que pulsa com energia de Sangue"],
        ["Frasco de Vitalidade", "Armazena PV para recuperação posterior", 1, 1, "Sangue", "Frasco que pode armazenar sangue para uso posterior"]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Op_paranormal (nome, efeito, categoria, espaco, elemento, descricao) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($itens as $item) {
        $stmt->bind_param("ssiiss", $item[0], $item[1], $item[2], $item[3], $item[4], $item[5]);
        $stmt->execute();
    }
    
    echo "Tabela de itens paranormais populada com sucesso!\n";
}

function popularTabelaModificacoes($conn) {
    $modificacoes = [
        // Modificações para armas
        ["Certeira", "arma", "+2 em testes de ataque", 1, "Modificação que melhora a precisão da arma"],
        ["Cruel", "arma", "+2 em rolagens de dano", 1, "Modificação que aumenta o dano causado"],
        ["Discreta", "arma", "+5 em testes para ser ocultada e reduz o espaço em -1", 0, "Modificação que torna a arma mais fácil de ocultar"],
        ["Perigosa", "arma", "+2 em margem de ameaça", 1, "Modificação que aumenta a chance de acerto crítico"],
        ["Alongada", "arma", "+2 em testes de ataque", 1, "Modificação para armas de fogo que aumenta o alcance"],
        ["Calibre Grosso", "arma", "Aumenta o dano em mais um dado do mesmo tipo", 1, "Modificação que aumenta o calibre da arma"],
        
        // Modificações para proteções
        ["Antibombas", "protecao", "+5 em testes de resistência contra efeitos de área", 1, "Modificação que oferece proteção contra explosões"],
        ["Blindada", "protecao", "Aumenta RD para 5 e o espaço em +1", 1, "Modificação que aumenta a resistência a dano"],
        ["Discreta", "protecao", "+5 em testes de ocultar e reduz o espaço em -1", 0, "Modificação que torna a proteção mais fácil de ocultar"],
        ["Reforçada", "protecao", "Aumenta a Defesa em +2 e o espaço em +1", 1, "Modificação que aumenta a proteção oferecida"],
        
        // Modificações paranormais
        ["Amaldiçoada", "paranormal", "Adiciona efeito paranormal ao item", 2, "Modificação que imbui o item com energia paranormal"],
        ["Potencializada", "paranormal", "Aumenta a potência do efeito paranormal", 1, "Modificação que amplifica os efeitos paranormais"]
    ];
    
    $stmt = $conn->prepare("INSERT INTO Op_modificacoes (nome, tipo_item, efeito, categoria_extra, descricao) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($modificacoes as $mod) {
        $stmt->bind_param("sssis", $mod[0], $mod[1], $mod[2], $mod[3], $mod[4]);
        $stmt->execute();
    }
    
    echo "Tabela de modificações populada com sucesso!\n";
}

// Executar as funções para popular as tabelas
try {
    popularTabelaArmas($conn);
    popularTabelaProtecoes($conn);
    popularTabelaGerais($conn);
    popularTabelaParanormal($conn);
    popularTabelaModificacoes($conn);
    
    echo "Todas as tabelas foram populadas com sucesso!\n";
} catch (Exception $e) {
    echo "Erro ao popular tabelas: " . $e->getMessage() . "\n";
}

$conn->close();
?>