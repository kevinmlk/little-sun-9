-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Gegenereerd op: 12 mei 2024 om 14:19
-- Serverversie: 5.7.39
-- PHP-versie: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Litte-sun-9`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `locations`
--

CREATE TABLE `locations` (
  `Id` int(11) NOT NULL,
  `Hubname` varchar(300) NOT NULL,
  `Hublocation` varchar(300) NOT NULL,
  `ManagerId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `locations`
--

INSERT INTO `locations` (`Id`, `Hubname`, `Hublocation`, `ManagerId`) VALUES
(1, 'Zambezi River Hub', 'Lusaka', 4),
(2, 'Muchinga MTS. Hub', 'Mbala', 16),
(3, 'Bangweulu Hub', 'Bangweulu Swamps', 17);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `RoleName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `roles`
--

INSERT INTO `roles` (`Id`, `RoleName`) VALUES
(1, 'Employee'),
(2, 'Admin'),
(3, 'Manager');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `schedules`
--

CREATE TABLE `schedules` (
  `Id` int(11) NOT NULL,
  `Title` varchar(255) DEFAULT NULL,
  `Description` varchar(255) DEFAULT NULL,
  `Day` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `schedules`
--

INSERT INTO `schedules` (`Id`, `Title`, `Description`, `Day`) VALUES
(1, 'Work schedule 6 mai', 'Preparing and cleaning the office for visitors.', '2024-05-06 06:30:00'),
(2, 'Work schedule 6 mai', 'Preparing and cleaning the office for visitors.', '2024-05-06 06:30:00');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shifts`
--

CREATE TABLE `shifts` (
  `Id` int(11) NOT NULL,
  `StartTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `EndTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `EmployeeId` int(11) NOT NULL,
  `TaskId` int(11) NOT NULL,
  `LocationId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `shifts`
--

INSERT INTO `shifts` (`Id`, `StartTime`, `EndTime`, `EmployeeId`, `TaskId`, `LocationId`) VALUES
(1, '2024-05-13 07:00:00', '2024-05-13 15:30:00', 3, 2, 1),
(2, '2024-05-14 08:00:00', '2024-05-14 14:00:00', 6, 3, 2),
(11, '2024-05-14 07:00:00', '2024-05-14 15:30:30', 17, 2, 2),
(12, '2024-05-16 07:00:00', '2024-05-16 15:30:00', 20, 2, 3),
(13, '2024-05-17 12:00:00', '2024-05-17 16:00:00', 19, 3, 3),
(14, '2024-05-20 08:00:00', '2024-05-20 10:00:00', 16, 3, 1),
(15, '2024-05-21 12:00:00', '2024-05-21 14:00:00', 16, 2, 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `shiftswap`
--

CREATE TABLE `shiftswap` (
  `Id` int(11) NOT NULL,
  `RequesterId` int(11) DEFAULT NULL,
  `ReceiverId` int(11) DEFAULT NULL,
  `ShiftId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `tasks`
--

CREATE TABLE `tasks` (
  `Id` int(11) NOT NULL,
  `Taskname` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `tasks`
--

INSERT INTO `tasks` (`Id`, `Taskname`) VALUES
(1, 'no task assigned'),
(2, 'office duty'),
(3, 'office cleaning');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `timeoffrequests`
--

CREATE TABLE `timeoffrequests` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `Approved` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `timeoffrequests`
--

INSERT INTO `timeoffrequests` (`Id`, `UserId`, `Type`, `StartDate`, `EndDate`, `Approved`) VALUES
(1, 17, 'Ziek', '2024-05-12 15:03:28', '2024-05-14 15:03:28', 1);

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Lastname` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `ProfilePicture` varchar(300) DEFAULT NULL,
  `RoleId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`Id`, `Firstname`, `Lastname`, `Email`, `Password`, `ProfilePicture`, `RoleId`) VALUES
(3, 'James', 'Doe', 'james.doe@littlesun.zm', '$2y$15$khAysbZfD8sJsXW5pOEQ.uYSyYpXo1sQFPWgyHibpM85YP81LaO5e', '', 1),
(4, 'Jamie', 'Doe', 'jamie.doe@littlesun.zm', '$2y$15$ctFg0KCfMaVDBId7dArwkOXTl8GT4AsKNqrY6/L4GCC0TVt1KKlcu', '', 3),
(5, 'Jane', 'Doe', 'jane.doe@littlesun.zm', '$2y$15$BN6aS7ryZ1SHJUjcZ9OiruttGZ1y3h6TErJ9TVxFTtHp0JFn.PWC.', '', 2),
(6, 'Jeremy', 'Decuypere', 'jeremy.decuypere@littlesun.zm', '$2y$15$H9Sm.Yfdi8AJ1KDfP0upQuB31.z7BCteNOW8k/kLEKfYzFYxurx4i', '', 1),
(7, 'Jennifer', 'Doe', 'jennifer.doe@littlesun.zm', '$2y$15$HThqfT7KJYnmMFz.9ogNq.D/mdZoaK2yT2KgOCLCXK9WLkwIts2Za', '', 1),
(16, 'Frank', 'Ribery', 'frank.ribery@littlesun.zm', '$2y$15$spxP8saS5Bu5pNPYDSfH/ucmViCpgsv4JWb6XY1TPeTWj2ZeZw4.C', 'Frank-Ribery-pexels-tony-schnagl-5588224.jpg', 1),
(17, 'Amanda', 'Seales', 'amanda.seales@littlesun.zm', '$2y$15$vQlvrpWq4vsszevSpAg47.2Kd0w1kOMxCJO7.i4XOF8Uf05OnC6Ga', 'Amanda-Seales-pexels-olly-3769021.jpg', 1),
(19, 'Kirk', 'Leon', 'kirk.leoon@littlesun.zm', '$2y$15$KIO/WfUKBgnNFLvSgU78neBcXaonvEWCVVXJhRlxOf2B1VX1/jZ5.', 'Kirk-Leoon-pexels-tony-schnagl-5588224.jpg', 1),
(20, 'Dean', 'Saber', 'dean.saber@littlesun.zm', '$2y$15$CXC01H3GyFirHzyZVTZwbuNXMSOYrVeFsFl1K9yCDdz/6fffLsisO', 'Dean-Saber-pexels-olly-3769021.jpg', 1),
(30, 'Lars', 'Raeymaekers', 'lars@rmkrs.be', '$2y$15$hMurTOdCMtHbpmin/M3fIutgFROtqRs1FDns0P2ei2bLINvq.A12y', NULL, 3);

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ManagerId` (`ManagerId`);

--
-- Indexen voor tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EmployeeId` (`EmployeeId`),
  ADD KEY `TaskId` (`TaskId`),
  ADD KEY `LocationId` (`LocationId`);

--
-- Indexen voor tabel `shiftswap`
--
ALTER TABLE `shiftswap`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RequesterId` (`RequesterId`),
  ADD KEY `ReceiverId` (`ReceiverId`),
  ADD KEY `ShiftId` (`ShiftId`);

--
-- Indexen voor tabel `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Id`);

--
-- Indexen voor tabel `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `UserId` (`UserId`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`RoleId`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `locations`
--
ALTER TABLE `locations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT voor een tabel `schedules`
--
ALTER TABLE `schedules`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT voor een tabel `shifts`
--
ALTER TABLE `shifts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT voor een tabel `shiftswap`
--
ALTER TABLE `shiftswap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT voor een tabel `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `locations`
--
ALTER TABLE `locations`
  ADD CONSTRAINT `locations_ibfk_1` FOREIGN KEY (`ManagerId`) REFERENCES `users` (`Id`);

--
-- Beperkingen voor tabel `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_ibfk_2` FOREIGN KEY (`EmployeeId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `shifts_ibfk_3` FOREIGN KEY (`TaskId`) REFERENCES `tasks` (`Id`),
  ADD CONSTRAINT `shifts_ibfk_4` FOREIGN KEY (`LocationId`) REFERENCES `locations` (`Id`);

--
-- Beperkingen voor tabel `shiftswap`
--
ALTER TABLE `shiftswap`
  ADD CONSTRAINT `shiftswap_ibfk_1` FOREIGN KEY (`RequesterId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `shiftswap_ibfk_2` FOREIGN KEY (`ReceiverId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `shiftswap_ibfk_3` FOREIGN KEY (`ShiftId`) REFERENCES `shifts` (`Id`);

--
-- Beperkingen voor tabel `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  ADD CONSTRAINT `timeoffrequests_ibfk_1` FOREIGN KEY (`UserId`) REFERENCES `users` (`Id`);

--
-- Beperkingen voor tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
