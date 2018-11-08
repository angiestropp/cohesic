# ==============================================================================
# Name: Angie Stropp
# URL: http://www.angiestropp.com
# ==============================================================================
-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 08, 2018 at 02:16 PM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angiestropp`
--

-- --------------------------------------------------------

--
-- Table structure for table `level1`
--

CREATE TABLE `level1` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `checked` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `hasChild` int(11) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level1`
--

INSERT INTO `level1` (`id`, `title`, `checked`, `level`, `hasChild`, `parentId`) VALUES
(1, 'Chest', 0, 1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `level2`
--

CREATE TABLE `level2` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `checked` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `hasChild` int(11) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level2`
--

INSERT INTO `level2` (`id`, `title`, `checked`, `level`, `hasChild`, `parentId`) VALUES
(1, 'Lungs', 0, 2, 1, 1),
(2, 'Heart', 0, 2, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `level3`
--

CREATE TABLE `level3` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `checked` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `hasChild` int(11) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level3`
--

INSERT INTO `level3` (`id`, `title`, `checked`, `level`, `hasChild`, `parentId`) VALUES
(1, 'Right Lung', 0, 3, 1, 1),
(2, 'Left Lung', 0, 3, 1, 1),
(3, 'Left Ventricle', 0, 3, 0, 2),
(4, 'Right Ventricle', 0, 3, 0, 2),
(5, 'Left Atrium', 0, 3, 0, 2),
(6, 'Right Atrium', 0, 3, 0, 2),
(7, 'Septum', 0, 3, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `level4`
--

CREATE TABLE `level4` (
  `id` int(11) NOT NULL,
  `title` varchar(30) NOT NULL,
  `checked` int(11) NOT NULL,
  `level` int(11) NOT NULL,
  `hasChild` int(11) NOT NULL,
  `parentId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `level4`
--

INSERT INTO `level4` (`id`, `title`, `checked`, `level`, `hasChild`, `parentId`) VALUES
(1, 'Superior Lobe', 0, 4, 0, 1),
(2, 'Middle Lobe', 0, 4, 0, 1),
(3, 'Inferior Lobe', 0, 4, 0, 1),
(4, 'Superior Lobe', 0, 4, 0, 2),
(5, 'Inferior Lobe', 0, 4, 0, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `level1`
--
ALTER TABLE `level1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level2`
--
ALTER TABLE `level2`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level3`
--
ALTER TABLE `level3`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `level4`
--
ALTER TABLE `level4`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `level1`
--
ALTER TABLE `level1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `level2`
--
ALTER TABLE `level2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `level3`
--
ALTER TABLE `level3`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `level4`
--
ALTER TABLE `level4`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
