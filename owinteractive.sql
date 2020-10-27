-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 26-Out-2020 às 07:12
-- Versão do servidor: 10.4.14-MariaDB
-- versão do PHP: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `owinteractive`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `operacoes`
--

CREATE TABLE `operacoes` (
  `id` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `operacao` varchar(7) NOT NULL,
  `valor` decimal(5,2) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `operacoes`
--

INSERT INTO `operacoes` (`id`, `id_usuario`, `operacao`, `valor`, `created_at`, `updated_at`) VALUES
(1, 1, 'credito', '10.00', '2020-10-24 16:26:43', '2020-10-24 16:26:43'),
(2, 2, 'debito', '10.00', '2020-10-24 16:27:59', '2020-10-24 16:27:59'),
(4, 1, 'estorno', '50.00', '2020-10-24 20:01:57', '2020-10-24 20:01:57');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `saldo_inicial` decimal(5,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `name`, `email`, `birthday`, `created_at`, `updated_at`, `saldo_inicial`) VALUES
(1, 'Gabriel', 'gabriel@usp', '1999-09-17', '2020-10-23 03:47:36', '2020-10-23 03:47:36', '0.00'),
(2, 'Luiza', 'luiza@usp', '1999-03-17', '2020-10-23 03:47:36', '2020-10-23 03:47:36', '0.00'),
(3, 'carol', 'carol@usp', '1999-10-15', '2020-10-23 04:42:08', '2020-10-23 04:42:08', '0.00'),
(4, 'valeria', 'valeria@usp.br', '1999-10-23', '2020-10-24 00:09:29', '2020-10-24 00:09:29', '0.00');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `operacoes`
--
ALTER TABLE `operacoes`
  ADD PRIMARY KEY (`id`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `operacoes`
--
ALTER TABLE `operacoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
