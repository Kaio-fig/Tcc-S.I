-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 04-Set-2025 às 15:35
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
-- Estrutura da tabela `op_armas`
--

CREATE TABLE IF NOT EXISTS `op_armas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `dano` varchar(20) NOT NULL,
  `crit` varchar(20) NOT NULL,
  `categoria` int(11) NOT NULL DEFAULT '0',
  `espaco` int(11) NOT NULL DEFAULT '1',
  `tipo` varchar(20) DEFAULT NULL,
  `alcance` varchar(20) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=71 ;

--
-- Extraindo dados da tabela `op_armas`
--

INSERT INTO `op_armas` (`id`, `nome`, `dano`, `crit`, `categoria`, `espaco`, `tipo`, `alcance`, `descricao`) VALUES
(1, 'Faca', '1d4', '19', 0, 1, 'C', 'Curto', 'Arma corpo a corpo leve'),
(2, 'Pistola', '1d12', '18', 1, 1, 'B', 'Curto', 'Arma de fogo leve'),
(3, 'Revolver', '2d6', '19×3', 1, 1, 'B', 'Curto', 'Arma de fogo leve'),
(4, 'Fuzil de caça', '2d8', '19×3', 1, 2, 'B', 'Médio', 'Arma de fogo duas mãos'),
(5, 'Espada', '1d8/1d10', '19', 1, 1, 'C', '-', 'Arma corpo a corpo uma mão'),
(6, 'Machado', '1d8', '×3', 1, 1, 'C', '-', 'Arma corpo a corpo uma mão'),
(7, 'Submetralhadora', '2d6', '19/x3', 1, 1, 'B', 'Curto', 'Arma de fogo automática'),
(8, 'Espingarda', '4d6', '×3', 1, 2, 'B', 'Curto', 'Arma de fogo duas mãos'),
(9, 'Fuzil de assalto', '2d10', '19/x3', 2, 2, 'B', 'Médio', 'Arma de fogo tática'),
(10, 'Fuzil de precisão', '2d10', '19/x3', 3, 2, 'B', 'Longo', 'Arma de fogo de longo alcance');

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_gerais`
--

CREATE TABLE IF NOT EXISTS `op_gerais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `bonus` varchar(100) DEFAULT NULL,
  `categoria` int(11) NOT NULL DEFAULT '0',
  `espaco` int(11) NOT NULL DEFAULT '1',
  `tipo` varchar(50) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=57 ;

--
-- Extraindo dados da tabela `op_gerais`
--

INSERT INTO `op_gerais` (`id`, `nome`, `bonus`, `categoria`, `espaco`, `tipo`, `descricao`) VALUES
(1, 'Kit Médico', '+5 em testes de Medicina', 0, 1, 'Utensílio', 'Equipamento médico para primeiros socorros'),
(2, 'Lanterna', 'Iluminação em área média', 0, 1, 'Ferramenta', 'Fonte de luz portátil'),
(3, 'Rádio Comunicador', 'Comunicação em até 1km', 0, 1, 'Comunicação', 'Dispositivo de comunicação por rádio'),
(4, 'Binóculos', '+2 em Percepção à distância', 0, 1, 'Utensílio', 'Dispositivo óptico para visão à distância'),
(5, 'Corda', '15m de corda resistente', 0, 1, 'Utensílio', 'Corda de nylon para escalada e amarração'),
(6, 'Máscara de gás', 'Proteção contra gases', 0, 1, 'Proteção', 'Máscara de proteção respiratória'),
(7, 'Granada de Fragmentação', '4d6 de dano em área', 1, 1, 'Explosivo', 'Explosivo de fragmentação para múltiplos alvos'),
(8, 'Granada de Fumaça', 'Cria área de cobertura', 0, 1, 'Explosivo', 'Granada que libera fumaça para ocultação');

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
  `tipo_item` enum('arma','protecao','geral','paranormal') NOT NULL,
  `efeito` text NOT NULL,
  `categoria_extra` int(11) NOT NULL DEFAULT '0',
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=85 ;

--
-- Extraindo dados da tabela `op_modificacoes`
--

INSERT INTO `op_modificacoes` (`id`, `nome`, `tipo_item`, `efeito`, `categoria_extra`, `descricao`) VALUES
(1, 'Certeira', 'arma', '+2 em testes de ataque', 1, 'Modificação que melhora a precisão da arma'),
(2, 'Cruel', 'arma', '+2 em rolagens de dano', 1, 'Modificação que aumenta o dano causado'),
(3, 'Discreta', 'arma', '+5 em testes para ser ocultada e reduz o espaço em -1', 0, 'Modificação que torna a arma mais fácil de ocultar'),
(4, 'Perigosa', 'arma', '+2 em margem de ameaça', 1, 'Modificação que aumenta a chance de acerto crítico'),
(5, 'Alongada', 'arma', '+2 em testes de ataque', 1, 'Modificação para armas de fogo que aumenta o alcance'),
(6, 'Calibre Grosso', 'arma', 'Aumenta o dano em mais um dado do mesmo tipo', 1, 'Modificação que aumenta o calibre da arma'),
(7, 'Antibombas', 'protecao', '+5 em testes de resistência contra efeitos de área', 1, 'Modificação que oferece proteção contra explosões'),
(8, 'Blindada', 'protecao', 'Aumenta RD para 5 e o espaço em +1', 1, 'Modificação que aumenta a resistência a dano'),
(9, 'Discreta', 'protecao', '+5 em testes de ocultar e reduz o espaço em -1', 0, 'Modificação que torna a proteção mais fácil de ocultar'),
(10, 'Reforçada', 'protecao', 'Aumenta a Defesa em +2 e o espaço em +1', 1, 'Modificação que aumenta a proteção oferecida'),
(11, 'Amaldiçoada', 'paranormal', 'Adiciona efeito paranormal ao item', 2, 'Modificação que imbui o item com energia paranormal'),
(12, 'Potencializada', 'paranormal', 'Aumenta a potência do efeito paranormal', 1, 'Modificação que amplifica os efeitos paranormais');

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_paranormal`
--

CREATE TABLE IF NOT EXISTS `op_paranormal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `efeito` text NOT NULL,
  `categoria` int(11) NOT NULL DEFAULT '0',
  `espaco` int(11) NOT NULL DEFAULT '1',
  `elemento` varchar(20) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=43 ;

--
-- Extraindo dados da tabela `op_paranormal`
--

INSERT INTO `op_paranormal` (`id`, `nome`, `efeito`, `categoria`, `espaco`, `elemento`, `descricao`) VALUES
(1, 'Amuleto de Proteção', 'Fornece +2 em Defesa', 1, 1, 'Conhecimento', 'Amuleto que oferece proteção contra ataques'),
(2, 'Anel do Elo Mental', 'Permite comunicação telepática', 2, 1, 'Conhecimento', 'Par de anéis que conecta mentalmente os usuários'),
(3, 'Pérola de Sangue', 'Fornece +5 em testes físicos temporariamente', 2, 1, 'Sangue', 'Esfera que injeta adrenalina no usuário'),
(4, 'Máscara das Sombras', 'Permite teletransporte entre sombras', 3, 1, 'Morte', 'Máscara que concede habilidades de manipulação de sombras'),
(5, 'Coração Pulsante', 'Reduz dano pela metade uma vez por cena', 2, 1, 'Sangue', 'Coração humano preservado que pulsa com energia de Sangue'),
(6, 'Frasco de Vitalidade', 'Armazena PV para recuperação posterior', 1, 1, 'Sangue', 'Frasco que pode armazenar sangue para uso posterior');

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `op_protecoes`
--

CREATE TABLE IF NOT EXISTS `op_protecoes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `defesa` varchar(20) NOT NULL,
  `categoria` int(11) NOT NULL DEFAULT '0',
  `espaco` int(11) NOT NULL DEFAULT '1',
  `tipo` varchar(50) DEFAULT NULL,
  `descricao` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Extraindo dados da tabela `op_protecoes`
--

INSERT INTO `op_protecoes` (`id`, `nome`, `defesa`, `categoria`, `espaco`, `tipo`, `descricao`) VALUES
(1, 'Leve', '+5', 1, 2, 'Armadura', 'Proteção leve que permite boa mobilidade'),
(2, 'Pesada', '+10', 2, 5, 'Armadura', 'Proteção pesada que oferece maior defesa mas reduz mobilidade'),
(3, 'Escudo', '+2', 1, 2, 'Escudo', 'Proteção adicional que pode ser empunhada');

-- --------------------------------------------------------

--
-- Estrutura da tabela `personagens`
--

CREATE TABLE IF NOT EXISTS `personagens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `sistema` varchar(50) NOT NULL,
  `nivel` int(11) NOT NULL DEFAULT '1',
  `imagem` varchar(255) DEFAULT 'default.jpg',
  `data_criacao` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Extraindo dados da tabela `personagens`
--

INSERT INTO `personagens` (`id`, `user_id`, `nome`, `sistema`, `nivel`, `imagem`, `data_criacao`) VALUES
(3, 1, 'myke', 'Ordem Paranormal', 9, 'default.jpg', '2025-09-04 15:22:33');

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

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
-- Limitadores para a tabela `op_personagem_itens`
--
ALTER TABLE `op_personagem_itens`
  ADD CONSTRAINT `op_personagem_itens_ibfk_1` FOREIGN KEY (`personagem_id`) REFERENCES `personagens` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `personagens`
--
ALTER TABLE `personagens`
  ADD CONSTRAINT `personagens_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
