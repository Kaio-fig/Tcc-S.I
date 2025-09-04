<?php
// ficha_op.php
// Correção do caminho da conexão
require_once '../conection/db_connect.php';


// Obter personagem atual
$personagem_id = isset($_GET['personagem_id']) ? intval($_GET['personagem_id']) : 0;
$personagem = null;

if ($personagem_id > 0) {
    // Buscar dados do personagem (verificando se pertence ao usuário)
    $stmt = $conn->prepare("SELECT * FROM personagens WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $personagem_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $personagem = $result->fetch_assoc();
    
    if (!$personagem) {
        // Personagem não encontrado ou não pertence ao usuário
        header('Location: meus_personagens.php');
        exit;
    }
} else {
    // Nenhum personagem especificado
    header('Location: meus_personagens.php');
    exit;
}

// Mensagem de sucesso se acabou de criar o personagem
if (isset($_GET['criado']) && $_GET['criado'] == 1) {
    $mensagem_sucesso = "Personagem criado com sucesso!";
}
// Carregar itens do banco de dados
$armas = getArmas();
$protecoes = getProtecoes();
$itens_gerais = getItensGerais();
$itens_paranormais = getItensParanormais();

// Converter para JSON para uso no JavaScript
$armas_json = json_encode($armas);
$protecoes_json = json_encode($protecoes);
$itens_gerais_json = json_encode($itens_gerais);
$itens_paranormais_json = json_encode($itens_paranormais);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Ordem Paranormal Automatizada</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../static/ficha_op.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-dragon"></i> Ficha de Ordem Paranormal</h1>
            <p>Automatizada para Agentes da Ordem</p>
            <?php if ($personagem): ?>
                <p>Personagem: <?php echo htmlspecialchars($personagem['nome']); ?> | NEX: <?php echo $personagem['nivel'] * 5; ?>%</p>
            <?php endif; ?>
        </header>
        
        <!-- Painel Esquerdo: Token e Nome -->
        <div class="left-panel">
            <div class="token-container">
                <div class="token-preview" id="token-preview">
                    <?php if ($personagem && $personagem['imagem'] != 'default.jpg'): ?>
                        <img src="../uploads/<?php echo $personagem['imagem']; ?>" alt="Token do Personagem">
                    <?php else: ?>
                        <i class="fas fa-user-circle"></i>
                    <?php endif; ?>
                </div>
                <input type="file" id="token-upload" accept="image/*" class="token-upload">
                <button class="btn-save" onclick="document.getElementById('token-upload').click()">
                    <i class="fas fa-upload"></i> Importar Token
                </button>
            </div>
            
            <div class="character-name">
                <input type="text" id="char-name" placeholder="Nome do Personagem" 
                    value="<?php echo $personagem ? htmlspecialchars($personagem['nome']) : ''; ?>">
            </div>
        </div>
        
        <!-- Painel Direito: Abas e Conteúdo -->
        <div class="right-panel">
            <div class="tab-controls">
                <div class="tab-btn active" data-tab="status-tab">
                    <i class="fas fa-heart"></i> Status
                </div>
                <div class="tab-btn" data-tab="powers-tab">
                    <i class="fas fa-fire"></i> Poderes e Rituais
                </div>
                <div class="tab-btn" data-tab="equipment-tab">
                    <i class="fas fa-shield-alt"></i> Equipamento
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Aba Status -->
                <div id="status-tab" class="tab-pane active">
                    <h2>Atributos e Perícias</h2>
                    
                    <div class="attributes-grid">
                        <div class="attribute">
                            <label>FORÇA</label>
                            <input type="number" id="for" min="0" max="5" value="1">
                            <div class="modifier" id="for-mod">+1</div>
                        </div>
                        <div class="attribute">
                            <label>AGILIDADE</label>
                            <input type="number" id="agi" min="0" max="5" value="1">
                            <div class="modifier" id="agi-mod">+1</div>
                        </div>
                        <div class="attribute">
                            <label>INTELECTO</label>
                            <input type="number" id="int" min="0" max="5" value="1">
                            <div class="modifier" id="int-mod">+1</div>
                        </div>
                        <div class="attribute">
                            <label>VIGOR</label>
                            <input type="number" id="vig" min="0" max="5" value="1">
                            <div class="modifier" id="vig-mod">+1</div>
                        </div>
                        <div class="attribute">
                            <label>PRESENÇA</label>
                            <input type="number" id="pre" min="0" max="5" value="1">
                            <div class="modifier" id="pre-mod">+1</div>
                        </div>
                    </div>
                    
                    <div class="skills-grid">
                        <div class="skill-category">
                            <h3>Físicas</h3>
                            <div class="skill">
                                <span>Acrobacia (AGI)</span>
                                <input type="number" id="acrobacia" value="1">
                            </div>
                            <div class="skill">
                                <span>Atletismo (FOR)</span>
                                <input type="number" id="atletismo" value="1">
                            </div>
                            <div class="skill">
                                <span>Furtividade (AGI)</span>
                                <input type="number" id="furtividade" value="1">
                            </div>
                            <div class="skill">
                                <span>Pilotagem (AGI)</span>
                                <input type="number" id="pilotagem" value="1">
                            </div>
                            <div class="skill">
                                <span>Pontaria (AGI)</span>
                                <input type="number" id="pontaria" value="1">
                            </div>
                        </div>
                        
                        <div class="skill-category">
                            <h3>Mentais</h3>
                            <div class="skill">
                                <span>Atualidades (INT)</span>
                                <input type="number" id="atualidades" value="1">
                            </div>
                            <div class="skill">
                                <span>Ciências (INT)</span>
                                <input type="number" id="ciencias" value="1">
                            </div>
                            <div class="skill">
                                <span>Crime (INT)</span>
                                <input type="number" id="crime" value="1">
                            </div>
                            <div class="skill">
                                <span>Investigação (INT)</span>
                                <input type="number" id="investigacao" value="1">
                            </div>
                            <div class="skill">
                                <span>Medicina (INT)</span>
                                <input type="number" id="medicina" value="1">
                            </div>
                        </div>
                        
                        <div class="skill-category">
                            <h3>Sociais</h3>
                            <div class="skill">
                                <span>Diplomacia (PRE)</span>
                                <input type="number" id="diplomacia" value="1">
                            </div>
                            <div class="skill">
                                <span>Enganação (PRE)</span>
                                <input type="number" id="enganacao" value="1">
                            </div>
                            <div class="skill">
                                <span>Intimidação (PRE)</span>
                                <input type="number" id="intimidacao" value="1">
                            </div>
                            <div class="skill">
                                <span>Percepção (PRE)</span>
                                <input type="number" id="percepcao" value="1">
                            </div>
                            <div class="skill">
                                <span>Vontade (PRE)</span>
                                <input type="number" id="vontade" value="1">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Aba Poderes e Rituais -->
                <div id="powers-tab" class="tab-pane">
                    <h2>Poderes de Classe e Rituais</h2>
                    
                    <div class="abilities-list">
                        <div class="ability">
                            <h3>Ataque Especial</h3>
                            <p>Gaste 2 PE para receber +5 em um ataque</p>
                        </div>
                        <div class="ability">
                            <h3>Golpe Pesado</h3>
                            <p>Seu ataque causa +1 dado de dano</p>
                        </div>
                        <div class="ability">
                            <h3>Combate Defensivo</h3>
                            <p>Ganhe +5 em Defesa</p>
                        </div>
                        <div class="ability">
                            <h3>Escudo Mental</h3>
                            <p>Protege sua mente contra efeitos paranormais</p>
                        </div>
                        <div class="ability">
                            <h3>Amaldiçoar Arma</h3>
                            <p>Ritual: Arma causa dano paranormal adicional</p>
                        </div>
                        <div class="ability">
                            <h3>Definhar</h3>
                            <p>Ritual: Enfraquece inimigos próximos</p>
                        </div>
                        <div class="ability">
                            <h3>Perturbação</h3>
                            <p>Ritual: Cria ilusões para confundir oponentes</p>
                        </div>
                        <div class="ability">
                            <h3>Arma Atroz</h3>
                            <p>Ritual: Cria uma arma feita de energia paranormal</p>
                        </div>
                    </div>
                    
                    <div class="add-item">
                        <button class="btn-save">
                            <i class="fas fa-plus"></i> Adicionar Novo Poder
                        </button>
                    </div>
                </div>
                
                <!-- Aba Equipamento -->
                <div id="equipment-tab" class="tab-pane">
                    <h2>Equipamentos e Itens</h2>
                    
                    <div class="equipment-grid">
                        <div class="equipment-category">
                            <h3>Armas</h3>
                            <div id="weapons-list">
                                <!-- As armas serão carregadas via JavaScript -->
                            </div>
                            <div class="add-item">
                                <button class="btn-save" id="add-weapon">
                                    <i class="fas fa-plus"></i> Adicionar Arma
                                </button>
                            </div>
                        </div>
                        
                        <div class="equipment-category">
                            <h3>Armaduras</h3>
                            <div id="armors-list">
                                <!-- As proteções serão carregadas via JavaScript -->
                            </div>
                            <div class="add-item">
                                <button class="btn-save" id="add-armor">
                                    <i class="fas fa-plus"></i> Adicionar Armadura
                                </button>
                            </div>
                        </div>
                        
                        <div class="equipment-category">
                            <h3>Itens Paranormais</h3>
                            <div id="paranormal-list">
                                <!-- Os itens paranormais serão carregados via JavaScript -->
                            </div>
                            <div class="add-item">
                                <button class="btn-save" id="add-paranormal">
                                    <i class="fas fa-plus"></i> Adicionar Item Paranormal
                                </button>
                            </div>
                        </div>
                        
                        <div class="equipment-category">
                            <h3>Itens Gerais</h3>
                            <div id="general-list">
                                <!-- Os itens gerais serão carregados via JavaScript -->
                            </div>
                            <div class="add-item">
                                <button class="btn-save" id="add-general">
                                    <i class="fas fa-plus"></i> Adicionar Item Geral
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="save-button">
                <button class="btn-save" id="save-btn">
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
            </div>
        </div>
    </div>
    
    <!-- Modal para seleção de equipamentos -->
    <div class="modal" id="equipment-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-title">Selecionar Equipamento</h2>
                <button class="close-modal">&times;</button>
            </div>
            
            <div class="equipment-filters">
                <button class="filter-btn active" data-filter="all">Todos</button>
                <button class="filter-btn" data-filter="weapon">Armas</button>
                <button class="filter-btn" data-filter="armor">Proteções</button>
                <button class="filter-btn" data-filter="paranormal">Paranormais</button>
                <button class="filter-btn" data-filter="general">Gerais</button>
            </div>
            
            <div class="equipment-list" id="equipment-options">
                <!-- As opções de equipamento serão preenchidas via JavaScript -->
            </div>
            
            <div class="equipment-details" id="equipment-details">
                <h3>Detalhes do Item</h3>
                <p>Selecione um item para ver os detalhes</p>
            </div>
            
            <div class="save-button">
                <button class="btn-save" id="select-equipment">
                    <i class="fas fa-check"></i> Selecionar Item
                </button>
            </div>
        </div>
    </div>

    <!-- Modal para modificações -->
    <div class="modal" id="modifications-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modifications-title">Modificações do Item</h2>
                <button class="close-modal">&times;</button>
            </div>
            
            <div class="modifications-list" id="modifications-options">
                <!-- As opções de modificação serão preenchidas via JavaScript -->
            </div>
            
            <div class="selected-modifications" id="selected-modifications">
                <h3>Modificações Selecionadas</h3>
                <ul id="selected-mods-list"></ul>
            </div>
            
            <div class="save-button">
                <button class="btn-save" id="save-modifications">
                    <i class="fas fa-check"></i> Aplicar Modificações
                </button>
            </div>
        </div>
    </div>
    
    <script>
        // Dados de equipamentos do banco (convertidos de PHP para JavaScript)
        const equipmentData = {
            weapons: <?php echo $armas_json; ?>,
            armors: <?php echo $protecoes_json; ?>,
            paranormal: <?php echo $itens_paranormais_json; ?>,
            general: <?php echo $itens_gerais_json; ?>
        };

        // Dados do personagem atual
        const currentCharacter = {
            id: <?php echo $personagem ? $personagem['id'] : 0; ?>,
            name: "<?php echo $personagem ? addslashes($personagem['nome']) : ''; ?>",
            nex: <?php echo $personagem ? $personagem['nivel'] * 5 : 0; ?>
        };

        // Elementos DOM
        const tokenPreview = document.getElementById('token-preview');
        const tokenUpload = document.getElementById('token-upload');
        const tabBtns = document.querySelectorAll('.tab-btn');
        const tabPanes = document.querySelectorAll('.tab-pane');
        const atributos = ['for', 'agi', 'int', 'vig', 'pre'];
        const equipmentModal = document.getElementById('equipment-modal');
        const modificationsModal = document.getElementById('modifications-modal');
        const modalTitle = document.getElementById('modal-title');
        const modificationsTitle = document.getElementById('modifications-title');
        const equipmentOptions = document.getElementById('equipment-options');
        const modificationsOptions = document.getElementById('modifications-options');
        const equipmentDetails = document.getElementById('equipment-details');
        const filterBtns = document.querySelectorAll('.filter-btn');
        const closeModal = document.querySelectorAll('.close-modal');
        const selectEquipmentBtn = document.getElementById('select-equipment');
        const saveModificationsBtn = document.getElementById('save-modifications');
        const addWeaponBtn = document.getElementById('add-weapon');
        const addArmorBtn = document.getElementById('add-armor');
        const addParanormalBtn = document.getElementById('add-paranormal');
        const addGeneralBtn = document.getElementById('add-general');
        
        // Listas de equipamentos do personagem
        const weaponsList = document.getElementById('weapons-list');
        const armorsList = document.getElementById('armors-list');
        const paranormalList = document.getElementById('paranormal-list');
        const generalList = document.getElementById('general-list');
        
        // Estado atual
        let currentEquipmentType = "";
        let selectedEquipment = null;
        let currentModifications = [];
        let selectedItemForModification = null;
        
        // Inicialização
        document.addEventListener('DOMContentLoaded', () => {
            // Configurar eventos
            setupEventListeners();
            
            // Atualizar a ficha inicial
            updateCharacterSheet();
            
            // Carregar equipamentos do personagem se existir
            if (currentCharacter.id > 0) {
                loadCharacterEquipment();
            }
        });
        
        function setupEventListeners() {
            // Upload de token
            tokenUpload.addEventListener('change', function(e) {
                if (e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        tokenPreview.innerHTML = `<img src="${e.target.result}" alt="Token do Personagem">`;
                    }
                    
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
            
            // Controle das abas
            tabBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const tabId = this.dataset.tab;
                    
                    // Desativar todas as abas
                    tabBtns.forEach(b => b.classList.remove('active'));
                    tabPanes.forEach(p => p.classList.remove('active'));
                    
                    // Ativar aba clicada
                    this.classList.add('active');
                    document.getElementById(tabId).classList.add('active');
                });
            });
            
            // Atualizar modificadores de atributos
            atributos.forEach(atr => {
                const input = document.getElementById(atr);
                const mod = document.getElementById(`${atr}-mod`);
                
                input.addEventListener('input', function() {
                    const value = parseInt(this.value) || 0;
                    const modifier = Math.floor((value - 1) / 2);
                    mod.textContent = modifier >= 0 ? `+${modifier}` : modifier;
                });
            });
            
            // Botões para adicionar equipamentos
            addWeaponBtn.addEventListener('click', () => openEquipmentModal('weapon', 'Armas'));
            addArmorBtn.addEventListener('click', () => openEquipmentModal('armor', 'Proteções'));
            addParanormalBtn.addEventListener('click', () => openEquipmentModal('paranormal', 'Itens Paranormais'));
            addGeneralBtn.addEventListener('click', () => openEquipmentModal('general', 'Itens Gerais'));
            
            // Filtros do modal
            filterBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    filterBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filter = this.dataset.filter;
                    filterEquipmentOptions(filter);
                });
            });
            
            // Fechar modais
            closeModal.forEach(btn => {
                btn.addEventListener('click', function() {
                    equipmentModal.style.display = 'none';
                    modificationsModal.style.display = 'none';
                });
            });
            
            // Selecionar equipamento
            selectEquipmentBtn.addEventListener('click', addSelectedEquipment);
            
            // Aplicar modificações
            saveModificationsBtn.addEventListener('click', applyModifications);
            
            // Botão de salvar
            document.getElementById('save-btn').addEventListener('click', saveCharacter);
        }
        
        function updateCharacterSheet() {
            // Atualizar modificadores de atributos
            atributos.forEach(atr => {
                const mod = Math.floor((parseInt(document.getElementById(atr).value) - 1) / 2);
                document.getElementById(`${atr}-mod`).textContent = mod >= 0 ? `+${mod}` : mod;
            });
        }
        
        function openEquipmentModal(type, title) {
            currentEquipmentType = type;
            modalTitle.textContent = `Selecionar ${title}`;
            equipmentModal.style.display = 'flex';
            
            // Resetar seleção
            selectedEquipment = null;
            equipmentDetails.innerHTML = '<h3>Detalhes do Item</h3><p>Selecione um item para ver os detalhes</p>';
            
            // Preencher opções
            filterEquipmentOptions('all');
        }
        
        function filterEquipmentOptions(filter) {
            equipmentOptions.innerHTML = '';
            
            // Determinar quais tipos mostrar
            const typesToShow = filter === 'all' 
                ? ['weapons', 'armors', 'paranormal', 'general'] 
                : [filter];
            
            typesToShow.forEach(type => {
                if (equipmentData[type]) {
                    equipmentData[type].forEach(item => {
                        const option = document.createElement('div');
                        option.className = 'equipment-option';
                        option.dataset.type = type;
                        option.dataset.id = item.id;
                        
                        let details = '';
                        if (type === 'weapons') {
                            details = `<p><strong>Dano:</strong> ${item.dano}</p>
                                       <p><strong>Crítico:</strong> ${item.crit}</p>
                                       <p><strong>Alcance:</strong> ${item.alcance || '-'}</p>`;
                        } else if (type === 'armors') {
                            details = `<p><strong>Defesa:</strong> ${item.defesa}</p>`;
                        } else if (type === 'paranormal') {
                            details = `<p><strong>Efeito:</strong> ${item.efeito}</p>`;
                        } else if (type === 'general') {
                            details = `<p><strong>Bônus:</strong> ${item.bonus || 'Item utilitário'}</p>`;
                        }
                        
                        option.innerHTML = `
                            <h4>${item.nome}</h4>
                            <p><strong>Categoria:</strong> ${item.categoria}</p>
                            <p><strong>Espaços:</strong> ${item.espaco}</p>
                            ${details}
                        `;
                        
                        option.addEventListener('click', () => selectEquipment(item, type));
                        equipmentOptions.appendChild(option);
                    });
                }
            });
        }
        
        function selectEquipment(item, type) {
            // Remover seleção anterior
            document.querySelectorAll('.equipment-option').forEach(opt => {
                opt.style.border = '1px solid var(--border-color)';
            });
            
            // Destacar seleção atual
            event.currentTarget.style.border = '2px solid var(--primary-color)';
            
            // Mostrar detalhes
            let detailsHTML = `
                <h3>${item.nome}</h3>
                <p><strong>Categoria:</strong> ${item.categoria}</p>
                <p><strong>Espaços:</strong> ${item.espaco}</p>
            `;
            
            if (type === 'weapons') {
                detailsHTML += `
                    <p><strong>Dano:</strong> ${item.dano}</p>
                    <p><strong>Crítico:</strong> ${item.crit}</p>
                    <p><strong>Alcance:</strong> ${item.alcance || '-'}</p>
                    <p><strong>Tipo:</strong> ${item.tipo || '-'}</p>
                `;
            } else if (type === 'armors') {
                detailsHTML += `<p><strong>Defesa:</strong> ${item.defesa}</p>`;
            } else if (type === 'paranormal') {
                detailsHTML += `<p><strong>Efeito:</strong> ${item.efeito}</p>`;
                if (item.elemento) {
                    detailsHTML += `<p><strong>Elemento:</strong> ${item.elemento}</p>`;
                }
            } else if (type === 'general') {
                detailsHTML += `<p><strong>Bônus:</strong> ${item.bonus || 'Item utilitário'}</p>`;
                if (item.tipo) {
                    detailsHTML += `<p><strong>Tipo:</strong> ${item.tipo}</p>`;
                }
            }
            
            if (item.descricao) {
                detailsHTML += `<p><strong>Descrição:</strong> ${item.descricao}</p>`;
            }
            
            equipmentDetails.innerHTML = detailsHTML;
            selectedEquipment = { ...item, sourceType: type };
        }
        
        function addSelectedEquipment() {
            if (!selectedEquipment) {
                alert('Por favor, selecione um item primeiro.');
                return;
            }
            
            // Fechar modal de equipamentos
            equipmentModal.style.display = 'none';
            
            // Abrir modal de modificações
            openModificationsModal();
        }
        
        function openModificationsModal() {
            modificationsTitle.textContent = `Modificações para ${selectedEquipment.nome}`;
            modificationsModal.style.display = 'flex';
            
            // Resetar modificações selecionadas
            currentModifications = [];
            document.getElementById('selected-mods-list').innerHTML = '';
            
            // Carregar modificações disponíveis para este tipo de item
            loadModifications(selectedEquipment.sourceType);
        }
        
        function loadModifications(itemType) {
            // Fazer requisição para buscar modificações do banco
            fetch(`get_modifications.php?tipo=${itemType}`)
                .then(response => response.json())
                .then(modifications => {
                    displayModifications(modifications);
                })
                .catch(error => {
                    console.error('Erro ao carregar modificações:', error);
                    modificationsOptions.innerHTML = '<p>Nenhuma modificação disponível.</p>';
                });
        }
        
        function displayModifications(modifications) {
            modificationsOptions.innerHTML = '';
            
            if (modifications.length === 0) {
                modificationsOptions.innerHTML = '<p>Nenhuma modificação disponível para este tipo de item.</p>';
                return;
            }
            
            modifications.forEach(mod => {
                const option = document.createElement('div');
                option.className = 'modification-option';
                option.dataset.id = mod.id;
                
                option.innerHTML = `
                    <h4>${mod.nome}</h4>
                    <p><strong>Efeito:</strong> ${mod.efeito}</p>
                    <p><strong>Categoria Extra:</strong> +${mod.categoria_extra}</p>
                    ${mod.descricao ? `<p><strong>Descrição:</strong> ${mod.descricao}</p>` : ''}
                    <button class="btn-add-mod">Adicionar</button>
                `;
                
                const addButton = option.querySelector('.btn-add-mod');
                addButton.addEventListener('click', () => addModification(mod));
                
                modificationsOptions.appendChild(option);
            });
        }
        
        function addModification(modification) {
            // Adicionar modificação à lista
            currentModifications.push(modification);
            
            // Atualizar lista de modificações selecionadas
            updateSelectedModificationsList();
        }
        
        function updateSelectedModificationsList() {
            const list = document.getElementById('selected-mods-list');
            list.innerHTML = '';
            
            currentModifications.forEach((mod, index) => {
                const listItem = document.createElement('li');
                listItem.innerHTML = `
                    ${mod.nome} (+${mod.categoria_extra} categoria)
                    <button class="btn-remove-mod" data-index="${index}">Remover</button>
                `;
                
                const removeButton = listItem.querySelector('.btn-remove-mod');
                removeButton.addEventListener('click', () => removeModification(index));
                
                list.appendChild(listItem);
            });
        }
        
        function removeModification(index) {
            currentModifications.splice(index, 1);
            updateSelectedModificationsList();
        }
        
        function applyModifications() {
            // Calcular categoria final
            let categoriaFinal = selectedEquipment.categoria;
            let primeiraModParanormal = true;
            
            currentModifications.forEach(mod => {
                if (mod.categoria_extra >= 2) {
                    // Modificação paranormal
                    if (primeiraModParanormal) {
                        categoriaFinal += 2;
                        primeiraModParanormal = false;
                    } else {
                        categoriaFinal += 1;
                    }
                } else {
                    // Modificação normal
                    categoriaFinal += 1;
                }
            });
            
            // Adicionar item à lista do personagem
            addItemToCharacter(selectedEquipment, currentModifications, categoriaFinal);
            
            // Fechar modal
            modificationsModal.style.display = 'none';
        }
        
        function addItemToCharacter(item, modifications, categoriaFinal) {
            // Fazer requisição para adicionar item ao personagem
            const formData = new FormData();
            formData.append('personagem_id', currentCharacter.id);
            formData.append('item_id', item.id);
            formData.append('tipo_item', item.sourceType);
            formData.append('modificacoes', JSON.stringify(modifications.map(m => m.id)));
            formData.append('categoria_final', categoriaFinal);
            
            fetch('add_item_personagem.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Recarregar equipamentos do personagem
                    loadCharacterEquipment();
                    alert('Item adicionado com sucesso!');
                } else {
                    alert('Erro ao adicionar item: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erro:', error);
                alert('Erro ao adicionar item.');
            });
        }
        
        function loadCharacterEquipment() {
            if (currentCharacter.id === 0) return;
            
            // Fazer requisição para carregar equipamentos do personagem
            fetch(`get_character_equipment.php?personagem_id=${currentCharacter.id}`)
                .then(response => response.json())
                .then(equipment => {
                    displayCharacterEquipment(equipment);
                })
                .catch(error => {
                    console.error('Erro ao carregar equipamentos:', error);
                });
        }
        
        function displayCharacterEquipment(equipment) {
            // Limpar listas
            weaponsList.innerHTML = '';
            armorsList.innerHTML = '';
            paranormalList.innerHTML = '';
            generalList.innerHTML = '';
            
            // Agrupar equipamentos por tipo
            const weapons = equipment.filter(item => item.tipo_item === 'arma');
            const armors = equipment.filter(item => item.tipo_item === 'protecao');
            const paranormal = equipment.filter(item => item.tipo_item === 'paranormal');
            const general = equipment.filter(item => item.tipo_item === 'geral');
            
            // Preencher listas
            fillEquipmentList(weapons, weaponsList, 'arma');
            fillEquipmentList(armors, armorsList, 'protecao');
            fillEquipmentList(paranormal, paranormalList, 'paranormal');
            fillEquipmentList(general, generalList, 'geral');
        }
        
        function fillEquipmentList(items, listElement, type) {
            if (items.length === 0) {
                listElement.innerHTML = '<p>Nenhum item adicionado.</p>';
                return;
            }
            
            items.forEach(item => {
                const itemElement = document.createElement('div');
                itemElement.className = 'equipment-item';
                
                let details = `Categoria: ${item.categoria_final} | Espaços: ${item.espaco}`;
                if (type === 'arma') {
                    details = `Dano: ${item.dano} | Crítico: ${item.crit} | ${details}`;
                } else if (type === 'protecao') {
                    details = `Defesa: ${item.defesa} | ${details}`;
                } else if (type === 'paranormal') {
                    details = `Efeito: ${item.efeito} | ${details}`;
                } else if (type === 'geral') {
                    details = `Bônus: ${item.bonus} | ${details}`;
                }
                
                itemElement.innerHTML = `
                    <span>${item.nome}</span>
                    <span>${details}</span>
                    <div class="equipment-actions">
                        <button class="btn-edit" data-id="${item.id}" data-type="${type}">Editar</button>
                        <button class="btn-remove" data-id="${item.id}" data-type="${type}">Remover</button>
                    </div>
                `;
                
                // Adicionar event listeners para os botões
                const editBtn = itemElement.querySelector('.btn-edit');
                const removeBtn = itemElement.querySelector('.btn-remove');
                
                editBtn.addEventListener('click', () => editEquipmentItem(item.id, type));
                removeBtn.addEventListener('click', () => removeEquipmentItem(item.id, type));
                
                listElement.appendChild(itemElement);
            });
        }
        
        function editEquipmentItem(itemId, itemType) {
            // Implementar edição de item
            alert(`Editar item ${itemId} do tipo ${itemType}`);
        }
        
        function removeEquipmentItem(itemId, itemType) {
            if (confirm('Tem certeza que deseja remover este item?')) {
                // Fazer requisição para remover item
                const formData = new FormData();
                formData.append('item_id', itemId);
                formData.append('tipo_item', itemType);
                
                fetch('remove_item_personagem.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Recarregar equipamentos
                        loadCharacterEquipment();
                        alert('Item removido com sucesso!');
                    } else {
                        alert('Erro ao remover item: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Erro ao remover item.');
                });
            }
        }
        
        function saveCharacter() {
            // Implementar salvamento da ficha completa
            alert('Salvando alterações...');
        }
    </script>
</body>
</html>