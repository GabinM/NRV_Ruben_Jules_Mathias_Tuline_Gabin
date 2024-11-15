
-- --------------------------------------------------------

--
-- Structure de la table `lieu`
--

CREATE TABLE `lieu` (
  `idLieu` int(3) NOT NULL,
  `nomLieu` varchar(100) NOT NULL,
  `adresse` varchar(100) NOT NULL,
  `nbrPlacesA` int(5) NOT NULL,
  `nbrPlacesD` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `lieu`
--

INSERT INTO `lieu` (`idLieu`, `nomLieu`, `adresse`, `nbrPlacesA`, `nbrPlacesD`) VALUES
(1, 'Breeze', '2 rue Altego', 100, 300),
(2, 'Ascent', '24 avenue Reyna', 250, 700),
(3, 'Fracture', 'avenue de la Liberté', 0, 500),
(4, 'Split', '90ter rue de l operator', 120, 650),
(5, 'Bind', '7 rue Phoenix-WatchoAyz', 50, 400);

-- --------------------------------------------------------

--
-- Structure de la table `media`
--

CREATE TABLE `media` (
  `idMedia` int(3) NOT NULL,
  `idSpectacle` int(3) NOT NULL,
  `fichier` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `media`
--

INSERT INTO `media` (`idMedia`, `idSpectacle`, `fichier`) VALUES
(4, 1, './Media/chanteur_noir_et_blanc_2.jpg'),
(5, 2, './Media/chanteur_noir_et_blanc.jpg'),
(6, 3, './Media/chanteuse_noir_et_blanc.jpg'),
(7, 4, './Media/chanteuse.jpg'),
(8, 5, './Media/concert_violons.jpg'),
(9, 6, './Media/dessin_groupe.jpg'),
(10, 7, './Media/musiciens_soleil.jpg'),
(11, 8, './Media/enfant_guitare.jpg'),
(12, 9, './Media/enjaille.jpg'),
(13, 10, './Media/femme_couleur.jpg'),
(14, 11, './Media/fiesta.jpg'),
(15, 12, './Media/fumee.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `soiree`
--

CREATE TABLE `soiree` (
  `idSoiree` int(3) NOT NULL,
  `nomSoiree` varchar(100) NOT NULL,
  `theme` varchar(25) NOT NULL,
  `date` date NOT NULL,
  `descriptionSoiree` varchar(500) NOT NULL,
  `tarif` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `soiree`
--

INSERT INTO `soiree` (`idSoiree`, `nomSoiree`, `theme`, `date`, `descriptionSoiree`, `tarif`) VALUES
(1, 'Fiesta', 'Soirée Vintage Années 80', '2025-08-20', 'Thème inspiré des années 80, avec des costumes, des musiques et une ambiance rétro pour revivre la nostalgie de cette décennie colorée.', 20),
(2, 'Party', 'Mystères et Masques', '2025-09-12', 'Soirée élégante où les invités portent des masques, ajoutant une touche de mystère et de glamour, dans une ambiance feutrée et intrigante.', 15),
(3, 'Yugata', 'Jungle Tropicale', '2025-11-03', 'Thème exotique avec une décoration inspirée de la jungle, des lumières vertes et une ambiance tropicale pour se sentir en pleine forêt amazonienne.', 12),
(4, 'Vecher', 'Soirée Vintage Années 80', '2025-05-24', 'Thème inspiré des années 80, avec des costumes, des musiques et une ambiance rétro pour revivre la nostalgie de cette décennie colorée.', 50),
(5, 'Aksam', 'Futur Cyberpunk', '2025-07-10', 'Une soirée inspirée des univers cyberpunk, avec des néons, des visuels futuristes et une musique électronique, plongeant les invités dans un monde dystopique.', 19),
(6, 'la soirée qui tue', 'soiréy', '0000-00-00', 'la mort qui tue', 2147483647),
(7, 'la soirée qui tue', 'soiréy', '0000-00-00', 'la mort qui tue', 2147483647);

-- --------------------------------------------------------

--
-- Structure de la table `spectacle`
--

CREATE TABLE `spectacle` (
  `idSpectacle` int(3) NOT NULL,
  `idLieu` int(3) NOT NULL,
  `titre` varchar(100) NOT NULL,
  `idStyle` int(3) NOT NULL,
  `date` date NOT NULL,
  `duree` int(5) NOT NULL,
  `descriptionSpec` varchar(500) NOT NULL,
  `horaire` time NOT NULL,
  `nomsArtistes` varchar(200) NOT NULL,
  `annule` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `spectacle`
--

INSERT INTO `spectacle` (`idSpectacle`, `idLieu`, `titre`, `idStyle`, `date`, `duree`, `descriptionSpec`, `horaire`, `nomsArtistes`, `annule`) VALUES
(1, 1, 'La soirée de la mort', 1, '2025-09-12', 60, 'Superbe soirée dans la faille', '21:00:00', 'Jules', 1),
(2, 3, 'Pyro Symphony', 2, '2025-09-12', 105, 'Un spectacle de rock intense avec des effets pyrotechniques impressionnants, où le feu et la musique fusionnent en une expérience inoubliable', '21:30:00', 'Flame Reapers', 0),
(3, 4, 'Oceanic Echoes', 3, '2025-11-03', 80, 'Une expérience sonore immersive inspirée par les profondeurs océaniques, avec des sons aquatiques et des visuels apaisants', '00:00:00', 'Blue Tides Ensemble', 0),
(4, 5, 'Starlight Jazz', 4, '2025-11-03', 130, 'Une nuit de jazz sous les étoiles, où chaque note est une exploration cosmique et chaque solo illumine le ciel', '19:00:00', 'Galaxy Groove Quartet', 0),
(5, 2, 'Ultra Heavy Galvanized Casted Iron', 1, '2025-05-24', 90, 'Un spectacle venant de l enfer pour manger du métal en fusion et boire de la lave à 10000 degrés Celsius en portant des casques à cornes', '04:00:00', 'Ragna-Rock', 0),
(6, 3, 'Celestial Drift', 3, '2025-05-24', 75, 'Un voyage musical à travers les galaxies avec des sons planants et des visuels immersifs', '20:00:00', 'Stella Nova', 0),
(7, 4, 'Enchanted Strings', 1, '2025-07-10', 120, 'Un concert magique de musique folle, inspiré par les forêts enchantées d Écosse', '19:30:00', 'The Celtic Woods', 0),
(8, 1, 'Neon Pulse', 5, '2025-08-20', 95, 'Une performance électrique avec des lumières néons et des rythmes entraînants', '22:00:00', 'Synthrider', 0),
(9, 2, 'Harmonic Breeze', 4, '2025-08-20', 110, 'Un concert de musique jazz moderne, combinant des œuvres nouvelles et des classiques réinterprétés', '18:00:00', 'Orchestre Lumière', 0),
(10, 1, 'Les raisons de la cilère', 4, '8655-05-25', 899, 'test test', '00:23:23', 'Chaka punk', 0),
(11, 1, 'Les raisons de la cilère', 4, '8655-05-25', 899, 'test test', '00:23:23', 'Chaka punk', 0),
(12, 1, 'Les raisons de la cilère', 4, '8655-05-25', 899, 'test test', '00:23:23', 'Chaka punk', 0);

-- --------------------------------------------------------

--
-- Structure de la table `spectacle2soiree`
--

CREATE TABLE `spectacle2soiree` (
  `idSpectacle` int(3) NOT NULL,
  `idSoiree` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `spectacle2soiree`
--

INSERT INTO `spectacle2soiree` (`idSpectacle`, `idSoiree`) VALUES
(8, 1),
(9, 1),
(1, 2),
(2, 2),
(5, 2),
(3, 3),
(4, 3),
(5, 4),
(6, 4),
(7, 5);

-- --------------------------------------------------------

--
-- Structure de la table `style`
--

CREATE TABLE `style` (
  `idStyle` int(3) NOT NULL,
  `libelle` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `style`
--

INSERT INTO `style` (`idStyle`, `libelle`) VALUES
(1, 'Metal'),
(2, 'Rock Pyrotechnique'),
(3, 'Musique Relaxante'),
(4, 'Jazz Cosmique'),
(5, 'Ambient Space Rock');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `idUtilisateur` int(3) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hashmdp` varchar(256) NOT NULL,
  `role` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`idUtilisateur`, `email`, `hashmdp`, `role`) VALUES
(1, 'user1@mail.com', '$2y$12$e9DCiDKOGpVs9s.9u2ENEOiq7wGvx7sngyhPvKXo2mUbI3ulGWOdC', 1),
(2, 'user2@mail.com', '$2y$12$4EuAiwZCaMouBpquSVoiaOnQTQTconCP9rEev6DMiugDmqivxJ3AG', 1),
(3, 'user3@mail.com', '$2y$12$5dDqgRbmCN35XzhniJPJ1ejM5GIpBMzRizP730IDEHsSNAu24850S', 1),
(4, 'user4@mail.com', '$2y$12$ltC0A0zZkD87pZ8K0e6TYOJPJeN/GcTSkUbpqq0kBvx6XdpFqzzqq', 1),
(5, 'admin@mail.com', '$2y$12$JtV1W6MOy/kGILbNwGR2lOqBn8PAO3Z6MupGhXpmkeCXUPQ/wzD8a', 2),
(6, 'mail@mail.com', '$2y$10$hTSSCrO01e0v138xsaUhu.5pkUakgIiLT8Flolv0KeDRXkXky0bRK', 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `lieu`
--
ALTER TABLE `lieu`
  ADD PRIMARY KEY (`idLieu`);

--
-- Index pour la table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`idMedia`),
  ADD KEY `fk_media` (`idSpectacle`);

--
-- Index pour la table `soiree`
--
ALTER TABLE `soiree`
  ADD PRIMARY KEY (`idSoiree`);

--
-- Index pour la table `spectacle`
--
ALTER TABLE `spectacle`
  ADD PRIMARY KEY (`idSpectacle`),
  ADD KEY `fk_spec` (`idLieu`),
  ADD KEY `fk2_spec` (`idStyle`);

--
-- Index pour la table `spectacle2soiree`
--
ALTER TABLE `spectacle2soiree`
  ADD PRIMARY KEY (`idSoiree`,`idSpectacle`),
  ADD KEY `fk1_spec2soi` (`idSpectacle`);

--
-- Index pour la table `style`
--
ALTER TABLE `style`
  ADD PRIMARY KEY (`idStyle`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`idUtilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `media`
--
ALTER TABLE `media`
  MODIFY `idMedia` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pour la table `soiree`
--
ALTER TABLE `soiree`
  MODIFY `idSoiree` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `spectacle`
--
ALTER TABLE `spectacle`
  MODIFY `idSpectacle` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `style`
--
ALTER TABLE `style`
  MODIFY `idStyle` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `idUtilisateur` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `media`
--
ALTER TABLE `media`
  ADD CONSTRAINT `fk_media` FOREIGN KEY (`idSpectacle`) REFERENCES `spectacle` (`idSpectacle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `spectacle`
--
ALTER TABLE `spectacle`
  ADD CONSTRAINT `fk1_spec` FOREIGN KEY (`idLieu`) REFERENCES `lieu` (`idLieu`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk2_spec` FOREIGN KEY (`idStyle`) REFERENCES `style` (`idStyle`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Contraintes pour la table `spectacle2soiree`
--
ALTER TABLE `spectacle2soiree`
  ADD CONSTRAINT `fk1_spec2soi` FOREIGN KEY (`idSpectacle`) REFERENCES `spectacle` (`idSpectacle`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk2_spec2soi` FOREIGN KEY (`idSoiree`) REFERENCES `soiree` (`idSoiree`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

