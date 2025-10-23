<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
// Autenticação (manter comentado por enquanto para testes)
// if (!isset($_SESSION['user_id'])) { header("Location: ../login.php"); exit(); }
require_once '../conection/db_connect.php';

// --- LÓGICA PARA CARREGAR OU CRIAR UM PERSONAGEM T20 ---
$personagem_t20 = null;
$is_new_t20 = true;
$id_t20 = isset($_GET['personagem_id']) ? intval($_GET['personagem_id']) : null;

if ($id_t20) {
    $user_id_placeholder = 1; // Substituir por $_SESSION['user_id'] em produção

    // Busca na tabela personagens_t20
    $stmt = $conn->prepare("SELECT * FROM personagens_t20 WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $id_t20, $user_id_placeholder);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $personagem_t20 = $result->fetch_assoc();
        $is_new_t20 = false;
    }
    $stmt->close();
}

// Se não encontrou personagem ou não passou ID, cria um novo com valores padrão T20
if ($is_new_t20) {
    $personagem_t20 = [
        'id' => null,
        'nome' => 'Novo Personagem T20',
        'jogador' => '', // Pode buscar do $_SESSION['nome_usuario']
        'nivel' => 1,
        'raca_id' => null, // Começa sem raça selecionada
        'origem_id' => null,
        'classe_id' => null,
        'divindade_id' => null,
        'imagem' => 'default_t20.jpg',
        'pv_max' => 0,
        'pv_atual' => 0,
        'pm_max' => 0,
        'pm_atual' => 0,
        'forca' => 0,
        'destreza' => 0,
        'constituicao' => 0,
        'inteligencia' => 0,
        'sabedoria' => 0,
        'carisma' => 0
    ];
}

// --- CARREGAR DADOS DE REGRAS T20 ---
// Raças
$racas_t20 = [];
$sql_racas = "SELECT id, nome, ajustes_atributos FROM t20_racas ORDER BY nome ASC";
$resultado_racas = $conn->query($sql_racas);
if ($resultado_racas) {
    while ($linha = $resultado_racas->fetch_assoc()) {
        $racas_t20[$linha['id']] = $linha; // Guarda usando o ID como chave
    }
}

// (Futuramente carregaremos Classes, Origens, etc. aqui)

// Função simples para calcular modificador (útil no PHP e JS)
function calcular_modificador($atributo_valor)
{
    return floor(($atributo_valor - 10) / 2);
}

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/ficha_t20.css"> <!-- Certifique-se que o CSS existe -->
    <title>Ficha T20 - <?= htmlspecialchars($personagem_t20['nome']) ?></title>
</head>

<body>

    <div class="ficha-container">
        <form id="ficha-t20-form" method="POST" action="../conection/save_character_t20.php" enctype="multipart/form-data">
            <input type="hidden" name="personagem_id" value="<?= htmlspecialchars($personagem_t20['id']) ?>">

            <!-- CABEÇALHO COM INFORMAÇÕES BÁSICAS -->
            <header class="cabecalho-grid">
                <div class="info-item">
                    <label for="nome">Nome do Personagem</label>
                    <input type="text" id="nome" name="nome" value="<?= htmlspecialchars($personagem_t20['nome']) ?>">
                </div>
                <div class="info-item">
                    <label for="nivel">Nível</label>
                    <input type="number" id="nivel" name="nivel" value="<?= htmlspecialchars($personagem_t20['nivel']) ?>" min="1" max="20">
                </div>
                <div class="info-item">
                    <label for="raca_id">Raça</label>
                    <select id="raca_id" name="raca_id">
                        <option value="">Selecione...</option>
                        <?php foreach ($racas_t20 as $id_raca => $raca): ?>
                            <option value="<?= $id_raca ?>" <?= ($personagem_t20['raca_id'] == $id_raca) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($raca['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Área para mostrar ajustes de atributos da raça -->
                    <div id="ajustes-raciais-info" class="info-racial"></div>
                </div>
                <div class="info-item">
                    <label for="classe_id">Classe</label>
                    <select id="classe_id" name="classe_id" disabled>
                        <option value="">(Carregar Classes)</option>
                        <!-- Options de classes serão carregadas aqui -->
                    </select>
                </div>
                <div class="info-item">
                    <label for="origem_id">Origem</label>
                    <select id="origem_id" name="origem_id" disabled>
                        <option value="">(Carregar Origens)</option>
                        <!-- Options de origens -->
                    </select>
                </div>
                <div class="info-item">
                    <label for="divindade_id">Divindade</label>
                    <select id="divindade_id" name="divindade_id" disabled>
                        <option value="">(Carregar Divindades)</option>
                        <!-- Options de divindades -->
                    </select>
                </div>
            </header>

            <div class="conteudo-grid">
                <!-- COLUNA LATERAL (IMAGEM, STATUS) -->
                <aside class="coluna-lateral">
                    <div class="bloco bloco-personagem">
                        <input type="file" name="imagem_personagem" id="input-imagem-t20" accept="image/png, image/jpeg, image/gif" style="display: none;">
                        <div class="personagem-imagem" id="container-imagem-t20">
                            <img src="../uploads/<?= htmlspecialchars($personagem_t20['imagem']) ?>" alt="Imagem Personagem" id="preview-imagem-t20">
                        </div>
                        <button type="button" id="btn-importar-imagem-t20" class="btn">Importar Imagem</button>
                    </div>
                    <div class="bloco status-grid">
                        <div class="status-box">
                            <label>❤️ PV</label>
                            <div class="valor"><span id="pv_atual"><?= htmlspecialchars($personagem_t20['pv_atual']) ?></span> / <span id="pv_max"><?= htmlspecialchars($personagem_t20['pv_max']) ?></span></div>
                        </div>
                        <div class="status-box">
                            <label>💧 PM</label>
                            <div class="valor"><span id="pm_atual"><?= htmlspecialchars($personagem_t20['pm_atual']) ?></span> / <span id="pm_max"><?= htmlspecialchars($personagem_t20['pm_max']) ?></span></div>
                        </div>
                        <div class="status-box">
                            <label>🛡️ Defesa</label>
                            <div class="valor" id="defesa_total">--</div>
                        </div>
                    </div>
                </aside>

                <!-- COLUNA PRINCIPAL (ABAS) -->
                <main class="coluna-principal">
                    <nav class="abas-nav">
                        <button type="button" class="tab-button active" data-tab="tab-atributos">Atributos & Perícias</button>
                        <button type="button" class="tab-button" data-tab="tab-poderes">Poderes</button>
                        <button type="button" class="tab-button" data-tab="tab-equipamento">Equipamento</button>
                    </nav>

                    <!-- ABA ATRIBUTOS -->
                    <div id="tab-atributos" class="tab-content active">
                        <div class="bloco">
                            <h3>Atributos</h3>
                            <div class="atributos-grid">
                                <?php foreach (['forca', 'destreza', 'constituicao', 'inteligencia', 'sabedoria', 'carisma'] as $attr): ?>
                                    <div class="atributo">
                                        <label><?= strtoupper($attr) ?></label>
                                        <input type="number" class="atributo-valor" id="<?= $attr ?>" name="<?= $attr ?>" value="<?= htmlspecialchars($personagem_t20[$attr]) ?>" min="-3">

                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="bloco">
                            <h3>Perícias</h3>
                            <div class="pericias-container" id="lista-pericias">
                                <!-- Cabeçalho da Tabela de Perícias -->
                                <div class="pericia-item header">
                                    <span>Perícia</span>
                                    <span>Total</span>
                                    <span>1/2 Nvl</span>
                                    <span>Mod. Atr.</span>
                                    <span>Treino</span>
                                    <span>Outros</span>
                                </div>

                                <?php
                                // Definindo as perícias e seus atributos chave
                                $lista_completa_pericias = [
                                    // Ordem Alfabética T20 JdA
                                    ['nome' => 'Acrobacia', 'attr' => 'DES', 'id_sufixo' => 'acrobacia'],
                                    ['nome' => 'Adestramento', 'attr' => 'CAR', 'id_sufixo' => 'adestramento', 'so_treinado' => true],
                                    ['nome' => 'Atletismo', 'attr' => 'FOR', 'id_sufixo' => 'atletismo'],
                                    ['nome' => 'Atuação', 'attr' => 'CAR', 'id_sufixo' => 'atuacao', 'so_treinado' => true],
                                    ['nome' => 'Cavalgar', 'attr' => 'DES', 'id_sufixo' => 'cavalgar'],
                                    ['nome' => 'Conhecimento', 'attr' => 'INT', 'id_sufixo' => 'conhecimento', 'so_treinado' => true],
                                    ['nome' => 'Cura', 'attr' => 'SAB', 'id_sufixo' => 'cura', 'so_treinado' => true],
                                    ['nome' => 'Diplomacia', 'attr' => 'CAR', 'id_sufixo' => 'diplomacia'],
                                    ['nome' => 'Enganação', 'attr' => 'CAR', 'id_sufixo' => 'enganacao'],
                                    ['nome' => 'Fortitude', 'attr' => 'CON', 'id_sufixo' => 'fortitude'],
                                    ['nome' => 'Furtividade', 'attr' => 'DES', 'id_sufixo' => 'furtividade'],
                                    ['nome' => 'Guerra', 'attr' => 'INT', 'id_sufixo' => 'guerra', 'so_treinado' => true],
                                    ['nome' => 'Iniciativa', 'attr' => 'DES', 'id_sufixo' => 'iniciativa'],
                                    ['nome' => 'Intimidação', 'attr' => 'CAR', 'id_sufixo' => 'intimidacao'],
                                    ['nome' => 'Intuição', 'attr' => 'SAB', 'id_sufixo' => 'intuicao'],
                                    ['nome' => 'Investigação', 'attr' => 'INT', 'id_sufixo' => 'investigacao'],
                                    ['nome' => 'Jogatina', 'attr' => 'CAR', 'id_sufixo' => 'jogatina', 'so_treinado' => true],
                                    ['nome' => 'Ladinagem', 'attr' => 'DES', 'id_sufixo' => 'ladinagem', 'so_treinado' => true],
                                    ['nome' => 'Luta', 'attr' => 'FOR', 'id_sufixo' => 'luta'],
                                    ['nome' => 'Misticismo', 'attr' => 'INT', 'id_sufixo' => 'misticismo', 'so_treinado' => true],
                                    ['nome' => 'Nobreza', 'attr' => 'INT', 'id_sufixo' => 'nobreza', 'so_treinado' => true],
                                    ['nome' => 'Ofício', 'attr' => 'INT', 'id_sufixo' => 'oficio', 'so_treinado' => true], // Ofício genérico
                                    ['nome' => 'Percepção', 'attr' => 'SAB', 'id_sufixo' => 'percepcao'],
                                    ['nome' => 'Pilotagem', 'attr' => 'DES', 'id_sufixo' => 'pilotagem', 'so_treinado' => true],
                                    ['nome' => 'Pontaria', 'attr' => 'DES', 'id_sufixo' => 'pontaria'],
                                    ['nome' => 'Reflexos', 'attr' => 'DES', 'id_sufixo' => 'reflexos'],
                                    ['nome' => 'Religião', 'attr' => 'SAB', 'id_sufixo' => 'religiao', 'so_treinado' => true],
                                    ['nome' => 'Sobrevivência', 'attr' => 'SAB', 'id_sufixo' => 'sobrevivencia'],
                                    ['nome' => 'Vontade', 'attr' => 'SAB', 'id_sufixo' => 'vontade']
                                ];
                                ?>

                                <?php foreach ($lista_completa_pericias as $pericia): ?>
                                    <div class="pericia-item" data-atributo-chave="<?= strtolower($pericia['attr']) ?>" id="item_<?= $pericia['id_sufixo'] ?>">
                                        <span class="pericia-nome">
                                            <?= htmlspecialchars($pericia['nome']) ?>
                                            <span class="pericia-attr">(<?= $pericia['attr'] ?>)</span>
                                            <?= isset($pericia['so_treinado']) && $pericia['so_treinado'] ? '<span class="so-treinado-marker">*</span>' : '' ?>
                                        </span>
                                        <strong class="pericia-total" id="total_<?= $pericia['id_sufixo'] ?>">0</strong>
                                        <span class="pericia-metade-nivel" id="nivel_<?= $pericia['id_sufixo'] ?>">0</span>
                                        <span class="pericia-mod-attr" id="mod_<?= $pericia['id_sufixo'] ?>">0</span>
                                        <input type="checkbox" class="pericia-treino" id="treino_<?= $pericia['id_sufixo'] ?>" data-pericia-id="<?= $pericia['id_sufixo'] ?>">
                                        <input type="number" class="pericia-outros" id="outros_<?= $pericia['id_sufixo'] ?>" value="0" min="-20" max="20" data-pericia-id="<?= $pericia['id_sufixo'] ?>">
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>

                    <!-- ABA PODERES -->
                    <div id="tab-poderes" class="tab-content">
                        <div class="bloco">
                            <h3>Poderes e Habilidades</h3>
                            <div id="habilidades-raciais-lista">
                                <h4>Habilidades de Raça</h4>
                                <!-- JS vai popular aqui -->
                            </div>
                            <div id="habilidades-classe-lista">
                                <h4>Habilidades de Classe</h4>
                                <!-- JS vai popular aqui -->
                            </div>
                            <div id="poderes-gerais-lista">
                                <h4>Poderes Gerais / Origem / Divindade</h4>
                                <!-- JS vai popular aqui -->
                            </div>
                            <!-- Botão para adicionar poder (futuro) -->
                        </div>
                    </div>

                    <!-- ABA EQUIPAMENTO -->
                    <div id="tab-equipamento" class="tab-content">
                        <div class="bloco">
                            <h3>Ataques</h3>
                            <table width="100%" id="tabela-ataques">
                                <thead>
                                    <tr style="text-align: left;">
                                        <th>Arma</th>
                                        <th>Teste</th>
                                        <th>Dano</th>
                                        <th>Crítico</th>
                                        <th>Tipo</th>
                                        <th>Alcance</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ataques serão adicionados pelo JS -->
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-small">Adicionar Ataque</button>
                        </div>
                        <div class="bloco">
                            <h3>Equipamento (<span id="peso_atual">0</span> / <span id="carga_maxima">--</span> Kg)</h3>
                            <ul class="equipamento-lista" id="lista-inventario">
                                <!-- Itens serão adicionados pelo JS -->
                            </ul>
                            <button type="button" class="btn btn-small">Adicionar Item</button>
                            <p style="text-align: right; margin-top: 1rem; font-weight: bold;"><span id="tibares_atuais">0</span> Tibares (T$)</p>
                        </div>
                    </div>
                </main>
            </div>

            <footer class="botoes-rodape">
                <a href="meus_personagens.php" class="btn btn-secondary">Voltar</a>
                <button type="submit" class="btn btn-primary">Salvar Personagem</button>
            </footer>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // --- DADOS DO PHP ---
            const racasData = <?= json_encode(isset($racas_t20) ? $racas_t20 : []) ?>;
            // Futuramente: const classesData = ... ; const origensData = ... ;

            // --- ELEMENTOS DO DOM ---
            const form = document.getElementById('ficha-t20-form');
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');
            const racaSelect = document.getElementById('raca_id');
            const ajustesInfoDiv = document.getElementById('ajustes-raciais-info');
            const nivelInput = document.getElementById('nivel');
            const atributosInputs = document.querySelectorAll('.atributo-valor');
            const periciasItems = document.querySelectorAll('.pericia-item:not(.header)');


            // --- MAPA DE PERÍCIAS E ATRIBUTOS-CHAVE ---
            const periciasMap = {
                acrobacia: 'destreza',
                adestramento: 'carisma',
                atletismo: 'forca',
                atuacao: 'carisma',
                cavalgar: 'destreza',
                conhecimento: 'inteligencia',
                cura: 'sabedoria',
                diplomacia: 'carisma',
                enganacao: 'carisma',
                fortitude: 'constituicao',
                furtividade: 'destreza',
                guerra: 'inteligencia',
                iniciativa: 'destreza',
                intimidacao: 'carisma',
                intuicao: 'sabedoria',
                investigacao: 'inteligencia',
                jogatina: 'carisma',
                ladinagem: 'destreza',
                luta: 'forca',
                misticismo: 'inteligencia',
                nobreza: 'inteligencia',
                oficio: 'inteligencia',
                percepcao: 'sabedoria',
                pilotagem: 'destreza',
                pontaria: 'destreza',
                reflexos: 'destreza',
                religiao: 'sabedoria',
                sobrevivencia: 'sabedoria',
                vontade: 'sabedoria'
            };

            // --- FUNÇÕES ---

            function calcularTudoT20() {
                const nivel = parseInt(nivelInput.value) || 1;
                const metadeNivel = Math.floor(nivel / 2);
                const modificadores = {};

                // 1. LÊ OS MODIFICADORES DIRETAMENTE DOS INPUTS
                atributosInputs.forEach(input => {
                    const modificadorLido = parseInt(input.value);
                    if (isNaN(modificadorLido)) {
                        modificadores[input.id] = 0; // Assume 0 como padrão se inválido
                    } else {
                        modificadores[input.id] = modificadorLido;
                    }
                });

                // 2. Calcula e exibe valores COMPLETOS das perícias
                if (!periciasItems || periciasItems.length === 0) {
                    return; // Interrompe se não encontrar perícias
                }

                periciasItems.forEach((item) => {
                    // VERIFICAÇÃO INICIAL DO ITEM E DADOS ESSENCIAIS
                    if (!item || !item.id || !item.dataset || !item.dataset.atributoChave) {
                        return; // Pula iteração se dados essenciais faltarem
                    }

                    const sufixoId = item.id.replace('item_', '');
                    const atributoChaveAbrev = item.dataset.atributoChave;

                    // Seleciona elementos internos
                    const spanTotal = item.querySelector('.pericia-total');
                    const spanNivel = item.querySelector('.pericia-metade-nivel');
                    const spanModAttr = item.querySelector('.pericia-mod-attr');
                    const checkboxTreino = item.querySelector('.pericia-treino');
                    const inputOutros = item.querySelector('.pericia-outros');

                    // Mapeia chave abreviada para completa
                    const chaveModificadorCompleta = {
                        'for': 'forca',
                        'des': 'destreza',
                        'con': 'constituicao',
                        'int': 'inteligencia',
                        'sab': 'sabedoria',
                        'car': 'carisma'
                    } [atributoChaveAbrev];

                    // Verifica se modificador existe
                    if (typeof modificadores[chaveModificadorCompleta] === 'undefined') {
                        if (spanTotal) spanTotal.textContent = '--';
                        if (spanNivel) spanNivel.textContent = '--';
                        if (spanModAttr) spanModAttr.textContent = '--';
                        return; // Pula iteração
                    }
                    const modValor = modificadores[chaveModificadorCompleta];

                    // Verifica se elementos visuais existem
                    if (!spanTotal || !spanNivel || !spanModAttr || !checkboxTreino || !inputOutros) {
                        if (spanTotal) spanTotal.textContent = 'ER';
                        if (spanNivel) spanNivel.textContent = 'ER';
                        if (spanModAttr) spanModAttr.textContent = 'ER';
                        return; // Pula iteração
                    }

                    // Calcula e atualiza
                    try {
                        let bonusTreino = 0;
                        if (checkboxTreino.checked) {
                            if (nivel >= 15) bonusTreino = 6;
                            else if (nivel >= 7) bonusTreino = 4;
                            else bonusTreino = 2;
                        }
                        const outrosValor = parseInt(inputOutros.value) || 0;
                        const totalPericia = metadeNivel + modValor + bonusTreino + outrosValor;

                        // Atualiza textContent
                        spanTotal.textContent = (totalPericia >= 0 ? '+' : '') + totalPericia;
                        spanNivel.textContent = (metadeNivel >= 0 ? '+' : '') + metadeNivel;
                        spanModAttr.textContent = (modValor >= 0 ? '+' : '') + modValor;

                    } catch (e) {
                        // Em caso de erro inesperado, marca a linha
                        if (spanTotal) spanTotal.textContent = 'ER';
                        if (spanNivel) spanNivel.textContent = 'ER';
                        if (spanModAttr) spanModAttr.textContent = 'ER';
                    }
                });

                // (Futuros cálculos: PV, PM, Defesa, etc.)
            }

            function mostrarAjustesRaciais() {
                const racaIdSelecionada = racaSelect.value;
                if (ajustesInfoDiv && racasData[racaIdSelecionada]) {
                    const ajustes = racasData[racaIdSelecionada].ajustes_atributos || "Nenhum";
                    let textoAjustes = ajustes;
                    // Formatação para exibição
                    if (ajustes.includes("ATRIBUTOS+1,+1,+1")) {
                        textoAjustes = "+1 em Três Atributos Diferentes";
                        if (ajustes.includes("CAR-1")) textoAjustes += ", CAR-1";
                        if (ajustes.includes("-exceto-CON, CON-1")) textoAjustes += " (exceto CON), CON-1";
                    } else if (ajustes.includes("(Aggelus);")) {
                        textoAjustes = "Escolha: Aggelus (SAB+2, CAR+1) OU Sulfure (DES+2, INT+1)";
                    }
                    ajustesInfoDiv.textContent = `Ajustes de Raça: ${textoAjustes}`;
                } else if (ajustesInfoDiv) {
                    ajustesInfoDiv.textContent = "";
                }
            }

            // --- EVENT LISTENERS ---
            // Abas
            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    tabContents.forEach(content => content.classList.remove('active'));
                    button.classList.add('active');
                    const targetContent = document.getElementById(button.dataset.tab);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });

            // Raça, Nível e Atributos disparam o cálculo
            if (racaSelect) {
                racaSelect.addEventListener('change', mostrarAjustesRaciais);
            }
            if (nivelInput) {
                nivelInput.addEventListener('input', calcularTudoT20);
            }
            atributosInputs.forEach(input => {
                input.addEventListener('input', calcularTudoT20);
            });

            // Listeners para Treino (checkbox) e Outros (input) das Perícias
            if (periciasItems) {
                periciasItems.forEach(item => {
                    const checkboxTreino = item.querySelector('.pericia-treino');
                    const inputOutros = item.querySelector('.pericia-outros');
                    if (checkboxTreino) {
                        checkboxTreino.addEventListener('change', calcularTudoT20);
                    }
                    if (inputOutros) {
                        inputOutros.addEventListener('input', calcularTudoT20);
                    }
                });
            }


            // --- INICIALIZAÇÃO ---
            mostrarAjustesRaciais();
            calcularTudoT20(); // Chamada inicial DEPOIS que tudo está definido
        });
    </script>

</body>

</html>