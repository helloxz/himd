-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-07-06 12:02:53
-- 服务器版本： 10.1.13-MariaDB
-- PHP Version: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `himd`
--

-- --------------------------------------------------------

--
-- 表的结构 `md_docs`
--

CREATE TABLE `md_docs` (
  `id` smallint(6) NOT NULL,
  `mail` char(64) NOT NULL,
  `title` char(100) NOT NULL,
  `utime` datetime NOT NULL,
  `fileid` char(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `user` char(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `md_user`
--

CREATE TABLE `md_user` (
  `id` smallint(6) NOT NULL,
  `ip` char(32) NOT NULL,
  `mail` char(128) NOT NULL,
  `passwd` char(128) NOT NULL,
  `regdate` datetime NOT NULL,
  `invite` char(64) DEFAULT NULL,
  `num` smallint(6) NOT NULL,
  `user` char(32) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `md_docs`
--
ALTER TABLE `md_docs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fileid` (`fileid`);

--
-- Indexes for table `md_user`
--
ALTER TABLE `md_user`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `md_docs`
--
ALTER TABLE `md_docs`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1008;
--
-- 使用表AUTO_INCREMENT `md_user`
--
ALTER TABLE `md_user`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1010;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
