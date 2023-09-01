-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:8889
-- Généré le : ven. 01 sep. 2023 à 15:50
-- Version du serveur : 5.7.39
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `snowtricks`
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
(9, 'La manière de rider'),
(10, 'Les grabs'),
(11, 'Les rotations'),
(12, 'Les flips'),
(13, 'Les rotations désaxées'),
(14, 'Les slides'),
(15, 'Les one foot tricks'),
(16, 'Old school');

-- --------------------------------------------------------

--
-- Structure de la table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `update_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comment`
--

INSERT INTO `comment` (`id`, `trick_id`, `author_id`, `content`, `created_at`, `update_at`) VALUES
(26, 19, 2, 'Bonjour, super trick !', '2023-08-18 08:17:28', '2023-08-18 08:17:28'),
(28, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:31', '2023-08-18 09:50:31'),
(29, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:33', '2023-08-18 09:50:33'),
(30, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:37', '2023-08-18 09:50:37'),
(31, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:41', '2023-08-18 09:50:41'),
(32, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:44', '2023-08-18 09:50:44'),
(33, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:46', '2023-08-18 09:50:46'),
(34, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:51', '2023-08-18 09:50:51'),
(35, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:53', '2023-08-18 09:50:53'),
(36, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:56', '2023-08-18 09:50:56'),
(37, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:50:59', '2023-08-18 09:50:59'),
(38, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:51:01', '2023-08-18 09:51:01'),
(39, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:51:04', '2023-08-18 09:51:04'),
(40, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:51:07', '2023-08-18 09:51:07'),
(41, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:51:10', '2023-08-18 09:51:10'),
(42, 19, 2, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus est diam, tincidunt ac lorem sed, vehicula lobortis ligula. Nullam id scelerisque magna, et cursus arcu. ', '2023-08-18 09:51:13', '2023-08-18 09:51:13'),
(44, 19, 10, 'Test', '2023-08-18 09:57:05', '2023-08-18 09:57:05'),
(45, 17, 2, 'Ce trick est vraiment génial ! Vous devez l\'essayer !', '2023-08-30 15:34:34', '2023-08-30 15:34:34'),
(47, 25, 13, 'Test', '2023-09-01 10:19:24', '2023-09-01 10:19:24');

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
('DoctrineMigrations\\Version20230723101831', '2023-07-23 10:18:41', 49),
('DoctrineMigrations\\Version20230723101955', '2023-07-23 10:19:58', 24),
('DoctrineMigrations\\Version20230723103136', '2023-07-23 10:31:41', 33),
('DoctrineMigrations\\Version20230729102808', '2023-07-29 10:28:14', 25),
('DoctrineMigrations\\Version20230729103849', '2023-07-29 10:39:53', 56),
('DoctrineMigrations\\Version20230729104635', '2023-07-29 10:47:41', 37),
('DoctrineMigrations\\Version20230729104938', '2023-07-29 10:49:44', 40),
('DoctrineMigrations\\Version20230806104838', '2023-08-06 10:49:15', 62);

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `image`
--

INSERT INTO `image` (`id`, `trick_id`, `name`, `alt`) VALUES
(22, 17, '64ef5f6931734_50_50_2.png', ''),
(23, 17, '64ef5f6931d3d_50_50_1.jpg', ''),
(24, 19, '64ef602985ff7_double_back_flip3.jpg', 'Double back flip image 3'),
(25, 19, '64ef602986100_double_back_flip1.jpg', 'Double back flip image 1'),
(26, 16, '64ef612fe3474_frontsite360_2.jpg', 'Frontsite 360 image 2'),
(27, 20, '64ef624f1a877_frontside_boardslide2.jpg', 'Frontsite boardslide image 2'),
(28, 21, '64ef62e363282_backside_air1.jpg', 'Backside Air image 1'),
(29, 22, '64ef635d66415_japan_air2.jpg', 'Japan air image 2'),
(30, 23, '64ef63f65fb70_method_air2.jpg', 'Method Ai image 2'),
(31, 23, '64ef63f65fca2_method_air3.jpg', 'Method Ai image 3'),
(32, 24, '64ef6524082c3_ezgif_com_webp_to_jpg.jpg', 'Front bluntslide 270 image 2'),
(33, 25, '64f19c76f0fbe_japan_air2.jpg', 'Un texte alt'),
(34, 25, '64f19c76f10db_backside_air1.jpg', 'Un texte alt 2');

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
-- Structure de la table `trick`
--

CREATE TABLE `trick` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `introtext` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `update_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `main_picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `trick`
--

INSERT INTO `trick` (`id`, `category_id`, `author_id`, `state`, `title`, `slug`, `introtext`, `content`, `update_at`, `created_at`, `main_picture`) VALUES
(16, 11, 2, 1, 'Frontsite 360', 'frontsite-360', 'Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style.', 'C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…', '2023-08-30 15:33:03', '2023-08-05 13:10:41', '64ef612fe3349_frontsite360_1.jpg'),
(17, 14, 2, 1, 'Le 50/50', 'le-50-50', 'Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis erat eros, in eleifend lorem bibendum in. Vivamus sit amet cursus sem. Quisque mollis ante sed metus placerat commodo. Praesent odio nisi, commodo sed accumsan eget, feugiat ac urna. Mauris faucibus semper nibh, sit amet sodales purus suscipit id. Etiam mattis sem orci, eu sodales enim mattis at. Vivamus vel elit erat. Vestibulum egestas in leo id venenatis. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc lacinia eros eu odio aliquet, sed egestas lacus pellentesque. Curabitur placerat congue enim, a malesuada ante posuere vel. Mauris tincidunt at risus non varius. Vestibulum nec tellus in elit vulputate suscipit a ac nisi. Cras at risus justo. Phasellus feugiat ligula eu congue cursus.', '2023-08-30 15:34:04', '2023-08-05 13:18:20', '64ef616c9b80d_50_50_2.png'),
(19, 12, 2, 1, 'Double back flip', 'double-back-flip', 'Le backflip figure parmi les sauts les plus spectaculaires de cette discipline.', 'Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes.', '2023-08-30 15:33:19', '2023-08-18 08:13:55', '64ef602985e8d_double_back_flip2.jpg'),
(20, 14, 2, 1, 'Frontsite boardslide', 'frontsite-boardslide', 'Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50.', 'En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks. Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.', '2023-08-30 15:37:51', '2023-08-30 15:37:51', '64ef624f1a70f_frontside_boardslide1.jpg'),
(21, 10, 2, 1, 'Backside Air', 'backside-air', 'Mais pourquoi le Backside air est-il si emblématique en réalité ?', 'C\'est vrai, il existe des figures bien plus complexes dans le snowboard moderne, ainsi que d\'autres avec des noms plus divertissants. Cependant, il faut se rappeler que le backside air est le seul mouvement impossible à réaliser en ski, ce qui en soi le rend spécial. De plus, il s\'avère être la figure qui reflète le mieux la personnalité du rider, car il existe une multitude de façons de l\'exécuter, offrant ainsi un large espace d\'expression. En dépit de sa simplicité apparente, il possède une certaine technicité. Pour bien saisir l\'air, il faut propulser le torse vers l\'avant au moment du saut, et avoir un réel engagement en suspension pour réussir un bon grab. Voilà donc trois raisons essentielles expliquant le succès durable du backside air, transcendant les générations et les adeptes de cette discipline.', '2023-08-30 15:40:19', '2023-08-30 15:40:19', '64ef62e36312c_backside_air2.jpg'),
(22, 10, 2, 1, 'Japan air', 'japan-air', 'Saisir la partie avant de la planche en utilisant la main avant, du côté de la carre frontside.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed iaculis erat eros, in eleifend lorem bibendum in. Vivamus sit amet cursus sem. Quisque mollis ante sed metus placerat commodo. Praesent odio nisi, commodo sed accumsan eget, feugiat ac urna. Mauris faucibus semper nibh, sit amet sodales purus suscipit id. Etiam mattis sem orci, eu sodales enim mattis at. Vivamus vel elit erat.', '2023-08-30 15:42:21', '2023-08-30 15:42:21', '64ef635d66265_japan_air1.jpg'),
(23, 15, 2, 1, 'Method Ai', 'method-ai', 'Cette figure, qui implique la saisie de la planche d\'une main et sa rotation perpendiculaire au sol, demeure un classique \"old school\". Pourtant, son attrait reste intemporel, comptant parmi ses véritables ambassadeurs des noms tels que Jamie Lynn et la star Terje Haakonsen.', 'En 2007, Terje Haakonsen a propulsé cette figure au sommet en réalisant un exploit impressionnant. Il a réussi à établir un nouveau record du monde pour le \"air\" le plus élevé en s\'élevant à une hauteur vertigineuse de 9,8 mètres au-dessus du kick, le point culminant d\'un mur de rampe ou d\'une autre structure de saut. Cette performance exceptionnelle a non seulement renforcé le statut emblématique de cette figure, mais elle a également mis en lumière les possibilités infinies de créativité et d\'audace dans le monde du snowboard. Terje Haakonsen est devenu un exemple vivant de la puissance et de la beauté du backside air, inspirant les riders du monde entier à repousser leurs limites et à explorer de nouvelles hauteurs dans les airs.', '2023-08-30 15:44:54', '2023-08-30 15:44:54', '64ef63f65fa47_method_air1.jpg'),
(24, 14, 2, 1, 'Front bluntslide 270', 'front-bluntslide-270', 'Parmi les mouvements captivants du snowboard, on retrouve un slide très distinctif.', 'Celui-ci exige un geste particulier : faire passer le pied avant au-dessus du rail dès l\'approche, tout en positionnant la planche perpendiculairement à celui-ci. Ensuite, l\'objectif est d\'accomplir une rotation de trois quarts de tour sur le rail lui-même.\r\n\r\nImaginez-vous glissant sur une surface étroite et rigide, une planche de snowboard sous vos pieds. Lorsque vous approchez du rail, la complexité commence. Vous devez déplacer habilement votre pied avant au-dessus du rail tout en maintenant la planche dans une position perpendiculaire par rapport à celui-ci. Cette combinaison de mouvements nécessite une coordination précise et un équilibre parfait, car le rail est souvent étroit et exige une attention constante pour éviter de perdre le contrôle.\r\n\r\nUne fois que vous avez réussi cette transition délicate et que vous êtes positionné(e) de manière stable sur le rail, il est temps de réaliser une rotation. L\'objectif est de faire tourner votre corps et la planche de trois quarts de tour tout en glissant le long du rail. Cette rotation ajoute une touche de style et de créativité à votre descente, tout en demandant une maîtrise totale de votre équilibre et de votre mouvement.\r\n\r\nEn somme, ce slide représente un mélange de précision, de contrôle et d\'audace. Il incarne l\'esprit aventureux du snowboard, poussant les riders à relever des défis techniques tout en offrant une opportunité de personnaliser leur style de glisse.', '2023-08-30 15:50:18', '2023-08-30 15:49:56', '64ef652408100_front_bluntslide_270_1.jpg'),
(25, 11, 13, 1, 'Test opc, un super trick !', 'test-opc-un-super-trick', 'Un texte intro', 'Contenu', '2023-09-01 14:18:22', '2023-09-01 10:10:30', '64f19c76f0c45_method_air3.jpg'),
(29, 9, 2, 1, 'test', 'test', 'aaa', 'aaa', '2023-09-01 14:24:48', '2023-09-01 14:13:38', 'snowtricks_header.jpeg');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `token_validation` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token_expiration` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `username`, `roles`, `password`, `name`, `created_at`, `validate`, `token_validation`, `token_expiration`, `avatar`, `email`) VALUES
(2, 'steven', '[]', '$2y$13$Y9kcs3VvyFT1g0L49llUpe5dnk0mgdH8NIEjQHI.j8olhqyIJFCFi', 'Steven Oyer', '2023-07-29 12:59:58', 1, NULL, NULL, '64c7d5d8bbbd9_stevenoyer.png', 'steven@oyer.fr'),
(10, 'stevenoyer', '[]', '$2y$13$ZLcZl73Pnw82/FlsuqE5qez/mOZ3cQEYTubAG9s8O3ntV1ryunjai', 'Steven Oyer', '2023-08-18 11:53:50', 1, NULL, NULL, '64df4061becd3_Sequence_Reinitialisation_du_mot_de_passe_drawio.png', 'contact.stevenoyer@gmail.com'),
(13, 'opc', '[]', '$2y$13$p21nFD4PJvkQmCzzH1teHeDrI8Q14VW8ZvwpbK0tm.ebA9tNVcCCW', 'Openclassrooms', '2023-09-01 10:07:44', 1, 'db8f9eab5eca5708945ef1d8e72b4765a98e1bfb', '1693570244', '64f19c1ea3fca_opc_logo.jpg', 'steven@systrio.fr');

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE `video` (
  `id` int(11) NOT NULL,
  `trick_id` int(11) NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `video`
--

INSERT INTO `video` (`id`, `trick_id`, `url`) VALUES
(17, 19, ''),
(18, 19, ''),
(19, 17, 'https://www.youtube.com/embed/kxZbQGjSg4w'),
(20, 19, 'https://www.youtube.com/embed/ZlNmeM1XdM4'),
(21, 17, ''),
(22, 16, 'https://www.youtube.com/embed/9T5AWWDxYM4'),
(23, 16, 'https://www.youtube.com/embed/SLncsNaU6es'),
(24, 19, ''),
(25, 17, ''),
(26, 17, ''),
(27, 20, 'https://www.youtube.com/embed/12OHPNTeoRs'),
(28, 21, 'https://www.youtube.com/embed/_CN_yyEn78M'),
(29, 22, 'https://www.youtube.com/embed/CzDjM7h_Fwo'),
(30, 23, 'https://www.youtube.com/embed/_hxLS2ErMiY'),
(31, 24, 'https://www.youtube.com/embed/O5DpwZjCsgA'),
(32, 24, ''),
(33, 25, 'https://www.youtube.com/embed/K9bjy5BczTY'),
(34, 25, ''),
(37, 25, ''),
(40, 29, ''),
(41, 25, ''),
(42, 29, ''),
(43, 29, ''),
(45, 29, '');

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
  ADD KEY `IDX_9474526CB281BE2E` (`trick_id`),
  ADD KEY `IDX_9474526CF675F31B` (`author_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_C53D045FB281BE2E` (`trick_id`);

--
-- Index pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  ADD KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  ADD KEY `IDX_75EA56E016BA31DB` (`delivered_at`);

--
-- Index pour la table `trick`
--
ALTER TABLE `trick`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E2B36786B` (`title`),
  ADD UNIQUE KEY `UNIQ_D8F0A91E989D9B62` (`slug`),
  ADD KEY `IDX_D8F0A91E12469DE2` (`category_id`),
  ADD KEY `IDX_D8F0A91EF675F31B` (`author_id`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `messenger_messages`
--
ALTER TABLE `messenger_messages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `trick`
--
ALTER TABLE `trick`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pour la table `video`
--
ALTER TABLE `video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FK_9474526CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`),
  ADD CONSTRAINT `FK_9474526CF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `FK_C53D045FB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `trick`
--
ALTER TABLE `trick`
  ADD CONSTRAINT `FK_D8F0A91E12469DE2` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`),
  ADD CONSTRAINT `FK_D8F0A91EF675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `FK_7CC7DA2CB281BE2E` FOREIGN KEY (`trick_id`) REFERENCES `trick` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
