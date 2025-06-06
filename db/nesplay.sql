-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 06/06/2025 às 05:41
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

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
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `idCategoria` int(11) NOT NULL,
  `nome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`idCategoria`, `nome`) VALUES
(1, 'Ação'),
(2, 'RPG'),
(3, 'Tiro'),
(4, 'Futebol'),
(6, 'Plataforma');

-- --------------------------------------------------------

--
-- Estrutura para tabela `roms`
--

CREATE TABLE `roms` (
  `idRom` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `descricao` text DEFAULT NULL,
  `ano` year(4) DEFAULT NULL,
  `nomeArquivo` varchar(255) NOT NULL,
  `caminho` varchar(255) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `roms`
--

INSERT INTO `roms` (`idRom`, `nome`, `descricao`, `ano`, `nomeArquivo`, `caminho`, `categoria_id`, `user_id`) VALUES
(24, 'Mega Man', 'Bora regaçar o Dr Wily!', '1987', 'Mega_Man.nes', 'roms/Mega_Man.nes', 6, 2),
(25, 'Castlevania', 'Bora regaçar o Drácula!', '1987', 'Castlevania.nes', 'roms/Castlevania.nes', 6, 2),
(26, 'The Legend Of Zelda', 'Bora salvar a Zelda e derrotar Ganon!', '1987', 'The_Legend_of_Zelda.nes', 'roms/The_Legend_of_Zelda.nes', 2, 2),
(27, 'Super Mario Bros', 'Bora salvar a Peach e derrotar Bowser!', '1985', 'SuperMarioBros.nes', 'roms/SuperMarioBros.nes', 6, 2);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`idUser`, `nome`, `sobrenome`, `dataNascimento`, `email`, `apelido`, `senha`, `adm`) VALUES
(1, 'Augusto', 'Vasconcelos', '1988-03-20', 'augusto.vasconcelos@fatec.sp.gov.br', 'trevor', 'teste32', 1),
(2, 'Teste1', 'Testesom1', '1991-01-01', 'teste1@teste.com', 'teste1', 'teste1', 1),
(4, 'Teste2', 'Testesom2', '1998-08-08', 'teste2@example.com', 'teste2', 'teste2', 0);

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`idCategoria`);

--
-- Índices de tabela `roms`
--
ALTER TABLE `roms`
  ADD PRIMARY KEY (`idRom`),
  ADD KEY `fk_roms_categoria` (`categoria_id`),
  ADD KEY `fk_roms_usuario` (`user_id`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `roms`
--
ALTER TABLE `roms`
  MODIFY `idRom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `roms`
--
ALTER TABLE `roms`
  ADD CONSTRAINT `fk_roms_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idCategoria`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_roms_usuario` FOREIGN KEY (`user_id`) REFERENCES `usuarios` (`idUser`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
