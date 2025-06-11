-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 11/06/2025 às 07:33
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
(6, 'Plataforma'),
(7, 'Corrida');

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `idNoticia` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `texto` text NOT NULL,
  `data` datetime NOT NULL DEFAULT current_timestamp(),
  `idUser` int(11) DEFAULT NULL,
  `adminNome` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`idNoticia`, `titulo`, `subtitulo`, `texto`, `data`, `idUser`, `adminNome`) VALUES
(1, 'Site NESPlay alcança 10.000 usuários', 'Marco histórico de comunidade', 'É com grande satisfação que anunciamos que alcançamos a marca de 10.000 usuários cadastrados em nossa plataforma. Obrigado pelo apoio de todos!', '2025-06-01 10:00:00', 1, 'Augusto'),
(2, 'Nova categoria: Jogos de RPG', 'Novas aventuras à disposição', 'Criamos uma categoria especial para RPGs clássicos de NES. Agora ficou ainda mais fácil encontrar seus jogos de RPG preferidos e viver grandes aventuras.', '2025-06-05 16:45:00', 2, 'Teste1'),
(3, 'Lançamento do Emulador Atualizado', 'Performance e compatibilidade', 'Disponibilizamos uma nova versão do emulador JSNES com melhorias de performance e suporte a várias roms que antes não rodavam corretamente.', '2025-06-10 14:30:00', 2, 'Teste1');

-- --------------------------------------------------------

--
-- Estrutura para tabela `roms`
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `roms`
--

INSERT INTO `roms` (`idRom`, `nome`, `descricao`, `ano`, `nomeArquivo`, `caminho`, `categoria_id`, `user_id`) VALUES
(24, 'Mega Man', 'Controle Mega Man e derrote robôs malignos neste icônico jogo de ação e plataforma!', '1987', 'Mega_Man.nes', 'roms/Mega_Man.nes', 6, 2),
(25, 'Castlevania', 'Caçe monstros e derrote Drácula neste clássico gótico de ação e plataforma!', '1987', 'Castlevania.nes', 'roms/Castlevania.nes', 6, 2),
(26, 'The Legend Of Zelda', 'Explore masmorras, resolva enigmas e salve Hyrule em The Legend of Zelda!', '1986', 'The_Legend_of_Zelda.nes', 'roms/The_Legend_of_Zelda.nes', 2, 2),
(27, 'Super Mario Bros', 'Salte e corra para salvar a princesa na clássica aventura do Super Mario Bros!', '1985', 'SuperMarioBros.nes', 'roms/SuperMarioBros.nes', 6, 2),
(28, 'Metroid', 'Explore labirintos alienígenas e derrote inimigos como Samus em Metroid!', '1986', 'Metroid.nes', 'roms/Metroid.nes', 3, 2),
(29, 'Contra', 'Lute contra invasores alienígenas em ação intensa e cooperativa no clássico Contra!', '1987', 'Contra.nes', 'roms/Contra.nes', 3, 2),
(30, 'Excitebike', 'Corra em pistas desafiadoras e faça manobras radicais no clássico Excitebike!', '1984', 'Excitebike.nes', 'roms/Excitebike.nes', 7, 2);

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
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`idNoticia`),
  ADD KEY `idx_data` (`data`),
  ADD KEY `fk_noticias_usuario` (`idUser`);

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
  MODIFY `idCategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `idNoticia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `roms`
--
ALTER TABLE `roms`
  MODIFY `idRom` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `fk_noticias_usuario` FOREIGN KEY (`idUser`) REFERENCES `usuarios` (`idUser`) ON DELETE SET NULL ON UPDATE CASCADE;

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
