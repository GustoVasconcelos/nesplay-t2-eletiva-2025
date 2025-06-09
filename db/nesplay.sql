-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 09-Jun-2025 às 16:14
-- Versão do servidor: 10.4.24-MariaDB
-- versão do PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `nesplay`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nome`) VALUES
(1, 'Ação'),
(2, 'RPG'),
(3, 'Tiro'),
(4, 'Futebol'),
(6, 'Plataforma'),
(7, 'Corrida');

-- --------------------------------------------------------

--
-- Estrutura da tabela `roms`
--

CREATE TABLE `roms` (
  `idRom` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text NOT NULL,
  `ano` year(4) NOT NULL,
  `nomeArquivo` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `roms`
--

INSERT INTO `roms` (`idRom`, `nome`, `descricao`, `ano`, `nomeArquivo`, `caminho`, `categoria_id`, `user_id`) VALUES
(24, 'Mega Man', 'Controle Mega Man e derrote robôs malignos neste icônico jogo de ação e plataforma!', 1987, 'Mega_Man.nes', 'roms/Mega_Man.nes', 6, 2),
(25, 'Castlevania', 'Caçe monstros e derrote Drácula neste clássico gótico de ação e plataforma!', 1987, 'Castlevania.nes', 'roms/Castlevania.nes', 6, 2),
(26, 'The Legend Of Zelda', 'Explore masmorras, resolva enigmas e salve Hyrule em The Legend of Zelda!', 1986, 'The_Legend_of_Zelda.nes', 'roms/The_Legend_of_Zelda.nes', 2, 2),
(27, 'Super Mario Bros', 'Salte e corra para salvar a princesa na clássica aventura do Super Mario Bros!', 1985, 'SuperMarioBros.nes', 'roms/SuperMarioBros.nes', 6, 2),
(28, 'Metroid', 'Explore labirintos alienígenas e derrote inimigos como Samus em Metroid!', 1986, 'Metroid.nes', 'roms/Metroid.nes', 3, 2),
(29, 'Contra', 'Lute contra invasores alienígenas em ação intensa e cooperativa no clássico Contra!', 1987, 'Contra.nes', 'roms/Contra.nes', 3, 2),
(30, 'Excitebike', 'Corra em pistas desafiadoras e faça manobras radicais no clássico Excitebike!', 1984, 'Excitebike.nes', 'roms/Excitebike.nes', 7, 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `idUser` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL,
  `sobrenome` varchar(200) NOT NULL,
  `dataNascimento` date NOT NULL,
  `email` varchar(200) NOT NULL,
  `apelido` varchar(200) NOT NULL,
  `senha` varchar(200) NOT NULL,
  `adm` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`idUser`, `nome`, `sobrenome`, `dataNascimento`, `email`, `apelido`, `senha`, `adm`) VALUES
(1, 'Augusto', 'Vasconcelos', '1988-03-20', 'augusto.vasconcelos@fatec.sp.gov.br', 'trevor', 'teste32', 1),
(2, 'Teste1', 'Testesom1', '1991-01-01', 'teste1@teste.com', 'teste1', 'teste1', 1),
(4, 'Teste2', 'Testesom2', '1998-08-08', 'teste2@example.com', 'teste2', 'teste2', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices para tabela `roms`
--
ALTER TABLE `roms`
  ADD PRIMARY KEY (`idRom`),
  ADD KEY `fk_roms_categoria` (`categoria_id`),
  ADD KEY `fk_roms_usuario` (`user_id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `roms`
--
ALTER TABLE `roms`
  MODIFY `idRom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `roms`
--
ALTER TABLE `roms`
  ADD CONSTRAINT `fk_roms_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idCategoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_roms_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`idUser`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
