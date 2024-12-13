-- Active: 1733407253980@@127.0.0.1@3306@gymsport

-- Structure de la table `activites`
--
CREATE DATABASE gymsport;
USE gymsport;

CREATE TABLE `activites` (
  `ID_Activite` int(11) AUTO_INCREMENT PRIMARY key NOT NULL,
  `Nom_Activite` varchar(100) NOT NULL,
  `Description` text DEFAULT NULL,
  `Capacite` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `Disponibilite` tinyint(1) NOT NULL
) ;

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `ID_Membre` int(11) AUTO_INCREMENT NOT NULL,
  `Nom` varchar(50) NOT NULL,
  `Prenom` varchar(50) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Telephone` varchar(15) DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT 0,
  `password` varchar(255) NOT NULL
);   


--
-- Déchargement des données de la table `membres`
--


CREATE TABLE `reservations` (
  `ID_Reservation` int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
  `ID_Membre` int(11) NOT NULL,
  `ID_Activite` int(11) NOT NULL,
  `Date_Reservation` datetime DEFAULT CURRENT_TIMESTAMP,
  `Statut` enum('Confirmee','Annulee') NOT NULL DEFAULT 'Confirmee'
);
ALTER TABLE `reservations`
ADD CONSTRAINT `fk_reservation_membre`
FOREIGN KEY (`ID_Membre`) REFERENCES `membres`(`ID_Membre`)
ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `reservations`
ADD CONSTRAINT `fk_reservation_activite`
FOREIGN KEY (`ID_Activite`) REFERENCES `activites`(`ID_Activite`)
ON DELETE CASCADE ON UPDATE CASCADE;

INSERT INTO `reservations` (`ID_Membre`,`ID_Activite`)
VALUES (1,1);
INSERT INTO `activites` (`Nom_Activite`, `Description`, `Capacite`, `date_debut`, `date_fin`, `Disponibilite`)
VALUES
('Yoga Matinal', 'Une séance de yoga pour bien commencer la journée', 20, '2024-01-01', '2024-01-31', 1),
('Cours de Zumba', 'Des sessions dynamiques pour brûler des calories en dansant', 30, '2024-02-01', '2024-02-28', 1),
('Musculation Intense', 'Un programme pour développer la force musculaire', 15, '2024-03-01', '2024-03-31', 1),
('Méditation Guidée', 'Se détendre et réduire le stress grâce à la méditation', 25, '2024-04-01', '2024-04-30', 1),
('Natation Libre', 'Accès à la piscine pour nager librement', 10, '2024-05-01', '2024-05-31', 1),
('Cours de Boxe', 'Apprenez les bases de la boxe avec un coach professionnel', 12, '2024-06-01', '2024-06-30', 1);


-- create Table aa(
--   nom varchar(15),
--   date_n DATETIME DEFAULT CURRENT_TIMESTAMP
-- );

-- insert into aa(nom) VALUES("md");

-- select * from aa;