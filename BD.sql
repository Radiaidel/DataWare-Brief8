-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 19 déc. 2023 à 20:16
-- Version du serveur : 10.4.28-MariaDB
-- Version de PHP : 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `dataware_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `answer`
--

CREATE TABLE `answer` (
  `answer_id` int(11) NOT NULL,
  `question_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `answer_text` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0,
  `is_solution` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `in_team`
--

CREATE TABLE `in_team` (
  `id_user_team` int(11) NOT NULL,
  `id_user` int(11) DEFAULT NULL,
  `Id_Team` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `in_team`
--

INSERT INTO `in_team` (`id_user_team`, `id_user`, `Id_Team`) VALUES
(61, 75, 16),
(62, 79, 16),
(64, 77, 8),
(65, 81, 8);

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

CREATE TABLE `project` (
  `Id_Project` int(11) NOT NULL,
  `project_name` varchar(50) DEFAULT NULL,
  `project_description` varchar(125) DEFAULT NULL,
  `project_status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deadline` date DEFAULT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`Id_Project`, `project_name`, `project_description`, `project_status`, `created_at`, `deadline`, `id_user`) VALUES
(25, 'Mobile App', 'Developing a mobile application', 'pending', '2023-12-07 08:22:51', '2024-01-15', 78);

-- --------------------------------------------------------

--
-- Structure de la table `question`
--

CREATE TABLE `question` (
  `question_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `Id_Project` int(11) DEFAULT NULL,
  `question_text` text NOT NULL,
  `likes` int(11) DEFAULT 0,
  `dislikes` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `archived` tinyint(1) DEFAULT 0,
  `title_question` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `question_tag`
--

CREATE TABLE `question_tag` (
  `id_question_tag` int(11) NOT NULL,
  `id_question` int(11) DEFAULT NULL,
  `id_tag` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `tags`
--

CREATE TABLE `tags` (
  `id_tag` int(11) NOT NULL,
  `tag_name` varchar(50) DEFAULT NULL,
  `category` varchar(55) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `tags`
--

INSERT INTO `tags` (`id_tag`, `tag_name`, `category`) VALUES
(7, 'JavaScript', 'Programming'),
(8, 'PHP', 'Programming'),
(9, 'HTML', 'Web Development'),
(10, 'CSS', 'Web Development'),
(11, 'MySQL', 'Database'),
(12, 'Programming', 'Programming');

-- --------------------------------------------------------

--
-- Structure de la table `team`
--

CREATE TABLE `team` (
  `Id_Team` int(11) NOT NULL,
  `team_name` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_user` int(11) NOT NULL,
  `Id_Project` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `team`
--

INSERT INTO `team` (`Id_Team`, `team_name`, `created_at`, `id_user`, `Id_Project`) VALUES
(8, 'Development Team 1', '2023-12-07 08:06:32', 78, 25),
(16, 'helloTeam', '2023-12-15 14:29:29', 78, 25);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass_word` varchar(100) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id_user`, `username`, `email`, `pass_word`, `role`, `status`, `image_url`) VALUES
(74, 'oumaima', 'oumaima@gmail.com', '$2y$10$ljxMUm1Yb7rZWY2aGx3F9OTXXMdsmVcBhJPIjC/ItxOgso/foi77W', 'po', 'active', 'upload/jane.jpg'),
(75, 'yassir', 'yassir@gmail.com', '$2y$10$O2xTEWnowOml2ZTbfD53QOfa4ZCqrgeMqvG/vNvywo0kUsWHGOIUW', 'user', 'active', 'upload/jane.jpg'),
(76, 'ahmed', 'ahmed@gmail.com', '$2y$10$nT5sh/h51aEv5K.V6K.kqO0k.aY6SDr8IJECsrwR5kJem6i88UHuq', 'user', 'active', 'upload/jane.jpg'),
(77, 'abderahman', 'abderahman@gmail.com', '$2y$10$iBVbVUdpW3OELQ8DO5pGZ./6P/7FcFQcod6pGY4zvrtYZO5fHNi6u', 'user', 'active', 'upload/jane.jpg'),
(78, 'sm', 'sm@gmail.com', '$2y$10$tYoCRXKQ.GGbIsIoDYzVf.IO.gH/05LwKUzCDt95rsiap59AbtGeS', 'sm', 'active', 'upload/jane.jpg'),
(79, 'er', 'fahedd@gmail.com', '$2y$10$rSqcfwuOHChAj/PB89MaOOeVzoDFBAZCV0Ns74iEH3fvYbkHiISwa', 'user', 'active', NULL),
(80, 'radia', 'radia@gmail.com', '$2y$10$SahHLwePhGEDl0BkNA1z.e7PI3quA9TAhIZBtJRzbKusMTYqBJw6m', 'user', 'active', NULL),
(81, 'ayoub88', 'ayoub@gmail.com', '$2y$10$6wV0hWqNrE/xHg/SUb7CuuVed4fal4OararLeB.wsU0fTWtEsNjV.', 'user', 'active', 'upload/mesh-267.png'),
(82, 'radiaaaaaaaa', 'radiaaaaaaaaa@gmail.com', '$2y$10$lEPolUZcJ..ru6SzPYlMsuJ5cJLb5BNcMN4uq5W1zo1ky935e5c3S', 'user', 'active', 'upload/zany-jadraque-YLdC7qO9M3g-unsplash.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `answer`
--
ALTER TABLE `answer`
  ADD PRIMARY KEY (`answer_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `question_id` (`question_id`);

--
-- Index pour la table `in_team`
--
ALTER TABLE `in_team`
  ADD PRIMARY KEY (`id_user_team`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `Id_Team` (`Id_Team`);

--
-- Index pour la table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`Id_Project`),
  ADD KEY `id_user` (`id_user`);

--
-- Index pour la table `question`
--
ALTER TABLE `question`
  ADD PRIMARY KEY (`question_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `Id_Project` (`Id_Project`);

--
-- Index pour la table `question_tag`
--
ALTER TABLE `question_tag`
  ADD PRIMARY KEY (`id_question_tag`),
  ADD KEY `id_question` (`id_question`),
  ADD KEY `id_tag` (`id_tag`);

--
-- Index pour la table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id_tag`);

--
-- Index pour la table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`Id_Team`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `Id_Project` (`Id_Project`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `project`
--
ALTER TABLE `project`
  MODIFY `Id_Project` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT pour la table `tags`
--
ALTER TABLE `tags`
  MODIFY `id_tag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `answer`
--
ALTER TABLE `answer`
  ADD CONSTRAINT `answer_ibfk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `answer_ibfk_2` FOREIGN KEY (`question_id`) REFERENCES `question` (`question_id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `in_team`
--
ALTER TABLE `in_team`
  ADD CONSTRAINT `in_team_ibf` FOREIGN KEY (`Id_Team`) REFERENCES `team` (`Id_Team`) ON DELETE CASCADE,
  ADD CONSTRAINT `in_team_ibfk1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Contraintes pour la table `question`
--
ALTER TABLE `question`
  ADD CONSTRAINT `question_ib` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_ibf` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Contraintes pour la table `question_tag`
--
ALTER TABLE `question_tag`
  ADD CONSTRAINT `question_tag` FOREIGN KEY (`id_question`) REFERENCES `question` (`question_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `question_tag_i` FOREIGN KEY (`id_tag`) REFERENCES `tags` (`id_tag`) ON DELETE CASCADE;

--
-- Contraintes pour la table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ib` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_ibf` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE,
  ADD CONSTRAINT `team_ibfk_2` FOREIGN KEY (`Id_Project`) REFERENCES `project` (`Id_Project`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
