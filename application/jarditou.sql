-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  ven. 25 jan. 2019 à 10:18
-- Version du serveur :  10.2.14-MariaDB
-- Version de PHP :  7.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `jarditou`
--

-- --------------------------------------------------------

--
-- Structure de la table `carts`
--

CREATE TABLE `carts` (
  `id` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `id_tmp` varchar(255) NOT NULL,
  `id_user` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `carts`
--

INSERT INTO `carts` (`id`, `id_product`, `quantity`, `id_tmp`, `id_user`) VALUES
(635, 8, 1, '5c49cf9b0e9aa', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(10) UNSIGNED NOT NULL COMMENT 'Clé de la table catégorie',
  `cat_nom` varchar(200) NOT NULL COMMENT 'Nom de la catégorie',
  `cat_parent` int(10) UNSIGNED DEFAULT NULL COMMENT 'Catégorie parente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_nom`, `cat_parent`) VALUES
(1, 'Outillage', NULL),
(2, 'Outillage manuel', 1),
(3, 'Outillage mécanique', 2),
(4, 'Plants et semis', NULL),
(5, 'Arbres et arbustes', NULL),
(6, 'Pots et accessoires', NULL),
(7, 'Mobilier de jardin', NULL),
(8, 'Matériaux', NULL),
(9, 'Tondeuses éléctriques', 3),
(10, 'Tondeuses à moteur thermique', 3),
(11, 'Débroussailleuses', 3),
(12, 'Sécateurs', 2),
(13, 'Brouettes', 2),
(14, 'Tomates', 4),
(15, 'Poireaux', 4),
(16, 'Salade', 4),
(17, 'Haricots', 4),
(18, 'Thuyas', 5),
(19, 'Oliviers', 5),
(20, 'Pommiers', 5),
(21, 'Pots de fleurs', 6),
(22, 'Soucoupes', 6),
(23, 'Supports', 6),
(24, 'Transats', 7),
(25, 'Parasols', 7),
(26, 'Tonnelles', 7),
(27, 'Divers', 7),
(28, 'Lames de terrasse', 8),
(29, 'Grillages', 8),
(30, 'Panneaux de clôture', 8);

-- --------------------------------------------------------

--
-- Structure de la table `produits`
--

CREATE TABLE `produits` (
  `pro_id` int(10) UNSIGNED NOT NULL COMMENT 'Clé de la table produits',
  `pro_cat_id` int(10) UNSIGNED NOT NULL COMMENT 'Catégorie du produit',
  `pro_ref` varchar(10) NOT NULL COMMENT 'Référence produit',
  `pro_libelle` varchar(200) NOT NULL COMMENT 'Nom du produit',
  `pro_description` text DEFAULT NULL COMMENT 'Description du produit',
  `pro_prix` decimal(6,2) UNSIGNED DEFAULT NULL COMMENT 'Prix ',
  `pro_stock` int(11) DEFAULT 0 COMMENT 'Nombre d''unités en stock',
  `pro_couleur` varchar(30) DEFAULT NULL COMMENT 'Couleur',
  `pro_photo` varchar(255) DEFAULT 'jpg' COMMENT 'Extension de la photo',
  `pro_d_ajout` date NOT NULL DEFAULT current_timestamp() COMMENT 'Date d''ajout',
  `pro_d_modif` datetime DEFAULT NULL COMMENT 'Date de modification',
  `pro_bloque` tinyint(1) DEFAULT NULL COMMENT 'Bloquer le produit à la vente'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produits`
--

INSERT INTO `produits` (`pro_id`, `pro_cat_id`, `pro_ref`, `pro_libelle`, `pro_description`, `pro_prix`, `pro_stock`, `pro_couleur`, `pro_photo`, `pro_d_ajout`, `pro_d_modif`, `pro_bloque`) VALUES
(7, 27, 'B05r', 'Aramisyuiz', 'Lorem ipsum doloré sit amet, consectetur adipiscing elit. In porttitor sit amet ipsum sit amet dapibus. Cras suscipit neque ac magna sagittis lobortis. Duis venenatis enim ac nisl luctus, a scelerisque velit porttitor. Integer nec massa quis urna mollis consectetur et et nisl. Nullam eget nunc vitae nisl convallis faucibus. Vestibulum dapibus, metus nec molestie lobortis, nunc sem mollis tortor, et auctor dolor nunc at nisi. Pellentesque sit amet turpis nisi. ', '110.00', 2, 'Brune', 'jpg', '2018-04-18', '2019-01-24 10:31:50', 1),
(8, 27, 'barb002', 'Athos', 'Curabitur pellentesque posuere luctus. Sed et risus vel quam pharetra pretium non quis odio. Praesent varius risus vel orci ultrices tincidunt.', '249.99', 0, 'Noir', 'jpg', '2016-06-14', '2019-01-24 10:09:29', 1),
(11, 27, 'barb003', 'Clatronic', 'Fusce rutrum odio sem, quis finibus nisl finibus a. Praesent dictum ex in lectus porta, vitae varius lacus eleifend. Sed sed lacinia mi, sed egestas odio. Integer a congue lectus.', '135.90', 10, 'Chrome', 'jpg', '2017-10-18', '2019-01-24 10:09:37', 1),
(12, 27, 'barb004', 'Camping', 'Phasellus auctor mattis justo, in semper urna congue eget. Nunc sit amet nunc sed dui fringilla scelerisque a eget sem. Aenean cursus eros vehicula arcu blandit, sit amet faucibus leo finibus. Duis pharetra felis eget viverra tempor. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas', '88.00', 5, 'Noir', 'jpg', '2018-08-20', NULL, 1),
(13, 13, 'brou001', 'Green', 'Fusce interdum ex justo, vel imperdiet erat volutpat non. Donec et maximus lacus. ', '49.00', 25, 'Verte', 'jpg', '2018-08-01', NULL, NULL),
(14, 13, 'brou002', 'Silver', 'Pellentesque ultrices vestibulum sagittis.', '88.00', 0, 'Argent', 'jpg', '2018-08-09', NULL, NULL),
(15, 13, 'brou003', 'Yellow', 'Sed lobortis pulvinar orci, ut efficitur urna egestas eu.', '54.49', 3, 'Jaune', 'jpg', '2018-08-12', NULL, NULL),
(16, 2, 'GA410', 'Bêche GA 410', 'Nulla at consequat orci.', '19.90', 50, 'Gris', 'png', '2018-08-13', NULL, NULL),
(17, 2, 'beche002', 'Bêche GA 388', 'Curabitur varius interdum nulla, sit amet consequat massa. Vestibulum rutrum leo lectus. Phasellus sit amet viverra velit.', '24.90', 1, 'Argent', 'png', '2018-03-15', NULL, NULL),
(18, 2, 'scm0555', 'Scie à main SCM0555', 'Pellentesque fermentum ut est sagittis feugiat. Morbi in turpis augue. Maecenas dapibus ligula velit, ac gravida risus imperdiet in.', '31.19', 0, 'Bleue', 'png', '2018-08-19', NULL, NULL),
(19, 2, 'scm559', 'Scie couteau', 'raesent ante felis, iaculis vitae lectus sed, luctus laoreet metus. Aenean mattis egestas eleifend. Morbi dictum erat ut lorem porta, a volutpat nibh ultrices. Nunc ut tortor ac velit fringilla dictum at non nulla.', '14.90', 4, 'Bleu', 'png', '2018-04-13', NULL, NULL),
(20, 2, 'h0662', 'Hache H062', 'Cras nec dapibus erat. Cras bibendum auctor dui quis tristique.', '31.19', 0, 'Noir', 'png', '2018-08-12', NULL, NULL),
(21, 11, 'DB0703', 'Titan', 'Etiam eu sem ligula. Donec aliquet velit a condimentum sagittis. Nullam ipsum augue, porta non vestibulum cursus, eleifend tempor erat. Proin et turpis molestie augue mollis laoreet. Nulla lorem tellus, pellentesque nec hendrerit vehicula, consectetur non nisl. Maecenas eget accumsan lectus. Vivamus eleifend lorem scelerisque augue rutrum laoreet. ', '599.99', 4, 'Bleue', 'png', '1999-08-26', NULL, NULL),
(22, 11, 'DB0755', 'Attila', 'Là où passe Attila, l\'herbe ne repousse pas.', '499.99', 0, 'Bleue', 'png', '2018-05-16', NULL, NULL),
(23, 28, 'LAM121', 'Aquitaine', 'Integer aliquet accumsan eleifend. Pellentesque mauris tortor, ultricies a pulvinar ut, fringilla ac mi. Sed consequat, nibh at tempus porttitor, tellus nunc dictum nulla, sed finibus felis augue sed libero. Donec augue mi, mattis et orci ac, mollis feugiat elit.', '12.00', 0, 'Rouge', 'jpg', '2018-03-17', NULL, NULL),
(24, 28, 'LAM233', 'Brown', 'Morbi porta ultricies nibh vel varius. Vestibulum nec rutrum ex, vel posuere nisi. Ut scelerisque sit amet ligula sed imperdiet. Morbi lacinia sapien in elementum iaculis. Vivamus a ultrices enim. ', '9.98', 500, 'Brun', 'jpg', '2018-03-17', NULL, NULL),
(25, 25, 'PRS-01C', 'Biarritz', 'Quisque fermentum, dui eu elementum sagittis, risus lorem placerat ipsum, vitae venenatis tellus sapien id nibh. Suspendisse et aliquet tellus, in suscipit magna.', '157.00', 5, 'Brun', 'jpg', '2018-08-19', NULL, NULL),
(26, 25, 'PRS-38A', 'Cannes', 'Curabitur sodales sem vitae ex commodo, in ullamcorper quam congue. Aliquam erat volutpat. Praesent mollis at velit eu molestie. Proin ac tellus a enim venenatis ultrices vitae sed libero. Vivamus at vulputate orci. Curabitur mattis ac turpis id tempus. Sed turpis enim, egestas ac arcu et, elementum luctus ante.', '299.40', 4, 'rOSE', 'jpg', '2018-08-12', NULL, NULL),
(27, 25, 'PRS-87F', 'Crotoy', 'Morbi porta ultricies nibh vel varius. Vestibulum nec rutrum ex, vel posuere nisi. Ut scelerisque sit amet ligula sed imperdiet. Morbi lacinia sapien in elementum iaculis.', '89.00', 21, 'Rouge', 'jpg', '2018-04-12', '2018-08-21 00:00:00', NULL),
(28, 21, 'POT_001', 'Agave', '. Vivamus a ultrices enim. Etiam at viverra justo. Cras consectetur justo euismod mi maximus, ac tincidunt leo suscipit. Quisque fermentum, dui eu elementum sagittis, risus lorem placerat ipsum, vitae venenatis tellus sapien id nibh.', '288.32', 11, 'Orange', 'jpg', '2017-11-12', NULL, NULL),
(29, 21, 'POT-002', 'Dark', 'Curabitur sodales sem vitae ex commodo, in ullamcorper quam congue. Aliquam erat volutpat. Praesent mollis at velit eu molestie.', '32.50', 45, 'Noir', 'jpg', '2018-08-19', '2019-01-23 13:12:10', 1),
(30, 21, 'POT_003', 'Fuschia', 'Vel porta orci convallis. Duis sodales vehicula porta. Etiam sit amet scelerisque massa. ', '149.97', 12, 'Rose', 'jpg', '2018-03-04', '2019-01-23 13:12:01', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `u_id` int(11) NOT NULL,
  `u_name` varchar(255) NOT NULL,
  `u_firstname` varchar(255) NOT NULL,
  `u_email` varchar(255) NOT NULL,
  `u_login` varchar(255) NOT NULL,
  `u_password` varchar(60) NOT NULL,
  `u_d_r` datetime NOT NULL DEFAULT current_timestamp(),
  `u_d_l` datetime DEFAULT NULL,
  `id_tmp` varchar(255) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`u_id`, `u_name`, `u_firstname`, `u_email`, `u_login`, `u_password`, `u_d_r`, `u_d_l`, `id_tmp`, `admin`) VALUES
(1, 'uu', 'uu', 'email@email.com', 'uu', '$2y$10$FXndM/3aanz2OoFjKEchP.8bY6ZSbYofTelYrAOfnwcMtPIeA7pby', '2019-01-04 09:00:11', NULL, NULL, NULL),
(9, 'uu', 'uu', 'tt@tt.fr', 'yy', '$2y$10$PncPNm.RhjprTbOWFgEmLOYfPi4yrlG06uB/lXB.DSocHGdKhOGgW', '2019-01-04 09:27:06', NULL, NULL, NULL),
(11, 'kk', 'kk', 'email@email.cok', 'jj', '$2y$10$AaB7LTl1mS3fgwRQIiRXnua9fdBFTfXL40l/BCm3yEaZSVeKHwWRW', '2019-01-04 10:32:25', NULL, NULL, NULL),
(12, 'Gerard', 'Klément', 'email@email.ctm', 'ddd', '$2y$10$A.0k/a4ksrk.PdiN.nEH3uNINsNatZ6LTa2fWHXL2J52ZZFS5bStC', '2019-01-04 10:35:12', NULL, NULL, NULL),
(13, 'Gerard', 'Klément', 'ail@email.com', 'Login_11', '$2y$10$y.68BQCogYcCh2jJZWPXKOi..vPZRdNFZsY5f91k/9Rf2aAZWCZfW', '2019-01-04 10:38:33', NULL, NULL, NULL),
(14, 'aa', 'zz', 'oooo@ooo.gt', 'az', 'az', '2019-01-14 13:40:25', NULL, NULL, NULL),
(16, 'll', 'll', 'oooo@ooo.gtl', 'll', '$2y$10$eAg4rSWPaM8tW1pbMx5PB.Zp1D3yXJSP05hV5rc6JtEdQIgS4D5eC', '2019-01-14 13:43:56', NULL, NULL, NULL),
(17, 'Bouillon', 'Anthony', 'aa@aa.fr', 'Chuuny', '$2y$10$vs693XdTJOHyk1hNj./HY.RmHzj5vsa7XYmHUGcD4GLtxAGPXmatO', '2019-01-14 15:18:18', NULL, NULL, 1),
(18, 'yyy', 'yyy', 'oooo@ooo.gty', 'yyy', '$2y$10$XIpmwwcvjRekHkQMtOpa6enW6VdgnyyMErMYmGd52B9OOmlh61G8O', '2019-01-15 15:54:59', NULL, NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`),
  ADD KEY `fk_categories_cat_parent` (`cat_parent`);

--
-- Index pour la table `produits`
--
ALTER TABLE `produits`
  ADD PRIMARY KEY (`pro_id`),
  ADD UNIQUE KEY `idx_pro_ref` (`pro_ref`),
  ADD KEY `fk_produits_cat_id` (`pro_cat_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`),
  ADD UNIQUE KEY `u_email` (`u_email`),
  ADD UNIQUE KEY `u_login` (`u_login`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=636;

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Clé de la table catégorie', AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `produits`
--
ALTER TABLE `produits`
  MODIFY `pro_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Clé de la table produits', AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_cat_parent` FOREIGN KEY (`cat_parent`) REFERENCES `categories` (`cat_id`);

--
-- Contraintes pour la table `produits`
--
ALTER TABLE `produits`
  ADD CONSTRAINT `fk_produits_cat_id` FOREIGN KEY (`pro_cat_id`) REFERENCES `categories` (`cat_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
