-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 18, 2020 at 11:26 AM
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
(1, 'hasan', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2020-07-11 11:33:00', 1, 'hasan', 'ghanbari', 0, '09101551518', '', '', 'grate', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'mohsen', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2020-07-27 10:25:28', 0, '', '', 0, '', '', '', '<div><br></div>', 1, 1, 1, 0, 1, 1, 1, 0, 1, 1, 1, 0),
(3, 'test', '81dc9bdb52d04dc20036dbd8313ed055', 1, '2020-08-12 04:56:58', 0, '', '', 0, '', '', '', '<div><br></div>', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

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
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 3, 1),
(5, 3, 2),
(9, 2, 3);

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
(5, 1, 3, 1, '', '5', 'Invite admin to collaborate on this task.', '', '0', '3', '', '', '', '', 0, '2020-07-11 11:33:00', '', '', '', 1, '2020-08-05', 0),
(6, 1, 3, 1, '', '6', 'Want updates on new features?', '<p dir=\"ltr\">Read our blog:<a href=\"%20http:/proja.aftab.cc/\" target=\"_blank\" rel=\"noopener\"> http://proja.aftab.cc/</a><br><br>Follow us on Google+: <a href=\"https://plus.google.com/+proja\" target=\"_blank\" rel=\"noopener\">https://plus.google.com/+proja</a><br><br>Like us on Facebook: <a href=\"https://www.facebook.com/proja\" target=\"_blank\" rel=\"noopener\">https://www.facebook.com/proja</a><br><br>Follow us on Twitter: <a href=\"http://twitter.com/proja\" target=\"_blank\" rel=\"noopener\">http://twitter.com/proja</a></p>', '0', '3', '', '', '', '', 0, '2020-07-11 11:33:00', '', '', '', 0, '0000-00-00', 0),
(11, 1, 1, 1, '', '', 'test2', '', '0', '0', '', '', '', '', 0, '2020-07-28 07:07:35', '', '', '', 1, '2020-07-28', 0),
(14, 1, 1, 1, NULL, NULL, 'مگه میشه', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-07-28 08:11:47', NULL, NULL, NULL, 1, '2020-08-04', 0),
(15, 1, 1, 1, NULL, NULL, 'این یک مساله تست است', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-08-05 05:43:43', NULL, NULL, NULL, NULL, NULL, 0),
(16, 1, 1, 1, NULL, NULL, 'مگه میشه. به این راحتی مساله اضافه کردم', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-08-05 05:47:02', NULL, NULL, NULL, 0, '0000-00-00', 0),
(17, 1, 1, 1, NULL, NULL, 'بیلسبلسبلسبقل', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-08-05 10:41:34', NULL, NULL, NULL, NULL, NULL, 0),
(18, 1, 1, 1, NULL, NULL, 'تست 5\n', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-08-05 10:42:12', NULL, NULL, NULL, NULL, NULL, 0),
(19, 1, 1, 3, NULL, NULL, 'تست', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, '2020-08-12 05:22:24', NULL, NULL, NULL, NULL, NULL, 0);

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
  `prjcode` varchar(255) COLLATE utf8_persian_ci NOT NULL COMMENT 'کد پروژه',
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
(1, '1', 'proja', 'این پروژه به صورت تست وارد شده', '-5843029.png', '#fd7e14', 'بخش فالپ', '2020-07-11 11:33:00', 1),
(2, '2', 'test', '', '', '#007bff', '', '2020-08-12 05:28:38', 1);

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
(1, 1, 1, '1', 'Getting Started', '<div><br></div>', '2020-07-11 11:33:00', 1, NULL),
(2, 1, 1, '2', 'Mastering Proja', '<div><br></div>', '2020-07-11 11:33:00', 0, NULL),
(3, 1, 1, '3', 'More Info', 'تست', '2020-07-11 11:33:00', 0, NULL),
(9, 2, 1, NULL, 'جدید', NULL, '2020-08-18 08:42:59', 0, NULL),
(10, 2, 1, NULL, 'خیلی جدید', NULL, '2020-08-18 08:43:14', 0, NULL),
(11, 2, 1, NULL, 'خیلی خیلی جدید', NULL, '2020-08-18 08:43:19', 0, NULL);

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
(5, 2, 5),
(6, 3, 6),
(13, 3, 15),
(14, 2, 16),
(15, 1, 17),
(16, 1, 18),
(17, 1, 19);

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
  MODIFY `atid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `issues`
--
ALTER TABLE `issues`
  MODIFY `iid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `issue_types`
--
ALTER TABLE `issue_types`
  MODIFY `tyid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `prjid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `tskid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tasks_issues`
--
ALTER TABLE `tasks_issues`
  MODIFY `tiid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

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
