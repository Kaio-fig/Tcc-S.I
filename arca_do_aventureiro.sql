-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 29-Out-2025 às 13:42
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `arca_do_aventureiro`
--
CREATE DATABASE IF NOT EXISTS `arca_do_aventureiro` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `arca_do_aventureiro`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `classes`
--

CREATE TABLE IF NOT EXISTS `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pv_inicial` int(11) NOT NULL,
  `pv_por_nivel` int(11) NOT NULL,
  `pe_inicial` int(11) NOT NULL DEFAULT '1',
  `pe_por_nivel` int(11) NOT NULL,
  `san_inicial` int(11) NOT NULL,
  `san_por_nivel` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `classes`
--

INSERT INTO `classes` (`id`, `nome`, `pv_inicial`, `pv_por_nivel`, `pe_inicial`, `pe_por_nivel`, `san_inicial`, `san_por_nivel`) VALUES
(1, 'Combatente', 20, 4, 2, 2, 12, 3),
(2, 'Especialista', 16, 3, 3, 3, 16, 4),
(3, 'Ocultista', 12, 2, 4, 4, 20, 5);

-- --------------------------------------------------------

--
-- Estrutura da tabela `historias`
--

CREATE TABLE IF NOT EXISTS `historias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `sistema_jogo` varchar(100) DEFAULT 'Desconhecido',
  `sinopse` text,
  `imagem_historia` varchar(255) DEFAULT 'default_historia.jpg',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventario_op`
--

CREATE TABLE IF NOT EXISTS `inventario_op` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personagem_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `quantidade` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `personagem_id` (`personagem_id`),
  KEY `item_id` (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_op`
--

CREATE TABLE IF NOT EXISTS `itens_op` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `tipo_item_id` int(11) NOT NULL COMMENT '1: Arma, 2: Proteção, 3: Geral, 4: Amaldiçoado',
  `categoria` int(11) NOT NULL DEFAULT '0' COMMENT 'O número romano da categoria (I, II, III, IV)',
  `espacos` int(11) NOT NULL DEFAULT '1',
  `descricao` text,
  `dano` varchar(20) DEFAULT NULL,
  `critico` varchar(20) DEFAULT NULL,
  `alcance` varchar(50) DEFAULT NULL,
  `tipo_dano` varchar(20) DEFAULT NULL,
  `defesa_bonus` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=78 ;

--
-- Extraindo dados da tabela `itens_op`
--

INSERT INTO `itens_op` (`id`, `nome`, `tipo_item_id`, `categoria`, `espacos`, `descricao`, `dano`, `critico`, `alcance`, `tipo_dano`, `defesa_bonus`) VALUES
(1, 'Coronhada', 1, 0, 1, NULL, '1d4/1d6', 'x2', '-', 'I', NULL),
(2, 'Faca', 1, 0, 1, NULL, '1d4', '19', 'Curto', 'C', NULL),
(3, 'Martelo', 1, 0, 1, NULL, '1d6', 'x2', '-', 'I', NULL),
(4, 'Punhal', 1, 0, 1, NULL, '1d4', 'x3', '-', 'P', NULL),
(5, 'Bastão', 1, 0, 1, NULL, '1d6/1d8', 'x2', '-', 'I', NULL),
(6, 'Machete', 1, 0, 1, NULL, '1d6', '19', '-', 'C', NULL),
(7, 'Lança', 1, 0, 1, NULL, '1d6', 'x2', 'Curto', 'P', NULL),
(8, 'Cajado', 1, 0, 2, NULL, '1d6/1d6', 'x2', '-', 'I', NULL),
(9, 'Arco', 1, 0, 2, NULL, '1d6', 'x3', 'Médio', 'P', NULL),
(10, 'Flechas', 1, 0, 1, NULL, '-', '-', '-', '-', NULL),
(11, 'Besta', 1, 0, 2, NULL, '1d8', '19', 'Médio', 'P', NULL),
(12, 'Pistola', 1, 1, 1, NULL, '1d12', '18', 'Curto', 'B', NULL),
(13, 'Balas Curtas', 1, 0, 1, NULL, '-', '-', '-', '-', NULL),
(14, 'Revólver', 1, 1, 1, NULL, '2d6', '19/x3', 'Curto', 'B', NULL),
(15, 'Fuzil de Caça', 1, 1, 2, NULL, '2d8', '19/x3', 'Médio', 'B', NULL),
(16, 'Balas Longas', 1, 1, 1, NULL, '-', '-', '-', '-', NULL),
(17, 'Machadinha', 1, 0, 1, NULL, '1d6', 'x3', 'Curto', 'C', NULL),
(18, 'Nunchaku', 1, 0, 1, NULL, '1d8', 'x2', '-', 'I', NULL),
(19, 'Corrente', 1, 0, 1, NULL, '1d8', 'x2', '-', 'I', NULL),
(20, 'Espada', 1, 1, 1, NULL, '1d8/1d10', '19', '-', 'C', NULL),
(21, 'Florete', 1, 1, 1, NULL, '1d6', '18', '-', 'C', NULL),
(22, 'Machado', 1, 1, 1, NULL, '1d8', 'x3', '-', 'C', NULL),
(23, 'Maça', 1, 1, 1, NULL, '2d4', 'x2', '-', 'I', NULL),
(24, 'Acha', 1, 1, 2, NULL, '1d12', 'x3', '-', 'C', NULL),
(25, 'Gadanho', 1, 1, 2, NULL, '2d4', 'x4', '-', 'C', NULL),
(26, 'Katana', 1, 1, 2, NULL, '1d10', '19', '-', 'C', NULL),
(27, 'Marreta', 1, 1, 2, NULL, '3d4', 'x2', '-', 'I', NULL),
(28, 'Montante', 1, 1, 2, NULL, '2d6', '19', '-', 'C', NULL),
(29, 'Motosserra', 1, 1, 2, NULL, '3d6', 'x2', '-', 'C', NULL),
(30, 'Arco Composto', 1, 1, 2, NULL, '1d10', 'x3', 'Médio', 'P', NULL),
(31, 'Balestra', 1, 1, 2, NULL, '1d12', '19', 'Médio', 'P', NULL),
(32, 'Submetralhadora', 1, 1, 1, NULL, '2d6', '19/x3', 'Curto', 'B', NULL),
(33, 'Espingarda', 1, 1, 2, NULL, '4d6', 'x3', 'Curto', 'B', NULL),
(34, 'Cartuchos', 1, 1, 1, NULL, '-', '-', '-', '-', NULL),
(35, 'Fuzil de Assalto', 1, 2, 2, NULL, '2d10', '19/x3', 'Médio', 'B', NULL),
(36, 'Fuzil de Precisão', 1, 3, 2, NULL, '2d10', '19/x3', 'Longo', 'B', NULL),
(37, 'Bazuca', 1, 3, 2, NULL, '10d8', 'x2', 'Médio', 'I', NULL),
(38, 'Foguete', 1, 1, 1, NULL, '-', '-', '-', '-', NULL),
(39, 'Lança-Chamas', 1, 3, 2, NULL, '6d6', 'x2', 'Curto', 'Fogo', NULL),
(40, 'Combustível', 1, 1, 1, NULL, '-', '-', '-', '-', NULL),
(41, 'Metralhadora', 1, 2, 2, NULL, '2d12', 'x2', 'Médio', 'B', NULL),
(42, 'Proteção Leve', 2, 1, 2, NULL, NULL, NULL, NULL, NULL, 5),
(43, 'Proteção Pesada', 2, 2, 5, NULL, NULL, NULL, NULL, NULL, 10),
(44, 'Escudo', 2, 1, 2, NULL, NULL, NULL, NULL, NULL, 2),
(45, 'Kit de perícia', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(46, 'Utensílio', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(47, 'Vestimenta', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(48, 'Granada de atordoamento', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(49, 'Granada de fragmentação', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(50, 'Granada de fumaça', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(51, 'Granada incendiária', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(52, 'Mina antipessoal', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(53, 'Algemas', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(54, 'Arpéu', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(55, 'Bandoleira', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(56, 'Binóculos', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(57, 'Bloqueador de sinal', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(58, 'Cicatrizante', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(59, 'Corda', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(60, 'Equipamento de sobrevivência', 3, 0, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(61, 'Lanterna tática', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(62, 'Máscara de gás', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(63, 'Mochila militar', 3, 1, 0, NULL, NULL, NULL, NULL, NULL, NULL),
(64, 'Óculos de visão térmica', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(65, 'Pé de cabra', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(66, 'Pistola de dardos', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(67, 'Pistola sinalizadora', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(68, 'Soqueira', 3, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(69, 'Spray de pimenta', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(70, 'Taser', 3, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(71, 'Traje hazmat', 3, 1, 2, NULL, NULL, NULL, NULL, NULL, NULL),
(72, 'Amarras de (elemento)', 4, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(73, 'Câmera de aura paranormal', 4, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(74, 'Componentes ritualísticos de (elemento)', 4, 0, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(75, 'Emissor de pulsos paranormais', 4, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(76, 'Escuta de ruídos paranormais', 4, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(77, 'Scanner de manifestação paranormal de (elemento)', 4, 2, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `mundos`
--

CREATE TABLE IF NOT EXISTS `mundos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `sistema_jogo` varchar(100) DEFAULT 'Desconhecido',
  `descricao` text,
  `imagem_mundo` varchar(255) DEFAULT 'default_mundo.jpg',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_item_modificacoes`
--

CREATE TABLE IF NOT EXISTS `op_item_modificacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `modificacao_id` int(11) NOT NULL,
  `tipo_item` enum('arma','protecao','geral','paranormal') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `item_id` (`item_id`),
  KEY `modificacao_id` (`modificacao_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_modificacoes`
--

CREATE TABLE IF NOT EXISTS `op_modificacoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `tipo_item` varchar(50) NOT NULL,
  `efeito` text NOT NULL,
  `categoria_extra` int(11) NOT NULL DEFAULT '0',
  `tipo_modificacao` enum('mundana','paranormal') NOT NULL,
  `elemento` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=39 ;

--
-- Extraindo dados da tabela `op_modificacoes`
--

INSERT INTO `op_modificacoes` (`id`, `nome`, `tipo_item`, `efeito`, `categoria_extra`, `tipo_modificacao`, `elemento`) VALUES
(1, 'Certeira', 'arma', '+2 em testes de ataque.', 1, 'mundana', NULL),
(2, 'Cruel', 'arma', '+2 em rolagens de dano.', 1, 'mundana', NULL),
(3, 'Discreta', 'arma', '+5 em testes para ser ocultada e reduz o espaço em -1.', 1, 'mundana', NULL),
(4, 'Perigosa', 'arma', '+2 em margem de ameaça.', 1, 'mundana', NULL),
(5, 'Tática', 'arma', 'Pode sacar como ação livre.', 1, 'mundana', NULL),
(6, 'Alongada', 'arma', '+2 em testes de ataque.', 1, 'mundana', NULL),
(7, 'Calibre Grosso', 'arma', 'Aumenta o dano em mais um dado do mesmo tipo.', 1, 'mundana', NULL),
(8, 'Compensador', 'arma', 'Anula penalidade por rajadas.', 1, 'mundana', NULL),
(9, 'Ferrolho Automático', 'arma', 'A arma se torna automática.', 1, 'mundana', NULL),
(10, 'Mira Laser', 'arma', '+2 em margem de ameaça.', 1, 'mundana', NULL),
(11, 'Mira Telescópica', 'arma', 'Aumenta alcance da arma e a habilidade Ataque Furtivo.', 1, 'mundana', NULL),
(12, 'Silenciador', 'arma', 'Reduz em -2d20 a penalidade em Furtividade para se esconder após atacar.', 1, 'mundana', NULL),
(13, 'Visão de Calor', 'arma', 'Ignora camuflagem.', 1, 'mundana', NULL),
(14, 'Dum dum', 'arma', '+1 em multiplicador de crítico.', 1, 'mundana', NULL),
(15, 'Explosiva', 'arma', 'Aumenta o dano em +2d6.', 1, 'mundana', NULL),
(16, 'Abascanta', 'protecao', '+5 em testes de resistência contra rituais.', 1, 'paranormal', 'Conhecimento'),
(17, 'Profética', 'protecao', 'Resistência a Conhecimento 10.', 1, 'paranormal', 'Conhecimento'),
(18, 'Cinética', 'protecao', '+2 em Defesa e resistência a dano 2.', 1, 'paranormal', 'Energia'),
(19, 'Lépida', 'protecao', '+10 em testes de Atletismo e +3m de deslocamento.', 1, 'paranormal', 'Energia'),
(20, 'Voltáica', 'protecao', 'Resistência a Energia 10.', 1, 'paranormal', 'Energia'),
(21, 'Letárgica', 'protecao', '+2 em Defesa e chance de ignorar dano extra.', 1, 'paranormal', 'Morte'),
(22, 'Repulsiva', 'protecao', 'Resistência a Morte 10.', 1, 'paranormal', 'Morte'),
(23, 'Sombria', 'protecao', '+5 em Furtividade e ignora penalidade de carga.', 1, 'paranormal', 'Morte'),
(24, 'Regenerativa', 'protecao', 'Resistência a Sangue 10.', 1, 'paranormal', 'Sangue'),
(25, 'Sádica', 'protecao', '+1 em testes de ataque e rolagens de dano para cada 10 pontos de dano sofrido.', 1, 'paranormal', 'Sangue'),
(26, 'Carisma', 'acessorio', '+1 em Presença.', 1, 'paranormal', 'Conhecimento'),
(27, 'Conjuração', 'acessorio', 'Permite conjurar um ritual de 1º círculo.', 1, 'paranormal', 'Conhecimento'),
(28, 'Escudo Mental', 'acessorio', 'Resistência mental 10.', 1, 'paranormal', 'Conhecimento'),
(29, 'Reflexão', 'acessorio', 'Pode refletir um ritual de volta ao conjurador.', 1, 'paranormal', 'Conhecimento'),
(30, 'Sagacidade', 'acessorio', '+1 em Intelecto.', 1, 'paranormal', 'Conhecimento'),
(31, 'Defesa', 'acessorio', '+5 em Defesa.', 1, 'paranormal', 'Energia'),
(32, 'Destreza', 'acessorio', '+1 em Agilidade.', 1, 'paranormal', 'Energia'),
(33, 'Potência', 'acessorio', 'Aumenta a DT de habilidades, poderes e rituais em +1.', 1, 'paranormal', 'Energia'),
(34, 'Esforço Adicional', 'acessorio', '+5 PE.', 1, 'paranormal', 'Morte'),
(35, 'Disposição', 'acessorio', '+1 em Vigor.', 1, 'paranormal', 'Sangue'),
(36, 'Pujança', 'acessorio', '+1 em Força.', 1, 'paranormal', 'Sangue'),
(37, 'Vitalidade', 'acessorio', '+15 PV.', 1, 'paranormal', 'Sangue'),
(38, 'Proteção Elemental', 'acessorio', 'Resistência 10 contra um elemento.', 1, 'paranormal', 'Varia');

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_personagem_itens`
--

CREATE TABLE IF NOT EXISTS `op_personagem_itens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personagem_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `tipo_item` enum('arma','protecao','geral','paranormal') NOT NULL,
  `modificacoes` text,
  `categoria_final` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `personagem_id` (`personagem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `origens`
--

CREATE TABLE IF NOT EXISTS `origens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `poder_nome` varchar(100) NOT NULL,
  `poder_desc` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=27 ;

--
-- Extraindo dados da tabela `origens`
--

INSERT INTO `origens` (`id`, `nome`, `poder_nome`, `poder_desc`) VALUES
(1, 'Acadêmico', 'Saber é Poder', 'Você pode usar seu Intelecto em vez de Presença em testes de Ocultismo e Religião.'),
(2, 'Agente de Saúde', 'Médico de Campo', 'Sempre que você curar um personagem com a perícia Medicina, você adiciona seu Intelecto no total de PV curados.'),
(3, 'Amnésico', 'Vislumbres do Passado', 'Uma vez por cena, você pode gastar 2 PE para rolar novamente um teste de perícia recém realizado. Você deve usar o segundo resultado.'),
(4, 'Artista', 'Obra Prima', 'Você pode gastar uma ação padrão e 2 PE para inspirar seus aliados. Você e aliados em alcance curto recebem +2 em testes de Vontade até o fim da cena.'),
(5, 'Atleta', '110%', 'Você pode gastar 2 PE para receber +5 em um teste de Atletismo ou Acrobacia.'),
(6, 'Chef', 'Comida Caseira', 'Você pode gastar uma ação padrão e 2 PE para preparar um alimento. Um personagem pode consumir este alimento para recuperar 1d6 pontos de vida.'),
(7, 'Criminoso', 'O Crime Compensa', 'No início de cada missão, você recebe um item adicional de categoria I à sua escolha.'),
(8, 'Cultista Arrependido', 'Traços do Outro Lado', 'Você sabe identificar e falar o idioma do Outro Lado, "Língua das Profundezas". Além disso, recebe +2 em testes de Ocultismo.'),
(9, 'Desgarrado', 'Calejado', 'Você recebe +1 PV para cada 5% de NEX.'),
(10, 'Engenheiro', 'Ferramentas Favoritas', 'Você recebe um kit de perícia de Profissão (Engenharia) com a modificação "Melhorada", que fornece +2 em testes.'),
(11, 'Executivo', 'Processo Otimizado', 'Uma vez por cena, você pode gastar 2 PE para realizar uma ação de interlúdio de "Obter Informação" como uma ação padrão.'),
(12, 'Lutador', 'Mão Pesada', 'Seus ataques desarmados causam 1d6 de dano e podem causar dano letal.'),
(13, 'Magnata', 'Patrocinador da Ordem', 'Você recebe +2 de Crédito no início de cada missão.'),
(14, 'Militar', 'Para Bellum', 'Você recebe +2 em rolagens de dano com armas de fogo.'),
(15, 'Operário', 'Ferramenta de Trabalho', 'Escolha uma arma simples ou tática que se assemelhe a uma ferramenta. Você recebe proficiência com essa arma.'),
(16, 'Policial', 'Investigador', 'Você recebe +2 na defesa\r\n'),
(17, 'Religioso', 'Acalentar', 'Você pode gastar uma ação padrão e 2 PE para acalmar um alvo em alcance curto, que recupera 1d6 pontos de Sanidade.'),
(18, 'Servidor Público', 'Espírito Cívico', 'Você recebe +2 em testes de Diplomacia e Intimidação.'),
(19, 'Teórico da Conspiração', 'Eu Sabia!', 'Uma vez por cena, você pode gastar 2 PE para receber +5 em um teste de Atualidades ou Investigação para descobrir uma pista ou segredo.'),
(20, 'T.I.', 'Motor de Busca', 'Você pode gastar 2 PE para usar a perícia Tecnologia para procurar informações como se estivesse usando Investigação.'),
(21, 'Trabalhador Rural', 'Desbravador', 'Você recebe +5 em testes de Sobrevivência.'),
(22, 'Trambiqueiro', 'Impostor', 'Você pode gastar 2 PE para receber +5 em um teste de Enganação.'),
(23, 'Universitário', 'Dedicado', 'Você recebe +2 em testes de Intelecto.'),
(24, 'Vítima', 'Cicatrizes Psicológicas', 'Você recebe +1 de Sanidade para cada 5% de NEX.'),
(25, 'Investigador', 'Faro para Pistas', 'Uma vez por cena, quando fizer um teste  para procurar pistas, você pode gastar 1 PE para receber +5 nesse teste.'),
(26, 'Mercenário', 'Posição de combate', 'No primeiro turno de cada cena de ação, você pode gastar 2 PE para receber uma ação de movimento adicional.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `pericias`
--

CREATE TABLE IF NOT EXISTS `pericias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personagem_id` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `valor` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personagem_pericia_unique` (`personagem_id`,`nome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personagens_op`
--

CREATE TABLE IF NOT EXISTS `personagens_op` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `imagem` varchar(255) DEFAULT 'default.jpg',
  `nex` int(11) NOT NULL DEFAULT '5',
  `origem_id` int(11) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL,
  `trilha_id` int(11) DEFAULT NULL,
  `patente` varchar(50) DEFAULT NULL,
  `pontos_prestigio` int(11) DEFAULT '0',
  `vida_max` int(11) DEFAULT '0',
  `pe_max` int(11) DEFAULT '0',
  `sanidade_max` int(11) DEFAULT '0',
  `forca` int(11) NOT NULL DEFAULT '1',
  `agilidade` int(11) NOT NULL DEFAULT '1',
  `intelecto` int(11) NOT NULL DEFAULT '1',
  `vigor` int(11) NOT NULL DEFAULT '1',
  `presenca` int(11) NOT NULL DEFAULT '1',
  `defesa` int(11) NOT NULL DEFAULT '11',
  `inventario_espacos` int(11) NOT NULL DEFAULT '7',
  `poderes_classe` text,
  `poderes_paranormais` text,
  `rituais` text,
  `habilidades_trilha` text,
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `fk_origem` (`origem_id`),
  KEY `fk_classe` (`classe_id`),
  KEY `fk_trilha` (`trilha_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personagens_op_poderes`
--

CREATE TABLE IF NOT EXISTS `personagens_op_poderes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personagem_id` int(11) NOT NULL,
  `poder_id` int(11) NOT NULL,
  `tipo_poder` enum('classe','paranormal') NOT NULL,
  PRIMARY KEY (`id`),
  KEY `personagem_id` (`personagem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `personagens_t20`
--

CREATE TABLE IF NOT EXISTS `personagens_t20` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `jogador` varchar(100) DEFAULT NULL,
  `nivel` int(11) NOT NULL DEFAULT '1',
  `raca_id` int(11) DEFAULT NULL,
  `origem_id` int(11) DEFAULT NULL,
  `classe_id` int(11) DEFAULT NULL,
  `divindade_id` int(11) DEFAULT NULL,
  `imagem` varchar(255) DEFAULT 'default_t20.jpg',
  `pv_max` int(11) DEFAULT '0',
  `pv_atual` int(11) DEFAULT '0',
  `pm_max` int(11) DEFAULT '0',
  `pm_atual` int(11) DEFAULT '0',
  `forca` int(11) NOT NULL DEFAULT '10',
  `destreza` int(11) NOT NULL DEFAULT '10',
  `constituicao` int(11) NOT NULL DEFAULT '10',
  `inteligencia` int(11) NOT NULL DEFAULT '10',
  `sabedoria` int(11) NOT NULL DEFAULT '10',
  `carisma` int(11) NOT NULL DEFAULT '10',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_t20` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `poderes_classe`
--

CREATE TABLE IF NOT EXISTS `poderes_classe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_id` int(11) DEFAULT NULL,
  `nex_requerido` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `classe_id` (`classe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=50 ;

--
-- Extraindo dados da tabela `poderes_classe`
--

INSERT INTO `poderes_classe` (`id`, `classe_id`, `nex_requerido`, `nome`, `descricao`) VALUES
(1, NULL, 15, 'Transcender', 'Você abre mão de um aumento de Sanidade para aprender um poder paranormal.'),
(2, NULL, 15, 'Treinamento em Perícia', 'Escolha duas perícias. Você se torna treinado nelas. Pode ser escolhido múltiplas vezes para se tornar Veterano (NEX 35%) e Expert (NEX 70%).'),
(3, 1, 15, 'Armamento Pesado', 'Você recebe proficiência com armas pesadas. (Pré-req: For 2)'),
(4, 1, 15, 'Artista Marcial', 'Seus ataques desarmados causam 1d6 de dano e contam como armas ágeis. O dano aumenta para 1d8 em NEX 35% e 1d10 em NEX 70%.'),
(5, 1, 15, 'Ataque de Oportunidade', 'Pode gastar 1 PE e uma reação para fazer um ataque corpo a corpo em um ser que sair de um espaço adjacente a você.'),
(6, 1, 15, 'Combater com Duas Armas', 'Se estiver usando duas armas (uma leve), pode fazer dois ataques na ação agredir, com -2 nos testes de ataque. (Pré-req: Agi 3)'),
(7, 1, 15, 'Combate Defensivo', 'Quando usa a ação agredir, pode sofrer -2 nos ataques para receber +5 na Defesa. (Pré-req: Int 2)'),
(8, 1, 15, 'Golpe Demolidor', 'Pode gastar 1 PE para causar +2d de dano do mesmo tipo da sua arma contra objetos. (Pré-req: For 2)'),
(9, 1, 15, 'Golpe Pesado', 'O dano de suas armas corpo a corpo aumenta em mais um dado do mesmo tipo.'),
(10, 1, 15, 'Incansável', 'Uma vez por cena, pode gastar 2 PE para fazer uma ação de investigação adicional usando Força ou Agilidade.'),
(11, 1, 15, 'Presteza Atlética', 'Pode gastar 1 PE para usar Força ou Agilidade em um teste para facilitar a investigação.'),
(12, 1, 30, 'Proteção Pesada', 'Você recebe proficiência com Proteções Pesadas. (Pré-req: NEX 30%)'),
(13, 1, 15, 'Reflexos Defensivos', 'Você recebe +2 em Defesa e em testes de resistência. (Pré-req: Agi 2)'),
(14, 1, 15, 'Saque Rápido', 'Você pode sacar ou guardar itens como uma ação livre.'),
(15, 1, 60, 'Segurar o Gatilho', 'Pode gastar PE para fazer ataques extras com armas de fogo. (Pré-req: NEX 60%)'),
(16, 1, 15, 'Sentido Tático', 'Pode gastar 2 PE para receber um bônus em Defesa e resistência igual ao seu Intelecto. (Pré-req: Int 2)'),
(17, 1, 30, 'Tanque de Guerra', 'Se estiver usando proteção pesada, a Defesa e RD dela aumentam em +2. (Pré-req: Proteção Pesada)'),
(18, 1, 15, 'Tiro Certeiro', 'Soma sua Agilidade no dano com armas de disparo e ignora penalidade por alvo em combate corpo a corpo.'),
(19, 1, 15, 'Tiro de Cobertura', 'Pode gastar 1 PE e uma ação padrão para forçar um alvo a se proteger, sofrendo -5 em testes de ataque.'),
(20, 2, 15, 'Perito', 'Escolha uma perícia. Você recebe +5 nela (não cumulativo com bônus de treinamento).'),
(21, 2, 40, 'Engenhosidade', 'Em NEX 40%, ao usar Eclético, pode gastar +2 PE para receber os benefícios de ser veterano na perícia.'),
(22, 3, 15, 'Fortalecimento Ritual', 'Seus rituais com duração de cena ou mais têm sua duração duplicada.'),
(23, 3, 30, 'Mente Sã', 'Você recebe +1 de Sanidade para cada 5% de NEX.'),
(24, 2, 15, 'Balística Avançada', 'Você recebe proficiência com armas táticas de fogo e +2 em rolagens de dano com armas de fogo.'),
(25, 2, 15, 'Conhecimento Aplicado', 'Quando faz um teste de perícia (exceto Luta e Pontaria), você pode gastar 2 PE para mudar o atributo-base da perícia para Intelecto. (Pré-req: Int 2)'),
(26, 2, 15, 'Hacker', 'Você recebe +5 em testes de Tecnologia para invadir sistemas e diminui o tempo necessário para hackear para uma ação completa. (Pré-req: treinado em Tecnologia)'),
(27, 2, 15, 'Mãos Rápidas', 'Ao fazer um teste de Crime, você pode pagar 1 PE para fazê-lo como uma ação livre. (Pré-req: Agi 3, treinado em Crime)'),
(28, 2, 15, 'Mochila de Utilidades', 'Um item a sua escolha (exceto armas) conta como uma categoria abaixo e ocupa 1 espaço a menos.'),
(29, 2, 15, 'Movimento Tático', 'Você pode gastar 1 PE para ignorar a penalidade em deslocamento por terreno difícil e por escalar até o final do turno. (Pré-req: treinado em Atletismo)'),
(30, 2, 15, 'Na Trilha Certa', 'Sempre que tiver sucesso em um teste para procurar pistas, você pode gastar 1 PE para receber +2 no próximo teste (cumulativo).'),
(31, 2, 15, 'Nerd', 'Uma vez por cena, pode gastar 2 PE para fazer um teste de Atualidades (DT 20) para receber uma informação útil para a cena.'),
(32, 2, 15, 'Ninja Urbano', 'Você recebe proficiência com armas táticas de ataque corpo a corpo e de disparo (exceto de fogo) e +2 em rolagens de dano com elas.'),
(33, 2, 15, 'Pensamento Ágil', 'Uma vez por rodada, durante uma cena de investigação, você pode gastar 2 PE para fazer uma ação de procurar pistas adicional.'),
(34, 2, 15, 'Perito em Explosivos', 'Você soma seu Intelecto na DT para resistir aos seus explosivos e pode excluir dos efeitos da explosão um número de alvos igual ao seu Intelecto.'),
(35, 2, 15, 'Primeira Impressão', 'Você recebe +10 no primeiro teste de Diplomacia, Enganação, Intimidação ou Intuição que fizer em uma cena.'),
(36, 3, 15, 'Camuflar Ocultismo', 'Você pode gastar +2 PE para lançar um ritual sem componentes ritualísticos e gesticulação. Outros seres só percebem o ritual com um teste de Ocultismo (DT 25).'),
(37, 3, 15, 'Criar Selo', 'Você sabe fabricar selos paranormais de rituais que conheça. Fabricar um selo gasta uma ação de interlúdio e PE iguais ao custo do ritual.'),
(38, 3, 15, 'Envolto em Mistério', 'Você recebe +5 em Enganação e Intimidação contra pessoas não treinadas em Ocultismo.'),
(39, 3, 15, 'Especialista em Elemento', 'Escolha um elemento. A DT para resistir aos seus rituais desse elemento aumenta em +2.'),
(40, 3, 15, 'Ferramentas Paranormais', 'Você reduz a categoria de um item paranormal em I e pode ativá-los sem pagar seu custo em PE.'),
(41, 3, 60, 'Fluxo de Poder', 'Você pode manter dois rituais sustentados ativos ao mesmo tempo com uma única ação livre. (Pré-req: NEX 60%)'),
(42, 3, 15, 'Guiado pelo Paranormal', 'Uma vez por cena, você pode gastar 2 PE para fazer uma ação de investigação adicional.'),
(43, 3, 15, 'Identificação Paranormal', 'Você recebe +10 em testes de Ocultismo para identificar criaturas, objetos ou rituais.'),
(44, 3, 15, 'Improvisar Componentes', 'Uma vez por cena, pode gastar uma ação completa e um teste de Investigação (DT 15) para encontrar componentes de um elemento à sua escolha.'),
(45, 3, 15, 'Intuição Paranormal', 'Sempre que usa a ação facilitar investigação, você soma seu Intelecto ou Presença no teste (à sua escolha).'),
(46, 3, 45, 'Mestre em Elemento', 'Escolha um elemento em que já seja Especialista. O custo para lançar rituais desse elemento diminui em –1 PE. (Pré-req: NEX 45%)'),
(47, 3, 15, 'Ritual Potente', 'Você soma seu Intelecto nas rolagens de dano ou nos efeitos de cura de seus rituais. (Pré-req: Int 2)'),
(48, 3, 15, 'Ritual Predileto', 'Escolha um ritual que você conhece. Você reduz em –1 PE o custo do ritual.'),
(49, 3, 15, 'Tatuagem Ritualística', 'Símbolos em sua pele reduzem em –1 PE o custo de rituais de alcance pessoal que têm você como alvo.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `poderes_paranormais`
--

CREATE TABLE IF NOT EXISTS `poderes_paranormais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `elemento` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=23 ;

--
-- Extraindo dados da tabela `poderes_paranormais`
--

INSERT INTO `poderes_paranormais` (`id`, `nome`, `descricao`, `elemento`) VALUES
(1, 'Anatomia Insana', 'Seu corpo é transfigurado. Você tem 50% de chance de ignorar o dano adicional de um acerto crítico ou ataque furtivo. Pré-requisito: Sangue 2.', 'Sangue'),
(2, 'Arma de Sangue', 'Você pode gastar uma ação de movimento e 2 PE para produzir garras, chifres ou uma lâmina de sangue que brota de seu corpo (arma simples, 1d6 de dano).', 'Sangue'),
(3, 'Sangue de Ferro', 'Seu sangue flui de forma paranormal e agressiva. Você recebe +2 pontos de vida por NEX.', 'Sangue'),
(4, 'Sangue Fervente', 'Enquanto estiver machucado, você recebe +1 em Agilidade ou Força (à sua escolha). Pré-requisito: Sangue 2.', 'Sangue'),
(5, 'Sangue Vivo', 'Na primeira vez que ficar machucado durante uma cena, você recebe cura acelerada 2. O efeito dura até o final da cena. Pré-requisito: Sangue 1.', 'Sangue'),
(6, 'Afortunado', 'Uma vez por rolagem, você pode rolar novamente um resultado 1 em qualquer dado que não seja d20.', 'Energia'),
(7, 'Campo Protetor', 'Você consegue gerar um campo de Energia que o protege de perigos. Quando usa a ação esquiva, pode gastar 1 PE para receber +5 em Defesa. Pré-requisito: Energia 1.', 'Energia'),
(8, 'Causalidade Fortuita', 'A Energia o conduz rumo a descobertas. Em cenas de investigação, a DT para procurar pistas diminui em –5 para você.', 'Energia'),
(9, 'Golpe de Sorte', 'Seus ataques recebem +1 na margem de ameaça. Pré-requisito: Energia 1.', 'Energia'),
(10, 'Manipular Entropia', 'Você pode gastar 2 PE para fazer um alvo em alcance curto rolar novamente um dos dados em um teste de perícia. Pré-requisito: Energia 1.', 'Energia'),
(11, 'Encarar a Morte', 'Sua conexão com a Morte faz com que você não hesite em situações de perigo. Durante cenas de ação, seu limite de gasto de PE aumenta em +1.', 'Morte'),
(12, 'Escapar da Morte', 'Uma vez por cena, quando um dano o deixaria com 0 PV, você fica com 1 PV. Não funciona em caso de dano massivo. Pré-requisito: Morte 1.', 'Morte'),
(13, 'Potencial Aprimorado', 'Você recebe +1 ponto de esforço por NEX.', 'Morte'),
(14, 'Potencial Reaproveitado', 'Uma vez por rodada, quando passa num teste de resistência, você ganha 2 PE temporários cumulativos.', 'Morte'),
(15, 'Surto Temporal', 'Uma vez por cena, você pode gastar 3 PE para realizar uma ação padrão adicional. Pré-requisito: Morte 2.', 'Morte'),
(16, 'Expansão de Conhecimento', 'Você se conecta com o Conhecimento, rompendo os limites de sua compreensão. Você aprende um poder de classe que não pertença à sua classe. Pré-requisito: Conhecimento 1.', 'Conhecimento'),
(17, 'Percepção Paranormal', 'Em cenas de investigação, sempre que fizer um teste para procurar pistas, você pode rolar novamente um dado com resultado menor que 10.', 'Conhecimento'),
(18, 'Precognição', 'Você possui um "sexto sentido". Você recebe +2 em Defesa e em testes de resistência.', 'Conhecimento'),
(19, 'Sensitivo', 'Você consegue sentir as emoções e intenções de outros personagens, recebendo +5 em testes de Diplomacia, Intimidação e Intuição.', 'Conhecimento'),
(20, 'Visão do Oculto', 'Você não enxerga mais pelos olhos, mas pela percepção do Conhecimento. Você recebe +5 em testes de Percepção e enxerga no escuro.', 'Conhecimento'),
(21, 'Aprender Ritual', 'Você aprende e pode conjurar um ritual de 1º círculo à sua escolha. A partir de NEX 45%, você aprende um ritual de até 2º círculo.', 'Nenhum'),
(22, 'Resistir a Elemento', 'Escolha entre Conhecimento, Energia, Morte ou Sangue. Você recebe resistência 10 contra esse elemento.', 'Nenhum');

-- --------------------------------------------------------

--
-- Estrutura da tabela `poderes_trilha`
--

CREATE TABLE IF NOT EXISTS `poderes_trilha` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trilha_id` int(11) NOT NULL,
  `nex_requerido` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `trilha_id` (`trilha_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=61 ;

--
-- Extraindo dados da tabela `poderes_trilha`
--

INSERT INTO `poderes_trilha` (`id`, `trilha_id`, `nex_requerido`, `nome`, `descricao`) VALUES
(1, 1, 10, 'A Favorita', 'Escolha uma arma para ser sua favorita, como katana ou fuzil de assalto. A categoria da arma escolhida é reduzida em I.'),
(2, 1, 40, 'Técnica Secreta', 'Sua arma favorita reduz a categoria em mais I. Além disso, você pode gastar 2 PE para adicionar o efeito "amplo" ou "destruidor" a um ataque com ela.'),
(3, 1, 65, 'Técnica Sublime', 'Sua arma favorita recebe +2 modificações. Você também aprende a modificação "letal".'),
(4, 1, 99, 'Máquina de Matar', 'A categoria da sua arma favorita é reduzida em mais I (totalizando III). Além disso, sua margem de ameaça com ela diminui em 2 e seu dano aumenta em mais um dado do mesmo tipo.'),
(5, 2, 10, 'Inspirar Confiança', 'Você pode gastar uma ação padrão e 2 PE para fazer um aliado em alcance curto rolar novamente um teste recém realizado.'),
(6, 2, 40, 'Estrategista', 'Você pode direcionar aliados em alcance curto. Gaste uma ação padrão e 1 PE por aliado que quiser direcionar (limitado pelo seu Intelecto). No próximo turno dos aliados afetados, eles ganham uma ação de movimento adicional.'),
(7, 2, 65, 'Brecha na Guarda', 'Uma vez por rodada, quando um aliado causar dano em um inimigo que esteja em seu alcance curto, você pode gastar uma reação e 2 PE para que você ou outro aliado em alcance curto faça um ataque adicional contra o mesmo inimigo.'),
(8, 2, 99, 'Oficial Comandante', 'Você pode gastar uma ação padrão e 5 PE para que cada aliado que você possa ver em alcance médio receba uma ação padrão adicional no próximo turno dele.'),
(9, 3, 10, 'Técnica Letal', 'Você recebe um aumento de +2 na margem de ameaça com todos os seus ataques corpo a corpo.'),
(10, 3, 40, 'Revidar', 'Sempre que bloquear um ataque, você pode gastar uma reação e 2 PE para fazer um ataque corpo a corpo no inimigo que o atacou.'),
(11, 3, 65, 'Força Opressora', 'Quando acerta um ataque corpo a corpo, você pode gastar 1 PE para realizar a manobra derrubar ou empurrar contra o alvo do ataque como ação livre.'),
(12, 3, 99, 'Potência Máxima', 'Quando usa seu Ataque Especial com armas corpo a corpo, todos os bônus numéricos são dobrados.'),
(13, 4, 10, 'Iniciativa Aprimorada', 'Você recebe +5 em Iniciativa e uma ação de movimento adicional na primeira rodada.'),
(14, 4, 40, 'Ataque Extra', 'Uma vez por rodada, quando faz um ataque, você pode gastar 2 PE para fazer um ataque adicional.'),
(15, 4, 65, 'Surto de Adrenalina', 'Uma vez por rodada, você pode gastar 5 PE para realizar uma ação padrão ou de movimento adicional.'),
(16, 4, 99, 'Sempre Alerta', 'Você recebe uma ação padrão adicional no início de cada cena de combate.'),
(17, 5, 10, 'Casca Grossa', 'Você recebe +1 PV para cada 5% de NEX e, quando faz um bloqueio, soma seu Vigor na resistência a dano recebida.'),
(18, 5, 40, 'Cai Dentro', 'Sempre que um oponente em alcance curto atacar um de seus aliados, você pode gastar uma reação e 1 PE para fazer com que esse oponente faça um teste de Vontade (DT Vig). Se falhar, o oponente deve atacar você em vez de seu aliado.'),
(19, 5, 65, 'Duro de Matar', 'Ao sofrer dano não paranormal, você pode gastar uma reação e 2 PE para reduzir esse dano à metade. Em NEX 85%, pode usar esta habilidade para reduzir dano paranormal.'),
(20, 5, 99, 'Inquebrável', 'Enquanto estiver machucado, você recebe +5 na Defesa e resistência a dano 5. Enquanto estiver morrendo, em vez de normal, você não fica indefeso e ainda pode realizar ações.'),
(21, 6, 10, 'Mira de Elite', 'Você recebe proficiência com armas de fogo de elite e soma seu Intelecto em rolagens de dano com essas armas.'),
(22, 6, 40, 'Disparo Letal', 'Quando faz a ação mirar, você pode gastar 1 PE para aumentar em +2 a margem de ameaça do próximo ataque que fizer até o final de seu próximo turno.'),
(23, 6, 65, 'Disparo Impactante', 'Se estiver usando uma arma de fogo com calibre grosso, você pode gastar 2 PE para fazer as manobras derrubar, desarmar, empurrar ou quebrar usando um ataque à distância.'),
(24, 6, 99, 'Atirar para Matar', 'Quando faz um acerto crítico com uma arma de fogo, você causa dano máximo, sem precisar rolar dados.'),
(25, 7, 10, 'Ataque Furtivo', 'Você sabe atingir os pontos vitais de um inimigo distraído. Uma vez por rodada, quando atinge um alvo desprevenido ou que você esteja flanqueando, pode gastar 1 PE para causar +1d6 pontos de dano. O dano adicional aumenta em +1d6 em NEX 40%, 65% e 99%.'),
(26, 7, 40, 'Gatuno', 'Você recebe +5 em Atletismo e Crime e pode percorrer seu deslocamento normal quando se esconder sem penalidade.'),
(27, 7, 65, 'Assassinar', 'Você pode gastar uma ação de movimento e 3 PE para analisar um alvo em alcance curto. Até o fim do seu próximo turno, seu primeiro Ataque Furtivo que causar dano a ele tem seus dados de dano extras dessa habilidade dobrados.'),
(28, 7, 99, 'Sombra Fugaz', 'Quando faz um teste de Furtividade após atacar ou fazer outra ação chamativa, você pode gastar 3 PE para não sofrer a penalidade de -10 no teste.'),
(29, 8, 10, 'Paramédico', 'Você pode usar uma ação padrão e 2 PE para curar 2d10 pontos de vida de si mesmo ou de um aliado adjacente. Pode gastar +1 PE para aumentar a cura em +1d10 em NEX 40% e 65%.'),
(30, 8, 40, 'Equipe de Trauma', 'Você pode usar uma ação padrão e 2 PE para remover uma condição negativa (exceto morrendo) de um aliado adjacente.'),
(31, 8, 65, 'Resgate', 'Uma vez por rodada, em alcance curto de um aliado machucado ou morrendo, você pode gastar uma ação livre para se aproximar dele e curá-lo. Sempre que curar PV ou remover condições, você e o aliado recebem +5 na Defesa até o início do seu próximo turno.'),
(32, 8, 99, 'Reanimação', 'Uma vez por cena, você pode gastar uma ação completa e 10 PE para trazer de volta à vida um personagem que tenha morrido na mesma cena (exceto morte por dano massivo).'),
(33, 9, 10, 'Eloquência', 'Você pode usar uma ação completa e 1 PE por alvo em alcance curto para afetar outros personagens com sua fala. Faça um teste de Diplomacia. Um alvo que falhar no teste de Vontade fica fascinado enquanto você se concentrar.'),
(34, 9, 40, 'Discurso Motivador', 'Você pode gastar uma ação padrão e 4 PE para inspirar seus aliados com suas palavras. Você e todos os seus aliados em alcance curto ganham +2 em testes de perícia até o fim da cena.'),
(35, 9, 65, 'Conheço um Cara', 'Uma vez por missão, você pode ativar sua rede de contatos para pedir um favor, como trocar todo o equipamento do seu grupo ou conseguir uma segunda chance de preparação de missão.'),
(36, 9, 99, 'Truque de Mestre', 'Você pode gastar 5 PE para simular o efeito de qualquer habilidade de Vontade que tenha visto um de seus aliados usar durante a cena.'),
(37, 10, 10, 'Inventário Otimizado', 'Você soma seu Intelecto à sua Força para calcular sua capacidade de carga. Por exemplo, se você tem Força 1 e Intelecto 3, seu inventário tem 20 espaços.'),
(38, 10, 40, 'Remendo', 'Você pode gastar uma ação completa e 1 PE para remover a condição quebrado de um equipamento adjacente até o final da cena.'),
(39, 10, 65, 'Improvisar', 'Você pode improvisar equipamentos com material ao seu redor. Escolha um equipamento geral e gaste uma ação completa e 2 PE; ele é de categoria 0. Você cria uma versão funcional do equipamento.'),
(40, 10, 99, 'Preparado para Tudo', 'Sempre que precisar de um item qualquer (exceto armas), pode gastar uma ação de movimento e 3 PE por categoria do item para lembrar que colocou ele no fundo da bolsa!'),
(41, 11, 10, 'Ampliar Ritual', 'Quando lança um ritual, você pode gastar +2 PE para aumentar seu alcance em um passo (de curto para médio, de médio para longo ou de longo para extremo) ou dobrar sua área de efeito.'),
(42, 11, 40, 'Acelerar Ritual', 'Uma vez por rodada, você pode aumentar o custo de um ritual em 4 PE para conjurá-lo como uma ação livre.'),
(43, 11, 65, 'Anular Ritual', 'Quando for alvo de um ritual, você pode gastar uma quantidade de PE igual ao custo pago por esse ritual e fazer um teste oposto de Ocultismo contra o conjurador. Se vencer, você anula o ritual.'),
(44, 11, 99, 'Canalizar o Medo', 'Você aprende o ritual Canalizar o Medo.'),
(45, 12, 10, 'Poder do Flagelo', 'Ao conjurar um ritual, você pode gastar seus próprios pontos de vida para pagar o custo em pontos de esforço, à taxa de 2 PV por PE pago. Pontos de vida gastos dessa forma só podem ser recuperados com descanso.'),
(46, 12, 40, 'Abraçar a Dor', 'Sempre que sofrer dano não paranormal, você pode gastar uma reação e 2 PE para reduzir esse dano à metade.'),
(47, 12, 65, 'Absorver a Agonia', 'Sempre que você reduz um ou mais inimigos a 0 PV com um ritual, você recebe uma quantidade de PE temporários igual ao círculo do ritual utilizado.'),
(48, 12, 99, 'Medo Tangível', 'Você aprende o ritual Medo Tangível.'),
(49, 13, 10, 'Saber Ampliado', 'Você aprende um ritual de 1º círculo. Toda vez que ganha acesso a um novo círculo, aprende um ritual adicional daquele círculo. Esses rituais não contam em seu limite de rituais.'),
(50, 13, 40, 'Grimório Ritualístico', 'Você cria um grimório especial, que armazena uma quantidade de rituais de 1º ou 2º círculos igual ao seu Intelecto. O grimório ocupa 1 espaço.'),
(51, 13, 65, 'Rituais Eficientes', 'A DT para resistir a todos os seus rituais aumenta em +5.'),
(52, 13, 99, 'Conhecendo o Medo', 'Você aprende o ritual Conhecendo o Medo.'),
(53, 14, 10, 'Mente Sã', 'Você compreende melhor as entidades do Outro Lado. Você recebe resistência paranormal +5.'),
(54, 14, 40, 'Presença Poderosa', 'Você adiciona sua Presença ao seu limite de PE por turno, mas apenas para conjurar rituais.'),
(55, 14, 65, 'Inabalável', 'Você recebe resistência a dano mental e paranormal 10. Se passar em um teste de Vontade para reduzir dano paranormal, não sofre dano algum.'),
(56, 14, 99, 'Presença do Medo', 'Você aprende o ritual Presença do Medo.'),
(57, 15, 10, 'Lâmina Maldita', 'Você aprende o ritual Amaldiçoar Arma. Seu custo é reduzido em -1 PE. Além disso, pode usar Ocultismo para testes de ataque com a arma amaldiçoada.'),
(58, 15, 40, 'Gladiador Paranormal', 'Sempre que acerta um ataque corpo a corpo, você recebe 2 PE temporários (máximo igual ao seu limite de PE por turno).'),
(59, 15, 65, 'Conjuração Marcial', 'Uma vez por rodada, ao lançar um ritual com execução de uma ação padrão, pode gastar 2 PE para fazer um ataque corpo a corpo como ação livre.'),
(60, 15, 99, 'Lâmina do Medo', 'Você aprende o ritual Lâmina do Medo.');

-- --------------------------------------------------------

--
-- Estrutura da tabela `t20_classes`
--

CREATE TABLE IF NOT EXISTS `t20_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pv_inicial` int(11) NOT NULL,
  `pv_por_nivel` int(11) NOT NULL,
  `pm_por_nivel` int(11) NOT NULL,
  `pericias_treinadas_fixas` text,
  `pericias_escolha_lista` text,
  `pericias_escolha_qtd` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `t20_classes`
--

INSERT INTO `t20_classes` (`id`, `nome`, `pv_inicial`, `pv_por_nivel`, `pm_por_nivel`, `pericias_treinadas_fixas`, `pericias_escolha_lista`, `pericias_escolha_qtd`) VALUES
(1, 'Caçador', 16, 4, 4, 'Luta ou Pontaria, Sobrevivência', 'Adestramento, Atletismo, Cavalgar, Cura, Fortitude, Furtividade, Iniciativa, Investigação, Luta, Ofício, Percepção, Pontaria, Reflexos', 6),
(2, 'Guerreiro', 20, 5, 3, 'Luta ou Pontaria, Fortitude', 'Adestramento, Atletismo, Cavalgar, Guerra, Iniciativa, Intimidação, Luta, Ofício, Percepção, Pontaria, Reflexos', 2),
(3, 'Nobre', 16, 4, 4, 'Diplomacia ou Intimidação, Vontade', 'Adestramento, Atuação, Cavalgar, Conhecimento, Diplomacia, Enganação, Fortitude, Guerra, Iniciativa, Intimidação, Intuição, Investigação, Jogatina, Luta, Nobreza, Ofício, Percepção, Pontaria', 4);

-- --------------------------------------------------------

--
-- Estrutura da tabela `t20_origens`
--

CREATE TABLE IF NOT EXISTS `t20_origens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `pericias_treinadas` text,
  `poder_1_nome` varchar(255) DEFAULT NULL,
  `poder_1_desc` text,
  `poder_2_nome` varchar(255) DEFAULT NULL,
  `poder_2_desc` text,
  `poder_3_nome` varchar(255) DEFAULT NULL,
  `poder_3_desc` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=36 ;

--
-- Extraindo dados da tabela `t20_origens`
--

INSERT INTO `t20_origens` (`id`, `nome`, `pericias_treinadas`, `poder_1_nome`, `poder_1_desc`, `poder_2_nome`, `poder_2_desc`, `poder_3_nome`, `poder_3_desc`) VALUES
(1, 'Acólito', 'Cura, Religião, Vontade', 'Membro da Igreja', 'Você consegue hospedagem confortável e informação em qualquer templo de sua divindade, para você e seus aliados.', 'Vontade de Ferro', 'Você recebe +1 PM para cada dois níveis de personagem e +2 em Vontade. Pré-requisito: Sab 1.', NULL, NULL),
(2, 'Amigo dos Animais', 'Adestramento, Cavalgar', 'Amigo Especial', 'Você recebe +5 em testes de Adestramento com animais. Além disso, possui um animal de estimação que o auxilia e o acompanha em suas aventuras. Em termos de jogo, é um parceiro que fornece +2 em uma perícia a sua escolha (exceto Luta ou Pontaria e aprovada pelo mestre) e não conta em seu limite de parceiros.', NULL, NULL, NULL, NULL),
(3, 'Amnésico', 'Uma perícia à escolha', 'Lembranças Graduais', 'Durante suas aventuras, em determinados momentos a critério do mestre, você pode fazer um teste de Sabedoria (CD 10) para reconhecer pessoas, criaturas ou lugares que tenha encontrado antes de perder a memória.', 'Poder Adicional (Definido pelo Mestre)', 'O mestre define um poder geral adicional que você possui, mas não se lembrava.', NULL, NULL),
(4, 'Aristocrata', 'Diplomacia, Enganação, Nobreza', 'Comandar', 'Você pode gastar uma ação de movimento e 1 PM para gritar ordens para seus aliados em alcance médio. Eles recebem +1 em testes de perícia até o fim da cena. Pré-requisito: Car 1.', 'Sangue Azul', 'Você tem alguma influência política, suficiente para ser tratado com mais leniência pela guarda, conseguir uma audiência com o nobre local etc.', NULL, NULL),
(5, 'Artesão', 'Ofício, Vontade', 'Frutos do Trabalho', 'No início de cada aventura, você recebe até 5 itens gerais que possa fabricar num valor total de até T$ 50. Esse valor aumenta para T$ 100 no patamar aventureiro, T$ 300 no heroico e T$ 500 no lenda.', 'Sortudo', 'Você pode gastar 3 PM para rolar novamente um teste recém realizado (apenas uma vez por teste).', NULL, NULL),
(6, 'Artista', 'Atuação, Enganação', 'Atraente', 'Você recebe +2 em testes de Diplomacia, Enganação e Intuição, mas apenas se não estiver usando armadura pesada.', 'Dom Artístico', 'Você recebe +2 em testes de Atuação, e recebe o dobro de tibares em apresentações.', 'Escolha: Sortudo ou Torcida', 'Sortudo: Você pode gastar 3 PM para rolar novamente um teste recém realizado (apenas uma vez por teste).\nTorcida: Você pode gastar 1 PM e uma ação padrão para fazer um teste de Atuação (CD 15). Se passar, você e todos os aliados em alcance curto recebem +1 em testes de ataque e rolagens de dano por uma rodada.'),
(7, 'Assistente de Laboratório', 'Ofício (alquimista), Misticismo', 'Esse Cheiro...', 'Você recebe +2 em testes de Misticismo e Ofício (alquimia).', 'Venefício', 'Você recebe +2 em testes de Ofício (alquimia) para fabricar venenos e aplica venenos como uma ação de movimento (em vez de ação padrão).', 'Poder da Tormenta (Escolha)', 'Você recebe um poder da Tormenta a sua escolha (funciona como o poder Transcender, exigindo escolha posterior).'),
(8, 'Batedor', 'Furtividade, Percepção, Sobrevivência', 'À Prova de Tudo', 'Você recebe +1 ponto de vida por nível de personagem.', 'Estilo de Disparo', 'Você recebe o poder Estilo de Disparo (escolha um).', 'Sentidos Aguçados', 'Você recebe +2 em testes de Percepção e não fica desprevenido contra inimigos que não possa ver em alcance curto.'),
(9, 'Capanga', 'Luta, Intimidação', 'Confissão', 'Você pode usar Intimidação para obter informação (veja Investigação). Esta ação leva uma hora e você não precisa fazer um teste — a vítima automaticamente revela a informação (se a tiver). Você só pode usar esta habilidade uma vez por cena contra o mesmo alvo.', 'Poder de Combate (Escolha)', 'Você recebe um poder de combate a sua escolha.', NULL, NULL),
(10, 'Charlatão', 'Enganação, Jogatina', 'Alpinista Social', 'Você pode usar Enganação no lugar de Diplomacia ou Intimidação para mudar atitude de alvos. Pré-requisito: treinado em Enganação.', 'Aparência Inofensiva', 'A dificuldade para resistir aos seus testes de Enganação aumenta em +2.', 'Sortudo', 'Você pode gastar 3 PM para rolar novamente um teste recém realizado (apenas uma vez por teste).'),
(11, 'Circense', 'Acrobacia, Atuação, Reflexos', 'Acrobático', 'Você recebe +2 em testes de Acrobacia. Além disso, quando sofre dano de queda, pode fazer um teste de Acrobacia (CD 15); se passar, reduz o dano da queda à metade.', 'Torcida', 'Você pode gastar 1 PM e uma ação padrão para fazer um teste de Atuação (CD 15). Se passar, você e todos os aliados em alcance curto recebem +1 em testes de ataque e rolagens de dano por uma rodada.', 'Truque de Mágica', 'Você aprende e pode lançar Ilusão. Se aprender novamente essa magia, seu custo diminui em –1 PM.'),
(12, 'Criminoso', 'Enganação, Furtividade, Ladinagem', 'Punguista', 'Você recebe +2 em testes de Ladinagem e pode usar esta perícia para furtar PM em vez de itens.', 'Venefício', 'Você recebe +2 em testes de Ofício (alquimia) para fabricar venenos e aplica venenos como uma ação de movimento (em vez de ação padrão).', NULL, NULL),
(13, 'Curandeiro', 'Cura, Vontade', 'Medicina', 'Você recebe +2 em testes de Cura. Além disso, pode gastar uma ação de movimento e 1 PM para curar 1d6 pontos de vida de um aliado adjacente.', 'Médico de Campo', 'Você pode usar a perícia Cura em alcance curto (em vez de apenas em alcance pessoal ou adjacente).', 'Venefício', 'Você recebe +2 em testes de Ofício (alquimia) para fabricar venenos e aplica venenos como uma ação de movimento (em vez de ação padrão).'),
(14, 'Eremita', 'Misticismo, Religião, Sobrevivência', 'Busca Interior', 'Você pode gastar uma hora meditando para recuperar 1 PM. Você pode usar esta habilidade um número de vezes por dia igual ao seu bônus de Sabedoria (mínimo 1).', 'Lobo Solitário', 'Você recebe +1 em testes de perícia e Defesa se estiver sem nenhum aliado em alcance curto. Você não sofre penalidade por usar Cura em si mesmo.', NULL, NULL),
(15, 'Escravo', 'Atletismo, Fortitude, Furtividade', 'Desejo de Liberdade', 'Você recebe +1 PM para cada dois níveis de personagem e +2 em Vontade.', 'Vitalidade', 'Você recebe +2 pontos de vida para cada nível de personagem.', NULL, NULL),
(16, 'Estudioso', 'Conhecimento, Guerra, Misticismo', 'Aparência Inofensiva', 'A dificuldade para resistir aos seus testes de Enganação aumenta em +2.', 'Palpite Fundamentado', 'Você pode gastar uma ação completa analisando um item, local ou criatura para descobrir uma de suas características, como RD, valores de atributos, se é mágico etc., a critério do mestre.', NULL, NULL),
(17, 'Fazendeiro', 'Adestramento, Cavalgar, Ofício (fazendeiro)', 'Água no Feijão', 'Você gasta apenas metade da ração diária normal para se alimentar. Além disso, sabe cozinhar: pode preparar alimentos para um número de pessoas igual ao seu bônus de Sabedoria +1 por 1 Tibar por pessoa. Um personagem que coma uma refeição recupera 1 PV por nível.', 'Ginete', 'Você recebe +2 em testes de Cavalgar. Além disso, não sofre penalidade em testes de ataque por lutar montado.', NULL, NULL),
(18, 'Forasteiro', 'Cavalgar, Pilotagem, Sobrevivência', 'Cultura Exótica', 'Você recebe +2 em testes de Conhecimento e Misticismo.', 'Lobo Solitário', 'Você recebe +1 em testes de perícia e Defesa se estiver sem nenhum aliado em alcance curto. Você não sofre penalidade por usar Cura em si mesmo.', NULL, NULL),
(19, 'Gladiador', 'Atuação, Luta', 'Atraente', 'Você recebe +2 em testes de Diplomacia, Enganação e Intuição, mas apenas se não estiver usando armadura pesada.', 'Pão e Circo', 'Você pode gastar uma hora e T$ 10 para entreter uma plateia mundana. Faça um teste de Atuação (CD 15). Se passar, você recebe T$ 10 mais T$ 1 por ponto que exceder a CD.', 'Torcida OU Poder de Combate', 'Torcida: Gastar 1 PM, ação padrão, teste Atuação (CD 15); sucesso: +1 ataque/dano para aliados em alcance curto por 1 rodada.\nPoder de Combate: Você recebe um poder de combate a sua escolha.'),
(20, 'Guarda', 'Investigação, Luta, Percepção', 'Detetive', 'Você recebe +2 em testes de Investigação.', 'Investigador', 'Você pode usar Investigação para procurar pistas. Esta ação leva um minuto e exige um teste de Investigação (CD 15). Se passar, você encontra uma pista sobre o mistério que estiver investigando.', 'Poder de Combate (Escolha)', 'Você recebe um poder de combate a sua escolha.'),
(21, 'Herdeiro', 'Misticismo, Nobreza, Ofício', 'Comandar', 'Você pode gastar uma ação de movimento e 1 PM para gritar ordens para seus aliados em alcance médio. Eles recebem +1 em testes de perícia até o fim da cena. Pré-requisito: Car 1.', 'Herança', 'Você começa o jogo com T$ 1.000 extras.', NULL, NULL),
(22, 'Herói Camponês', 'Adestramento, Ofício', 'Coração Heroico', 'Você recebe +1 em testes de resistência.', 'Sortudo', 'Você pode gastar 3 PM para rolar novamente um teste recém realizado (apenas uma vez por teste).', 'Escolha: Surto Heroico ou Torcida', 'Surto Heroico: Uma vez por dia, pode gastar 5 PM para realizar uma ação padrão ou de movimento adicional.\nTorcida: Gastar 1 PM, ação padrão, teste Atuação (CD 15); sucesso: +1 ataque/dano para aliados em alcance curto por 1 rodada.'),
(23, 'Marujo', 'Atletismo, Jogatina, Pilotagem', 'Acrobático', 'Você recebe +2 em testes de Acrobacia. Além disso, quando sofre dano de queda, pode fazer um teste de Acrobacia (CD 15); se passar, reduz o dano da queda à metade.', 'Passagem de Navio', 'Você consegue transporte marítimo gratuito para você e seus aliados.', NULL, NULL),
(24, 'Mateiro', 'Atletismo, Furtividade, Sobrevivência', 'Lobo Solitário', 'Você recebe +1 em testes de perícia e Defesa se estiver sem nenhum aliado em alcance curto. Você não sofre penalidade por usar Cura em si mesmo.', 'Sentidos Aguçados', 'Você recebe +2 em testes de Percepção e não fica desprevenido contra inimigos que não possa ver em alcance curto.', 'Vendedor de Carcaças', 'Você pode gastar 1 hora esfolando um animal que tenha caçado para obter couro e carne, que valem T$ 10.'),
(25, 'Membro de Guilda', 'Diplomacia, Enganação, Misticismo, Ofício', 'Foco em Perícia', 'Escolha uma perícia. Você recebe +2 nesta perícia.', 'Rede de Contatos', 'Você pode usar Diplomacia para obter informação (veja Investigação). Esta ação leva um dia.', NULL, NULL),
(26, 'Mercador', 'Diplomacia, Intuição, Ofício', 'Negociação', 'Você recebe +2 em testes de Diplomacia para barganhar.', 'Proficiência', 'Você recebe proficiência em uma arma exótica à sua escolha.', 'Sortudo', 'Você pode gastar 3 PM para rolar novamente um teste recém realizado (apenas uma vez por teste).'),
(27, 'Minerador', 'Atletismo, Fortitude, Ofício (minerador)', 'Ataque Poderoso', 'Você pode sofrer –2 em testes de ataque corpo a corpo para receber +5 nas rolagens de dano.', 'Escavador', 'Você não sofre penalidade em deslocamento por terreno difícil causado por pedras ou terra.', 'Sentidos Aguçados', 'Você recebe +2 em testes de Percepção e não fica desprevenido contra inimigos que não possa ver em alcance curto.'),
(28, 'Nômade', 'Cavalgar, Pilotagem, Sobrevivência', 'Lobo Solitário', 'Você recebe +1 em testes de perícia e Defesa se estiver sem nenhum aliado em alcance curto. Você não sofre penalidade por usar Cura em si mesmo.', 'Mochileiro', 'Seu limite de carga aumenta em +5 espaços.', 'Sentidos Aguçados', 'Você recebe +2 em testes de Percepção e não fica desprevenido contra inimigos que não possa ver em alcance curto.'),
(29, 'Pivete', 'Furtividade, Iniciativa, Ladinagem', 'Acrobático', 'Você recebe +2 em testes de Acrobacia. Além disso, quando sofre dano de queda, pode fazer um teste de Acrobacia (CD 15); se passar, reduz o dano da queda à metade.', 'Aparência Inofensiva', 'A dificuldade para resistir aos seus testes de Enganação aumenta em +2.', 'Quebra-Galho', 'Você pode usar Ladinagem no lugar de Ofício para consertar itens mundanos.'),
(30, 'Refugiado', 'Fortitude, Reflexos, Vontade', 'Estoico', 'Você recebe +2 em testes de Fortitude e Vontade.', 'Vontade de Ferro', 'Você recebe +1 PM para cada dois níveis de personagem e +2 em Vontade. Pré-requisito: Sab 1.', NULL, NULL),
(31, 'Seguidor', 'Adestramento, Ofício', 'Antigo Mestre', 'Uma vez por dia, você pode fazer um teste de Sabedoria (CD 15). Se passar, recebe +2 em um teste de perícia à sua escolha até o fim do dia.', 'Proficiência', 'Você recebe proficiência em uma arma exótica à sua escolha.', 'Surto Heroico', 'Uma vez por dia, pode gastar 5 PM para realizar uma ação padrão ou de movimento adicional.'),
(32, 'Selvagem', 'Percepção, Reflexos, Sobrevivência', 'Lobo Solitário', 'Você recebe +1 em testes de perícia e Defesa se estiver sem nenhum aliado em alcance curto. Você não sofre penalidade por usar Cura em si mesmo.', 'Vida Rústica', 'Você recebe +2 em testes de Percepção e Sobrevivência.', 'Vitalidade', 'Você recebe +2 pontos de vida para cada nível de personagem.'),
(33, 'Soldado', 'Fortitude, Guerra, Luta, Pontaria', 'Influência Militar', 'Você recebe +2 em testes de Intimidação.', 'Poder de Combate (Escolha)', 'Você recebe um poder de combate a sua escolha.', NULL, NULL),
(34, 'Taverneiro', 'Diplomacia, Jogatina, Ofício (cozinheiro)', 'Gororoba', 'Você pode preparar alimentos para um número de pessoas igual ao seu bônus de Carisma +1 por 1 Tibar por pessoa. Um personagem que coma uma refeição recupera 1 PV por nível.', 'Proficiência', 'Você recebe proficiência em uma arma exótica à sua escolha.', 'Vitalidade', 'Você recebe +2 pontos de vida para cada nível de personagem.'),
(35, 'Trabalhador', 'Atletismo, Fortitude', 'Atlético', 'Você recebe +2 em testes de Atletismo.', 'Esforçado', 'Você recebe +1 PM para cada dois níveis de personagem.', NULL, NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `t20_racas`
--

CREATE TABLE IF NOT EXISTS `t20_racas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `ajustes_atributos` text,
  `habilidade_1_nome` varchar(255) DEFAULT NULL,
  `habilidade_1_desc` text,
  `habilidade_2_nome` varchar(255) DEFAULT NULL,
  `habilidade_2_desc` text,
  `habilidade_3_nome` varchar(255) DEFAULT NULL,
  `habilidade_3_desc` text,
  `deslocamento` int(11) DEFAULT '9',
  `tamanho` varchar(50) DEFAULT 'Médio',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nome` (`nome`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=18 ;

--
-- Extraindo dados da tabela `t20_racas`
--

INSERT INTO `t20_racas` (`id`, `nome`, `ajustes_atributos`, `habilidade_1_nome`, `habilidade_1_desc`, `habilidade_2_nome`, `habilidade_2_desc`, `habilidade_3_nome`, `habilidade_3_desc`, `deslocamento`, `tamanho`) VALUES
(1, 'Anão', 'CON+2, SAB+1, DES-1', 'Conhecimento das Rochas', 'Você recebe visão no escuro e +2 em testes de Percepção e Sobrevivência realizados no subterrâneo.', 'Devagar e Sempre', 'Seu deslocamento é 6m (em vez de 9m). Porém, seu deslocamento não é reduzido por uso de armadura ou excesso de carga.', 'Duro como Pedra & Tradição de Heredrimm', 'Duro como Pedra: +3 PV no 1º nível e +1 PV por nível seguinte. Tradição de Heredrimm: Você é perito nas armas tradicionais anãs (machados, martelos, marretas e picaretas são armas simples para você). Você recebe +2 em ataques com essas armas.', 6, 'Médio'),
(2, 'Dahllan', 'SAB+2, DES+1, INT-1', 'Amiga das Plantas', 'Você pode lançar a magia Controlar Plantas (atributo-chave Sabedoria). Caso aprenda novamente esta magia, seu custo diminui em –1 PM.', 'Armadura de Allihanna', 'Você pode gastar uma ação de movimento e 1 PM para transformar sua pele em casca de árvore, recebendo +2 na Defesa até o fim da cena.', 'Empatia Selvagem', 'Você pode se comunicar com animais por meio de linguagem corporal e vocalizações. Você pode usar Adestramento para mudar atitude e persuasão com animais (veja Diplomacia). Caso receba esta habilidade novamente, recebe +2 em Adestramento.', 9, 'Médio'),
(3, 'Elfo', 'INT+2, DES+1, CON-1', 'Graça de Glórienn', 'Seu deslocamento é 12m (em vez de 9m).', 'Sangue Mágico', 'Você recebe +1 ponto de mana por nível.', 'Sentidos Élficos', 'Você recebe visão na penumbra e +2 em Misticismo e Percepção.', 12, 'Médio'),
(4, 'Goblin', 'DES+2, INT+1, CAR-1', 'Engenhoso', 'Você não sofre penalidades em testes de perícia por não usar ferramentas. Se usar a ferramenta necessária, recebe +2 no teste de perícia.', 'Espelunqueiro', 'Você recebe visão no escuro e deslocamento de escalada igual ao seu deslocamento terrestre.', 'Peste Esguia & Rato das Ruas', 'Peste Esguia: Tamanho Pequeno, deslocamento 9m. Rato das Ruas: Você recebe +2 em Fortitude e sua recuperação de PV e PM nunca é inferior ao seu nível.', 9, 'Pequeno'),
(5, 'Golem', 'FOR+2, CON+1, CAR-1', 'Chassi', 'Seu corpo artificial é resistente, mas rígido. Seu deslocamento é 6m, mas não é reduzido por uso de armadura ou excesso de carga. Você recebe +2 na Defesa, mas possui penalidade de armadura –2. Você leva um dia para vestir ou remover uma armadura.', 'Criatura Artificial', 'Você é uma criatura do tipo construto. Recebe visão no escuro e imunidade a efeitos de cansaço, metabólicos e de veneno. Não precisa respirar, alimentar-se ou dormir, mas não se beneficia de cura mundana ou itens da categoria alimentação. Precisa ficar inerte por 8h para recarregar (recupera PV e PM). A perícia Cura não funciona em você, mas Ofício (artesão) pode ser usada no lugar dela.', 'Propósito de Criação & Fonte Elemental', 'Propósito de Criação: Sem origem, recebe um poder geral. Fonte Elemental: Escolha entre água (frio), ar (eletricidade), fogo (fogo) e terra (ácido). Você é imune a dano desse tipo. Se fosse sofrer dano mágico desse tipo, em vez disso cura PV em quantidade igual à metade do dano.', 6, 'Médio'),
(6, 'Humano', 'ATRIBUTOS+1,+1,+1', 'Versátil', 'Você se torna treinado em duas perícias a sua escolha (não precisam ser da sua classe). Você pode trocar uma dessas perícias por um poder geral a sua escolha.', NULL, NULL, NULL, NULL, 9, 'Médio'),
(7, 'Hynne', 'DES+2, CAR+1, FOR-1', 'Arremessador', 'Quando faz um ataque à distância com uma funda ou uma arma de arremesso, seu dano aumenta em um passo.', 'Pequeno e Rechonchudo', 'Seu tamanho é Pequeno e seu deslocamento é 6m. Você recebe +2 em Enganação e pode usar Destreza como atributo-chave de Atletismo (em vez de Força).', 'Sorte Salvadora', 'Quando faz um teste de resistência, você pode gastar 1 PM para rolar este teste novamente.', 6, 'Pequeno'),
(8, 'Kliren', 'INT+2, CAR+1, FOR-1', 'Híbrido', 'Você se torna treinado em uma perícia a sua escolha (não precisa ser da sua classe).', 'Engenhosidade', 'Quando faz um teste de perícia, você pode gastar 2 PM para somar sua Inteligência no teste. Não funciona em testes de ataque. Se receber esta habilidade novamente, o custo é reduzido em –1 PM.', 'Ossos Frágeis & Vanguardista', 'Ossos Frágeis: Sofre +1 ponto de dano por dado de impacto. Vanguardista: Recebe proficiência em armas de fogo e +2 em Ofício (um qualquer, à sua escolha).', 9, 'Médio'),
(9, 'Lefou', 'ATRIBUTOS+1,+1,+1, CAR-1', 'Cria da Tormenta', 'Você é uma criatura do tipo monstro e recebe +5 em testes de resistência contra efeitos causados por lefeu e pela Tormenta.', 'Deformidade', 'Você recebe +2 em duas perícias a sua escolha. Cada um desses bônus conta como um poder da Tormenta (exceto para perda de Carisma). Você pode trocar um desses bônus por um poder da Tormenta a sua escolha (ele também não conta para perda de Carisma).', NULL, NULL, 9, 'Médio'),
(10, 'Medusa', 'DES+2, CAR+1', 'Cria de Megalokk', 'Você é uma criatura do tipo monstro e recebe visão no escuro.', 'Natureza Venenosa', 'Você recebe resistência a veneno +5 e pode gastar uma ação de movimento e 1 PM para envenenar uma arma que esteja usando. A arma causa perda de 1d12 PV (veneno). Dura até acertar um ataque ou fim da cena.', 'Olhar Atordoante', 'Você pode gastar uma ação de movimento e 1 PM para forçar uma criatura em alcance curto a fazer um teste de Fortitude (CD Car). Se falhar, fica atordoada por uma rodada (apenas uma vez por cena).', 9, 'Médio'),
(11, 'Minotauro', 'FOR+2, CON+1, SAB-1', 'Chifres', 'Você possui uma arma natural de chifres (dano 1d6, crítico x2, perfuração). Uma vez por rodada, quando usa a ação agredir para atacar com outra arma, pode gastar 1 PM para fazer um ataque corpo a corpo extra com os chifres.', 'Couro Rígido', 'Sua pele é dura como a de um touro. Você recebe +1 na Defesa.', 'Faro', 'Você tem olfato apurado. Contra inimigos em alcance curto que não possa ver, você não fica desprevenido e camuflagem total lhe causa apenas 20% de chance de falha.', 9, 'Médio'),
(12, 'Osteon', 'ATRIBUTOS+1,+1,+1,-exceto-CON, CON-1', 'Armadura Óssea', 'Você recebe redução de corte, frio e perfuração 5.', 'Memória Póstuma', 'Você se torna treinado em uma perícia (não precisa ser da sua classe) OU recebe um poder geral a sua escolha. Alternativamente, pode ser um osteon de outra raça (escolha uma habilidade dessa raça; se a raça for de tamanho diferente, você possui esse tamanho).', 'Natureza Esquelética & Preço da Não Vida', 'Natureza Esquelética: Morto-vivo, visão no escuro, imunidades (cansaço, metabólico, trevas, veneno), não precisa respirar/comer/dormir. Cura de luz causa dano, trevas cura. Preço da Não Vida: Precisa passar 8h sob estrelas ou subterrâneo para recuperar PV/PM por descanso (imune a condições boas/ruins). Caso contrário, sofre fome.', 9, 'Médio'),
(13, 'Qareen', 'CAR+2, INT+1, SAB-1', 'Desejos', 'Se lançar uma magia que alguém tenha pedido desde seu último turno, o custo da magia diminui em –1 PM. Fazer um desejo é ação livre.', 'Resistência Elemental', 'Conforme sua ascendência, você recebe RD 10 a um tipo de dano: frio (água), eletricidade (ar), fogo (fogo), ácido (terra), luz (luz) ou trevas (trevas).', 'Tatuagem Mística', 'Você pode lançar uma magia de 1º círculo a sua escolha (atributo-chave Carisma). Caso aprenda novamente essa magia, seu custo diminui em –1 PM.', 9, 'Médio'),
(14, 'Sereia/Tritão', 'ATRIBUTOS+1,+1,+1', 'Canção dos Mares', 'Você pode lançar duas das magias a seguir: Amedrontar, Comando, Despedaçar, Enfeitiçar, Hipnotismo ou Sono (atributo-chave Carisma). Caso aprenda novamente uma dessas magias, seu custo diminui em –1 PM.', 'Mestre do Tridente', 'Para você, o tridente é uma arma simples. Além disso, você recebe +2 em rolagens de dano com azagaias, lanças e tridentes.', 'Transformação Anfíbia', 'Você pode respirar debaixo d’água e possui deslocamento de natação 12m. Fora d’água, tem pernas (deslocamento 9m). Se ficar mais de um dia sem contato com água, não recupera PM com descanso.', 9, 'Médio'),
(15, 'Sílfide', 'CAR+2, DES+1, FOR-2', 'Asas de Borboleta', 'Seu tamanho é Minúsculo. Pode pairar a 1,5m do chão (desl. 9m), ignorando terreno difícil e imune a dano por queda (se consciente). Pode gastar 1 PM por rodada para voar com desl. 12m.', 'Espírito da Natureza', 'Você é do tipo espírito, recebe visão na penumbra e pode falar com animais livremente.', 'Magia das Fadas', 'Você pode lançar duas das magias a seguir: Criar Ilusão, Enfeitiçar, Luz (arcana) ou Sono (atributo-chave Carisma). Caso aprenda novamente uma dessas magias, seu custo diminui em –1 PM.', 9, 'Minúsculo'),
(16, 'Suraggel', 'SAB+2, CAR+1 (Aggelus); DES+2, INT+1 (Sulfure)', 'Herança Divina', 'Você é uma criatura do tipo espírito e recebe visão no escuro.', 'Luz Sagrada (Aggelus)', 'Você recebe +2 em Diplomacia e Intuição. Pode lançar Luz (divina, Carisma). Custo -1 PM se aprender de novo.', 'Sombras Profanas (Sulfure)', 'Você recebe +2 em Enganação e Furtividade. Pode lançar Escuridão (divina, Inteligência). Custo -1 PM se aprender de novo.', 9, 'Médio'),
(17, 'Trog', 'CON+2, FOR+1, INT-1', 'Mau Cheiro', 'Você pode gastar ação padrão e 2 PM para expelir gás fétido. Criaturas em alcance curto (exceto trogs) devem passar em Fortitude (CD Con) ou ficam enjoadas por 1d6 rodadas. Imunidade por um dia se passar.', 'Mordida', 'Arma natural de mordida (dano 1d6, crítico x2, perfuração). Uma vez por rodada, ao usar ação agredir com outra arma, pode gastar 1 PM para ataque extra com mordida.', 'Reptiliano & Sangue Frio', 'Reptiliano: Monstro, visão no escuro, +1 Defesa (se sem armadura/roupa pesada), +5 Furtividade. Sangue Frio: Sofre +1 ponto de dano por dado de dano de frio.', 9, 'Médio');

-- --------------------------------------------------------

--
-- Estrutura da tabela `trilhas`
--

CREATE TABLE IF NOT EXISTS `trilhas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classe_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `classe_id` (`classe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=16 ;

--
-- Extraindo dados da tabela `trilhas`
--

INSERT INTO `trilhas` (`id`, `classe_id`, `nome`) VALUES
(1, 1, 'Aniquilador'),
(2, 1, 'Comandante de Campo'),
(3, 1, 'Guerreiro'),
(4, 1, 'Operações Especiais'),
(5, 1, 'Tropa de Choque'),
(6, 2, 'Atirador de elite'),
(7, 2, 'Infiltrador'),
(8, 2, 'Médico de campo'),
(9, 2, 'Negociador'),
(10, 2, 'Técnico'),
(11, 3, 'Conduite'),
(12, 3, 'Flagelador'),
(13, 3, 'Graduado'),
(14, 3, 'Intuitivo'),
(15, 3, 'Lâmina Paranormal');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome_usuario` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome_usuario`, `email`, `senha`) VALUES
(1, 'Lemuaira', 'rodrigueskaio337@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b'),
(2, 'Testilson', 'Testilson@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `historias`
--
ALTER TABLE `historias`
  ADD CONSTRAINT `historias_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `inventario_op`
--
ALTER TABLE `inventario_op`
  ADD CONSTRAINT `fk_inventario_op_item` FOREIGN KEY (`item_id`) REFERENCES `itens_op` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_inventario_op_personagem` FOREIGN KEY (`personagem_id`) REFERENCES `personagens_op` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `mundos`
--
ALTER TABLE `mundos`
  ADD CONSTRAINT `mundos_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `op_personagem_itens`
--
ALTER TABLE `op_personagem_itens`
  ADD CONSTRAINT `op_personagem_itens_ibfk_1` FOREIGN KEY (`personagem_id`) REFERENCES `personagens_op` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `pericias`
--
ALTER TABLE `pericias`
  ADD CONSTRAINT `fk_pericia_personagem` FOREIGN KEY (`personagem_id`) REFERENCES `personagens_op` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `personagens_op`
--
ALTER TABLE `personagens_op`
  ADD CONSTRAINT `fk_classe` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_origem` FOREIGN KEY (`origem_id`) REFERENCES `origens` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_trilha` FOREIGN KEY (`trilha_id`) REFERENCES `trilhas` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_user_op` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `personagens_op_poderes`
--
ALTER TABLE `personagens_op_poderes`
  ADD CONSTRAINT `fk_poder_personagem` FOREIGN KEY (`personagem_id`) REFERENCES `personagens_op` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `personagens_t20`
--
ALTER TABLE `personagens_t20`
  ADD CONSTRAINT `fk_user_t20` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `poderes_classe`
--
ALTER TABLE `poderes_classe`
  ADD CONSTRAINT `poderes_classe_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `poderes_trilha`
--
ALTER TABLE `poderes_trilha`
  ADD CONSTRAINT `poderes_trilha_ibfk_1` FOREIGN KEY (`trilha_id`) REFERENCES `trilhas` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `trilhas`
--
ALTER TABLE `trilhas`
  ADD CONSTRAINT `trilhas_ibfk_1` FOREIGN KEY (`classe_id`) REFERENCES `classes` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
