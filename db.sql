-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: xxx
-- Generation Time: Apr 26, 2020 at 12:47 PM
-- Server version: 10.3.21-MariaDB-1:10.3.21+maria~bionic
-- PHP Version: 7.2.24-0ubuntu0.18.04.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `xxx`
--

-- --------------------------------------------------------

--
-- Table structure for table `entry`
--

CREATE TABLE `entry` (
  `entry_id` int(11) NOT NULL,
  `parent_entry_id` int(11) NOT NULL DEFAULT 0 COMMENT '0 if its on the root level otherwise refering to another entry in this table'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='table holding all the tree nodes';

--
-- Dumping data for table `entry`
--

INSERT INTO `entry` (`entry_id`, `parent_entry_id`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 9),
(5, 9),
(6, 9),
(7, 5),
(8, 5),
(9, 1),
(10, 1),
(11, 10),
(12, 11),
(13, 3),
(14, 2),
(15, 13),
(19, 13),
(17, 13),
(18, 5);

-- --------------------------------------------------------

--
-- Table structure for table `entry_lang`
--

CREATE TABLE `entry_lang` (
  `entry_id` int(11) NOT NULL,
  `lang` varchar(3) NOT NULL COMMENT 'language for the translation (eng/ger)',
  `name` varchar(255) NOT NULL COMMENT 'translated name for the given entry'
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='translation table for entry';

--
-- Dumping data for table `entry_lang`
--

INSERT INTO `entry_lang` (`entry_id`, `lang`, `name`) VALUES
(1, 'eng', 'Priority 1 Tasks'),
(2, 'eng', 'Priority 2 Tasks'),
(3, 'eng', 'Priority 3 Tasks'),
(1, 'ger', 'Priority 1 Aufgaben'),
(2, 'ger', 'Priority 2 Aufgaben'),
(3, 'ger', 'Priority 3 Aufgaben'),
(4, 'ger', 'Unternehmen ABC'),
(5, 'ger', 'Unternehmen CDE'),
(6, 'ger', 'Unternehmen EFG'),
(4, 'eng', 'Company ABC'),
(5, 'eng', 'Company CDE'),
(6, 'eng', 'Company EFG'),
(7, 'eng', 'Task 1'),
(8, 'eng', 'Task 2'),
(9, 'eng', 'Supplier'),
(10, 'eng', 'Customer'),
(11, 'eng', 'Company FGH'),
(12, 'eng', 'ID 300 Task'),
(13, 'eng', 'ID 400 Task'),
(14, 'eng', 'ID A12 Task'),
(15, 'eng', 'ID #32 Task'),
(19, 'eng', 'ID test1 Task'),
(17, 'eng', 'ID English Task'),
(18, 'eng', 'ID Other lang Task');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entry`
--
ALTER TABLE `entry`
  ADD PRIMARY KEY (`entry_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entry`
--
ALTER TABLE `entry`
  MODIFY `entry_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
