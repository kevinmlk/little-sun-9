-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2024 at 12:14 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `little_sun`
--

-- --------------------------------------------------------

--
-- Table structure for table `absence`
--

CREATE TABLE `absence` (
  `id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `absence`
--

INSERT INTO `absence` (`id`, `employee_id`, `start_time`, `end_time`, `status`) VALUES
(1, 1, '2024-05-19 09:00:00', '2024-05-19 10:00:00', 'sick'),
(2, 2, '2024-05-19 14:00:00', '2024-05-19 15:00:00', 'sick'),
(3, 3, '2024-05-19 17:01:19', '2024-05-19 17:01:19', 'working'),
(4, 4, '2024-05-19 17:55:30', '2024-05-19 17:55:30', 'sick'),
(5, 5, '2024-05-19 19:00:00', '2024-05-19 20:00:00', ''),
(6, 5, '2024-05-19 19:17:38', '2024-05-19 19:17:38', 'sick'),
(7, 6, '2024-05-19 17:00:24', '2024-05-19 18:00:24', 'sick'),
(8, 8, '2024-05-19 06:00:27', '2024-05-19 09:00:27', 'sick'),
(9, 9, '2024-05-19 11:00:45', '2024-05-19 14:00:45', 'sick');

-- --------------------------------------------------------

--
-- Table structure for table `absents`
--

CREATE TABLE `absents` (
  `Id` int(11) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `ShiftId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absents`
--

INSERT INTO `absents` (`Id`, `Type`, `ShiftId`) VALUES
(3, 'sick', 28),
(4, 'sick', 36),
(5, 'sick', 15);

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

CREATE TABLE `locations` (
  `Id` int(11) NOT NULL,
  `Hubname` varchar(300) NOT NULL,
  `Hublocation` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `locations`
--

INSERT INTO `locations` (`Id`, `Hubname`, `Hublocation`) VALUES
(1, 'No hub assigned', 'No location assigned'),
(2, 'Muchinga MTS. Hub', 'Mbala'),
(3, 'Bangweulu Hub', 'Bangweulu Swamps'),
(11, 'Mopani Hub', 'Kitwe');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `Id` int(11) NOT NULL,
  `RoleName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`Id`, `RoleName`) VALUES
(1, 'Employee'),
(2, 'Admin'),
(3, 'Manager');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--
-- Error reading structure for table little_sun.schedules: #1932 - Table &#039;little_sun.schedules&#039; doesn&#039;t exist in engine
-- Error reading data for table little_sun.schedules: #1064 - You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near &#039;FROM `little_sun`.`schedules`&#039; at line 1

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `Id` int(11) NOT NULL,
  `StartTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `EndTime` timestamp NOT NULL DEFAULT current_timestamp(),
  `EmployeeId` int(11) NOT NULL,
  `CheckIn` timestamp NULL DEFAULT NULL,
  `CheckOut` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shifts`
--

INSERT INTO `shifts` (`Id`, `StartTime`, `EndTime`, `EmployeeId`, `CheckIn`, `CheckOut`) VALUES
(12, '2024-05-16 07:00:00', '2024-05-16 15:30:00', 20, NULL, NULL),
(13, '2024-05-17 08:30:00', '2024-05-17 16:00:00', 19, NULL, NULL),
(14, '2024-05-20 08:00:00', '2024-05-20 10:00:00', 16, '2024-05-20 17:13:02', '2024-05-20 17:27:46'),
(15, '2024-05-21 10:00:00', '2024-05-21 14:00:00', 16, NULL, NULL),
(16, '2024-05-16 08:00:00', '2024-05-16 10:00:00', 19, NULL, NULL),
(17, '2024-05-12 18:30:00', '2024-05-12 21:59:00', 16, '2024-05-12 18:56:14', '2024-05-12 18:56:33'),
(18, '2024-05-23 08:00:00', '2024-05-23 14:00:00', 6, NULL, NULL),
(27, '2024-05-13 08:00:00', '2024-05-13 10:00:00', 16, NULL, NULL),
(28, '2024-05-19 19:00:00', '2024-05-19 21:59:00', 16, NULL, NULL),
(29, '2024-05-23 07:00:00', '2024-05-23 10:00:00', 20, NULL, NULL),
(30, '2024-05-22 08:00:00', '2024-05-22 09:00:00', 17, NULL, NULL),
(31, '2024-05-19 18:10:00', '2024-05-19 21:59:00', 3, NULL, NULL),
(34, '2024-05-20 08:00:00', '2024-05-20 10:00:00', 36, '2024-05-20 14:02:38', '2024-05-20 17:14:30'),
(35, '2024-05-29 08:00:00', '2024-05-29 09:00:00', 36, NULL, NULL),
(36, '2024-05-19 21:23:00', '2024-05-19 21:59:00', 36, NULL, NULL),
(37, '2024-05-22 08:00:00', '2024-05-22 09:00:00', 36, NULL, NULL),
(38, '2024-05-22 08:00:00', '2024-05-22 10:00:00', 35, NULL, NULL),
(39, '2024-05-23 12:00:00', '2024-05-23 14:00:00', 40, NULL, NULL),
(40, '2024-05-27 09:00:00', '2024-05-27 11:30:00', 37, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shiftswap`
--

CREATE TABLE `shiftswap` (
  `Id` int(11) NOT NULL,
  `RequesterId` int(11) DEFAULT NULL,
  `ReceiverId` int(11) DEFAULT NULL,
  `ShiftId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `Id` int(11) NOT NULL,
  `Taskname` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`Id`, `Taskname`) VALUES
(1, 'no task assigned'),
(2, 'office duty'),
(3, 'office cleaning'),
(6, 'milk collection'),
(7, 'milk analysis'),
(8, 'pickup'),
(9, 'external training'),
(10, 'internal training'),
(11, 'reporting'),
(13, 'hygiene');

-- --------------------------------------------------------

--
-- Table structure for table `timeoffrequests`
--

CREATE TABLE `timeoffrequests` (
  `Id` int(11) NOT NULL,
  `EmployeeId` int(11) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `StartDate` datetime DEFAULT NULL,
  `EndDate` datetime DEFAULT NULL,
  `Status` varchar(300) DEFAULT 'pending',
  `Reason` varchar(300) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `timeoffrequests`
--

INSERT INTO `timeoffrequests` (`Id`, `EmployeeId`, `Type`, `StartDate`, `EndDate`, `Status`, `Reason`) VALUES
(1, 20, 'marriage party', '2024-05-22 00:00:00', '2024-05-22 23:59:59', 'denied', 'Not notified in advance'),
(2, 37, 'marriage party', '2024-05-31 00:00:00', '2024-05-31 23:59:59', 'approved', 'Was announced of this in advance'),
(3, 20, 'vacation', '2024-06-03 00:00:00', '2024-06-07 00:00:00', 'pending', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Firstname` varchar(255) DEFAULT NULL,
  `Lastname` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `ProfilePicture` varchar(300) DEFAULT NULL,
  `RoleId` int(11) NOT NULL,
  `TaskId` int(11) DEFAULT 1,
  `LocationId` int(11) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Firstname`, `Lastname`, `Email`, `Password`, `ProfilePicture`, `RoleId`, `TaskId`, `LocationId`) VALUES
(3, 'James', 'Doe', 'james.doe@littlesun.zm', '$2y$15$khAysbZfD8sJsXW5pOEQ.uYSyYpXo1sQFPWgyHibpM85YP81LaO5e', '', 1, 1, 11),
(4, 'Jamie', 'Doe', 'jamie.doe@littlesun.zm', '$2y$15$veA.LeEiuesKP/W8qg3pJOIRZ4rU9UyeHwrbwlcO/E9efCthZMT4q', '', 3, 1, 11),
(5, 'Jane', 'Doe', 'jane.doe@littlesun.zm', '$2y$15$BN6aS7ryZ1SHJUjcZ9OiruttGZ1y3h6TErJ9TVxFTtHp0JFn.PWC.', '', 2, 1, 1),
(6, 'Jeremy', 'Decuypere', 'jeremy.decuypere@littlesun.zm', '$2y$15$H9Sm.Yfdi8AJ1KDfP0upQuB31.z7BCteNOW8k/kLEKfYzFYxurx4i', '', 1, 2, 2),
(7, 'Jennifer', 'Doe', 'jennifer.doe@littlesun.zm', '$2y$15$HThqfT7KJYnmMFz.9ogNq.D/mdZoaK2yT2KgOCLCXK9WLkwIts2Za', '', 1, 1, 3),
(16, 'Frank', 'Ribery', 'frank.ribery@littlesun.zm', '$2y$15$spxP8saS5Bu5pNPYDSfH/ucmViCpgsv4JWb6XY1TPeTWj2ZeZw4.C', 'Frank-Ribery-pexels-tony-schnagl-5588224.jpg', 1, 3, 2),
(17, 'Amanda', 'Seales', 'amanda.seales@littlesun.zm', '$2y$15$vQlvrpWq4vsszevSpAg47.2Kd0w1kOMxCJO7.i4XOF8Uf05OnC6Ga', 'Amanda-Seales-pexels-olly-3769021.jpg', 1, 1, 3),
(19, 'Kirk', 'Leon', 'kirk.leoon@littlesun.zm', '$2y$15$KIO/WfUKBgnNFLvSgU78neBcXaonvEWCVVXJhRlxOf2B1VX1/jZ5.', 'Kirk-Leoon-pexels-tony-schnagl-5588224.jpg', 1, 1, 3),
(20, 'Dean', 'Saber', 'dean.saber@littlesun.zm', '$2y$15$CXC01H3GyFirHzyZVTZwbuNXMSOYrVeFsFl1K9yCDdz/6fffLsisO', 'Dean-Saber-pexels-olly-3769021.jpg', 1, 7, 11),
(31, 'Temitope', 'Nkiruka', 'temipote.kniruka@littlesun.zm', '$2y$15$R6aGXRHTzLIqSutmQG/JnuXF4hOL0hykoqzNZuq6HUzxNLnpaTh86', 'Temitope-Nkiruka-pexels-olly-3769021.jpg', 3, 1, 3),
(32, 'Tashard', 'Simpson', 'tashard.simpson@littlesun.zm', '$2y$15$PyQ63RGnCtxe.xSq22oBl.79FEptkvTcnuGtkpkEotpES0lvwbB66', 'Tashard-Simpson-pexels-maksgelatin-5611966.jpg', 3, 1, 2),
(33, 'Rhad', 'Watkins', 'rhad.watkins@littlesun.zm', '$2y$15$Y1NvRKJGkshluM5YujJzAuRNCvBg5QadZHJEfeCijD7WRSku2DfUu', 'Rhad-Watkins-pexels-tony-schnagl-5588224.jpg', 1, 3, 2),
(34, 'Jumon', 'Baker', 'jumon.baker@littlesun.zm', '$2y$15$F7GF0BMWLf9REOk9REZIEuiWY4YIvRTY5ihNMHmfwNybM52VGxLES', 'Jumon-Baker-pexels-tony-schnagl-5588224.jpg', 1, 2, 2),
(35, 'Xaevan', 'Hart', 'xaevan.hart@littlesun.zm', '$2y$15$3u1Arvok9RFXWE0SlcQj.epQhPr52vElFBPNH8EgPr4.UP0k4fvNC', 'Xaevan-Hart-pexels-tony-schnagl-5588224.jpg', 1, 3, 2),
(36, 'Blake', 'Taylor', 'blake.taylor@littlesun.zm', '$2y$15$/OTiWQn0yvTCTSrC2.NOkenwLZja8w/Ntf3WBQbXdqX5j2yNdN8.e', 'Blake-Taylor-pexels-tony-schnagl-5588224.jpg', 1, 3, 3),
(37, 'Tambo', 'Kiama', 'tambo.kiama@littlesun.zm', '$2y$15$byOPIK24XO9nn.MtWiOKROWPabIKuCCefHzav516Txv010fTpfc0e', 'Tambo-Kiama-pexels-olly-3769021.jpg', 1, 10, 11),
(40, 'Mwila', 'Banda', 'mwila.banda@littlesun.zm', '$2y$15$Rkztdpu3YEkgR9o0.f3laOvErgwC/BkmvdDmEemJv0e7kHbrdmUTi', 'Mwila-Banda-pexels-olly-3769021.jpg', 1, 11, 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absence`
--
ALTER TABLE `absence`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `absents`
--
ALTER TABLE `absents`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `ShiftId` (`ShiftId`);

--
-- Indexes for table `locations`
--
ALTER TABLE `locations`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EmployeeId` (`EmployeeId`);

--
-- Indexes for table `shiftswap`
--
ALTER TABLE `shiftswap`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RequesterId` (`RequesterId`),
  ADD KEY `ReceiverId` (`ReceiverId`),
  ADD KEY `ShiftId` (`ShiftId`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `EmployeeId` (`EmployeeId`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `RoleId` (`RoleId`),
  ADD KEY `TaskId` (`TaskId`,`LocationId`),
  ADD KEY `LocationId` (`LocationId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absence`
--
ALTER TABLE `absence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `absents`
--
ALTER TABLE `absents`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `locations`
--
ALTER TABLE `locations`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `shiftswap`
--
ALTER TABLE `shiftswap`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absents`
--
ALTER TABLE `absents`
  ADD CONSTRAINT `absents_ibfk_1` FOREIGN KEY (`ShiftId`) REFERENCES `shifts` (`Id`);

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `shifts_ibfk_2` FOREIGN KEY (`EmployeeId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `shiftswap`
--
ALTER TABLE `shiftswap`
  ADD CONSTRAINT `shiftswap_ibfk_1` FOREIGN KEY (`RequesterId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `shiftswap_ibfk_2` FOREIGN KEY (`ReceiverId`) REFERENCES `users` (`Id`),
  ADD CONSTRAINT `shiftswap_ibfk_3` FOREIGN KEY (`ShiftId`) REFERENCES `shifts` (`Id`);

--
-- Constraints for table `timeoffrequests`
--
ALTER TABLE `timeoffrequests`
  ADD CONSTRAINT `timeoffrequests_ibfk_1` FOREIGN KEY (`EmployeeId`) REFERENCES `users` (`Id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`),
  ADD CONSTRAINT `users_ibfk_2` FOREIGN KEY (`RoleId`) REFERENCES `roles` (`Id`),
  ADD CONSTRAINT `users_ibfk_3` FOREIGN KEY (`TaskId`) REFERENCES `tasks` (`Id`),
  ADD CONSTRAINT `users_ibfk_4` FOREIGN KEY (`LocationId`) REFERENCES `locations` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
