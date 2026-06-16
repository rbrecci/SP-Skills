-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 08/06/2026 às 14:18
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
-- Banco de dados: `zoo`
--
create database zoodata;
use zoodata;

-- --------------------------------------------------------

--
-- Estrutura para tabela `animals`
--

CREATE TABLE `animals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `scientific_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `size` double NOT NULL,
  `weight` double NOT NULL,
  `visits` int(11) NOT NULL DEFAULT 0,
  `feed_class_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `extinction_risk_id` bigint(20) UNSIGNED NOT NULL,
  `status_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `animals`
--

INSERT INTO `animals` (`id`, `name`, `scientific_name`, `description`, `size`, `weight`, `visits`, `feed_class_id`, `category_id`, `extinction_risk_id`, `status_id`) VALUES
(1, 'Leão-africano', 'Panthera leo', 'Grande felino carnívoro, conhecido como o rei da selva, vive em bandos nas savanas.', 2.5, 190, 150, 1, 1, 2, 1),
(2, 'Elefante-africano', 'Loxodonta africana', 'O maior mamífero terrestre atual, possui grandes orelhas e uma tromba versátil.', 3.3, 6000, 230, 2, 1, 3, 1),
(3, 'Arara-azul-grande', 'Anodorhynchus hyacinthinus', 'Bela ave de plumagem azul vibrante, encontrada principalmente no Pantanal brasileiro.', 1, 1.3, 95, 2, 2, 2, 1),
(4, 'Tigre-de-bengala', 'Panthera tigris tigris', 'Predador solitário e imponente, conhecido por suas listras camufladas e agilidade.', 2.8, 220, 180, 1, 1, 3, 3),
(5, 'Urso-pardo', 'Ursus arctos', 'Grande mamífero onívoro com forte musculatura, excelente pescador e escalador.', 2, 350, 85, 3, 1, 1, 1),
(6, 'Jacaré-do-pantanal', 'Caiman yakare', 'Réptil carnívoro que habita rios e lagoas, alimenta-se principalmente de peixes.', 2.5, 60, 42, 1, 3, 1, 1),
(7, 'Pinguim-de-magalhães', 'Spheniscus magellanicus', 'Ave marinha que não voa, excelente nadadora, vive em colônias em regiões frias.', 0.7, 4.5, 110, 1, 2, 1, 2),
(8, 'Gorila-ocidental-das-terras-baixas', 'Gorilla gorilla gorilla', 'Primata de grande porte, vive em florestas tropicais e possui comportamento social complexo.', 1.7, 160, 140, 2, 1, 4, 1),
(9, 'Tartaruga-verde', 'Chelonia mydas', 'Grande tartaruga marinha que migra por longas distâncias pelos oceanos tropicais.', 1.2, 150, 65, 2, 3, 3, 1),
(10, 'Lobo-guará', 'Chrysocyon brachyurus', 'O maior canídeo da América do Sul, de pernas longas e pelagem avermelhada, típico do Cerrado.', 0.9, 25, 75, 3, 1, 2, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `animal_pictures`
--

CREATE TABLE `animal_pictures` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `filepath` varchar(255) NOT NULL,
  `animal_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(4, 'Anfíbios'),
(2, 'Aves'),
(6, 'Invertebrados'),
(1, 'Mamíferos'),
(7, 'Moluscos'),
(5, 'Peixes'),
(3, 'Répteis');

-- --------------------------------------------------------

--
-- Estrutura para tabela `extinction_risks`
--

CREATE TABLE `extinction_risks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `acronym` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `extinction_risks`
--

INSERT INTO `extinction_risks` (`id`, `name`, `acronym`) VALUES
(1, 'Segura', 'LC'),
(2, 'Vunerável', 'VU'),
(3, 'Em Perigo', 'EN'),
(4, 'Criticamente em Perigo', 'CR');

-- --------------------------------------------------------

--
-- Estrutura para tabela `feed_classes`
--

CREATE TABLE `feed_classes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `feed_classes`
--

INSERT INTO `feed_classes` (`id`, `name`) VALUES
(1, 'Carnívoro'),
(2, 'Herbívoro'),
(3, 'Onívoro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `status`
--

CREATE TABLE `status` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `status`
--

INSERT INTO `status` (`id`, `name`) VALUES
(3, 'Em Adaptação'),
(1, 'Em Exposição'),
(2, 'Fora de Exibição');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animals_category_id_foreign` (`category_id`),
  ADD KEY `animals_extinction_risk_id_foreign` (`extinction_risk_id`),
  ADD KEY `animals_feed_class_id_foreign` (`feed_class_id`),
  ADD KEY `animals_status_id_foreign` (`status_id`);

--
-- Índices de tabela `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `animal_pictures_animal_id_foreign` (`animal_id`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Índices de tabela `extinction_risks`
--
ALTER TABLE `extinction_risks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `extinction_risks_name_unique` (`name`),
  ADD UNIQUE KEY `extinction_risks_acronym_unique` (`acronym`);

--
-- Índices de tabela `feed_classes`
--
ALTER TABLE `feed_classes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `feed_classes_name_unique` (`name`);

--
-- Índices de tabela `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `status_name_unique` (`name`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `animals`
--
ALTER TABLE `animals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de tabela `animal_pictures`
--
ALTER TABLE `animal_pictures`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `extinction_risks`
--
ALTER TABLE `extinction_risks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `feed_classes`
--
ALTER TABLE `feed_classes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `status`
--
ALTER TABLE `status`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `animals`
--
ALTER TABLE `animals`
  ADD CONSTRAINT `animals_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `animals_extinction_risk_id_foreign` FOREIGN KEY (`extinction_risk_id`) REFERENCES `extinction_risks` (`id`),
  ADD CONSTRAINT `animals_feed_class_id_foreign` FOREIGN KEY (`feed_class_id`) REFERENCES `feed_classes` (`id`),
  ADD CONSTRAINT `animals_status_id_foreign` FOREIGN KEY (`status_id`) REFERENCES `status` (`id`);

--
-- Restrições para tabelas `animal_pictures`
--
ALTER TABLE `animal_pictures`
  ADD CONSTRAINT `animal_pictures_animal_id_foreign` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
