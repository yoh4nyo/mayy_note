-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 10 juin 2024 à 17:35
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
-- Base de données : `mayynote`
--

-- --------------------------------------------------------

--
-- Structure de la table `demi_groupe`
--

CREATE TABLE `demi_groupe` (
  `Numero_dGrp` int(11) NOT NULL,
  `Nom_dGrp` varchar(40) DEFAULT NULL,
  `Numero_Grp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demi_groupe`
--

INSERT INTO `demi_groupe` (`Numero_dGrp`, `Nom_dGrp`, `Numero_Grp`) VALUES
(1, 'TPA', 1),
(2, 'TPB', 1),
(3, 'TPC', 2),
(4, 'TPD', 2),
(5, 'TPE', 3),
(6, 'TPF', 3);

-- --------------------------------------------------------

--
-- Structure de la table `enseignants`
--

CREATE TABLE `enseignants` (
  `Numero_Ens` int(11) NOT NULL,
  `Prenom_Ens` varchar(20) DEFAULT NULL,
  `Nom_Ens` varchar(20) DEFAULT NULL,
  `Identifiant_Ens` varchar(30) DEFAULT NULL,
  `Mdp_Ens` varchar(30) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `enseignants`
--

INSERT INTO `enseignants` (`Numero_Ens`, `Prenom_Ens`, `Nom_Ens`, `Identifiant_Ens`, `Mdp_Ens`, `role`) VALUES
(1, 'Cherifa', 'Boucetta', 'cherifa.boucetta', 'admin', 'administrateur'),
(2, 'Reda', 'Laroussi', 'reda.laroussi', 'enseignant', 'enseignant'),
(3, 'Nadia', 'Al-salti', 'nadia.al-salti', 'enseignant', 'enseignant'),
(4, 'Cherifa', 'Boucetta', 'cherifa.boucetta', 'enseignant', 'enseignant');

-- --------------------------------------------------------

--
-- Structure de la table `etudiants`
--

CREATE TABLE `etudiants` (
  `Numero_Etu` int(11) NOT NULL,
  `Prenom_Etu` varchar(20) DEFAULT NULL,
  `Nom_Etu` varchar(20) DEFAULT NULL,
  `Identifiant_Etu` varchar(40) DEFAULT NULL,
  `Mdp_Etu` varchar(30) DEFAULT NULL,
  `Cursus` varchar(20) DEFAULT NULL,
  `Annee` int(11) DEFAULT NULL,
  `Numero_Grp` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `etudiants`
--

INSERT INTO `etudiants` (`Numero_Etu`, `Prenom_Etu`, `Nom_Etu`, `Identifiant_Etu`, `Mdp_Etu`, `Cursus`, `Annee`, `Numero_Grp`) VALUES
(1, 'Yannis', 'Camelin', 'yannis.camelin', 'azerty', 'mmi', 1, 3),
(2, 'Mathias', 'Rakotomavo', 'mathias.rakotomavo', 'azerty', 'mmi', 1, 3),
(3, 'Alexandre', 'Lopere', 'alexandre.lopere', 'azerty', 'mmi', 1, 3),
(4, 'Yohan', 'Som', 'yohan.som', 'azerty', 'mmi', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE `groupe` (
  `Numero_Grp` int(11) NOT NULL,
  `Nom_Grp` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `groupe`
--

INSERT INTO `groupe` (`Numero_Grp`, `Nom_Grp`) VALUES
(1, 'TD1'),
(2, 'TD2'),
(3, 'TD3');

-- --------------------------------------------------------

--
-- Structure de la table `notation`
--

CREATE TABLE `notation` (
  `Type_Note` varchar(40) DEFAULT NULL,
  `Note` int(11) DEFAULT NULL,
  `Coefficient_Note` int(11) DEFAULT NULL,
  `Date` date DEFAULT NULL,
  `Numero_Etu` int(11) DEFAULT NULL,
  `Numero_Res` int(11) DEFAULT NULL,
  `Numero_Ens` int(11) DEFAULT NULL,
  `Numero_Grp` int(11) DEFAULT NULL,
  `id_note` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `notation`
--

INSERT INTO `notation` (`Type_Note`, `Note`, `Coefficient_Note`, `Date`, `Numero_Etu`, `Numero_Res`, `Numero_Ens`, `Numero_Grp`, `id_note`) VALUES
('SAE', 15, 2, '2024-05-05', 1, 101, 1, 3, 1),
('SAE', 15, 2, '2024-05-05', 2, 101, 1, 3, 2),
('SAE', 15, 2, '2024-05-05', 3, 101, 1, 3, 3),
('SAE', 15, 2, '2024-05-05', 4, 101, 1, 3, 4),
('SAE', 15, 2, '2024-05-05', 1, 102, 1, 3, 5),
('SAE', 15, 2, '2024-05-05', 2, 102, 1, 3, 6),
('SAE', 15, 2, '2024-05-05', 3, 102, 1, 3, 7),
('SAE', 15, 2, '2024-05-05', 4, 102, 1, 3, 8),
('Oral', 15, 2, '2024-05-05', 1, 103, 1, 3, 9);

-- --------------------------------------------------------

--
-- Structure de la table `ressources`
--

CREATE TABLE `ressources` (
  `Numero_Res` int(11) NOT NULL,
  `Nom_Res` varchar(30) DEFAULT NULL,
  `Coefficient_Res` int(11) DEFAULT NULL,
  `Numero_UE` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ressources`
--

INSERT INTO `ressources` (`Numero_Res`, `Nom_Res`, `Coefficient_Res`, `Numero_UE`) VALUES
(101, 'Anglais', 1, 2),
(102, 'Anglais renforcé', 1, 2),
(103, 'Ergonomie', 1, 1),
(104, 'Culture Numérique', 1, 1),
(201, 'Anglais', 1, 2),
(202, 'Anglais renforcé', 1, 2),
(203, 'Ergonomie', 1, 1),
(203, 'Ergonomie', 1, 3);

-- --------------------------------------------------------

--
-- Structure de la table `ressources_prof`
--

CREATE TABLE `ressources_prof` (
  `Numero_Res` int(11) NOT NULL,
  `Numero_Ens` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Structure de la table `ue`
--

CREATE TABLE `ue` (
  `Numero_UE` int(11) NOT NULL,
  `Nom_UE` varchar(20) DEFAULT NULL,
  `Coefficient_UE` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ue`
--

INSERT INTO `ue` (`Numero_UE`, `Nom_UE`, `Coefficient_UE`) VALUES
(1, 'Comprendre', 10),
(2, 'Concevoir', 10),
(3, 'Exprimer', 10),
(4, 'Developper', 10),
(5, 'Entreprendre', 10);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `demi_groupe`
--
ALTER TABLE `demi_groupe`
  ADD PRIMARY KEY (`Numero_dGrp`),
  ADD KEY `Numero_Grp` (`Numero_Grp`);

--
-- Index pour la table `enseignants`
--
ALTER TABLE `enseignants`
  ADD PRIMARY KEY (`Numero_Ens`);

--
-- Index pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD PRIMARY KEY (`Numero_Etu`),
  ADD KEY `Numero_Grp` (`Numero_Grp`);

--
-- Index pour la table `groupe`
--
ALTER TABLE `groupe`
  ADD PRIMARY KEY (`Numero_Grp`);

--
-- Index pour la table `notation`
--
ALTER TABLE `notation`
  ADD PRIMARY KEY (`id_note`),
  ADD KEY `Numero_Etu` (`Numero_Etu`),
  ADD KEY `Numero_Res` (`Numero_Res`),
  ADD KEY `Numero_Ens` (`Numero_Ens`),
  ADD KEY `Numero_Grp` (`Numero_Grp`);

--
-- Index pour la table `ressources`
--
ALTER TABLE `ressources`
  ADD PRIMARY KEY (`Numero_Res`,`Numero_UE`),
  ADD KEY `Numero_UE` (`Numero_UE`);

--
-- Index pour la table `ressources_prof`
--
ALTER TABLE `ressources_prof`
  ADD PRIMARY KEY (`Numero_Ens`,`Numero_Res`),
  ADD KEY `Numero_Res` (`Numero_Res`);

--
-- Index pour la table `ue`
--
ALTER TABLE `ue`
  ADD PRIMARY KEY (`Numero_UE`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `notation`
--
ALTER TABLE `notation`
  MODIFY `id_note` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `demi_groupe`
--
ALTER TABLE `demi_groupe`
  ADD CONSTRAINT `demi_groupe_ibfk_1` FOREIGN KEY (`Numero_Grp`) REFERENCES `groupe` (`Numero_Grp`);

--
-- Contraintes pour la table `etudiants`
--
ALTER TABLE `etudiants`
  ADD CONSTRAINT `etudiants_ibfk_1` FOREIGN KEY (`Numero_Grp`) REFERENCES `groupe` (`Numero_Grp`);

--
-- Contraintes pour la table `notation`
--
ALTER TABLE `notation`
  ADD CONSTRAINT `notation_ibfk_1` FOREIGN KEY (`Numero_Etu`) REFERENCES `etudiants` (`Numero_Etu`),
  ADD CONSTRAINT `notation_ibfk_2` FOREIGN KEY (`Numero_Res`) REFERENCES `ressources` (`Numero_Res`),
  ADD CONSTRAINT `notation_ibfk_3` FOREIGN KEY (`Numero_Ens`) REFERENCES `enseignants` (`Numero_Ens`),
  ADD CONSTRAINT `notation_ibfk_4` FOREIGN KEY (`Numero_Grp`) REFERENCES `groupe` (`Numero_Grp`);

--
-- Contraintes pour la table `ressources`
--
ALTER TABLE `ressources`
  ADD CONSTRAINT `ressources_ibfk_1` FOREIGN KEY (`Numero_UE`) REFERENCES `ue` (`Numero_UE`);

--
-- Contraintes pour la table `ressources_prof`
--
ALTER TABLE `ressources_prof`
  ADD CONSTRAINT `ressources_prof_ibfk_1` FOREIGN KEY (`Numero_Res`) REFERENCES `ressources` (`Numero_Res`),
  ADD CONSTRAINT `ressources_prof_ibfk_2` FOREIGN KEY (`Numero_Ens`) REFERENCES `enseignants` (`Numero_Ens`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
