-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : ven. 24 nov. 2023 à 20:35
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `site_communautaire_snowtricks`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(16, 'Grabs', 'grabs', '2023-10-26 12:24:42', NULL),
(17, 'Flips', 'flips', '2023-10-26 12:24:42', NULL),
(18, 'Slides', 'slides', '2023-10-26 12:24:42', NULL),
(19, 'Rotations', 'Rotations', '2023-11-09 00:50:17', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `trick_id`, `author_id`, `content`, `created_at`, `updated_at`) VALUES
(21, 104, 26, '1er commentaire', '2023-11-16 09:45:06', NULL),
(22, 104, 26, 'waaaaaaaaaaw', '2023-11-16 09:46:24', NULL),
(23, 104, 26, 'tesst commentaire', '2023-11-16 09:46:54', NULL),
(24, 104, 29, 'mon premier commentaire', '2023-11-17 11:58:47', NULL),
(25, 104, 26, 'commentaire', '2023-11-21 22:42:06', NULL),
(26, 99, 26, 'cooool', '2023-11-21 22:56:08', NULL),
(27, 99, 26, 'bien', '2023-11-21 22:56:18', NULL),
(28, 103, 26, 'commentaire', '2023-11-24 20:06:13', NULL),
(29, 104, 26, 'waaw', '2023-11-24 20:07:11', NULL),
(30, 104, 26, 'test commentaire', '2023-11-24 20:07:21', NULL),
(31, 104, 26, 'joli figure', '2023-11-24 20:07:32', NULL),
(32, 104, 26, 'cooool', '2023-11-24 20:07:43', NULL),
(33, 104, 26, 'waaaw', '2023-11-24 20:07:53', NULL),
(34, 104, 26, 'coool', '2023-11-24 20:07:59', NULL);

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
('DoctrineMigrations\\Version20231026092426', '2023-10-26 11:25:18', 487),
('DoctrineMigrations\\Version20231103142239', '2023-11-03 15:22:53', 57),
('DoctrineMigrations\\Version20231103173150', '2023-11-03 18:31:59', 86),
('DoctrineMigrations\\Version20231103174746', '2023-11-03 18:47:52', 18),
('DoctrineMigrations\\Version20231106113848', '2023-11-06 12:38:58', 149),
('DoctrineMigrations\\Version20231106125552', '2023-11-06 13:55:59', 123),
('DoctrineMigrations\\Version20231110141207', '2023-11-10 15:12:23', 109),
('DoctrineMigrations\\Version20231110160146', '2023-11-10 17:02:02', 194);

-- --------------------------------------------------------

--
-- Structure de la table `image_urls`
--

CREATE TABLE `image_urls` (
  `id` int(11) NOT NULL,
  `tricks_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image_urls`
--

INSERT INTO `image_urls` (`id`, `tricks_id`, `name`) VALUES
(95, 94, 'stalefish-2-6552e7b944ccd.jpg'),
(96, 95, 'slides-barre-6552e94641eeb.jpg'),
(97, 96, 'download-6552ea39b5e53.jpg'),
(98, 96, 'crippler-6475e0e35b25f343827844-6552ea39b57bc.jpg'),
(99, 97, 'download-6552eb8287765.jpg'),
(100, 97, '1-6552eb8286ec2.jpg'),
(101, 98, 'rodeo-1-6552ec35a5fc9.jpg'),
(102, 99, 'frontflip-2-6552ecd8c2bc6.jpg'),
(103, 99, 'frontflip-1-6552ecd8c1c10.jpg'),
(104, 100, 'cork-1-6552fa88a35d4.jpg'),
(105, 101, 'download-6552fbbd8c510.jpg'),
(106, 101, '1-6552fbbd8ba16.jpg'),
(107, 102, 'download-6552fd7662232.jpg'),
(108, 103, 'download-6552feed084f4.jpg'),
(109, 103, '2-6552feed07a26.jpg'),
(110, 104, 'download-6553004a2f90b.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

CREATE TABLE `messenger_messages` (
  `id` bigint(20) NOT NULL,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `picture_trick`
--

CREATE TABLE `picture_trick` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `picture_trick`
--

INSERT INTO `picture_trick` (`id`, `name`) VALUES
(3, 'rotations-horizontales-654e7a17619b3.jpg'),
(4, 'rotations-horizontales-654e7a48bba32.jpg'),
(5, 'rotations-horizontales-654e7a8b95fe4.jpg'),
(6, 'rotations-horizontales-654e7bdfba1f3.jpg'),
(7, 'Les-rotations8360-654e7e201b46b.jpg'),
(8, 'Les-rotations-654e806b78abc.jpg'),
(9, 'Les-rotations-654e80f970801.jpg'),
(10, 'Les-rotations-654e8149cc63a.jpg'),
(11, 'Les-rotations8360-654e8e246b3ca.jpg'),
(12, 'rotations-horizontales-654e8f669af36.jpg'),
(13, 'rotations-horizontales-654e97ea5f11f.jpg'),
(14, 'Les-rotations8360-654e986074cf2.jpg'),
(15, 'Les-rotations8360-654e9a752c37e.jpg'),
(16, 'rotations-horizontales-654e9af48e528.jpg'),
(17, 'Les-rotations8360-654e9baac0914.jpg'),
(19, 'stalefish-6552e7b94554a.jpg'),
(20, 'barre-de-slide-6552e9464252d.jpg'),
(21, 'crippler-6475e0e35b25f343827844-6552ea39b6379.jpg'),
(22, '3-6552eb8287cf5.jpg'),
(23, 'rodeo-6552ec35a6ac2.jpg'),
(24, 'frontflip-6552ecd8c347e.jpg'),
(25, 'cork-6552fa88a3e34.jpg'),
(26, 'tailslide-6552fbbd8ca89.jpg'),
(27, '1-6552fd76628ed.jpg'),
(28, '1-6552feed08b7e.jpg'),
(29, 'japan-air-6474724878483531579467-6553004a3096f.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `tricks`
--

CREATE TABLE `tricks` (
  `id` int(11) NOT NULL,
  `categories_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discription` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `updated_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  `picture_trick_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `tricks`
--

INSERT INTO `tricks` (`id`, `categories_id`, `name`, `slug`, `discription`, `created_at`, `updated_at`, `picture_trick_id`) VALUES
(94, 16, 'stalefish', 'stalefish', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. Proin eleifend lacus sit amet bibendum imperdiet. Fusce a iaculis ex, eu euismod ni', '2023-11-14 04:21:27', NULL, 19),
(95, 18, 'Boardslide', 'Boardslide', 'La barre de slide est une structure métallique en forme de rampe d\'escalier. Le module complet comporte une piste d\'élan, un kick (bosse servant de tremplin) placé devant la barre, la barre elle-même ou rail et une pente de réception.\r\n\r\nSi dans les snowp', '2023-11-14 04:28:06', NULL, 20),
(96, 17, 'CRIPPLER', 'CRIPPLER', 'Un flip est une rotation verticale. On distingue les front flips, rotations en avant, et les back flips, rotations en arrière.\r\n\r\nIl est possible de faire plusieurs flips à la suite, et d\'ajouter un grab à la rotation.\r\n\r\nLes flips agrémentés d\'une vrille', '2023-11-14 04:32:09', NULL, 21),
(97, 19, 'ROTATION', 'ROTATION', 'Une rotation peut être frontside ou backside : une rotation frontside correspond à une rotation orientée vers la carre backside. Cela peut paraître incohérent mais l\'origine étant que dans un halfpipe ou une rampe de skateboard, une rotation frontside se ', '2023-11-14 04:37:38', NULL, 22),
(98, 19, 'RODEO', 'RODEO', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. Proin eleifend lacus sit amet bibendum imperdiet. Fusce a iaculis ex, eu euismod ni', '2023-11-14 04:40:37', NULL, 23),
(99, 17, 'FRONTFLIP', 'FRONTFLIP', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. Proin eleifend lacus sit amet bibendum imperdiet. Fusce a iaculis ex, eu euismod ni', '2023-11-14 04:43:20', NULL, 24),
(100, 19, 'CORK', 'CORK', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. Proin eleifend lacus sit amet bibendum imperdiet. Fusce a iaculis ex, eu euismod ni', '2023-11-14 05:41:44', NULL, 25),
(101, 18, 'TAIL SLIDE', 'TAIL-SLIDE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. Proin eleifend lacus sit amet bibendum imperdiet. Fusce a iaculis ex, eu euismod ni', '2023-11-14 05:46:53', NULL, 26),
(102, 16, 'Les grabs', 'Les-grabs', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »\r\n\r\nIl existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l\'effectuer, avec des difficultés variables :', '2023-11-14 05:54:14', NULL, 27),
(103, 19, 'La Manière De Rider', 'La-Maniere-De-Rider', 'Tout d\'abord, il faut savoir qu\'il y a deux positions sur sa planche: regular ou goofy. Un rider regular aura son pied gauche devant et un rider goofy aura son pied droit devant. Après un certain moment, les planchistes sont capables de descendre dans les', '2023-11-14 06:00:28', NULL, 28),
(104, 16, 'JAPAN AIR', 'JAPAN-AIR', 'Un grab consiste à attraper la planche avec la main pendant le saut. Le verbe anglais to grab signifie « attraper. »\r\n\r\nIl existe plusieurs types de grabs selon la position de la saisie et la main choisie pour l\'effectuer, avec des difficultés variables :', '2023-11-14 06:06:18', NULL, 29);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '(DC2Type:json)' CHECK (json_valid(`roles`)),
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp() COMMENT '(DC2Type:datetime_immutable)',
  `is_verified` tinyint(1) NOT NULL,
  `reset_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `email`, `roles`, `password`, `name`, `created_at`, `is_verified`, `reset_token`, `avatar`) VALUES
(26, 'khaoulabha1991@gmail.com', '[]', '$2y$13$Feb4nSBiqxAbkKCimvXoM.mZJn/YruKwl00yuiNRklknLJJnr6jHO', 'ammar khaoula', '2023-10-27 17:25:09', 1, '_JugUu5J0WrGf8kYh4hCjBmz6WSr6dubi6crcstjfh8', '9da10ef8610d79b44c50116b3bb112da-6545390a8b815.jpg'),
(27, 'iyed@gmail.com', '[]', '$2y$13$tIBiMhBsmQhnmaJHwgFYWeKvamvmtpY65oHxbEmAoAG.p46kfVlou', 'bha iyed', '2023-10-27 21:25:39', 0, NULL, NULL),
(28, 'ilyes@gmail.com', '[]', '$2y$13$Fh5F/2ZgRKawpW36O4qqWuZM935LVaMeRMVyVMl.kX6iGLVMyQkMy', 'ilyes', '2023-11-11 11:10:53', 0, NULL, NULL),
(29, 'omar@hotmail.fr', '[]', '$2y$13$ixM3kwMG/V8CGUefbii97uVh79pE62yvzPAsQxmQqTQCvyJttLCJ.', 'omar', '2023-11-16 18:22:52', 0, NULL, NULL),
(30, 'omar160590@hotmail.fr', '[]', '$2y$13$R6tdie.Yr1CT4D1xqNuIh.ZAnjd9lvn0emZ5WbXWhwufVde2D.JXe', 'omar1', '2023-11-16 19:40:27', 1, '', NULL),
(31, 'khaoula1@gmail.com', '[]', '$2y$13$y8YZ4RT0reftIEQYvx3nHuksTZpAZoEQmZHAZPfYDe6vD6iGw51tu', 'khaoula1', '2023-11-24 19:56:22', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `video_urls`
--

CREATE TABLE `video_urls` (
  `id` int(11) NOT NULL,
  `tricks_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video_urls`
--

INSERT INTO `video_urls` (`id`, `tricks_id`, `name`) VALUES
(52, 94, 'https://youtu.be/xXCCGYqAWqI?si=QKJdIdFtUlEGB2yQ'),
(53, 94, 'https://youtu.be/f9FjhCt_w2U?si=NG5-jTogLAPApq_e'),
(54, 95, 'https://youtu.be/FKKc4Bx4OY8?si=DNt5ME-kaN3eF-DO'),
(55, 96, 'https://youtu.be/tjMo7FfW2WE?si=uyipV4yVXcJZnF2R'),
(56, 97, 'https://youtu.be/bDJZfmYMuP8?si=BsRFSP6CdwYCGVWn'),
(57, 97, 'https://youtu.be/spZPdWCSkLk?si=u3a3i6DXtkfzXOk2'),
(58, 98, 'https://youtu.be/QX6yvs6uTVg?si=bgSsRmuIsGmo5jIo'),
(59, 99, 'https://youtu.be/mBB7CznvSPQ?si=VkF9I4iUJn8jvYF2'),
(60, 99, 'https://youtu.be/g0L0LnF3JiY?si=MlB4qMOYYLmNqwvW'),
(61, 100, 'https://youtu.be/_3C02T-4Uug?si=VPZzRZs5lA3Hoc6M'),
(62, 101, 'https://youtu.be/lunYxCQrs1E?si=IYWOOTGLeeWYsXbu'),
(63, 102, 'https://youtu.be/lunYxCQrs1E?si=hUw0aTIaEKdKISJB'),
(64, 103, 'https://youtu.be/U0hRnXY3fbk?si=Fg1Atkg1LXJm2gJt'),
(65, 104, 'https://youtu.be/I7N45iRPrhw?si=Q6-G3ZWtjIXim2AI');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_5F9E962AB281BE2E` (`trick_id`),
  ADD KEY `IDX_5F9E962AF675F31B` (`author_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `image_urls`
--
ALTER TABLE `image_urls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_D8AEDD3F3B153154` (`tricks_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `picture_trick`
--
ALTER TABLE `picture_trick`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E1D902C15E237E06` (`name`),
  ADD UNIQUE KEY `UNIQ_E1D902C1DA412B22` (`picture_trick_id`),
  ADD KEY `IDX_E1D902C1A21214B7` (`categories_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  ADD UNIQUE KEY `UNIQ_1483A5E95E237E06` (`name`);

--
-- Index pour la table `video_urls`
--
ALTER TABLE `video_urls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_2D036A7D3B153154` (`tricks_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `image_urls`
--
ALTER TABLE `image_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `picture_trick`
--
ALTER TABLE `picture_trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pour la table `tricks`
--
ALTER TABLE `tricks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `video_urls`
--
ALTER TABLE `video_urls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `FK_5F9E962AB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `tricks` (`id`),
  ADD CONSTRAINT `FK_5F9E962AF675F31B` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `image_urls`
--
ALTER TABLE `image_urls`
  ADD CONSTRAINT `FK_D8AEDD3F3B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`);

--
-- Contraintes pour la table `tricks`
--
ALTER TABLE `tricks`
  ADD CONSTRAINT `FK_E1D902C1A21214B7` FOREIGN KEY (`categories_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_E1D902C1DA412B22` FOREIGN KEY (`picture_trick_id`) REFERENCES `picture_trick` (`id`);

--
-- Contraintes pour la table `video_urls`
--
ALTER TABLE `video_urls`
  ADD CONSTRAINT `FK_2D036A7D3B153154` FOREIGN KEY (`tricks_id`) REFERENCES `tricks` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
