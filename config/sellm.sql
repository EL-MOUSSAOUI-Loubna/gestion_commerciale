-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 14 mai 2025 à 03:55
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `sellm`
--

-- --------------------------------------------------------

--
-- Structure de la table `bonslivraison`
--

CREATE TABLE `bonslivraison` (
  `id` int(11) NOT NULL,
  `num_bonl` varchar(20) DEFAULT NULL,
  `date_emission` date NOT NULL DEFAULT curdate(),
  `client_id` int(11) NOT NULL,
  `facture_id` int(11) NOT NULL,
  `nom_transport` varchar(255) DEFAULT NULL,
  `telephone_transport` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `bonslivraison`
--

INSERT INTO `bonslivraison` (`id`, `num_bonl`, `date_emission`, `client_id`, `facture_id`, `nom_transport`, `telephone_transport`, `created_at`, `updated_at`) VALUES
(9, 'BL-2025-00009', '2025-05-13', 4, 7, 'transport', '', '2025-05-13 16:31:27', '2025-05-13 16:31:27');

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `nom`, `parent_id`) VALUES
(1, 'Electronics', NULL),
(2, 'Clothing', NULL),
(3, 'Smartphones', 1),
(4, 'Laptops', 1),
(5, 'Men', 2),
(6, 'Women', 2),
(7, 'iPhone', 3),
(8, 'Android', 3),
(9, 'T-Shirts', 5),
(10, 'children', 2),
(11, 'Fourniture', NULL),
(47, 'Health & Skin Care', NULL),
(51, 'test sibling', 11),
(52, 'Food', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `nom_ste` varchar(255) NOT NULL,
  `ice` int(11) NOT NULL,
  `idf` int(11) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `clients`
--

INSERT INTO `clients` (`id`, `nom_ste`, `ice`, `idf`, `adresse`, `email`, `telephone`) VALUES
(2, 'ste1', 123456789, 147258369, 'morocco', 'ste1@gmail.com', '0605040302'),
(3, 'stlit', 123456789, 147258369, 'morocco', 'mail@stlit.ma', '0605040302'),
(4, 'ste 3', 123456, 0, 'maroc', 'ste3@gmail.com', '0666666666'),
(5, 'client ste', 123456, 0, '', '', '0666666666');

-- --------------------------------------------------------

--
-- Structure de la table `factures`
--

CREATE TABLE `factures` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `date_emission` date NOT NULL,
  `num_facture` varchar(20) DEFAULT NULL,
  `total_ht` decimal(10,2) DEFAULT NULL,
  `total_ttc` decimal(10,2) DEFAULT NULL,
  `modes_pay` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `factures`
--

INSERT INTO `factures` (`id`, `client_id`, `date_emission`, `num_facture`, `total_ht`, `total_ttc`, `modes_pay`, `created_at`, `updated_at`) VALUES
(5, 2, '2025-05-02', 'FAC-2025-00005', 4840.00, 5799.00, NULL, '2025-05-02 04:15:34', NULL),
(6, 2, '2025-05-02', 'FAC-2025-00006', 9500.00, 11400.00, 'carte', '2025-05-02 05:12:55', NULL),
(7, 3, '2025-05-01', 'FAC-2025-00007', 90.00, 99.00, 'espèce,chèque', '2025-05-02 05:17:30', '2025-05-07 23:03:15'),
(8, 2, '2025-05-02', 'FAC-2025-00008', 60.00, 66.00, 'espèce', '2025-05-02 05:29:34', NULL),
(9, 2, '2025-05-02', 'FAC-2025-00009', 124.16, 140.30, 'espèce', '2025-05-02 05:32:35', NULL),
(10, 3, '2025-05-02', 'FAC-2025-00010', 120.00, 132.00, 'carte', '2025-05-02 06:13:25', NULL),
(11, 2, '2025-05-02', 'FAC-2025-00011', 30060.00, 36066.00, 'espèce,carte', '2025-05-02 06:28:08', NULL),
(12, 3, '2025-05-03', 'FAC-2025-00012', 60.00, 66.00, 'effet', '2025-05-03 03:08:56', NULL),
(13, 4, '2025-05-06', 'FAC-2025-00013', 60.00, 66.00, 'espèce', '2025-05-06 16:46:53', NULL),
(14, 2, '2025-05-13', 'FAC-2025-00014', 90.00, 99.00, 'espèce', '2025-05-13 15:11:52', '2025-05-13 15:18:16');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseurs`
--

CREATE TABLE `fournisseurs` (
  `id` int(11) NOT NULL,
  `nom_ste` varchar(255) NOT NULL,
  `ice` int(11) NOT NULL,
  `idf` int(11) DEFAULT NULL,
  `adresse` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telephone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseurs`
--

INSERT INTO `fournisseurs` (`id`, `nom_ste`, `ice`, `idf`, `adresse`, `email`, `telephone`) VALUES
(2, 'fournisseeur ste', 764533, 6, 'maroc', 'frns@ste.com', '0000000000');

-- --------------------------------------------------------

--
-- Structure de la table `lignes_bl`
--

CREATE TABLE `lignes_bl` (
  `id` int(11) NOT NULL,
  `bl_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lignes_bl`
--

INSERT INTO `lignes_bl` (`id`, `bl_id`, `produit_id`, `qte`) VALUES
(5, 9, 3, 2),
(6, 9, 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `lignes_facture`
--

CREATE TABLE `lignes_facture` (
  `id` int(11) NOT NULL,
  `facture_id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `qte` int(11) NOT NULL,
  `remise` int(11) DEFAULT NULL,
  `prix_u` decimal(10,2) DEFAULT NULL,
  `ttva` int(11) DEFAULT NULL,
  `ht` decimal(10,2) DEFAULT NULL,
  `ttc` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lignes_facture`
--

INSERT INTO `lignes_facture` (`id`, `facture_id`, `produit_id`, `qte`, `remise`, `prix_u`, `ttva`, `ht`, `ttc`) VALUES
(1, 5, 3, 3, 0, 30.00, 10, 90.00, 99.00),
(2, 5, 1, 1, 5, 5000.00, 20, 4750.00, 5700.00),
(3, 6, 1, 2, 5, 5000.00, 20, 9500.00, 11400.00),
(5, 8, 3, 2, 0, 30.00, 10, 60.00, 66.00),
(6, 9, 4, 2, 3, 64.00, 13, 124.16, 140.30),
(7, 10, 3, 4, 0, 30.00, 10, 120.00, 132.00),
(8, 11, 3, 2, 0, 30.00, 10, 60.00, 66.00),
(9, 11, 1, 6, 0, 5000.00, 20, 30000.00, 36000.00),
(10, 12, 3, 2, 0, 30.00, 10, 60.00, 66.00),
(11, 13, 3, 2, 0, 30.00, 10, 60.00, 66.00),
(17, 7, 3, 3, 0, 30.00, 10, 90.00, 99.00),
(19, 14, 3, 3, 0, 30.00, 10, 90.00, 99.00);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `id` int(11) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `description_p` text DEFAULT NULL,
  `prix_u` decimal(10,2) NOT NULL,
  `ttva` decimal(10,2) NOT NULL,
  `categorie` int(11) DEFAULT NULL,
  `fournisseur` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`id`, `libelle`, `reference`, `description_p`, `prix_u`, `ttva`, `categorie`, `fournisseur`) VALUES
(1, 'samsung s24', 'a123a123', 'descr samsung', 5000.00, 20.00, 1, 'four2'),
(3, 'libellé2', 'bio53', 'buio', 30.00, 10.00, 1, '0'),
(4, 'zr', 'vjbk', 'k i', 64.00, 13.00, 2, 'four2'),
(5, 'produit5', '987654321', '', 30.50, 20.00, 3, 'four1'),
(6, 'produit 1', '951159', '', 10.00, 20.00, 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `penom` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `login` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `bonslivraison`
--
ALTER TABLE `bonslivraison`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `num_facture` (`num_bonl`),
  ADD UNIQUE KEY `num_bonl` (`num_bonl`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `facture_id` (`facture_id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Index pour la table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `factures`
--
ALTER TABLE `factures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `client_id` (`client_id`);

--
-- Index pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lignes_bl`
--
ALTER TABLE `lignes_bl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bl_id` (`bl_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facture_id` (`facture_id`),
  ADD KEY `produit_id` (`produit_id`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `reference` (`reference`),
  ADD KEY `fk_produits_categorie` (`categorie`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `indx_email` (`login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `bonslivraison`
--
ALTER TABLE `bonslivraison`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT pour la table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `factures`
--
ALTER TABLE `factures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `fournisseurs`
--
ALTER TABLE `fournisseurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `lignes_bl`
--
ALTER TABLE `lignes_bl`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bonslivraison`
--
ALTER TABLE `bonslivraison`
  ADD CONSTRAINT `bonslivraison_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`),
  ADD CONSTRAINT `bonslivraison_ibfk_2` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`);

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `categories_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `factures`
--
ALTER TABLE `factures`
  ADD CONSTRAINT `factures_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`);

--
-- Contraintes pour la table `lignes_bl`
--
ALTER TABLE `lignes_bl`
  ADD CONSTRAINT `lignes_bl_ibfk_1` FOREIGN KEY (`bl_id`) REFERENCES `bonslivraison` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `lignes_bl_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `lignes_facture`
--
ALTER TABLE `lignes_facture`
  ADD CONSTRAINT `lignes_facture_ibfk_1` FOREIGN KEY (`facture_id`) REFERENCES `factures` (`id`),
  ADD CONSTRAINT `lignes_facture_ibfk_2` FOREIGN KEY (`produit_id`) REFERENCES `produits` (`id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produits_categorie` FOREIGN KEY (`categorie`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
