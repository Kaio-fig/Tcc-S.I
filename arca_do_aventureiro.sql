-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS arca_do_aventureiro;
USE arca_do_aventureiro;

-- Tabela de usuários
CREATE TABLE IF NOT EXISTS usuarios (
    id INT NOT NULL AUTO_INCREMENT,
    nome_usuario VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY email (email)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela de personagens
CREATE TABLE IF NOT EXISTS personagens (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    sistema VARCHAR(50) NOT NULL,
    nivel INT NOT NULL DEFAULT 1,
    imagem VARCHAR(255) DEFAULT 'default.jpg',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para armas
CREATE TABLE IF NOT EXISTS Op_armas (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    dano VARCHAR(20) NOT NULL,
    crit VARCHAR(20) NOT NULL,
    ameaca VARCHAR(20) DEFAULT NULL,
    categoria INT NOT NULL DEFAULT 0,
    espaco INT NOT NULL DEFAULT 1,
    tipo VARCHAR(20) DEFAULT NULL,
    alcance VARCHAR(20) DEFAULT NULL,
    descricao TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para proteções
CREATE TABLE IF NOT EXISTS Op_protecoes (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    defesa VARCHAR(20) NOT NULL,
    categoria INT NOT NULL DEFAULT 0,
    espaco INT NOT NULL DEFAULT 1,
    tipo VARCHAR(50) DEFAULT NULL,
    descricao TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para itens gerais
CREATE TABLE IF NOT EXISTS Op_gerais (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    bonus VARCHAR(100) DEFAULT NULL,
    categoria INT NOT NULL DEFAULT 0,
    espaco INT NOT NULL DEFAULT 1,
    tipo VARCHAR(50) DEFAULT NULL,
    descricao TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para itens paranormais
CREATE TABLE IF NOT EXISTS Op_paranormal (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    efeito TEXT NOT NULL,
    categoria INT NOT NULL DEFAULT 0,
    espaco INT NOT NULL DEFAULT 1,
    elemento VARCHAR(20) DEFAULT NULL,
    descricao TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para modificações de itens
CREATE TABLE IF NOT EXISTS Op_modificacoes (
    id INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    tipo_item ENUM('arma', 'protecao', 'geral', 'paranormal') NOT NULL,
    efeito TEXT NOT NULL,
    categoria_extra INT NOT NULL DEFAULT 0,
    descricao TEXT,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para relacionar itens com modificações
CREATE TABLE IF NOT EXISTS Op_item_modificacoes (
    id INT NOT NULL AUTO_INCREMENT,
    item_id INT NOT NULL,
    modificacao_id INT NOT NULL,
    tipo_item ENUM('arma', 'protecao', 'geral', 'paranormal') NOT NULL,
    PRIMARY KEY (id),
    KEY item_id (item_id),
    KEY modificacao_id (modificacao_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Tabela para personagem_itens (relaciona personagens com itens)
CREATE TABLE IF NOT EXISTS Op_personagem_itens (
    id INT NOT NULL AUTO_INCREMENT,
    personagem_id INT NOT NULL,
    item_id INT NOT NULL,
    tipo_item ENUM('arma', 'protecao', 'geral', 'paranormal') NOT NULL,
    modificacoes TEXT,
    categoria_final INT NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY personagem_id (personagem_id),
    FOREIGN KEY (personagem_id) REFERENCES personagens(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Inserir dados iniciais de exemplo
INSERT INTO usuarios (nome_usuario, email, senha) VALUES
('Lemuaira', 'rodrigueskaio337@gmail.com', MD5('12345')),
('Testilson', 'Testilson@gmail.com', MD5('12345'));

-- Inserir algumas armas iniciais
INSERT INTO Op_armas (nome, dano, crit, ameaca, categoria, espaco, tipo, alcance, descricao) VALUES
('Faca', '1d4', '19', NULL, 0, 1, 'C', 'Curto', 'Arma corpo a corpo leve'),
('Pistola', '1d12', '18', NULL, 1, 1, 'B', 'Curto', 'Arma de fogo leve'),
('Revolver', '2d6', '19×3', NULL, 1, 1, 'B', 'Curto', 'Arma de fogo leve'),
('Fuzil de caça', '2d8', '19×3', NULL, 1, 2, 'B', 'Médio', 'Arma de fogo duas mãos'),
('Espada', '1d8/1d10', '19', NULL, 1, 1, 'C', '-', 'Arma corpo a corpo uma mão'),
('Machado', '1d8', '×3', NULL, 1, 1, 'C', '-', 'Arma corpo a corpo uma mão'),
('Submetralhadora', '2d6', '19/x3', NULL, 1, 1, 'B', 'Curto', 'Arma de fogo automática'),
('Espingarda', '4d6', '×3', NULL, 1, 2, 'B', 'Curto', 'Arma de fogo duas mãos'),
('Fuzil de assalto', '2d10', '19/x3', NULL, 2, 2, 'B', 'Médio', 'Arma de fogo tática'),
('Fuzil de precisão', '2d10', '19/x3', NULL, 3, 2, 'B', 'Longo', 'Arma de fogo de longo alcance');

-- Inserir proteções iniciais
INSERT INTO Op_protecoes (nome, defesa, categoria, espaco, tipo, descricao) VALUES
('Leve', '+5', 1, 2, 'Armadura', 'Proteção leve que permite boa mobilidade'),
('Pesada', '+10', 2, 5, 'Armadura', 'Proteção pesada que oferece maior defesa mas reduz mobilidade'),
('Escudo', '+2', 1, 2, 'Escudo', 'Proteção adicional que pode ser empunhada');

-- Inserir itens gerais iniciais
INSERT INTO Op_gerais (nome, bonus, categoria, espaco, tipo, descricao) VALUES
('Kit Médico', '+5 em testes de Medicina', 0, 1, 'Utensílio', 'Equipamento médico para primeiros socorros'),
('Lanterna', 'Iluminação em área média', 0, 1, 'Ferramenta', 'Fonte de luz portátil'),
('Rádio Comunicador', 'Comunicação em até 1km', 0, 1, 'Comunicação', 'Dispositivo de comunicação por rádio'),
('Binóculos', '+2 em Percepção à distância', 0, 1, 'Utensílio', 'Dispositivo óptico para visão à distância'),
('Corda', '15m de corda resistente', 0, 1, 'Utensílio', 'Corda de nylon para escalada e amarração'),
('Máscara de gás', 'Proteção contra gases', 0, 1, 'Proteção', 'Máscara de proteção respiratória'),
('Granada de Fragmentação', '4d6 de dano em área', 1, 1, 'Explosivo', 'Explosivo de fragmentação para múltiplos alvos'),
('Granada de Fumaça', 'Cria área de cobertura', 0, 1, 'Explosivo', 'Granada que libera fumaça para ocultação');

-- Inserir itens paranormais iniciais
INSERT INTO Op_paranormal (nome, efeito, categoria, espaco, elemento, descricao) VALUES
('Amuleto de Proteção', 'Fornece +2 em Defesa', 1, 1, 'Conhecimento', 'Amuleto que oferece proteção contra ataques'),
('Anel do Elo Mental', 'Permite comunicação telepática', 2, 1, 'Conhecimento', 'Par de anéis que conecta mentalmente os usuários'),
('Pérola de Sangue', 'Fornece +5 em testes físicos temporariamente', 2, 1, 'Sangue', 'Esfera que injeta adrenalina no usuário'),
('Máscara das Sombras', 'Permite teletransporte entre sombras', 3, 1, 'Morte', 'Máscara que concede habilidades de manipulação de sombras'),
('Coração Pulsante', 'Reduz dano pela metade uma vez por cena', 2, 1, 'Sangue', 'Coração humano preservado que pulsa com energia de Sangue'),
('Frasco de Vitalidade', 'Armazena PV para recuperação posterior', 1, 1, 'Sangue', 'Frasco que pode armazenar sangue para uso posterior');

-- Inserir modificações iniciais
INSERT INTO Op_modificacoes (nome, tipo_item, efeito, categoria_extra, descricao) VALUES
-- Modificações para armas
('Certeira', 'arma', '+2 em testes de ataque', 1, 'Modificação que melhora a precisão da arma'),
('Cruel', 'arma', '+2 em rolagens de dano', 1, 'Modificação que aumenta o dano causado'),
('Discreta', 'arma', '+5 em testes para ser ocultada e reduz o espaço em -1', 0, 'Modificação que torna a arma mais fácil de ocultar'),
('Perigosa', 'arma', '+2 em margem de ameaça', 1, 'Modificação que aumenta a chance de acerto crítico'),
('Alongada', 'arma', '+2 em testes de ataque', 1, 'Modificação para armas de fogo que aumenta o alcance'),
('Calibre Grosso', 'arma', 'Aumenta o dano em mais um dado do mesmo tipo', 1, 'Modificação que aumenta o calibre da arma'),
-- Modificações para proteções
('Antibombas', 'protecao', '+5 em testes de resistência contra efeitos de área', 1, 'Modificação que oferece proteção contra explosões'),
('Blindada', 'protecao', 'Aumenta RD para 5 e o espaço em +1', 1, 'Modificação que aumenta a resistência a dano'),
('Discreta', 'protecao', '+5 em testes de ocultar e reduz o espaço em -1', 0, 'Modificação que torna a proteção mais fácil de ocultar'),
('Reforçada', 'protecao', 'Aumenta a Defesa em +2 e o espaço em +1', 1, 'Modificação que aumenta a proteção oferecida'),
-- Modificações paranormais
('Amaldiçoada', 'paranormal', 'Adiciona efeito paranormal ao item', 2, 'Modificação que imbui o item com energia paranormal'),
('Potencializada', 'paranormal', 'Aumenta a potência do efeito paranormal', 1, 'Modificação que amplifica os efeitos paranormais');