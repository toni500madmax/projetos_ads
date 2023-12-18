-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 27/11/2023 às 21:33
-- Versão do servidor: 10.4.28-MariaDB
-- Versão do PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `automatizit`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `automoveis`
--

CREATE TABLE `automoveis` (
  `id_auto` int(11) NOT NULL,
  `nome_carro` varchar(30) DEFAULT NULL,
  `placa` varchar(10) NOT NULL,
  `cad_cliente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `automoveis`
--

INSERT INTO `automoveis` (`id_auto`, `nome_carro`, `placa`, `cad_cliente`) VALUES
(1, 'f75', 'aaaaa', 1),
(2, 'opala', 'bbbbb', 2),
(5, 'gol', 'cccc', 5),
(6, 'palio', 'isdgoqh', 6);

-- --------------------------------------------------------

--
-- Estrutura para tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(11) NOT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `dtnasc` date DEFAULT NULL,
  `genero` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `cpf`, `telefone`, `dtnasc`, `genero`) VALUES
(1, 'Antonio Przebiovicz', '45625958632', '41999964572', '1992-07-03', 'Masculino'),
(2, 'Antonio Sergio', '45625958632', '41999964572', '1992-07-03', 'Masculino'),
(5, 'Jessica', '3945982752', '8349739573', '1992-11-30', 'Feminino'),
(6, 'Marta', '18073808404', '25072', '1650-05-19', 'Feminino');

-- --------------------------------------------------------

--
-- Estrutura stand-in para view `custos_totais`
-- (Veja abaixo para a visão atual)
--
CREATE TABLE `custos_totais` (
`id_cliente` int(11)
,`nome` varchar(100)
,`cad_cliente` int(11)
,`qtd_servicos` bigint(21)
,`custo_total` decimal(32,2)
);

-- --------------------------------------------------------

--
-- Estrutura para tabela `servicos`
--

CREATE TABLE `servicos` (
  `id_servico` int(11) NOT NULL,
  `cad_cliente` int(11) NOT NULL,
  `nome_servico` varchar(30) NOT NULL,
  `descricao` varchar(90) NOT NULL,
  `custo` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `servicos`
--

INSERT INTO `servicos` (`id_servico`, `cad_cliente`, `nome_servico`, `descricao`, `custo`) VALUES
(1, 1, 'Suspensão', 'Substituição de par de amortecedores traseiros', 200.00),
(2, 2, 'Freio', 'Substituição de flúido de freio', 80.00),
(3, 5, 'Suspensão', 'Substituição de par de coxins dianteiros', 100.00),
(4, 6, 'Freio', 'Substituição de pastilhas dianteiras e recondicionamento de discos', 350.00),
(5, 1, 'Manutenção no Cabeçote', 'Substituição de Junta de Cabeçote', 250.00),
(10, 1, 'roda', 'blablabla', 100.00),
(11, 1, 'motor', 'troca de velas', 150.00),
(12, 6, 'motor', 'troca de velas', 150.00),
(13, 5, 'motor', 'troca de velas', 150.00);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `senha` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `username`, `senha`) VALUES
(1, 'toni', '123456'),
(2, 'toni12121', '1234'),
(3, 'toni12', '09876'),
(9, 'testar', '81dc9bdb52d04dc20036dbd8313ed055'),
(10, 'tomas', 'd41d8cd98f00b204e9800998ecf8427e'),
(11, 'jessica', 'd41d8cd98f00b204e9800998ecf8427e'),
(12, 'jess', 'd41d8cd98f00b204e9800998ecf8427e'),
(13, 'aaa', 'd41d8cd98f00b204e9800998ecf8427e');

-- --------------------------------------------------------

--
-- Estrutura para view `custos_totais`
--
DROP TABLE IF EXISTS `custos_totais`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `custos_totais`  AS SELECT `clientes`.`id_cliente` AS `id_cliente`, `clientes`.`nome` AS `nome`, `servicos`.`cad_cliente` AS `cad_cliente`, count(`servicos`.`nome_servico`) AS `qtd_servicos`, sum(`servicos`.`custo`) AS `custo_total` FROM ((`clientes` left join `servicos` on(`clientes`.`id_cliente` = `servicos`.`cad_cliente`)) left join `automoveis` on(`clientes`.`id_cliente` = `automoveis`.`cad_cliente`)) GROUP BY `clientes`.`id_cliente` ;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `automoveis`
--
ALTER TABLE `automoveis`
  ADD PRIMARY KEY (`id_auto`),
  ADD UNIQUE KEY `placa` (`placa`),
  ADD KEY `cad_cliente` (`cad_cliente`);

--
-- Índices de tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices de tabela `servicos`
--
ALTER TABLE `servicos`
  ADD PRIMARY KEY (`id_servico`),
  ADD KEY `cad_cliente` (`cad_cliente`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `servicos`
--
ALTER TABLE `servicos`
  MODIFY `id_servico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `automoveis`
--
ALTER TABLE `automoveis`
  ADD CONSTRAINT `automoveis_ibfk_1` FOREIGN KEY (`cad_cliente`) REFERENCES `clientes` (`id_cliente`);

--
-- Restrições para tabelas `servicos`
--
ALTER TABLE `servicos`
  ADD CONSTRAINT `cad_cliente` FOREIGN KEY (`cad_cliente`) REFERENCES `clientes` (`id_cliente`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
