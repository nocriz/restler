-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb1
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 24-Maio-2013 às 14:08
-- Versão do servidor: 5.5.31
-- versão do PHP: 5.4.6-1ubuntu1.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `api`
--
CREATE DATABASE `api` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `api`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `complement` varchar(50) NOT NULL,
  `city` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `zip_code` varchar(50) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `client`
--

INSERT INTO `client` (`name`, `email`, `phone`, `address`, `number`, `complement`, `city`, `country`, `zip_code`, `id`) VALUES
('Ramon', 'rbarros_@hotmail.com', '5430282803', 'Rua', '1835', 'Casa', '', 'RS', '95098310', 1),
('Fulano', 'fulano@domain.com', '5430282020', 'Rua Vinte de Setembro', '200', 'Sala 201', 'Caxias do Sul', 'RS', '95095300', 2);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `tokens`
--

INSERT INTO `tokens` (`id`, `token`, `role`) VALUES
(1, 'b599cfee8a52251902ed4a52cbe635cf', 'client');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
