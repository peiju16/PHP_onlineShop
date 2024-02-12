-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : lun. 03 avr. 2023 à 14:31
-- Version du serveur : 5.7.34
-- Version de PHP : 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `onlineshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id_comment` int(11) NOT NULL,
  `id_member` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `comment` varchar(250) DEFAULT NULL,
  `date` date NOT NULL,
  `state` enum('in progress','validated','rejected') DEFAULT NULL,
  `grade` enum('1','2','3','4','5') DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `contact`
--

CREATE TABLE `contact` (
  `id_contact` int(11) NOT NULL,
  `id_member` int(11) DEFAULT NULL,
  `first_name` varchar(45) NOT NULL,
  `last_name` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `phone_number` int(11) NOT NULL,
  `message` longtext NOT NULL,
  `subject` varchar(250) NOT NULL,
  `date` date DEFAULT NULL,
  `state` enum('in progress','processed') DEFAULT 'in progress',
  `response` longtext,
  `response_state` enum('read','unread') NOT NULL DEFAULT 'unread',
  `date_response` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `members`
--

CREATE TABLE `members` (
  `id_member` int(3) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `password` varchar(60) NOT NULL,
  `name` varchar(20) NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `sexe` enum('m','f') NOT NULL,
  `city` varchar(20) NOT NULL,
  `postal_code` int(5) UNSIGNED ZEROFILL NOT NULL,
  `address` varchar(50) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '0',
  `photo` varchar(250) DEFAULT NULL,
  `phone_number` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id_order` int(3) NOT NULL,
  `id_member` int(3) DEFAULT NULL,
  `amount` int(3) NOT NULL,
  `date` datetime NOT NULL,
  `state` enum('in progress','sent','delivered') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `order_details`
--

CREATE TABLE `order_details` (
  `id_order_details` int(3) NOT NULL,
  `id_order` int(3) DEFAULT NULL,
  `id_product` int(3) DEFAULT NULL,
  `quantity` int(3) NOT NULL,
  `price` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id_product` int(3) NOT NULL,
  `reference` varchar(20) NOT NULL,
  `category` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `color` varchar(20) NOT NULL,
  `size` varchar(5) NOT NULL,
  `public` enum('m','f','all') NOT NULL,
  `picture` varchar(250) NOT NULL,
  `price` int(3) NOT NULL,
  `stock` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id_product`, `reference`, `category`, `title`, `description`, `color`, `size`, `public`, `picture`, `price`, `stock`) VALUES
(2, '31-p-33', 'T-shirt', 'Black original t-shirt', 'Nice original t-shirt', 'black', 'XL', 'm', 'http://localhost:8888/php/onlineshop/pictures/31-p-33_green_t-shirt.png', 25, 10),
(3, '56-a-65', 'Shirt', 'White shirt', 'Classic white shirt', 'white', 'L', 'm', 'http://localhost:8888/php/onlineshop/pictures/white_shirt.png', 49, 1),
(4, '77-p-79', 'Pullover', 'Grey pullover', 'Grey Pullover for winter', 'grey', 'XL', 'f', 'http://localhost:8888/php/onlineshop/pictures/grey_pullover.png', 79, 4),
(5, '11-d-231', 'T-shirt', 'V-neck T-shirt', 'Dark blue t-shirt for men', 'dark blue', 'M', 'm', 'http://localhost:8888/php/onlineshop/pictures/blue_t-shirt.png', 44, 3),
(6, '66-f-15_01', 'T-shirt', 'Red t-shirt', 'Red t-shirt for man', 'red', 'S', 'm', 'http://localhost:8888/php/onlineshop/pictures/red_t-shirt.png', 56, 5),
(7, '88-g-77-01', 'T-shirt', 'Green t-shirt', 'Green t-shirt for man', 'green', 'L', 'm', 'http://localhost:8888/php/onlineshop/pictures/green_t-shirt.png', 29, 6),
(8, '72-g-17-22', 'Shirt', 'Black shirt', 'Black shirt for man', 'green', 'L', 'm', 'http://localhost:8888/php/onlineshop/pictures/black_shirt.png', 39, 13);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id_comment`);

--
-- Index pour la table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id_contact`);

--
-- Index pour la table `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id_member`),
  ADD UNIQUE KEY `pseudo` (`pseudo`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_member` (`id_member`);

--
-- Index pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id_order_details`),
  ADD KEY `id_order` (`id_order`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_product`),
  ADD UNIQUE KEY `reference` (`reference`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id_comment` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `contact`
--
ALTER TABLE `contact`
  MODIFY `id_contact` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `members`
--
ALTER TABLE `members`
  MODIFY `id_member` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id_order` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id_order_details` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id_product` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`id_member`) REFERENCES `members` (`id_member`);

--
-- Contraintes pour la table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`id_order`) REFERENCES `orders` (`id_order`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
