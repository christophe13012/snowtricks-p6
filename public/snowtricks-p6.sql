-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le :  mer. 13 jan. 2021 à 17:44
-- Version du serveur :  5.7.26
-- Version de PHP :  7.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `snowtricks-p6`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Basic'),
(2, 'Grabs'),
(3, 'Jumps'),
(4, 'Slides'),
(5, 'Rotations'),
(6, 'Flips'),
(7, 'Rotations désaxées');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `id_trick` int(11) NOT NULL,
  `content` varchar(10000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `id_trick`, `content`, `created_at`, `user_id`) VALUES
(2, 1, 'test2', '2020-12-07 00:00:00', 4),
(5, 1, 'test 3', '2020-12-14 14:11:24', 4),
(6, 1, 'super figure !!!', '2020-12-14 14:11:35', 4),
(7, 9, 'erferfef', '2020-12-29 14:52:43', 4),
(8, 9, 'referfe', '2020-12-29 14:56:33', 4),
(9, 9, 'rtgrtg', '2021-01-07 15:01:41', 4);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201129222558', '2020-11-29 22:26:14', 59),
('DoctrineMigrations\\Version20201129222842', '2020-11-29 22:28:54', 66),
('DoctrineMigrations\\Version20201130112006', '2020-11-30 11:20:17', 134),
('DoctrineMigrations\\Version20201130223640', '2020-11-30 22:36:49', 142),
('DoctrineMigrations\\Version20201206171345', '2020-12-06 17:13:58', 168),
('DoctrineMigrations\\Version20201206171849', '2020-12-06 17:18:57', 65),
('DoctrineMigrations\\Version20201212225900', '2020-12-12 23:00:04', 128),
('DoctrineMigrations\\Version20201212233833', '2020-12-12 23:38:37', 151),
('DoctrineMigrations\\Version20201212235458', '2020-12-12 23:55:06', 115),
('DoctrineMigrations\\Version20201213225710', '2020-12-13 22:57:21', 197),
('DoctrineMigrations\\Version20201214175607', '2020-12-14 17:56:17', 150),
('DoctrineMigrations\\Version20201217210557', '2020-12-17 21:06:06', 128),
('DoctrineMigrations\\Version20201217211912', '2020-12-17 21:22:25', 101),
('DoctrineMigrations\\Version20201217212209', '2020-12-17 21:22:25', 29),
('DoctrineMigrations\\Version20201217214540', '2020-12-17 21:45:43', 100),
('DoctrineMigrations\\Version20201218082252', '2020-12-18 08:22:59', 146),
('DoctrineMigrations\\Version20201218085412', '2020-12-18 08:54:20', 107),
('DoctrineMigrations\\Version20201218085734', '2020-12-18 08:57:43', 84),
('DoctrineMigrations\\Version20201218090132', '2020-12-18 09:01:36', 115),
('DoctrineMigrations\\Version20201218091055', '2020-12-18 09:10:58', 161),
('DoctrineMigrations\\Version20201218093918', '2020-12-18 09:39:22', 166),
('DoctrineMigrations\\Version20201218095633', '2020-12-18 09:56:36', 152),
('DoctrineMigrations\\Version20201218095757', '2020-12-18 09:58:10', 155),
('DoctrineMigrations\\Version20201218133116', '2020-12-18 13:31:19', 97),
('DoctrineMigrations\\Version20201219213523', '2020-12-19 21:35:30', 152);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `photo`
--

INSERT INTO `photo` (`id`, `trick_id`, `url`) VALUES
(3, 9, 'https://snowtricks.jeandescorps.fr/images/stalefish-2.jpg'),
(4, 9, 'https://cdn.shopify.com/s/files/1/0370/4055/4115/t/6/assets/21_Stale_Collection_Image_2.png'),
(5, 9, 'https://cdn.shopify.com/s/files/1/0370/4055/4115/t/6/assets/21_Stale_Collection_Image_2.png'),
(6, 9, 'https://www.snowsurf.com/media/Cody%20Rosenthal.png'),
(33, NULL, ''),
(35, 7, 'https://i.pinimg.com/originals/0e/d9/e2/0ed9e296f8e4a6fcc074dd5e488593ee.jpg'),
(36, NULL, '');

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

CREATE TABLE `tricks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `url_path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `name`, `description`, `main_image`, `category_id`, `url_path`) VALUES
(2, 'FS 720', '<p>Deux tours complets en front-side.</p>', 'https://coresites-cdn-adm.imgix.net/onboardfr/wp-content/uploads/2017/03/TOTALFIGHT17_KUNITAKE_HIROAKI-2.jpg?fit=crop', 6, 'FS-720'),
(3, 'BACKSIDE RODEO 1080', '<p>Trois tours avec une rotation d&eacute;sax&eacute;e (Rodeo).</p>', 'https://jimmysweat.sebastienavenel.fr/uploads/images/37d2c0a60b52b086d78fcf2ea4e25928.jpeg', 2, 'BACKSIDE-RODEO-1080'),
(4, 'FRONTFLIP', '<p>Rotation en avant.</p>', 'https://coresites-cdn-adm.imgix.net/whitelines_new/wp-content/uploads/2012/12/frontflipknuckle.jpg?fit=crop', 3, 'FRONTFLIP'),
(5, 'BACKFLIP', '<p>Rotation en arri&egrave;re.</p>', 'https://www.imperiumsnow.com/upload/1-udpvcpu7sqlvxgy15zgxrq.jpeg', 5, 'BACKFLIP'),
(6, 'CORK', '<p>Un cork est une rotation horizontale plus ou moins d&eacute;sax&eacute;e, selon un mouvement d\'&eacute;paules effectu&eacute; juste au moment du saut.</p>', 'https://www.lequipe.fr/_medias/img-photo-jpg/le-slopestyle-lors-des-jo-2018-a-pyeongchang-en-coree-du-sud-sebastien-boue-l-equipe/1500000001051147/32:73,1974:1044-624-312-75/d64e3.jpg', 7, 'CORK'),
(7, 'RODEO', '<p>Le rodeo est une rotation d&eacute;sax&eacute;e, qui se reconna&icirc;t par son aspect vrill&eacute;.</p>', 'https://coresites-cdn-adm.imgix.net/whitelines_new/wp-content/uploads/2009/10/Robin-rodeo.jpg', 6, 'RODEO'),
(8, 'NOSE SLIDE', '<p>Un nose slide consiste &agrave; glisser sur une barre de slide avec l\'avant de la planche sur la barre.</p>', 'https://cdn.shopify.com/s/files/1/0230/2239/articles/Snowboard_Trick_Terminology_1024x1024.jpg?v=1556396922', 7, 'NOSE-SLIDE'),
(9, 'NOSE GRAB', '<p>Un Nosegrab est un trick de skateboard qui consiste &agrave; saisir la planche avec une main au niveau du nose (avant de la planche) le tout en l\'air en faisant un ollie. test</p>', 'https://cdn.shopify.com/s/files/1/0230/2239/files/3_b5916b1c-dec5-4882-8e5d-abf311e254b3_large.jpg?v=1517870727', 1, 'NOSE-GRAB'),
(11, 'fzrferfc', '<p>erferf</p>', 'https://i.pinimg.com/originals/0e/d9/e2/0ed9e296f8e4a6fcc074dd5e488593ee.jpg', 1, 'fzrferf'),
(16, 'aaatyhfh', '<p>rtgrg</p>', 'https://i.pinimg.com/originals/0e/d9/e2/0ed9e296f8e4a6fcc074dd5e488593ee.jpg', 1, 'aaatyhfh');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` int(11) NOT NULL,
  `reset_link_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `exp_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `email`, `is_admin`, `reset_link_token`, `exp_date`) VALUES
(1, 'grtgrtgrtg', 'trgrtgrtgrtgrtg', 'contact@bingofoot.fr', 0, NULL, NULL),
(2, 'zedzdzedzedz', '$2y$10$TqFz7zILImNwJ7648cTxa.ztKA5QX/wXJ/Ol6xGNdohusK4kFn7BK', 'contac515t@bingofoot.fr', 0, NULL, NULL),
(3, 'erferf', '$2y$10$K5rQVwIwKogr.fz4BMdu3OHlSXrec5KtQv96oJABPCBIjdHBYKkUu', 'erferf@icloud.com', 0, NULL, NULL),
(4, 'christophe13012', '$2y$10$LAsEHiiQXebaVwpLfGYx5ePeG.VHpS2pCX6Z.lx//95EFZSac7shK', 'christophecaillet@icloud.com', 0, 'dd88effc6e20c8389b6991e2ca779e277765', '2021-01-14 17:02:09'),
(14, 'ergergerg', '$2y$10$T/85/apg5sZCL8Hb5n/huOq2JvAhrlqurjU03NxGdwhMH3mmSTSRO', 'contactvfdvdfvd@bingofoot.fr', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) DEFAULT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(12, 7, '<iframe width=\"1280\" height=\"817\" src=\"https://www.youtube.com/embed/f9FjhCt_w2U\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(13, 9, '<iframe width=\"286\" height=\"175\" src=\"https://www.youtube.com/embed/f9FjhCt_w2U\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>'),
(14, 9, '<iframe width=\"286\" height=\"175\" src=\"https://www.youtube.com/embed/f9FjhCt_w2U\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_9474526CA76ED395` (`user_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_14B78418B281BE2E` (`trick_id`);

--
-- Index pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E1D902C15E237E06` (`name`),
  ADD KEY `IDX_E1D902C112469DE2` (`category_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`);

--
-- Index pour la table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7CC7DA2CB281BE2E` (`trick_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pour la table `tricks`
--
ALTER TABLE `tricks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `photo`
--
ALTER TABLE `photo`
  ADD CONSTRAINT `FK_14B78418B281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C112469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
