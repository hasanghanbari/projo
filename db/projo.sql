-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 26, 2020 at 02:06 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projo`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `aid` int(11) NOT NULL,
  `ausername` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `apass` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `aactive` tinyint(1) NOT NULL DEFAULT 0,
  `aexpiration_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `asuper_admin` tinyint(1) NOT NULL DEFAULT 0,
  `afname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `alname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `agender` tinyint(1) NOT NULL DEFAULT 0,
  `atel` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `aemail` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `apic` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `acomments` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `allow_add_project` tinyint(1) NOT NULL DEFAULT 0,
  `allow_edit_project` tinyint(1) NOT NULL DEFAULT 0,
  `allow_list_project` tinyint(1) NOT NULL DEFAULT 0,
  `allow_delete_project` tinyint(1) NOT NULL DEFAULT 0,
  `allow_add_task` tinyint(1) NOT NULL DEFAULT 0,
  `allow_edit_task` tinyint(1) NOT NULL DEFAULT 0,
  `allow_list_task` tinyint(1) NOT NULL DEFAULT 0,
  `allow_delete_task` tinyint(1) NOT NULL DEFAULT 0,
  `allow_add_issues` tinyint(1) NOT NULL DEFAULT 0,
  `allow_edit_issues` tinyint(1) NOT NULL DEFAULT 0,
  `allow_list_issues` tinyint(1) NOT NULL DEFAULT 0,
  `allow_delete_issues` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`aid`, `ausername`, `apass`, `aactive`, `aexpiration_date`, `asuper_admin`, `afname`, `alname`, `agender`, `atel`, `aemail`, `apic`, `acomments`, `allow_add_project`, `allow_edit_project`, `allow_list_project`, `allow_delete_project`, `allow_add_task`, `allow_edit_task`, `allow_list_task`, `allow_delete_task`, `allow_add_issues`, `allow_edit_issues`, `allow_list_issues`, `allow_delete_issues`) VALUES
(1, 'admin', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2020-07-11 11:33:00', 1, 'admin', 'admin2', 0, '09101551518', '', '-7815956.jpg', 'grate', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `admins_tasks`
--

CREATE TABLE `admins_tasks` (
  `atid` int(11) NOT NULL,
  `aids` int(11) NOT NULL,
  `tskid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `admins_tasks`
--

INSERT INTO `admins_tasks` (`atid`, `aids`, `tskid`) VALUES
(9, 2, 3),
(47, 2, 3),
(49, 3, 26),
(51, 3, 3),
(52, 2, 3);

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `cid` int(11) NOT NULL,
  `ctext` text COLLATE utf8_persian_ci NOT NULL,
  `cdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`cid`, `ctext`, `cdate`) VALUES
(2, 'خیلی چیزها ولی روم نمیشه بگم\r\n', '2020-08-05 00:43:20');

-- --------------------------------------------------------

--
-- Table structure for table `issues`
--

CREATE TABLE `issues` (
  `iid` int(11) NOT NULL,
  `prjid` int(11) NOT NULL,
  `tyid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `iversion` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `icode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `ititle` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `idesc` text COLLATE utf8_persian_ci DEFAULT NULL,
  `iproirity` varchar(10) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'اهمیت',
  `icomplexity` varchar(1) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'پیچیدگی',
  `ineeded_time` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'زمان مورد نیاز',
  `ifile1` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `ifile2` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `ifile3` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL,
  `iarchive` tinyint(1) DEFAULT NULL,
  `idate` timestamp NOT NULL DEFAULT current_timestamp(),
  `iwho_fullname` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام پیشنهاد دهنده',
  `iwho_email` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'نام خانوادگی پیشنهاد دهنده',
  `iwho_tel` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'ایمیل پیشنهاد دهنده',
  `idone` tinyint(1) DEFAULT NULL,
  `idone_date` date DEFAULT NULL COMMENT 'تاریخ پایان',
  `idone_version` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'پایان پروژه'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `issues`
--

INSERT INTO `issues` (`iid`, `prjid`, `tyid`, `aid`, `iversion`, `icode`, `ititle`, `idesc`, `iproirity`, `icomplexity`, `ineeded_time`, `ifile1`, `ifile2`, `ifile3`, `iarchive`, `idate`, `iwho_fullname`, `iwho_email`, `iwho_tel`, `idone`, `idone_date`, `idone_version`) VALUES
(25, 6, 1, 1, '', NULL, 'aaaaaa', '', '1', '3', '', '', '', '', 0, '2020-08-24 08:12:14', '', '', '', 0, '2020-08-26', 0);

-- --------------------------------------------------------

--
-- Table structure for table `issue_types`
--

CREATE TABLE `issue_types` (
  `tyid` int(11) NOT NULL,
  `tycode` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `tytitle` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `tycomments` text COLLATE utf8_persian_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `issue_types`
--

INSERT INTO `issue_types` (`tyid`, `tycode`, `tytitle`, `tycomments`) VALUES
(1, '1', 'ایراد (Bugs)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>'),
(2, '2', 'قابلیت (Features)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>'),
(3, '3', 'پیشنهادات (Suggestions)', '<!DOCTYPE html>\r\n<html>\r\n<head>\r\n</head>\r\n<body>\r\n\r\n</body>\r\n</html>');

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `prjid` int(11) NOT NULL,
  `prjcode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد پروژه',
  `prjtitle` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان پروژه',
  `prjdesc` text COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `prjlogo` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'لوگو محصول',
  `bg_color` text COLLATE utf8_persian_ci NOT NULL,
  `prjcomments` text COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'توضیحات',
  `prjdate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'زمان ثبت',
  `aid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`prjid`, `prjcode`, `prjtitle`, `prjdesc`, `prjlogo`, `bg_color`, `prjcomments`, `prjdate`, `aid`) VALUES
(6, NULL, 'test3', '', '-8089051.png', '#6f42c1', NULL, '2020-08-22 09:37:31', 1),
(8, NULL, 'سریر', '', '', '#17a2b8', NULL, '2020-08-26 07:07:08', 1),
(9, NULL, 'test2', '', NULL, '#fd7e14', NULL, '2020-08-26 07:08:22', 3),
(10, NULL, 'test3', '', NULL, '#fd7e14', NULL, '2020-08-26 07:09:15', 3),
(11, NULL, 'test4', '', '', '#fd7e14', NULL, '2020-08-26 07:09:47', 3),
(12, NULL, 'test5', '', '', '#fd7e14', NULL, '2020-08-26 07:25:03', 3),
(13, NULL, 'test6', '', '', '#fd7e14', NULL, '2020-08-26 07:29:05', 3),
(14, NULL, 'test7', '', '', '#28a745', NULL, '2020-08-26 07:31:15', 1);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `system_title` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `language` varchar(255) COLLATE utf8_persian_ci NOT NULL,
  `direction` tinyint(1) NOT NULL DEFAULT 0,
  `theme` varchar(255) COLLATE utf8_persian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `system_title`, `language`, `direction`, `theme`) VALUES
(1, 'projo', 'farsi', 1, '2020');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `tskid` int(11) NOT NULL,
  `prjid` int(11) NOT NULL,
  `aid` int(11) NOT NULL,
  `tskcode` varchar(255) COLLATE utf8_persian_ci DEFAULT NULL COMMENT 'کد',
  `tsktitle` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'عنوان',
  `tskdesc` text COLLATE utf8_persian_ci DEFAULT NULL,
  `tskdate` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'تاریخ درج',
  `tskdone` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'پایان',
  `tskdone_date` date DEFAULT NULL COMMENT 'تاریخ پایان'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`tskid`, `prjid`, `aid`, `tskcode`, `tsktitle`, `tskdesc`, `tskdate`, `tskdone`, `tskdone_date`) VALUES
(3, 6, 1, '3', 'More Info', 'تست', '2020-07-11 11:33:00', 0, NULL),
(24, 12, 3, NULL, 'در حال توسعه', '', '2020-08-26 07:25:03', 1, '2020-08-26'),
(25, 13, 3, NULL, 'در حال توسعه', NULL, '2020-08-26 07:29:05', 0, NULL),
(26, 14, 3, NULL, 'در حال توسعه', NULL, '2020-08-26 07:31:15', 0, NULL),
(28, 8, 1, NULL, 'جدید', NULL, '2020-08-26 07:44:50', 0, NULL),
(29, 6, 1, NULL, 'جدید', NULL, '2020-08-26 10:43:22', 0, NULL),
(30, 6, 1, NULL, 'خیلی جدید', NULL, '2020-08-26 11:12:36', 0, NULL),
(31, 6, 1, NULL, 'خیلی خیلی جدید', NULL, '2020-08-26 11:12:40', 0, NULL),
(32, 6, 1, NULL, 'جدید 2', NULL, '2020-08-26 11:12:44', 0, NULL),
(33, 6, 1, NULL, 'جدید 3', NULL, '2020-08-26 11:12:50', 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tasks_issues`
--

CREATE TABLE `tasks_issues` (
  `tiid` int(11) NOT NULL,
  `tskid` int(11) NOT NULL,
  `iid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

--
-- Dumping data for table `tasks_issues`
--

INSERT INTO `tasks_issues` (`tiid`, `tskid`, `iid`) VALUES
(23, 3, 25),
(24, 3, 26),
(25, 3, 27),
(31, 28, 33);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `admins_tasks`
--
ALTER TABLE `admins_tasks`
  ADD PRIMARY KEY (`atid`),
  ADD KEY `aid` (`aids`),
  ADD KEY `tskid` (`tskid`),
  ADD KEY `aids` (`aids`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `issues`
--
ALTER TABLE `issues`
  ADD PRIMARY KEY (`iid`),
  ADD KEY `tyid` (`tyid`),
  ADD KEY `prjid` (`prjid`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `issue_types`
--
ALTER TABLE `issue_types`
  ADD PRIMARY KEY (`tyid`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`prjid`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`tskid`),
  ADD KEY `prjid` (`prjid`),
  ADD KEY `aid` (`aid`);

--
-- Indexes for table `tasks_issues`
--
ALTER TABLE `tasks_issues`
  ADD PRIMARY KEY (`tiid`),
  ADD KEY `tskid` (`tskid`),
  ADD KEY `iid` (`iid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `admins_tasks`
--
ALTER TABLE `admins_tasks`
  MODIFY `atid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `issue_types`
--
ALTER TABLE `issue_types`
  MODIFY `tyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `prjid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `tasks_issues`
--
ALTER TABLE `tasks_issues`
  MODIFY `tiid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admins_tasks`
--
ALTER TABLE `admins_tasks`
  ADD CONSTRAINT `at_aids_fk` FOREIGN KEY (`aids`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `at_tskid_fk` FOREIGN KEY (`tskid`) REFERENCES `tasks` (`tskid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `issues`
--
ALTER TABLE `issues`
  ADD CONSTRAINT `issue_prjid_fk` FOREIGN KEY (`prjid`) REFERENCES `projects` (`prjid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `issues_tyid_fk` FOREIGN KEY (`tyid`) REFERENCES `issue_types` (`tyid`) ON UPDATE CASCADE;

--
-- Constraints for table `projects`
--
ALTER TABLE `projects`
  ADD CONSTRAINT `project_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `task_aid_fk` FOREIGN KEY (`aid`) REFERENCES `admins` (`aid`) ON UPDATE CASCADE,
  ADD CONSTRAINT `task_prjid_fk` FOREIGN KEY (`prjid`) REFERENCES `projects` (`prjid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks_issues`
--
ALTER TABLE `tasks_issues`
  ADD CONSTRAINT `ti_iid_fk` FOREIGN KEY (`iid`) REFERENCES `issues` (`iid`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `ti_tskid_fk` FOREIGN KEY (`tskid`) REFERENCES `tasks` (`tskid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
