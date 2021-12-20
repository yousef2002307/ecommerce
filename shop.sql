-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 20, 2021 at 12:46 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.3.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `catagories`
--

CREATE TABLE `catagories` (
  `ID` int(11) NOT NULL,
  `NAME` varchar(255) NOT NULL,
  `DESCRIPTION` text NOT NULL,
  `ORDERING` int(11) NOT NULL,
  `VISIBLITY` tinyint(4) NOT NULL DEFAULT 0,
  `ALLOW_COMMENT` tinyint(4) NOT NULL DEFAULT 0,
  `ALLOW_ADS` tinyint(4) NOT NULL DEFAULT 0,
  `parent` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `catagories`
--

INSERT INTO `catagories` (`ID`, `NAME`, `DESCRIPTION`, `ORDERING`, `VISIBLITY`, `ALLOW_COMMENT`, `ALLOW_ADS`, `parent`) VALUES
(10, 'computers', 'this computer description', 1, 0, 0, 0, 0),
(11, 'tools', 'this tools section', 2, 1, 0, 1, 0),
(12, 'cell phpnes', 'this is cell phones man', 3, 1, 1, 1, 0),
(13, 'Hand Made', 'this is hand made section', 4, 1, 1, 1, 0),
(14, 'clothing', 'this is clothing section', 5, 0, 0, 0, 0),
(15, 'NOKIA', 'tgkkfkgkl;fg ggfkl;gkl;g', 4, 0, 0, 0, 12);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `c_id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `adddate` date NOT NULL,
  `item_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`c_id`, `comment`, `status`, `adddate`, `item_id`, `user_id`) VALUES
(4, 'tteeuuyeu ejdsdjjhdf fdjdfshdf dfjdfhjkfdhff fjkdhdfdfb df dfdjfkhfds', 1, '2021-11-09', 6670, 979),
(6, 'dfdfjkdjklf dfjdshdsfldsf  fdsklsdflkf', 1, '2021-11-01', 6671, 984),
(10, 'gfgjkfgjk fd jgjkfklkljjkjk kjgfdlflgjklfg', 1, '2021-07-12', 6670, 977),
(8347, 'this is comment', 1, '2021-11-17', 6669, 54),
(8348, 'fsdsdfsfd', 1, '2021-12-03', 6669, 565),
(8349, 'sdfdsfdfs', 1, '2021-12-03', 6669, 565),
(8350, 'hello new comments man', 1, '2021-12-03', 6669, 565),
(8351, 'fhdfjjhdfjjk kfjdsdjkjjhdfjhfddf lorem', 1, '2021-12-04', 6671, 54),
(8352, 'hkdkdfd lorem man', 1, '2021-12-04', 6669, 565),
(8353, 'hkdkdfd lorem man', 1, '2021-12-04', 6669, 565),
(8354, 'hkdkdfd lorem man', 1, '2021-12-04', 6669, 565),
(8355, 'gfhghghghfg', 1, '2021-12-04', 6669, 565),
(8356, 'gfgdfgf', 1, '2021-12-04', 6669, 565),
(8357, 'dfdfsdfsd dfsfddff', 1, '2021-12-04', 6669, 565),
(8358, 'gtfggdfdf', 1, '2021-12-04', 6669, 565),
(8359, 'hghhj', 1, '2021-12-04', 6669, 565),
(8360, 'hghhj', 1, '2021-12-04', 6669, 54),
(8361, 'ghgghghghgh man yousef', 1, '2021-12-04', 6669, 54),
(8362, 'f;flg g fl;gkkl;gfg', 1, '2021-12-05', 6677, 54),
(8363, 'jhdfjhsdfjfjkddfs ffd,dfs.', 0, '2021-12-08', 6668, 54),
(8364, ' uiuiiuuiyiu', 0, '2021-12-09', 44, 54),
(8365, ' uiuiiuuiyiu', 1, '2021-12-09', 44, 54),
(8366, ' llkllk', 1, '2021-12-09', 44, 54),
(8367, ' llkllk', 0, '2021-12-09', 44, 54),
(8369, ' o;;llkoiiokjkkjjjjjjjjjjjjjjkjjjjjjj', 1, '2021-12-09', 44, 54),
(8370, ' gkkglklhgkl;g gh', 1, '2021-12-09', 6671, 54),
(8371, ' flkdfkl;fgkl;fg', 1, '2021-12-09', 6670, 54),
(8372, ' i am yousef neigga', 1, '2021-12-09', 6670, 54),
(8373, ' my man jo', 1, '2021-12-09', 6669, 54),
(8374, 'samira husssien', 0, '2021-12-09', 44, 54),
(8375, ' mahmoud a ya mahmoud', 0, '2021-12-09', 6674, 54),
(8376, 'mahmoud ada ya mahmoud', 0, '2021-12-09', 44, 54);

-- --------------------------------------------------------

--
-- Table structure for table `item`
--

CREATE TABLE `item` (
  `itemid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `des` text NOT NULL,
  `price` varchar(255) NOT NULL,
  `adddate` date NOT NULL,
  `country` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `rating` smallint(6) NOT NULL,
  `cat_id` int(11) NOT NULL,
  `USERID` int(11) NOT NULL,
  `approve` tinyint(4) NOT NULL DEFAULT 0,
  `tags` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `item`
--

INSERT INTO `item` (`itemid`, `name`, `des`, `price`, `adddate`, `country`, `image`, `status`, `rating`, `cat_id`, `USERID`, `approve`, `tags`) VALUES
(44, 'balls', 'fkgk;kl;gh hkhylkl;hy', '5544', '2021-11-18', 'mali', '', 'new', 0, 12, 54, 1, 'sasjkladjk,dsjdjsdj,sksklsakl,slsals,me'),
(6668, 'speaker', 'very good', '10', '2021-11-12', 'china', '', '1', 0, 12, 979, 1, 'slsls'),
(6669, 'spoons', '', '332', '2021-11-12', 'china', '', '2', 0, 14, 565, 1, 'me,'),
(6670, 'cars be', 'bad and good', '4455', '2021-11-12', 'mali', '', '3', 0, 10, 981, 1, ''),
(6671, 'mailing', 'very good', '32', '2021-11-12', 'mali', '', '1', 0, 10, 54, 0, ''),
(6672, 'game', 'sdggdg', '435', '2021-11-23', 'egypt', '', '3', 0, 11, 54, 0, ''),
(6673, 'gameofplaying', 'amaizing section if you ever think of what', '232', '2021-11-23', 'egypt', '', '3', 0, 12, 54, 0, ''),
(6674, 'sghdfjhdf', 'gffgfgfgj', '3', '2021-12-03', 'egypt', '', '2', 0, 14, 54, 1, ''),
(6675, 'new added', 'gffgfgfgj', '323', '2021-12-03', 'egypt', '', '3', 0, 12, 54, 1, ''),
(6676, 'planes', 'planes are aweasom to fly by', '234', '2021-12-04', 'gambia', '', '1', 0, 13, 993, 1, ''),
(6677, 'sghdfjhdfuyytyt', 'gfjjklgjklfjklklfg fgklgjkl', '444', '2021-12-05', 'gahna', '', '3', 0, 14, 54, 1, ''),
(6678, 'cxzxczxcz', 'fsdsfsdfdf', '3233', '2021-12-16', 'gambia', '', '3', 0, 14, 988, 0, '[{\"value\":\"fvccxv\"},{\"value\":\"dsdjds\"}]'),
(6679, 'yweywuwu', 'fgg gfgfgf', '323', '2021-12-16', 'masr', '', '1', 0, 12, 979, 0, 'vfdcvffd,djsjkdsjkdls,sksjklsa'),
(6680, 'newitem', 'fggfg', '422', '2021-12-17', 'palestaine', '', '1', 0, 14, 54, 0, ''),
(6681, 'newestitem', 'fggfg', '22', '2021-12-17', 'gambia', '', '2', 0, 11, 54, 0, ''),
(6682, 'fsddjkfdfsjjkls', 'dfdskdsfjkdfsjkl', '4747', '2021-12-17', 'palestaine', '', '3', 0, 11, 54, 0, 'sdjsdaj,dsksdajksdkja,slsls');

-- --------------------------------------------------------

--
-- Table structure for table `shop`
--

CREATE TABLE `shop` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `groupid` int(11) NOT NULL DEFAULT 0,
  `truststatus` int(11) NOT NULL DEFAULT 0,
  `regstatus` int(11) NOT NULL DEFAULT 0,
  `date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `shop`
--

INSERT INTO `shop` (`userid`, `username`, `password`, `email`, `fullname`, `groupid`, `truststatus`, `regstatus`, `date`) VALUES
(54, 'yousef', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'yousif20022008@yahoo.com', 'yousef ahmed farag salman', 1, 0, 1, '2021-10-19 00:00:00'),
(565, 'fgfgfgfg', 'fgfgfgfg', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-01 00:00:00'),
(566, 'erwerwwerwer', 'a35d6ef0e02fd54169d24cb2cb6c9c2dbb819264', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-01 00:00:00'),
(567, 'ytttttttthhgf', 'c32a3e6af4c94a4b50bc18dcb6eeae0cfa204eae', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-01 00:00:00'),
(977, 'ssfdfsdf', 'c7a3f545aebb01815b8b3aee992609ff35d4ce33', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-03 00:00:00'),
(979, 'ramy', '4f08bff5c4335bfcc4ef05fba228655ac4da94ce', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-03 00:00:00'),
(980, 'gmlgkl;ghk', '183f65fc19d9077b791121ed5f5366ec6c524f0b', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-03 00:00:00'),
(981, '4FSDFSDSDF', '5f84a516058d10099f7c5cebbf36ec771991eab2', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-03 20:44:53'),
(982, 'YYYUYUs', '123YYYUYU', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-03 20:45:07'),
(983, 'bauomi', 'aa0b47b8f74a06489d9ee3903670ad2813ce946d', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-14 14:52:46'),
(984, 'samira', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'mmnwat6@gmail.com', 'yousef ahmed', 0, 0, 1, '2021-11-14 15:06:23'),
(985, 'bagami', 'db2a2d0a3c9992fa8b47f205df8c997ef90e1e5d', 'mddfsm@yahoo.com', 'eefwefefw', 0, 0, 1, '2021-11-16 15:46:13'),
(986, 'yousef555553', '5b6892facdc1b53a3f4beeab28acbbf161509366', 'yousif20022008@yahoo.com', '', 0, 0, 1, '2021-11-21 20:49:19'),
(987, 'turki', 'ae50cc6d880890467efff5c74a6eb4f34f1ce731', 'yousif2002205508@yahoo.com', '', 0, 0, 0, '2021-11-21 20:50:22'),
(988, 'yousef565665', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'yousif20022008@yahoo.com', '', 0, 0, 0, '2021-12-04 18:41:58'),
(989, 'yousef533232', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'yousif20022008@yahoo.com', '', 0, 0, 0, '2021-12-04 18:44:57'),
(991, 'yousef5332321', '2e8c0277e396fabf683e56c8b7fa7e6dad68c679', 'yousif20022008@yahoo.com', '', 0, 0, 0, '2021-12-04 18:45:32'),
(992, 'kamal', '527dc687fa586a676045bc4cf16cb04ba5ff58eb', 'yousif20022008@yahoo.com', '', 0, 0, 1, '2021-12-04 18:47:06'),
(993, 'turki2', 'fea7f657f56a2a448da7d4b535ee5e279caf3d9a', 'yousif20022008@yahoo.com', '', 0, 0, 0, '2021-12-04 18:55:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `catagories`
--
ALTER TABLE `catagories`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `catgnames` (`NAME`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`c_id`),
  ADD KEY `j0987` (`item_id`),
  ADD KEY `j0987443` (`user_id`);

--
-- Indexes for table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`itemid`),
  ADD UNIQUE KEY `ghf` (`name`),
  ADD KEY `jo11` (`USERID`),
  ADD KEY `jo12` (`cat_id`);

--
-- Indexes for table `shop`
--
ALTER TABLE `shop`
  ADD PRIMARY KEY (`userid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `catagories`
--
ALTER TABLE `catagories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8377;

--
-- AUTO_INCREMENT for table `item`
--
ALTER TABLE `item`
  MODIFY `itemid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6683;

--
-- AUTO_INCREMENT for table `shop`
--
ALTER TABLE `shop`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=994;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `j0987` FOREIGN KEY (`item_id`) REFERENCES `item` (`itemid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `j0987443` FOREIGN KEY (`user_id`) REFERENCES `shop` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item`
--
ALTER TABLE `item`
  ADD CONSTRAINT `jo11` FOREIGN KEY (`USERID`) REFERENCES `shop` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `jo12` FOREIGN KEY (`cat_id`) REFERENCES `catagories` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
