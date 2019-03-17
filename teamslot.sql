-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 06, 2018 at 10:11 AM
-- Server version: 5.7.21
-- PHP Version: 7.0.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `teamslot`
--

-- --------------------------------------------------------

--
-- Table structure for table `Event`
--

CREATE TABLE `Event` (
  `EventID` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `startTime` datetime NOT NULL,
  `finishTime` datetime NOT NULL,
  `UserID` varchar(25) DEFAULT NULL,
  `TeamID` int(11) NOT NULL,
  `URL` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `MemberOf`
--

CREATE TABLE `MemberOf` (
  `UserID` varchar(25) NOT NULL,
  `TeamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `PendingMemberOf`
--

CREATE TABLE `PendingMemberOf` (
  `username` varchar(50) NOT NULL,
  `TeamID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `SchedLink`
--

CREATE TABLE `SchedLink` (
  `LinkID` int(11) NOT NULL,
  `LinkName` varchar(100) NOT NULL,
  `TeamID` int(11) NOT NULL,
  `UserID` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Team`
--

CREATE TABLE `Team` (
  `TeamID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TimeSlot`
--

CREATE TABLE `TimeSlot` (
  `LinkID` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `UserID` varchar(25) NOT NULL,
  `Fname` varchar(25) NOT NULL,
  `Lname` varchar(25) NOT NULL,
  `username` varchar(100) NOT NULL,
  `ppsrc` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Event`
--
ALTER TABLE `Event`
  ADD PRIMARY KEY (`EventID`),
  ADD UNIQUE KEY `URL` (`URL`),
  ADD KEY `TeamID` (`TeamID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indexes for table `MemberOf`
--
ALTER TABLE `MemberOf`
  ADD PRIMARY KEY (`UserID`,`TeamID`),
  ADD KEY `TeamID` (`TeamID`);

--
-- Indexes for table `PendingMemberOf`
--
ALTER TABLE `PendingMemberOf`
  ADD PRIMARY KEY (`username`,`TeamID`),
  ADD KEY `TeamID` (`TeamID`);

--
-- Indexes for table `SchedLink`
--
ALTER TABLE `SchedLink`
  ADD PRIMARY KEY (`LinkID`),
  ADD KEY `TeamID` (`TeamID`),
  ADD KEY `schedlink_ibfk_2` (`UserID`);

--
-- Indexes for table `Team`
--
ALTER TABLE `Team`
  ADD UNIQUE KEY `TeamID` (`TeamID`);

--
-- Indexes for table `TimeSlot`
--
ALTER TABLE `TimeSlot`
  ADD KEY `LinkID` (`LinkID`) USING BTREE;

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Event`
--
ALTER TABLE `Event`
  MODIFY `EventID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `SchedLink`
--
ALTER TABLE `SchedLink`
  MODIFY `LinkID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `Team`
--
ALTER TABLE `Team`
  MODIFY `TeamID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Event`
--
ALTER TABLE `Event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `MemberOf`
--
ALTER TABLE `MemberOf`
  ADD CONSTRAINT `memberof_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `memberof_ibfk_2` FOREIGN KEY (`TeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `PendingMemberOf`
--
ALTER TABLE `PendingMemberOf`
  ADD CONSTRAINT `pendingmemberof_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `SchedLink`
--
ALTER TABLE `SchedLink`
  ADD CONSTRAINT `schedlink_ibfk_1` FOREIGN KEY (`TeamID`) REFERENCES `Team` (`TeamID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `schedlink_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `User` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `TimeSlot`
--
ALTER TABLE `TimeSlot`
  ADD CONSTRAINT `timeslot_ibfk_1` FOREIGN KEY (`LinkID`) REFERENCES `SchedLink` (`LinkID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
