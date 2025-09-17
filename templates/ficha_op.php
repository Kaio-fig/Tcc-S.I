<?php
session_start();
// Autenticação
// if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
require_once '../conection/db_connect.php';

// --- LÓGICA PARA CARREGAR OU CRIAR UM PERSONAGEM PARA EXIBIÇÃO ---
$personagem = null;
$is_new = true;

// Se um ID foi passado na URL, carrega o personagem
if (isset($_GET['personagem_id'])) {
    $id = intval($_GET['personagem_id']);
    // O user_id viria da sessão para segurança
    $user_id_placeholder = 1; // Substitua por $_SESSION['user_id']

    $stmt = $conn->prepare("SELECT * FROM personagens_op WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id, $user_id_placeholder);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $personagem = $result->fetch_assoc();
        $is_new = false;
    }
}

// Se não encontrou um personagem ou nenhum ID foi passado, cria uma ficha em branco
if ($is_new) {
    $personagem = [
        'id' => null,
        'nome' => 'Novo Personagem',
        'imagem' => 'default.jpg',
        'nex' => 5,
        'classe_id' => 1,
        'origem_id' => 1,
        'patente' => 'Recruta',
        'forca' => 1,
        'agilidade' => 1,
        'intelecto' => 1,
        'vigor' => 1,
        'presenca' => 1
    ];
}

// --- DADOS DO UNIVERSO (Viriam de tabelas de apoio no DB) ---
// --- DADOS DO UNIVERSO (EXPANDIDOS) ---
// --- DADOS DO UNIVERSO (BUSCANDO DO BANCO DE DADOS) ---
$classes = [ // (Manteremos classes hardcoded por enquanto, pois são poucas)
    1 => ['nome' => "Combatente"],
    2 => ['nome' => "Especialista"],
    3 => ['nome' => "Ocultista"]
];

// Busca todas as origens diretamente da nova tabela 'origens'
$origens = [];
$sql_origens = "SELECT id, nome, poder_nome, poder_desc FROM origens ORDER BY nome ASC";
$resultado_origens = $conn->query($sql_origens);

if ($resultado_origens && $resultado_origens->num_rows > 0) {
    while($linha = $resultado_origens->fetch_assoc()) {
        // Usamos o 'id' da origem como a chave do array para manter a
        // compatibilidade com o resto do código que já funciona.
        $origens[$linha['id']] = $linha;
    }
}



$pericias_agrupadas = [
    'Agilidade' => [['id' => 1, 'nome' => 'Acrobacia'], ['id' => 7, 'nome' => 'Crime', 'so_treinado' => true], ['id' => 11, 'nome' => 'Furtividade'], ['id' => 12, 'nome' => 'Iniciativa'], ['id' => 20, 'nome' => 'Pilotagem', 'so_treinado' => true], ['id' => 21, 'nome' => 'Pontaria'], ['id' => 23, 'nome' => 'Reflexos']],
    'Força' => [['id' => 4, 'nome' => 'Atletismo'], ['id' => 16, 'nome' => 'Luta']],
    'Inteligência' => [['id' => 5, 'nome' => 'Atualidades'], ['id' => 6, 'nome' => 'Ciências', 'so_treinado' => true], ['id' => 14, 'nome' => 'Intuição'], ['id' => 15, 'nome' => 'Investigação'], ['id' => 17, 'nome' => 'Medicina', 'so_treinado' => true], ['id' => 18, 'nome' => 'Ocultismo', 'so_treinado' => true], ['id' => 22, 'nome' => 'Profissão', 'so_treinado' => true], ['id' => 25, 'nome' => 'Sobrevivência'], ['id' => 26, 'nome' => 'Tática', 'so_treinado' => true], ['id' => 27, 'nome' => 'Tecnologia', 'so_treinado' => true]],
    'Presença' => [['id' => 2, 'nome' => 'Adestramento', 'so_treinado' => true], ['id' => 3, 'nome' => 'Artes', 'so_treinado' => true], ['id' => 8, 'nome' => 'Diplomacia'], ['id' => 9, 'nome' => 'Enganação'], ['id' => 13, 'nome' => 'Intimidação'], ['id' => 19, 'nome' => 'Percepção'], ['id' => 24, 'nome' => 'Religião', 'so_treinado' => true], ['id' => 28, 'nome' => 'Vontade', 'so_treinado' => true]],
    'Vigor' => [['id' => 10, 'nome' => 'Fortitude']]
];
$todos_os_poderes = [
    // PODERES DE COMBATENTE
    ['id' => 101, 'nome' => 'Ataque Especial', 'desc' => 'Você pode gastar 2 PE para receber +5 em um teste de ataque ou rolagem de dano.', 'classe_id' => 1, 'nex_requerido' => 15],
    ['id' => 102, 'nome' => 'Técnica de Luta', 'desc' => 'Você recebe +2 em rolagens de dano com ataques corpo a corpo.', 'classe_id' => 1, 'nex_requerido' => 30],

    // TRILHA DE ANIQUILADOR (COMBATENTE)
    ['id' => 150, 'nome' => 'A Favorita (Aniquilador)', 'desc' => 'Escolha uma arma. Você recebe +1 na margem de ameaça com ela.', 'classe_id' => 1, 'nex_requerido' => 40, 'trilha' => 'Aniquilador'],

    // PODERES DE ESPECIALISTA
    ['id' => 201, 'nome' => 'Perito', 'desc' => 'Escolha uma perícia. Você recebe +5 nela. Você pode escolher este poder várias vezes.', 'classe_id' => 2, 'nex_requerido' => 15],
    ['id' => 202, 'nome' => 'Conhecimento Aplicado', 'desc' => 'Você pode gastar 2 PE para usar seu Intelecto em vez do atributo base de uma perícia.', 'classe_id' => 2, 'nex_requerido' => 30],

    // PODERES DE OCULTISTA
    ['id' => 301, 'nome' => 'Fortalecimento Ritual', 'desc' => 'Seus rituais recebem +2 na DT de resistência.', 'classe_id' => 3, 'nex_requerido' => 15],

    // PODERES PARANORMAIS (TRANSCENDER)
    ['id' => 901, 'nome' => 'Coração de Monstro', 'desc' => '(Sangue) Seu corpo se adapta. Você recebe +1 de Vida para cada 5% de NEX.', 'tipo' => 'paranormal'],
    ['id' => 902, 'nome' => 'Visão do Oculto', 'desc' => '(Conhecimento) Você enxerga o que não deveria. Pode usar Ocultismo mesmo sem treinamento.', 'tipo' => 'paranormal'],
];
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Personagem - Ordem Paranormal</title>
    <link rel="stylesheet" href="../static/ficha_op.css">
</head>

<body>
    <div class="container">
        <form id="ficha-form" method="POST" action="salvar_personagem.php" enctype="multipart/form-data">
            <input type="hidden" name="personagem_id" value="<?= $personagem['id'] ?>">
            <div class="ficha-grid">
                <div class="coluna-esquerda">
                    <div class="bloco-personagem">
                        <input type="file" name="imagem_personagem" id="input-imagem" accept="image/png, image/jpeg, image/gif" style="display: none;">

                        <div class="personagem-imagem" id="container-imagem">
                            <img src="../uploads/<?= htmlspecialchars($personagem['imagem']) ?>" alt="Imagem do Personagem" id="preview-imagem">
                        </div>

                        <button type="button" id="btn-importar-imagem" class="btn-acao" style="margin-bottom: 15px;">Importar Imagem</button>

                        <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($personagem['nome']) ?>">
                    </div>
                    <div class="bloco-status">
                        <div class="status-box">
                            <label>❤️ VIDA</label>
                            <div><span id="vida-display" class="valor">--</span><span class="maximo"> / --</span></div>
                        </div>
                        <div class="status-box">
                            <label>🧠 SANIDADE</label>
                            <div><span id="sanidade-display" class="valor">--</span><span class="maximo"> / --</span></div>
                        </div>
                        <div class="status-box">
                            <label>🔥 ESFORÇO</label>
                            <div><span id="pe-display" class="valor">--</span><span class="maximo"> / --</span></div>
                        </div>
                        <div class="status-box">
                            <label>🛡️ DEFESA</label>
                            <div><span id="defesa-display" class="valor">--</span></div>
                        </div>
                    </div>
                </div>

                <div class="coluna-direita">
                    <nav class="abas-nav">
                        <button type="button" class="tab-button active" data-tab="tab-atributos">Atributos & Perícias</button>
                        <button type="button" class="tab-button" data-tab="tab-poderes">Poderes & Rituais</button>
                        <button type="button" class="tab-button" data-tab="tab-equipamento">Equipamento</button>
                    </nav>

                    <div id="tab-atributos" class="tab-content active">
                        <h2>Atributos</h2>
                        <div class="atributos-grid">
                            <?php foreach (['forca', 'agilidade', 'intelecto', 'vigor', 'presenca'] as $attr): ?>
                                <div class="atributo-box">
                                    <label><?= strtoupper($attr) ?></label>
                                    <input type="number" class="atributo-input" id="<?= $attr ?>" name="<?= $attr ?>" value="<?= $personagem[$attr] ?>" min="0" max="5">
                                </div>
                            <?php endforeach; ?>
                            <div class="atributo-box">
                                <label>NEX</label>
                                <select class="atributo-input" id="nex" name="nex">
                                    <?php
                                    // Loop para os valores de 5% a 95%
                                    for ($i = 5; $i <= 95; $i += 5) {
                                        // Verifica se o valor atual deve ser o selecionado
                                        $selected = ($i == $personagem['nex']) ? 'selected' : '';
                                        echo "<option value=\"$i\" $selected>$i%</option>";
                                    }
                                    // Adiciona a opção final de 99%
                                    $selected_99 = ($personagem['nex'] == 99) ? 'selected' : '';
                                    echo "<option value=\"99\" $selected_99>99%</option>";
                                    ?>
                                </select>
                            </div>
                        </div>
                        <h2>Perícias</h2>
                        <div class="pericias-container">
                            <?php foreach ($pericias_agrupadas as $atributo => $lista_pericias): ?>
                                <div class="pericia-coluna">
                                    <h3><?= strtoupper($atributo) ?></h3>
                                    <?php foreach ($lista_pericias as $p): ?>
                                        <div class="pericia-item" data-atributo-base="<?= strtolower($atributo) ?>">
                                            <div class="pericia-nome">
                                                <?= $p['nome'] ?>
                                                <?php if (isset($p['so_treinado']) && $p['so_treinado']): ?>
                                                    <span>*</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="pericia-input-wrapper">
                                                <input type="number" class="pericia-input" id="pericia_<?= $p['id'] ?>" value="0">
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div id="tab-poderes" class="tab-content">
                        <div class="info-poderes">
                            <div>
                                <label for="classe-select">Classe</label>
                                <select id="classe-select" name="classe_id">
                                    <?php foreach ($classes as $id => $classe): ?>
                                        <option value="<?= $id ?>" <?= ($personagem['classe_id'] == $id) ? 'selected' : '' ?>>
                                            <?= $classe['nome'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div>
                                <label for="origem-select">Origem</label>
                                <select id="origem-select" name="origem_id">
                                    <?php foreach ($origens as $id => $origem): ?>
                                        <option value="<?= $id ?>" <?= ($personagem['origem_id'] == $id) ? 'selected' : '' ?>>
                                            <?= $origem['nome'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div id="dt-rituais-container" style="display: none;">
                                DT Rituais: <span id="dt-rituais-span"></span>
                            </div>
                        </div>
                        <h2>Poderes e Habilidades</h2>
                        <div class="lista-poderes">
                            <div class="poder-item">
                                <h4>Poder de Origem</h4>
                                <p id="poder-origem-display">Escolha sua origem para ver seu poder.</p>
                            </div>
                        </div>
                        <button type="button" class="btn-acao" id="btn-adicionar-poder">Adicionar Poder</button>
                    </div>

                    <div id="tab-equipamento" class="tab-content">
                        <div class="info-poderes">
                            <div>Patente: <strong><?= $personagem['patente'] ?></strong></div>
                            <div>Limite de Itens: <strong>Categoria <span id="limite-categoria-display">I</span></strong></div>
                            <div>Carga Máxima: <strong id="carga-maxima-display">5</strong></div>
                        </div>
                        <h2>Inventário</h2>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div id="modal-poderes" class="modal-overlay">
        <div class="modal-content">
            <h2>Adicionar Habilidade de Classe</h2>
            <div id="lista-poderes-modal-content">
            </div>
            <hr style="margin: 20px 0;">
            <p>Ou, se o mestre permitir, você pode abrir mão da sua sanidade...</p>
            <button type="button" class="btn-acao" onclick="abrirModalTranscender()">Transcender...</button>
        </div>
    </div>
    <div id="modal-transcender" class="modal-overlay">
        <div class="modal-content">
            <h2>O Outro Lado Chama</h2>
            <div class="poderes-transcender-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-top:20px;">
                <div class="poder-card sangue">
                    <h4>Coração de Monstro</h4>
                    <p>(Sangue) Você recebe +1 de Vida para cada 5% de NEX.</p>
                </div>
                <div class="poder-card conhecimento">
                    <h4>Visão do Oculto</h4>
                    <p>(Conhecimento) Você enxerga o que não deveria.</p>
                </div>
                <div class="poder-card morte">
                    <h4>Toque do Vazio</h4>
                    <p>(Morte) Sua presença perturba inimigos próximos.</p>
                </div>
                <div class="poder-card energia">
                    <h4>Corpo Elétrico</h4>
                    <p>(Energia) Você recebe +5 de Defesa contra ataques à distância.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- DADOS DO PHP PARA O JS ---
            const origens = <?= json_encode($origens) ?>;
            const todosOsPoderes = <?= json_encode($todos_os_poderes) ?>;

            // --- LÓGICA DE UPLOAD DE IMAGEM (sem alterações) ---
            const btnImportar = document.getElementById('btn-importar-imagem');
            const inputImagem = document.getElementById('input-imagem');
            const previewImagem = document.getElementById('preview-imagem');
            const containerImagem = document.getElementById('container-imagem');
            btnImportar.addEventListener('click', () => inputImagem.click());
            containerImagem.addEventListener('click', () => inputImagem.click());
            inputImagem.addEventListener('change', event => {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = e => {
                        previewImagem.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });

            // --- ELEMENTOS GLOBAIS PARA CÁLCULO E LÓGICA ---
            const form = document.getElementById('ficha-form');
            const inputsParaMonitorar = form.querySelectorAll('input.atributo-input, select.atributo-input, input.pericia-input, #classe-select, #origem-select');

            // --- LÓGICA DAS ABAS (sem alterações) ---
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    button.classList.add('active');
                    document.getElementById(button.dataset.tab).classList.add('active');
                });
            });

            // --- FUNÇÃO PARA ATUALIZAR O PODER DA ORIGEM NA FICHA ---
            function atualizarPoderOrigem() {
                const origemId = document.getElementById('origem-select').value;
                const poderOrigemInfo = origens[origemId];
                const displayContainer = document.getElementById('poder-origem-display');

                if (poderOrigemInfo && displayContainer) {
                    // Atualiza o título e a descrição do poder de origem exibido na ficha
                    displayContainer.parentElement.querySelector('h4').textContent = `Poder de Origem (${poderOrigemInfo.nome})`;
                    displayContainer.textContent = poderOrigemInfo.poder_desc;
                }
            }

            // --- FUNÇÃO MASTER DE CÁLCULO ---
            function calcularTudo() {
                // ... (A lógica de cálculo de atributos, status e perícias continua a mesma de antes) ...
                const nex = parseInt(document.getElementById('nex').value) || 0;
                const classeId = parseInt(document.getElementById('classe-select').value) || 0;
                const atributos = {};
                ['forca', 'agilidade', 'intelecto', 'vigor', 'presenca'].forEach(attr => {
                    atributos[attr] = parseInt(document.getElementById(attr).value) || 0;
                });

                // Exemplo de cálculo de Defesa e DT
                document.getElementById('defesa-display').textContent = 10 + atributos.agilidade;
                const dtRituaisContainer = document.getElementById('dt-rituais-container');
                if (classeId === 3) { // Ocultista
                    dtRituaisContainer.style.display = 'block';
                    document.getElementById('dt-rituais-span').textContent = 10 + atributos.presenca + Math.floor(nex / 10);
                } else {
                    dtRituaisContainer.style.display = 'none';
                }

                // Atualiza o poder de origem sempre que recalcular
                atualizarPoderOrigem();
            }

            // --- LÓGICA DOS MODAIS (COMPLETAMENTE REFEITA) ---
            const modalPoderes = document.getElementById('modal-poderes');
            const modalTranscender = document.getElementById('modal-transcender');

            window.abrirModalPoderes = function() {
                const nex = parseInt(document.getElementById('nex').value) || 0;
                const classeId = parseInt(document.getElementById('classe-select').value) || 0;

                const listaPoderesModal = document.getElementById('lista-poderes-modal-content');
                listaPoderesModal.innerHTML = ''; // Limpa a lista antes de preencher

                // Filtra os poderes que o personagem pode aprender
                const poderesDisponiveis = todosOsPoderes.filter(poder => {
                    // Não mostra poderes paranormais aqui
                    if (poder.tipo === 'paranormal') return false;

                    // Verifica o NEX e a Classe
                    const nexOk = poder.nex_requerido <= nex;
                    const classeOk = poder.classe_id === classeId;

                    // Lógica para trilhas (a ser implementada quando o personagem tiver uma trilha salva)
                    // const trilhaOk = !poder.trilha || poder.trilha === personagem.trilha;

                    return nexOk && classeOk; // && trilhaOk;
                });

                // Cria o HTML para cada poder disponível
                if (poderesDisponiveis.length > 0) {
                    poderesDisponiveis.forEach(poder => {
                        const poderDiv = document.createElement('div');
                        poderDiv.className = 'poder-item-modal';
                        poderDiv.innerHTML = `
                    <div>
                        <strong>${poder.nome}</strong>
                        <p>${poder.desc}</p>
                    </div>
                    <button onclick="adicionarPoder(${poder.id})">Adicionar</button>
                `;
                        listaPoderesModal.appendChild(poderDiv);
                    });
                } else {
                    listaPoderesModal.innerHTML = '<p>Nenhum poder de classe ou trilha disponível para seu NEX e Classe atuais.</p>';
                }

                modalPoderes.style.display = 'flex';
            }

            window.adicionarPoder = function(poderId) {
                const poderInfo = todosOsPoderes.find(p => p.id === poderId);
                if (!poderInfo) return;

                const listaPoderesFicha = document.querySelector('#tab-poderes .lista-poderes');

                const poderDiv = document.createElement('div');
                poderDiv.className = 'poder-item';
                poderDiv.innerHTML = `<h4>${poderInfo.nome}</h4><p>${poderInfo.desc}</p>`;

                listaPoderesFicha.appendChild(poderDiv);
                modalPoderes.style.display = 'none';
                // Aqui você faria uma chamada AJAX para salvar o poder no DB
            }

            // Lógica de transcender (semelhante, mas com os poderes paranormais)
            window.abrirModalTranscender = function() {
                // ... (Lógica para preencher o modal de transcender)
                modalPoderes.style.display = 'none';
                modalTranscender.style.display = 'flex';
            }

            // Event listeners para fechar os modais
            [modalPoderes, modalTranscender].forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) modal.style.display = 'none';
                });
            });

            // --- EVENT LISTENERS E INICIALIZAÇÃO ---
            inputsParaMonitorar.forEach(input => {
                input.addEventListener('change', calcularTudo);
            });

            document.getElementById('btn-adicionar-poder').addEventListener('click', abrirModalPoderes);

            // Roda tudo uma vez para inicializar a ficha
            calcularTudo();
        });
    </script>
</body>

</html>