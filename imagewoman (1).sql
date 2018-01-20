-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: May 30, 2016 at 02:10 PM
-- Server version: 5.6.13
-- PHP Version: 5.5.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `imagewoman`
--
CREATE DATABASE IF NOT EXISTS `imagewoman` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `imagewoman`;

-- --------------------------------------------------------

--
-- Stand-in structure for view `compname`
--
CREATE TABLE IF NOT EXISTS `compname` (
`isopen` tinyint(3) unsigned
,`did` int(11)
,`cname` char(250)
,`cid` int(10) unsigned
,`dname` char(50)
,`dfamily` char(50)
,`username` char(25)
,`cisopen` tinyint(3) unsigned
,`clevel` varchar(15)
,`cstartdate` bigint(20)
,`cenddate` bigint(20)
,`cdecription` varchar(1000)
,`cprise` varchar(500)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `forbaz`
--
CREATE TABLE IF NOT EXISTS `forbaz` (
`bazid` int(11)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`isavatar` tinyint(3) unsigned
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
,`username` char(50)
,`family` char(50)
,`uname` char(25)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `foridx`
--
CREATE TABLE IF NOT EXISTS `foridx` (
`name` char(50)
,`family` char(50)
,`username` char(25)
,`id` int(11)
,`did` int(11)
,`compid` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `isnotok`
--
CREATE TABLE IF NOT EXISTS `isnotok` (
`bazid` int(11)
,`isavatar` tinyint(3) unsigned
,`uf` char(50)
,`un` char(50)
,`rateid` int(11)
,`bazbinid` int(11)
,`imgid` int(11)
,`bbcom` varchar(150)
,`isok` tinyint(1)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
,`username` char(25)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `isok`
--
CREATE TABLE IF NOT EXISTS `isok` (
`bazid` int(11)
,`isavatar` tinyint(3) unsigned
,`uf` char(50)
,`un` char(50)
,`rateid` int(11)
,`bazbinid` int(11)
,`imgid` int(11)
,`bbcom` varchar(150)
,`isok` tinyint(1)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`username` char(25)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `notinbazrate`
--
CREATE TABLE IF NOT EXISTS `notinbazrate` (
`bazid` int(11)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `notview`
--
CREATE TABLE IF NOT EXISTS `notview` (
`un` char(50)
,`isavatar` tinyint(3) unsigned
,`username` char(25)
,`uf` char(50)
,`bazid` int(11)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `photconf`
--
CREATE TABLE IF NOT EXISTS `photconf` (
`pid` int(10) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pdate` char(10)
,`comment` char(250)
,`confirm` tinyint(3) unsigned
,`uname` char(50)
,`uf` char(50)
,`username` char(25)
,`isavatar` tinyint(3) unsigned
,`cname` char(250)
,`compid` int(10) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `photosearch`
--
CREATE TABLE IF NOT EXISTS `photosearch` (
`cid` int(10) unsigned
,`numofpic` int(11)
,`startdate` bigint(20)
,`enddate` bigint(20)
,`imglike` decimal(10,2)
,`tags` char(100)
,`username` char(25)
,`pid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pcmt` char(250)
,`pdate` char(10)
,`uname` char(50)
,`uf` char(50)
,`isavatar` tinyint(3) unsigned
,`cname` char(250)
,`ispeopel` smallint(6)
,`locate` char(30)
,`locateid` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `photowin`
--
CREATE TABLE IF NOT EXISTS `photowin` (
`refrate` decimal(10,1)
,`pid` int(10) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pdate` char(10)
,`uname` char(50)
,`uf` char(50)
,`isavatar` tinyint(3) unsigned
,`cname` char(250)
,`cmpid` int(10) unsigned
,`comment` char(250)
);
-- --------------------------------------------------------

--
-- Table structure for table `tbl_about`
--

CREATE TABLE IF NOT EXISTS `tbl_about` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `aboutus` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_about`
--

INSERT INTO `tbl_about` (`id`, `aboutus`) VALUES
(1, 'متن درباره ما');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_active`
--

CREATE TABLE IF NOT EXISTS `tbl_active` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `activecode` char(32) NOT NULL,
  `activtime` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_activecod`
--

CREATE TABLE IF NOT EXISTS `tbl_activecod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(11) NOT NULL,
  `activecod` varchar(11) NOT NULL,
  `activtime` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tbl_activecod`
--

INSERT INTO `tbl_activecod` (`id`, `mobile`, `activecod`, `activtime`) VALUES
(12, '09358891888', '463606', 1462271335);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bazbinrate`
--

CREATE TABLE IF NOT EXISTS `tbl_bazbinrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bazbinid` int(11) NOT NULL,
  `imgid` int(11) NOT NULL,
  `isok` tinyint(1) NOT NULL COMMENT '0:reject,1:ok,2:ok bazbin nahaee,3:not ok bazbin nahaee',
  `comment` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_bazbinrate`
--

INSERT INTO `tbl_bazbinrate` (`id`, `bazbinid`, `imgid`, `isok`, `comment`) VALUES
(11, 89, 13, 1, NULL),
(12, 89, 12, 1, NULL),
(13, 89, 9, 1, NULL),
(14, 89, 14, 1, NULL),
(15, 89, 11, 1, NULL),
(16, 89, 8, 1, NULL),
(17, 89, 1, 1, NULL),
(18, 89, 7, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_bazcomp`
--

CREATE TABLE IF NOT EXISTS `tbl_bazcomp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bid` int(11) NOT NULL COMMENT 'fk to tbl_usres',
  `compid` int(11) NOT NULL COMMENT 'fk to tbl_comp',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_bazcomp`
--

INSERT INTO `tbl_bazcomp` (`id`, `bid`, `compid`) VALUES
(1, 89, 1),
(2, 89, 2),
(3, 89, 3),
(4, 89, 4),
(5, 89, 5),
(6, 89, 6),
(7, 89, 7),
(8, 89, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_comp`
--

CREATE TABLE IF NOT EXISTS `tbl_comp` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(250) NOT NULL,
  `decription` varchar(1000) NOT NULL,
  `isopen` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `publishend` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1: no need to assign again',
  `level` varchar(15) NOT NULL,
  `startdate` bigint(20) NOT NULL,
  `enddate` bigint(20) NOT NULL,
  `numofpic` int(11) NOT NULL DEFAULT '0',
  `prise` varchar(500) NOT NULL,
  `winno` smallint(6) NOT NULL,
  `selno` smallint(6) NOT NULL COMMENT 'tedade montakhab',
  `davarino` smallint(6) NOT NULL COMMENT 'can send to davari step',
  `peopelwinno` smallint(6) NOT NULL DEFAULT '0',
  `peoplewinprise` varchar(500) DEFAULT NULL,
  `hasposter` tinyint(4) DEFAULT '0' COMMENT '=1: has poster',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_comp`
--

INSERT INTO `tbl_comp` (`id`, `name`, `decription`, `isopen`, `publishend`, `level`, `startdate`, `enddate`, `numofpic`, `prise`, `winno`, `selno`, `davarino`, `peopelwinno`, `peoplewinprise`, `hasposter`) VALUES
(3, 'تست من', 'برای توضیح', 3, 1, 'حرفه ای', 1455568200, 1455740999, 14, 'ندارد', 2, 6, 8, 2, 'ندارد', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_contact`
--

CREATE TABLE IF NOT EXISTS `tbl_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(100) NOT NULL,
  `tell` varchar(20) NOT NULL,
  `fax` varchar(20) NOT NULL,
  `mail` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_contact`
--

INSERT INTO `tbl_contact` (`id`, `address`, `tell`, `fax`, `mail`) VALUES
(1, 'ایران-تهران', '021-1111111111', '021-111111111111', 'info@test.commmmmmm');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_copyright`
--

CREATE TABLE IF NOT EXISTS `tbl_copyright` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rules` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_copyright`
--

INSERT INTO `tbl_copyright` (`id`, `rules`, `comment`) VALUES
(1, 'حقوق 1', 'متن حقوق 1'),
(2, 'حقوق 2', 'متن حقوق 2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_davarcomp`
--

CREATE TABLE IF NOT EXISTS `tbl_davarcomp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `did` int(11) NOT NULL,
  `compid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `tbl_davarcomp`
--

INSERT INTO `tbl_davarcomp` (`id`, `did`, `compid`) VALUES
(1, 88, 1),
(2, 88, 2),
(3, 88, 3),
(4, 88, 4),
(5, 88, 5),
(6, 88, 6),
(7, 88, 7),
(8, 88, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_deactivecode`
--

CREATE TABLE IF NOT EXISTS `tbl_deactivecode` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) unsigned NOT NULL,
  `deccode` char(32) NOT NULL,
  `acttinme` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_files`
--

CREATE TABLE IF NOT EXISTS `tbl_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `comment` text NOT NULL,
  `extention` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_follow`
--

CREATE TABLE IF NOT EXISTS `tbl_follow` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `fid` int(10) unsigned NOT NULL COMMENT 'follower id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_follow`
--

INSERT INTO `tbl_follow` (`id`, `userid`, `fid`) VALUES
(1, 1, 88),
(2, 89, 88);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_formcontact`
--

CREATE TABLE IF NOT EXISTS `tbl_formcontact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `tell` varchar(20) DEFAULT NULL,
  `mobile` varchar(20) NOT NULL,
  `mail` varchar(50) DEFAULT NULL,
  `message` varchar(300) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'unread:0,read:1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_formcontact`
--

INSERT INTO `tbl_formcontact` (`id`, `name`, `tell`, `mobile`, `mail`, `message`, `status`) VALUES
(1, 'امینق', '6065165', '09131234567', 'a@dd.com', 'klsdjflksaj', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_method`
--

CREATE TABLE IF NOT EXISTS `tbl_method` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruls` varchar(20) NOT NULL,
  `message` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tbl_method`
--

INSERT INTO `tbl_method` (`id`, `ruls`, `message`) VALUES
(2, '1', '1'),
(3, '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notify`
--

CREATE TABLE IF NOT EXISTS `tbl_notify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `href` varchar(200) DEFAULT NULL,
  `ndate` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59 ;

--
-- Dumping data for table `tbl_notify`
--

INSERT INTO `tbl_notify` (`id`, `text`, `href`, `ndate`) VALUES
(1, 'مسابقه تست بانوان آغاز شد.', 'comp/id/1', '۱۷:۱۵ | چهارشنبه, ۲۱ بهمن ۱۳۹۴'),
(2, 'مسابقه bgfgfvg آغاز شد.', 'comp/id/2', '۰۹:۲۸ | پنجشنبه, ۲۲ بهمن ۱۳۹۴'),
(3, 'مسابقه تست من آغاز شد.', 'comp/id/3', '۱۲:۲۲ | شنبه, ۱ اسفند ۱۳۹۴'),
(4, 'ممد بلدی فروشانی شما را دنبال می کند', 'blog/id/1', '۱ اسفند ۱۳۹۴'),
(5, 'zahra شما را دنبال می کند', 'blog/id/89', '۱ اسفند ۱۳۹۴'),
(6, 'مسابقه تست من به پایان رسید.', 'comp/id/3', '۹۴-۱۲-۰۱'),
(7, 'مسابقه تست من به پایان رسید.', 'comp/id/3', '۹۴-۱۲-۰۱'),
(8, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(9, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(10, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(11, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(12, 'عکس "گلدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(13, 'عکس "آقادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(14, 'عکس "پلیکاندر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(15, 'عکس "امامدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(16, 'عکس "گل های زیبادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(17, 'عکس "گویدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(18, 'عکس "شیپوریدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(19, 'عکس "دارکوبدر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(20, 'عکس "گلدر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(21, 'عکس "شیپوریدر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(22, 'عکس "هواپیمادر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(23, 'مسابقه تست من به پایان رسید.', 'comp/id/3', '۹۴-۱۲-۰۱'),
(24, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(25, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(26, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(27, 'عکس "هواپیمادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(28, 'عکس "گل های زیبادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(29, 'عکس "گویدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(30, 'عکس "شیپوریدر مسابقه "تست من" رتبه  را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(31, 'عکس "هواپیمادر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(32, 'عکس "هواپیمادر مسابقه "تست من" رتبه hhhh را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(33, 'عکس "امامدر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(34, 'عکس "دارکوبدر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(35, 'مسابقه تست من به پایان رسید.', 'comp/id/3', '۹۴-۱۲-۰۱'),
(36, 'عکس "هواپیمادر مسابقه "تست من" رتبه ttt را در بخش داوریکسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(37, 'عکس "آقادر مسابقه "تست من"  منتخب بخش داوری شد', NULL, '۹۴-۱۲-۰۱'),
(38, 'عکس "دارکوبدر مسابقه "تست من" رتبه  را در بخش مسابقه مردمی کسب کرد.', NULL, '۹۴-۱۲-۰۱'),
(39, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(40, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(41, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(42, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(43, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(44, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(45, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(46, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(47, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(48, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(49, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(50, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(51, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(52, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(53, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(54, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(55, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(56, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(57, 'امین قاضی شما را دنبال می کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵'),
(58, 'امین قاضی شما را دنبال نمی کند', 'blog/id/88', '۱۳ اردیبهشت ۱۳۹۵');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_photos`
--

CREATE TABLE IF NOT EXISTS `tbl_photos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(10) unsigned NOT NULL,
  `name` char(150) NOT NULL,
  `comment` char(250) DEFAULT NULL,
  `locate` varchar(150) NOT NULL,
  `tags` char(100) DEFAULT NULL,
  `date` char(10) DEFAULT NULL,
  `compid` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `refrate` decimal(10,1) DEFAULT '0.0',
  `iswin` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `bazid` int(11) NOT NULL DEFAULT '0' COMMENT 'fk tbl_users(isadmin=3)',
  `imglike` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `tbl_photos`
--

INSERT INTO `tbl_photos` (`id`, `userid`, `name`, `comment`, `locate`, `tags`, `date`, `compid`, `confirm`, `refrate`, `iswin`, `bazid`, `imglike`) VALUES
(1, 1, 'هواپیما', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',هواپیما,', '1455827400', 3, 1, '10.0', 1, 89, '7.33'),
(2, 1, 'روباه', 'نداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',روباه,', '1455827400', 3, 1, '0.0', 0, 89, '1.67'),
(3, 1, 'پنگوئن', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',پنگوئن,', '1455827400', 3, 1, '0.0', 0, 89, '6.00'),
(4, 1, 'کانگورو', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', '', '1455827400', 3, 1, '0.0', 0, 89, '7.50'),
(5, 88, 'دارکوب', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',دارکوب,', '1455827400', 3, 1, '0.0', 3, 89, '7.33'),
(6, 88, 'گوسفند', 'نداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',گوسفند,', '1455827400', 3, 1, '0.0', 0, 89, '6.00'),
(7, 88, 'پلیکان', 'نداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',ماهی,', '1455827400', 3, 1, '9.0', 0, 89, '4.00'),
(8, 88, 'گوی', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',گوی,', '1455827400', 3, 1, '5.0', 0, 89, '8.33'),
(9, 88, 'گل', 'نداردنداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',گل,', '1455827400', 3, 1, '10.0', 0, 89, '8.67'),
(10, 89, 'اسب', 'نداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',اسب,', '1455827400', 3, 1, '0.0', 0, 89, '4.33'),
(11, 89, 'شیپوری', 'نداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',شیپوری,', '1455827400', 3, 1, '1.0', 0, 89, '5.67'),
(12, 89, 'امام', 'نداردنداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',امام,', '1455827400', 3, 1, '9.0', 0, 89, '4.33'),
(13, 88, 'آقا', 'جانم فدای رهبرم', 'آذربایجان شرقی', ',رهبرم,عزیزترجانم,', '1455827400', 3, 1, '10.0', 2, 89, '9.00'),
(14, 1, 'گل های زیبا', 'نداردنداردنداردنداردنداردنداردنداردندارد', 'آذربایجان شرقی', ',گل,', '1455827400', 3, 1, '8.0', 0, 89, '10.00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_policy`
--

CREATE TABLE IF NOT EXISTS `tbl_policy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rules` text NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_policy`
--

INSERT INTO `tbl_policy` (`id`, `rules`, `comment`) VALUES
(1, 'قانون شماره یک', 'متن قانون');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prize`
--

CREATE TABLE IF NOT EXISTS `tbl_prize` (
  `comment` text NOT NULL,
  `cmpid` int(10) unsigned NOT NULL COMMENT 'fk to tbl_comp',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_prize`
--

INSERT INTO `tbl_prize` (`comment`, `cmpid`, `id`) VALUES
('12345', 3, 1),
('12345', 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_prizefiles`
--

CREATE TABLE IF NOT EXISTS `tbl_prizefiles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `prizeid` int(10) unsigned NOT NULL COMMENT 'fk to tbl_prize',
  `type` tinyint(4) NOT NULL COMMENT '=0:image =1:video',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `tbl_prizefiles`
--

INSERT INTO `tbl_prizefiles` (`id`, `prizeid`, `type`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 0),
(4, 1, 0),
(5, 1, 0),
(6, 1, 0),
(7, 1, 0),
(8, 1, 0),
(9, 1, 0),
(10, 1, 0),
(11, 1, 0),
(12, 1, 0),
(13, 1, 0),
(14, 1, 0),
(15, 1, 0),
(16, 1, 0),
(17, 1, 0),
(18, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_question`
--

CREATE TABLE IF NOT EXISTS `tbl_question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(250) NOT NULL,
  `answer` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `tbl_question`
--

INSERT INTO `tbl_question` (`id`, `question`, `answer`) VALUES
(1, 'چگونه در سامانه عضو شوم؟', 'با استفاده از دکمه ثبت نام شما می توانید، ثبت نام کنید.'),
(2, 'چگونه وارد سامانه شوم؟', 'با کلیک کردن بر روی دکمه ورود');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_ratemardomi`
--

CREATE TABLE IF NOT EXISTS `tbl_ratemardomi` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- Dumping data for table `tbl_ratemardomi`
--

INSERT INTO `tbl_ratemardomi` (`uid`, `pid`, `rate`, `id`) VALUES
(1, 8, 6, 1),
(1, 9, 6, 2),
(1, 10, 3, 3),
(1, 11, 8, 4),
(1, 3, 10, 6),
(1, 2, 1, 7),
(1, 1, 4, 8),
(1, 4, 6, 9),
(1, 5, 5, 10),
(1, 6, 2, 11),
(1, 7, 8, 12),
(89, 8, 10, 13),
(89, 9, 10, 14),
(89, 10, 1, 15),
(89, 11, 8, 16),
(89, 12, 1, 17),
(89, 5, 10, 18),
(89, 1, 10, 20),
(89, 2, 2, 21),
(89, 3, 7, 22),
(89, 7, 1, 23),
(88, 8, 9, 25),
(88, 9, 10, 26),
(88, 11, 1, 27),
(88, 12, 3, 28),
(88, 2, 2, 29),
(88, 3, 1, 30),
(88, 4, 9, 31),
(88, 7, 3, 32),
(88, 5, 7, 33),
(88, 6, 10, 34),
(88, 1, 8, 35),
(88, 10, 9, 36),
(1, 12, 9, 43),
(1, 14, 10, 49);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_score`
--

CREATE TABLE IF NOT EXISTS `tbl_score` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL COMMENT 'fk users tbl',
  `confirm_photo` int(11) NOT NULL DEFAULT '0' COMMENT 'case1',
  `login_score` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- Dumping data for table `tbl_score`
--

INSERT INTO `tbl_score` (`id`, `userid`, `confirm_photo`, `login_score`) VALUES
(12, 1, 1700, 584),
(167, 91, 0, 0),
(168, 92, 0, 0),
(169, 93, 0, 0),
(170, 94, 0, 0),
(171, 95, 0, 0),
(172, 96, 0, 0),
(173, 97, 0, 2),
(174, 98, 0, 0),
(175, 99, 0, 0),
(176, 100, 0, 2),
(177, 101, 0, 0),
(178, 102, 0, 0),
(179, 103, 0, 2),
(180, 104, 0, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_siteinfo`
--

CREATE TABLE IF NOT EXISTS `tbl_siteinfo` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sitename` char(150) NOT NULL,
  `address` varchar(30) NOT NULL,
  `cashvalue` int(11) DEFAULT NULL,
  `description` varchar(400) NOT NULL,
  `info` varchar(2500) NOT NULL,
  `min_size` int(11) NOT NULL,
  `max_size` int(11) NOT NULL,
  `max_siz_avatar` int(11) NOT NULL,
  `format` varchar(50) NOT NULL,
  `width_img` int(11) NOT NULL,
  `height_img` int(11) NOT NULL,
  `watemark` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tbl_siteinfo`
--

INSERT INTO `tbl_siteinfo` (`id`, `sitename`, `address`, `cashvalue`, `description`, `info`, `min_size`, `max_size`, `max_siz_avatar`, `format`, `width_img`, `height_img`, `watemark`) VALUES
(1, 'اشتراک عکس بانوان', 'dd', 0, '', '', 1, 5, 350, 'jpg,jpeg,png,gif', 500, 500, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE IF NOT EXISTS `tbl_slider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_states`
--

CREATE TABLE IF NOT EXISTS `tbl_states` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `state` char(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `tbl_states`
--

INSERT INTO `tbl_states` (`id`, `state`) VALUES
(1, 'آذربایجان شرقی'),
(2, 'آذربایجان غربی'),
(3, 'اردبیل'),
(4, 'اصفهان'),
(5, 'البرز'),
(6, 'ایلام'),
(7, 'بوشهر'),
(8, 'تهران'),
(9, 'خراسان جنوبی'),
(10, 'خراسان رضوی'),
(11, 'خراسان شمالی'),
(12, 'خوزستان'),
(13, 'زنجان'),
(14, 'سمنان'),
(15, 'سیستان و بلوچستان'),
(16, 'فارس'),
(17, 'قزوین'),
(18, 'قم'),
(19, 'لرستان'),
(20, 'مازندران'),
(21, 'مرکزی'),
(22, 'هرمزگان'),
(23, 'همدان'),
(24, 'چهارمحال و بختیاری'),
(25, 'کردستان'),
(26, 'کرمان'),
(27, 'کرمانشاه'),
(28, 'کهگیلویه و بویر احمد'),
(29, 'گلستان'),
(30, 'گیلان'),
(31, 'یزد'),
(32, 'سایر');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_usernotify`
--

CREATE TABLE IF NOT EXISTS `tbl_usernotify` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'fk tbl_users ',
  `nid` int(11) NOT NULL COMMENT 'fk tbl_notify',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0:unread 1:seen',
  `phtemp` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67 ;

--
-- Dumping data for table `tbl_usernotify`
--

INSERT INTO `tbl_usernotify` (`id`, `uid`, `nid`, `status`, `phtemp`) VALUES
(1, 1, 1, 1, NULL),
(2, 88, 1, 0, NULL),
(3, 89, 1, 1, NULL),
(4, 1, 2, 1, NULL),
(5, 88, 2, 0, NULL),
(6, 89, 2, 1, NULL),
(7, 88, 4, 0, NULL),
(8, 88, 5, 0, NULL),
(9, 1, 6, 0, NULL),
(10, 88, 6, 0, NULL),
(11, 89, 6, 0, NULL),
(12, 1, 7, 1, NULL),
(13, 88, 7, 0, NULL),
(14, 89, 7, 0, NULL),
(15, 0, 8, 0, NULL),
(16, 0, 9, 0, NULL),
(17, 0, 10, 0, NULL),
(18, 0, 11, 0, NULL),
(19, 88, 12, 0, NULL),
(20, 0, 13, 0, NULL),
(21, 88, 14, 0, NULL),
(22, 89, 15, 0, NULL),
(23, 0, 16, 0, NULL),
(24, 88, 17, 0, NULL),
(25, 89, 18, 0, NULL),
(26, 88, 19, 0, NULL),
(27, 88, 20, 0, NULL),
(28, 89, 21, 0, NULL),
(29, 1, 22, 1, NULL),
(30, 1, 23, 0, NULL),
(31, 88, 23, 1, NULL),
(32, 89, 23, 0, NULL),
(33, 0, 24, 0, NULL),
(34, 0, 25, 0, NULL),
(35, 0, 26, 0, NULL),
(36, 0, 27, 0, NULL),
(37, 0, 28, 0, NULL),
(38, 88, 29, 0, NULL),
(39, 89, 30, 0, NULL),
(40, 1, 31, 1, NULL),
(41, 1, 32, 0, NULL),
(42, 0, 33, 0, NULL),
(43, 88, 34, 0, NULL),
(44, 1, 35, 1, NULL),
(45, 88, 35, 0, NULL),
(46, 89, 35, 0, NULL),
(47, 1, 36, 1, NULL),
(48, 0, 37, 0, NULL),
(49, 88, 38, 0, NULL),
(50, 1, 39, 0, NULL),
(51, 1, 40, 0, NULL),
(52, 1, 42, 0, NULL),
(53, 1, 43, 0, NULL),
(54, 1, 44, 0, NULL),
(55, 1, 45, 0, NULL),
(56, 1, 46, 0, NULL),
(57, 1, 47, 0, NULL),
(58, 1, 48, 0, NULL),
(59, 1, 50, 0, NULL),
(60, 1, 51, 0, NULL),
(61, 1, 52, 0, NULL),
(62, 1, 54, 0, NULL),
(63, 1, 55, 0, NULL),
(64, 1, 56, 0, NULL),
(65, 1, 57, 0, NULL),
(66, 1, 58, 0, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE IF NOT EXISTS `tbl_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(50) NOT NULL,
  `family` char(50) NOT NULL,
  `username` char(25) NOT NULL,
  `password` char(32) NOT NULL,
  `token` varchar(32) NOT NULL,
  `melicode` char(10) NOT NULL,
  `postcode` char(10) NOT NULL,
  `address` varchar(500) NOT NULL,
  `tel` char(15) NOT NULL,
  `mobile` char(11) NOT NULL,
  `mail` char(50) NOT NULL,
  `isheader` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isavatar` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `userinfo` varchar(1000) DEFAULT NULL,
  `photonumber` int(10) unsigned NOT NULL DEFAULT '0',
  `confirm` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isban` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `isadmin` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `loginip` char(16) DEFAULT NULL,
  `lastlogin` bigint(20) unsigned NOT NULL,
  `activenotify` tinyint(1) NOT NULL DEFAULT '1',
  `gcmid` text,
  `deviceld` varchar(100) NOT NULL,
  `devicever` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=105 ;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `name`, `family`, `username`, `password`, `token`, `melicode`, `postcode`, `address`, `tel`, `mobile`, `mail`, `isheader`, `isavatar`, `userinfo`, `photonumber`, `confirm`, `isban`, `isadmin`, `loginip`, `lastlogin`, `activenotify`, `gcmid`, `deviceld`, `devicever`) VALUES
(1, 'ممد', 'بلدی فروشانی', 'admin', '0192023a7bbd73250516f069df18b500', 'ee1443129ec7dd5aa9accf625ebfcef1', '1092143831', '8518866143', 'هنتدئنظ', '1234567', '355560649', 'baladi@yahoo.com', 1, 0, 'dsddasd', 78, 1, 0, 4, '127.0.0.1', 1464502387, 1, 'APA91bGb-neqymveIVS0yWX_uLDzDoBOTGl4mNC0oLvdr4OShZk44t5hPVx1-_zMvjHcmJ-aDTfRJMLQ_roz4atRCvRZpTHu30XzddPZU5SNa-Zkw4CKU6F-PBgKVXz6WTuyQdNuUzuq', '', ''),
(88, 'امین', 'قاضی', 'amin', 'b25bd893d48f22c82f5e8e3f08ee1b42', '', '', '', '', '', '', '', 0, 0, NULL, 6, 1, 0, 1, '127.0.0.1', 1462355240, 1, NULL, '', ''),
(89, 'زهرا', 'شاهسون', 'zahra', '3b972fa77cc41309d88d22c169b01dc8', '', '', '', '', '', '', '', 0, 0, NULL, 12, 1, 0, 3, '127.0.0.1', 1455969246, 1, NULL, '', ''),
(97, '', '', 'samira', '3f3b0950f371a42d6b2cd8508de77f1d', '', '', '', '', '', '09368804421', '', 0, 0, NULL, 0, 1, 0, 1, '127.0.0.1', 1462197648, 1, NULL, '', ''),
(98, '', '', 'amin2', 'b25bd893d48f22c82f5e8e3f08ee1b42', '', '', '', '', '', '', '', 0, 0, NULL, 0, 1, 0, 1, NULL, 1462261407, 1, NULL, '', ''),
(104, '', '', 'amin5', 'b25bd893d48f22c82f5e8e3f08ee1b42', '', '', '', '', '', '09358891888', '', 0, 0, NULL, 0, 1, 0, 1, '127.0.0.1', 1462272366, 1, NULL, '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_view`
--

CREATE TABLE IF NOT EXISTS `tbl_view` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `imageid` int(10) unsigned NOT NULL,
  `timeofview` char(20) NOT NULL,
  `userip` char(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_violation`
--

CREATE TABLE IF NOT EXISTS `tbl_violation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subjectv` varchar(150) NOT NULL,
  `comment` varchar(300) NOT NULL,
  `idpic` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_vrdrate`
--

CREATE TABLE IF NOT EXISTS `tbl_vrdrate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `vrdid` int(10) unsigned NOT NULL,
  `imgid` int(10) unsigned NOT NULL,
  `rate` tinyint(3) unsigned NOT NULL,
  `issize` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `tbl_vrdrate`
--

INSERT INTO `tbl_vrdrate` (`id`, `vrdid`, `imgid`, `rate`, `issize`) VALUES
(6, 88, 11, 1, 0),
(7, 88, 14, 0, 1),
(8, 88, 8, 0, 1),
(9, 88, 12, 9, 0),
(10, 88, 13, 10, 0),
(11, 88, 9, 10, 0),
(12, 88, 1, 10, 0),
(13, 88, 7, 9, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_wins`
--

CREATE TABLE IF NOT EXISTS `tbl_wins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rate` char(255) DEFAULT NULL,
  `price` varchar(50) NOT NULL,
  `cmnt` varchar(150) NOT NULL,
  `uid` int(11) NOT NULL,
  `imgid` int(10) unsigned NOT NULL,
  `cmpid` int(10) unsigned NOT NULL,
  `wintype` tinyint(4) NOT NULL COMMENT '=0:win dv  =1:mon dv   =2win po',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tbl_wins`
--

INSERT INTO `tbl_wins` (`id`, `rate`, `price`, `cmnt`, `uid`, `imgid`, `cmpid`, `wintype`) VALUES
(19, 'ttt', 'hhh', 'hhh', 1, 1, 3, 0),
(20, '', 'fffff', 'fffff', 0, 13, 3, 1),
(21, '', 'aaa', 'aaaa', 88, 5, 3, 2);

-- --------------------------------------------------------

--
-- Stand-in structure for view `userfornote`
--
CREATE TABLE IF NOT EXISTS `userfornote` (
`id` int(10) unsigned
,`name` char(50)
,`family` char(50)
,`username` char(25)
,`password` char(32)
,`melicode` char(10)
,`postcode` char(10)
,`address` varchar(500)
,`tel` char(15)
,`mobile` char(11)
,`mail` char(50)
,`isheader` tinyint(3) unsigned
,`isavatar` tinyint(3) unsigned
,`userinfo` varchar(1000)
,`photonumber` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`isban` tinyint(3) unsigned
,`isadmin` tinyint(3) unsigned
,`loginip` char(16)
,`lastlogin` bigint(20) unsigned
,`activenotify` tinyint(1)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_comp`
--
CREATE TABLE IF NOT EXISTS `viw_comp` (
`iswin` tinyint(3) unsigned
,`imglike` decimal(10,2)
,`prate` decimal(10,1)
,`pid` int(10) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pcmt` char(250)
,`pdate` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`uname` char(50)
,`uf` char(50)
,`isavatar` tinyint(3) unsigned
,`username` char(25)
,`cname` char(250)
,`isopen` tinyint(3) unsigned
,`level` varchar(15)
,`startdate` bigint(20)
,`enddate` bigint(20)
,`numofpic` int(11)
,`peopelwinno` smallint(6)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_compbaz`
--
CREATE TABLE IF NOT EXISTS `viw_compbaz` (
`id` int(10) unsigned
,`name` char(250)
,`decription` varchar(1000)
,`isopen` tinyint(3) unsigned
,`level` varchar(15)
,`startdate` bigint(20)
,`bname` char(50)
,`bfamily` char(50)
,`username` char(25)
,`enddate` bigint(20)
,`numofpic` int(11)
,`prise` varchar(500)
,`winno` smallint(6)
,`selno` smallint(6)
,`davarino` smallint(6)
,`peopelwinno` smallint(6)
,`peoplewinprise` varchar(500)
,`bid` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_compphot`
--
CREATE TABLE IF NOT EXISTS `viw_compphot` (
`davarino` smallint(6)
,`compid` int(10) unsigned
,`bazid` int(11)
,`confirm` tinyint(3) unsigned
,`photnam` char(150)
,`isopen` tinyint(3) unsigned
,`publishend` tinyint(1)
,`enddate` bigint(20)
,`name` char(250)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_davaranimg`
--
CREATE TABLE IF NOT EXISTS `viw_davaranimg` (
`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
,`bazid` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_davarcomnew`
--
CREATE TABLE IF NOT EXISTS `viw_davarcomnew` (
`iswin` tinyint(3) unsigned
,`imglike` decimal(10,2)
,`prate` decimal(10,1)
,`pid` int(10) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pcmt` char(250)
,`pdate` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`uname` char(50)
,`uf` char(50)
,`isavatar` tinyint(3) unsigned
,`username` char(25)
,`cname` char(250)
,`isopen` tinyint(3) unsigned
,`level` varchar(15)
,`startdate` bigint(20)
,`enddate` bigint(20)
,`numofpic` int(11)
,`peopelwinno` smallint(6)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_editcomp`
--
CREATE TABLE IF NOT EXISTS `viw_editcomp` (
`id` int(11) unsigned
,`name` char(250)
,`decription` text
,`isopen` tinyint(4) unsigned
,`level` varchar(15)
,`startdate` bigint(20)
,`enddate` bigint(20)
,`numofpic` int(11)
,`prise` varchar(500)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_fer`
--
CREATE TABLE IF NOT EXISTS `viw_fer` (
`id` int(10) unsigned
,`userid` int(10) unsigned
,`fid` int(10) unsigned
,`name` char(50)
,`family` char(50)
,`username` char(25)
,`isavatar` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_fing`
--
CREATE TABLE IF NOT EXISTS `viw_fing` (
`id` int(10) unsigned
,`userid` int(10) unsigned
,`fid` int(10) unsigned
,`name` char(50)
,`family` char(50)
,`username` char(25)
,`isavatar` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_pcomp`
--
CREATE TABLE IF NOT EXISTS `viw_pcomp` (
`id` int(10) unsigned
,`name` char(250)
,`decription` varchar(1000)
,`isopen` tinyint(3) unsigned
,`level` varchar(15)
,`startdate` bigint(20)
,`enddate` bigint(20)
,`numofpic` int(11)
,`prise` varchar(500)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_phcomp`
--
CREATE TABLE IF NOT EXISTS `viw_phcomp` (
`id` int(10) unsigned
,`userid` int(10) unsigned
,`name` char(150)
,`comment` char(250)
,`locate` varchar(150)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`iswin` tinyint(3) unsigned
,`bazid` int(11)
,`imglike` decimal(10,2)
,`cname` char(250)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_photus`
--
CREATE TABLE IF NOT EXISTS `viw_photus` (
`comment` char(250)
,`id` int(10) unsigned
,`userid` int(10) unsigned
,`photonam` char(150)
,`tags` char(100)
,`date` char(10)
,`compid` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`iswin` tinyint(3) unsigned
,`bazid` int(11)
,`name` char(50)
,`family` char(50)
,`username` char(25)
,`isavatar` tinyint(3) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_photwin`
--
CREATE TABLE IF NOT EXISTS `viw_photwin` (
`iswin` tinyint(3) unsigned
,`refrate` decimal(10,1)
,`imglike` decimal(10,2)
,`pid` int(10) unsigned
,`userid` int(10) unsigned
,`pn` char(150)
,`pdate` char(10)
,`uname` char(50)
,`uf` char(50)
,`username` char(25)
,`isavatar` tinyint(3) unsigned
,`cname` char(250)
,`cmpid` int(10) unsigned
,`comment` char(250)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_prizeandfiles`
--
CREATE TABLE IF NOT EXISTS `viw_prizeandfiles` (
`id` int(10) unsigned
,`comment` text
,`cmpid` int(10) unsigned
,`pfid` int(10) unsigned
,`type` tinyint(4)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_searchuser`
--
CREATE TABLE IF NOT EXISTS `viw_searchuser` (
`id` int(10) unsigned
,`name` varchar(101)
,`username` char(25)
,`password` char(32)
,`melicode` char(10)
,`postcode` char(10)
,`address` varchar(500)
,`tel` char(15)
,`mobile` char(11)
,`mail` char(50)
,`isheader` tinyint(3) unsigned
,`isavatar` tinyint(3) unsigned
,`userinfo` varchar(1000)
,`photonumber` int(10) unsigned
,`confirm` tinyint(3) unsigned
,`isban` tinyint(3) unsigned
,`isadmin` tinyint(3) unsigned
,`loginip` char(16)
,`lastlogin` bigint(20) unsigned
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_userwin`
--
CREATE TABLE IF NOT EXISTS `viw_userwin` (
`id` int(11)
,`rate` char(255)
,`price` varchar(50)
,`cmnt` varchar(150)
,`uid` int(11)
,`imgid` int(10) unsigned
,`cmpid` int(10) unsigned
,`wintype` tinyint(4)
,`nam` char(50)
,`family` char(50)
,`username` char(25)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_violat`
--
CREATE TABLE IF NOT EXISTS `viw_violat` (
`id` int(11)
,`name` char(50)
,`userid` int(10) unsigned
,`family` char(50)
,`subject` varchar(150)
,`comment` varchar(300)
,`cname` char(250)
,`idpic` int(11)
,`isavatar` tinyint(3) unsigned
,`username` char(25)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_win`
--
CREATE TABLE IF NOT EXISTS `viw_win` (
`id` int(11)
,`rate` char(255)
,`price` varchar(50)
,`cmnt` varchar(150)
,`uid` int(11)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `viw_winph`
--
CREATE TABLE IF NOT EXISTS `viw_winph` (
`rate` char(255)
,`price` varchar(50)
,`uid` int(11)
,`imgid` int(10) unsigned
,`cmpid` int(10) unsigned
,`wintype` tinyint(4)
,`name` char(150)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `whonots`
--
CREATE TABLE IF NOT EXISTS `whonots` (
`href` varchar(200)
,`id` int(11)
,`uid` int(11)
,`nid` int(11)
,`status` tinyint(1)
,`notid` int(11)
,`text` text
,`date` varchar(50)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `winphotos`
--
CREATE TABLE IF NOT EXISTS `winphotos` (
`id` int(11)
,`rate` char(255)
,`price` varchar(50)
,`cmnt` varchar(150)
,`uid` int(11)
,`photoid` int(10) unsigned
,`compid` int(10) unsigned
,`pname` char(150)
,`compname` char(250)
);
-- --------------------------------------------------------

--
-- Stand-in structure for view `x`
--
CREATE TABLE IF NOT EXISTS `x` (
`id` int(11)
,`rate` char(255)
,`price` varchar(50)
,`cmnt` varchar(150)
,`uid` int(11)
,`photoid` int(10) unsigned
,`compid` int(10) unsigned
,`pname` char(150)
);
-- --------------------------------------------------------

--
-- Structure for view `compname`
--
DROP TABLE IF EXISTS `compname`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `compname` AS (select `p`.`isopen` AS `isopen`,`d`.`did` AS `did`,`p`.`name` AS `cname`,`p`.`id` AS `cid`,`u`.`name` AS `dname`,`u`.`family` AS `dfamily`,`u`.`username` AS `username`,`p`.`isopen` AS `cisopen`,`p`.`level` AS `clevel`,`p`.`startdate` AS `cstartdate`,`p`.`enddate` AS `cenddate`,`p`.`decription` AS `cdecription`,`p`.`prise` AS `cprise` from ((`tbl_comp` `p` join `tbl_users` `u`) join `tbl_davarcomp` `d`) where ((`p`.`id` = `d`.`compid`) and (`d`.`did` = `u`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `forbaz`
--
DROP TABLE IF EXISTS `forbaz`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `forbaz` AS (select `notinbazrate`.`bazid` AS `bazid`,`notinbazrate`.`id` AS `id`,`notinbazrate`.`userid` AS `userid`,`notinbazrate`.`name` AS `name`,`tbl_users`.`isavatar` AS `isavatar`,`notinbazrate`.`comment` AS `comment`,`notinbazrate`.`tags` AS `tags`,`notinbazrate`.`date` AS `date`,`notinbazrate`.`compid` AS `compid`,`notinbazrate`.`confirm` AS `confirm`,`notinbazrate`.`refrate` AS `refrate`,`notinbazrate`.`iswin` AS `iswin`,`tbl_users`.`name` AS `username`,`tbl_users`.`family` AS `family`,`tbl_users`.`username` AS `uname` from (`notinbazrate` join `tbl_users`) where (`notinbazrate`.`userid` = `tbl_users`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `foridx`
--
DROP TABLE IF EXISTS `foridx`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `foridx` AS (select `u`.`name` AS `name`,`u`.`family` AS `family`,`u`.`username` AS `username`,`d`.`id` AS `id`,`d`.`did` AS `did`,`d`.`compid` AS `compid` from (`tbl_davarcomp` `d` join `tbl_users` `u`) where (`d`.`did` = `u`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `isnotok`
--
DROP TABLE IF EXISTS `isnotok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `isnotok` AS (select `n`.`bazid` AS `bazid`,`n`.`isavatar` AS `isavatar`,`n`.`uf` AS `uf`,`n`.`un` AS `un`,`tb`.`id` AS `rateid`,`tb`.`bazbinid` AS `bazbinid`,`tb`.`imgid` AS `imgid`,`tb`.`comment` AS `bbcom`,`tb`.`isok` AS `isok`,`n`.`id` AS `id`,`n`.`userid` AS `userid`,`n`.`name` AS `name`,`n`.`comment` AS `comment`,`n`.`tags` AS `tags`,`n`.`date` AS `date`,`n`.`compid` AS `compid`,`n`.`confirm` AS `confirm`,`n`.`refrate` AS `refrate`,`n`.`iswin` AS `iswin`,`n`.`username` AS `username` from (`notview` `n` left join `tbl_bazbinrate` `tb` on((`tb`.`isok` = 0))) where (`tb`.`imgid` = `n`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `isok`
--
DROP TABLE IF EXISTS `isok`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `isok` AS (select `n`.`bazid` AS `bazid`,`n`.`isavatar` AS `isavatar`,`n`.`uf` AS `uf`,`n`.`un` AS `un`,`tb`.`id` AS `rateid`,`tb`.`bazbinid` AS `bazbinid`,`tb`.`imgid` AS `imgid`,`tb`.`comment` AS `bbcom`,`tb`.`isok` AS `isok`,`n`.`id` AS `id`,`n`.`userid` AS `userid`,`n`.`name` AS `name`,`n`.`comment` AS `comment`,`n`.`tags` AS `tags`,`n`.`date` AS `date`,`n`.`username` AS `username`,`n`.`compid` AS `compid`,`n`.`confirm` AS `confirm`,`n`.`refrate` AS `refrate`,`n`.`iswin` AS `iswin` from (`notview` `n` left join `tbl_bazbinrate` `tb` on((`tb`.`isok` = 1))) where (`tb`.`imgid` = `n`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `notinbazrate`
--
DROP TABLE IF EXISTS `notinbazrate`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `notinbazrate` AS (select `tbl_photos`.`bazid` AS `bazid`,`tbl_photos`.`id` AS `id`,`tbl_photos`.`userid` AS `userid`,`tbl_photos`.`name` AS `name`,`tbl_photos`.`comment` AS `comment`,`tbl_photos`.`tags` AS `tags`,`tbl_photos`.`date` AS `date`,`tbl_photos`.`compid` AS `compid`,`tbl_photos`.`confirm` AS `confirm`,`tbl_photos`.`refrate` AS `refrate`,`tbl_photos`.`iswin` AS `iswin` from `tbl_photos` where (not(`tbl_photos`.`id` in (select `tbl_bazbinrate`.`imgid` from `tbl_bazbinrate`))));

-- --------------------------------------------------------

--
-- Structure for view `notview`
--
DROP TABLE IF EXISTS `notview`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `notview` AS (select `u`.`name` AS `un`,`u`.`isavatar` AS `isavatar`,`u`.`username` AS `username`,`u`.`family` AS `uf`,`p`.`bazid` AS `bazid`,`p`.`id` AS `id`,`p`.`userid` AS `userid`,`p`.`name` AS `name`,`p`.`comment` AS `comment`,`p`.`tags` AS `tags`,`p`.`date` AS `date`,`p`.`compid` AS `compid`,`p`.`confirm` AS `confirm`,`p`.`refrate` AS `refrate`,`p`.`iswin` AS `iswin` from (`tbl_photos` `p` join `tbl_users` `u`) where ((`p`.`userid` = `u`.`id`) and `p`.`id` in (select `b`.`imgid` from `tbl_bazbinrate` `b`)));

-- --------------------------------------------------------

--
-- Structure for view `photconf`
--
DROP TABLE IF EXISTS `photconf`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `photconf` AS (select `p`.`id` AS `pid`,`p`.`userid` AS `userid`,`p`.`name` AS `pn`,`p`.`date` AS `pdate`,`p`.`comment` AS `comment`,`p`.`confirm` AS `confirm`,`u`.`name` AS `uname`,`u`.`family` AS `uf`,`u`.`username` AS `username`,`u`.`isavatar` AS `isavatar`,`c`.`name` AS `cname`,`c`.`id` AS `compid` from ((`tbl_photos` `p` join `tbl_users` `u`) join `tbl_comp` `c`) where ((`p`.`userid` = `u`.`id`) and (`p`.`compid` = `c`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `photosearch`
--
DROP TABLE IF EXISTS `photosearch`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `photosearch` AS (select `c`.`id` AS `cid`,`c`.`numofpic` AS `numofpic`,`c`.`startdate` AS `startdate`,`c`.`enddate` AS `enddate`,`p`.`imglike` AS `imglike`,`p`.`tags` AS `tags`,`u`.`username` AS `username`,`p`.`id` AS `pid`,`p`.`confirm` AS `confirm`,`p`.`userid` AS `userid`,`p`.`name` AS `pn`,`p`.`comment` AS `pcmt`,`p`.`date` AS `pdate`,`u`.`name` AS `uname`,`u`.`family` AS `uf`,`u`.`isavatar` AS `isavatar`,`c`.`name` AS `cname`,`c`.`peopelwinno` AS `ispeopel`,`s`.`state` AS `locate`,`s`.`id` AS `locateid` from (((`tbl_photos` `p` join `tbl_users` `u`) join `tbl_comp` `c`) join `tbl_states` `s`) where ((`p`.`userid` = `u`.`id`) and (`p`.`compid` = `c`.`id`) and (`s`.`state` = `p`.`locate`)));

-- --------------------------------------------------------

--
-- Structure for view `photowin`
--
DROP TABLE IF EXISTS `photowin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `photowin` AS (select `p`.`refrate` AS `refrate`,`p`.`id` AS `pid`,`p`.`userid` AS `userid`,`p`.`name` AS `pn`,`p`.`date` AS `pdate`,`u`.`name` AS `uname`,`u`.`family` AS `uf`,`u`.`isavatar` AS `isavatar`,`c`.`name` AS `cname`,`c`.`id` AS `cmpid`,`p`.`comment` AS `comment` from ((`tbl_photos` `p` join `tbl_users` `u`) join `tbl_comp` `c`) where ((`p`.`userid` = `u`.`id`) and (`p`.`compid` = `c`.`id`) and (`p`.`confirm` = 1) and (`c`.`isopen` = 1)));

-- --------------------------------------------------------

--
-- Structure for view `userfornote`
--
DROP TABLE IF EXISTS `userfornote`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `userfornote` AS (select `tbl_users`.`id` AS `id`,`tbl_users`.`name` AS `name`,`tbl_users`.`family` AS `family`,`tbl_users`.`username` AS `username`,`tbl_users`.`password` AS `password`,`tbl_users`.`melicode` AS `melicode`,`tbl_users`.`postcode` AS `postcode`,`tbl_users`.`address` AS `address`,`tbl_users`.`tel` AS `tel`,`tbl_users`.`mobile` AS `mobile`,`tbl_users`.`mail` AS `mail`,`tbl_users`.`isheader` AS `isheader`,`tbl_users`.`isavatar` AS `isavatar`,`tbl_users`.`userinfo` AS `userinfo`,`tbl_users`.`photonumber` AS `photonumber`,`tbl_users`.`confirm` AS `confirm`,`tbl_users`.`isban` AS `isban`,`tbl_users`.`isadmin` AS `isadmin`,`tbl_users`.`loginip` AS `loginip`,`tbl_users`.`lastlogin` AS `lastlogin`,`tbl_users`.`activenotify` AS `activenotify` from `tbl_users` where (`tbl_users`.`activenotify` = 1));

-- --------------------------------------------------------

--
-- Structure for view `viw_comp`
--
DROP TABLE IF EXISTS `viw_comp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_comp` AS (select `p`.`iswin` AS `iswin`,`p`.`imglike` AS `imglike`,`p`.`refrate` AS `prate`,`p`.`id` AS `pid`,`p`.`userid` AS `userid`,`p`.`name` AS `pn`,`p`.`comment` AS `pcmt`,`p`.`date` AS `pdate`,`p`.`compid` AS `compid`,`p`.`confirm` AS `confirm`,`u`.`name` AS `uname`,`u`.`family` AS `uf`,`u`.`isavatar` AS `isavatar`,`u`.`username` AS `username`,`c`.`name` AS `cname`,`c`.`isopen` AS `isopen`,`c`.`level` AS `level`,`c`.`startdate` AS `startdate`,`c`.`enddate` AS `enddate`,`c`.`numofpic` AS `numofpic`,`c`.`peopelwinno` AS `peopelwinno` from ((`tbl_photos` `p` join `tbl_users` `u`) join `tbl_comp` `c`) where ((`p`.`userid` = `u`.`id`) and (`c`.`id` = `p`.`compid`)) group by `p`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `viw_compbaz`
--
DROP TABLE IF EXISTS `viw_compbaz`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_compbaz` AS (select `c`.`id` AS `id`,`c`.`name` AS `name`,`c`.`decription` AS `decription`,`c`.`isopen` AS `isopen`,`c`.`level` AS `level`,`c`.`startdate` AS `startdate`,`u`.`name` AS `bname`,`u`.`family` AS `bfamily`,`u`.`username` AS `username`,`c`.`enddate` AS `enddate`,`c`.`numofpic` AS `numofpic`,`c`.`prise` AS `prise`,`c`.`winno` AS `winno`,`c`.`selno` AS `selno`,`c`.`davarino` AS `davarino`,`c`.`peopelwinno` AS `peopelwinno`,`c`.`peoplewinprise` AS `peoplewinprise`,`b`.`bid` AS `bid` from ((`tbl_comp` `c` join `tbl_bazcomp` `b`) join `tbl_users` `u`) where ((`b`.`compid` = `c`.`id`) and (`b`.`bid` = `u`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `viw_compphot`
--
DROP TABLE IF EXISTS `viw_compphot`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_compphot` AS (select `c`.`davarino` AS `davarino`,`p`.`compid` AS `compid`,`p`.`bazid` AS `bazid`,`p`.`confirm` AS `confirm`,`p`.`name` AS `photnam`,`c`.`isopen` AS `isopen`,`c`.`publishend` AS `publishend`,`c`.`enddate` AS `enddate`,`c`.`name` AS `name` from (`tbl_photos` `p` join `tbl_comp` `c`) where (`c`.`id` = `p`.`compid`) order by `p`.`compid`,`p`.`confirm`);

-- --------------------------------------------------------

--
-- Structure for view `viw_davaranimg`
--
DROP TABLE IF EXISTS `viw_davaranimg`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_davaranimg` AS select `tbl_photos`.`id` AS `id`,`tbl_photos`.`userid` AS `userid`,`tbl_photos`.`name` AS `name`,`tbl_photos`.`comment` AS `comment`,`tbl_photos`.`tags` AS `tags`,`tbl_photos`.`date` AS `date`,`tbl_photos`.`compid` AS `compid`,`tbl_photos`.`confirm` AS `confirm`,`tbl_photos`.`refrate` AS `refrate`,`tbl_photos`.`iswin` AS `iswin`,`tbl_photos`.`bazid` AS `bazid` from `tbl_photos` where `tbl_photos`.`id` in (select `tbl_bazbinrate`.`imgid` from `tbl_bazbinrate` where (`tbl_bazbinrate`.`isok` = 1));

-- --------------------------------------------------------

--
-- Structure for view `viw_davarcomnew`
--
DROP TABLE IF EXISTS `viw_davarcomnew`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_davarcomnew` AS select `viw_comp`.`iswin` AS `iswin`,`viw_comp`.`imglike` AS `imglike`,`viw_comp`.`prate` AS `prate`,`viw_comp`.`pid` AS `pid`,`viw_comp`.`userid` AS `userid`,`viw_comp`.`pn` AS `pn`,`viw_comp`.`pcmt` AS `pcmt`,`viw_comp`.`pdate` AS `pdate`,`viw_comp`.`compid` AS `compid`,`viw_comp`.`confirm` AS `confirm`,`viw_comp`.`uname` AS `uname`,`viw_comp`.`uf` AS `uf`,`viw_comp`.`isavatar` AS `isavatar`,`viw_comp`.`username` AS `username`,`viw_comp`.`cname` AS `cname`,`viw_comp`.`isopen` AS `isopen`,`viw_comp`.`level` AS `level`,`viw_comp`.`startdate` AS `startdate`,`viw_comp`.`enddate` AS `enddate`,`viw_comp`.`numofpic` AS `numofpic`,`viw_comp`.`peopelwinno` AS `peopelwinno` from `viw_comp` where `viw_comp`.`pid` in (select `tbl_bazbinrate`.`imgid` from `tbl_bazbinrate` where (`tbl_bazbinrate`.`isok` = 1));

-- --------------------------------------------------------

--
-- Structure for view `viw_editcomp`
--
DROP TABLE IF EXISTS `viw_editcomp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_editcomp` AS select `tbl_comp`.`id` AS `id`,`tbl_comp`.`name` AS `name`,`tbl_comp`.`decription` AS `decription`,`tbl_comp`.`isopen` AS `isopen`,`tbl_comp`.`level` AS `level`,`tbl_comp`.`startdate` AS `startdate`,`tbl_comp`.`enddate` AS `enddate`,`tbl_comp`.`numofpic` AS `numofpic`,`tbl_comp`.`prise` AS `prise` from `tbl_comp` where (`tbl_comp`.`isopen` = 1) union select `tbl_comp`.`id` AS `id`,`tbl_comp`.`name` AS `name`,`tbl_comp`.`decription` AS `decription`,`tbl_comp`.`isopen` AS `isopen`,`tbl_comp`.`level` AS `level`,`tbl_comp`.`startdate` AS `startdate`,`tbl_comp`.`enddate` AS `enddate`,`tbl_comp`.`numofpic` AS `numofpic`,`tbl_comp`.`prise` AS `prise` from `tbl_comp` where (`tbl_comp`.`isopen` = 0);

-- --------------------------------------------------------

--
-- Structure for view `viw_fer`
--
DROP TABLE IF EXISTS `viw_fer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_fer` AS (select `f`.`id` AS `id`,`f`.`userid` AS `userid`,`f`.`fid` AS `fid`,`u`.`name` AS `name`,`u`.`family` AS `family`,`u`.`username` AS `username`,`u`.`isavatar` AS `isavatar` from (`tbl_follow` `f` join `tbl_users` `u`) where (`f`.`userid` = `u`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `viw_fing`
--
DROP TABLE IF EXISTS `viw_fing`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_fing` AS (select `f`.`id` AS `id`,`f`.`userid` AS `userid`,`f`.`fid` AS `fid`,`u`.`name` AS `name`,`u`.`family` AS `family`,`u`.`username` AS `username`,`u`.`isavatar` AS `isavatar` from (`tbl_follow` `f` join `tbl_users` `u`) where (`f`.`fid` = `u`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `viw_pcomp`
--
DROP TABLE IF EXISTS `viw_pcomp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_pcomp` AS select `tbl_comp`.`id` AS `id`,`tbl_comp`.`name` AS `name`,`tbl_comp`.`decription` AS `decription`,`tbl_comp`.`isopen` AS `isopen`,`tbl_comp`.`level` AS `level`,`tbl_comp`.`startdate` AS `startdate`,`tbl_comp`.`enddate` AS `enddate`,`tbl_comp`.`numofpic` AS `numofpic`,`tbl_comp`.`prise` AS `prise` from `tbl_comp` where (`tbl_comp`.`isopen` = 2);

-- --------------------------------------------------------

--
-- Structure for view `viw_phcomp`
--
DROP TABLE IF EXISTS `viw_phcomp`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_phcomp` AS (select `p`.`id` AS `id`,`p`.`userid` AS `userid`,`p`.`name` AS `name`,`p`.`comment` AS `comment`,`p`.`locate` AS `locate`,`p`.`tags` AS `tags`,`p`.`date` AS `date`,`p`.`compid` AS `compid`,`p`.`confirm` AS `confirm`,`p`.`refrate` AS `refrate`,`p`.`iswin` AS `iswin`,`p`.`bazid` AS `bazid`,`p`.`imglike` AS `imglike`,`c`.`name` AS `cname` from (`tbl_photos` `p` join `tbl_comp` `c`) where (`p`.`compid` = `c`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `viw_photus`
--
DROP TABLE IF EXISTS `viw_photus`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_photus` AS (select `p`.`comment` AS `comment`,`p`.`id` AS `id`,`p`.`userid` AS `userid`,`p`.`name` AS `photonam`,`p`.`tags` AS `tags`,`p`.`date` AS `date`,`p`.`compid` AS `compid`,`p`.`confirm` AS `confirm`,`p`.`iswin` AS `iswin`,`p`.`bazid` AS `bazid`,`u`.`name` AS `name`,`u`.`family` AS `family`,`u`.`username` AS `username`,`u`.`isavatar` AS `isavatar` from (`tbl_photos` `p` join `tbl_users` `u`) where (`p`.`userid` = `u`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `viw_photwin`
--
DROP TABLE IF EXISTS `viw_photwin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_photwin` AS (select `p`.`iswin` AS `iswin`,`p`.`refrate` AS `refrate`,`p`.`imglike` AS `imglike`,`p`.`id` AS `pid`,`p`.`userid` AS `userid`,`p`.`name` AS `pn`,`p`.`date` AS `pdate`,`u`.`name` AS `uname`,`u`.`family` AS `uf`,`u`.`username` AS `username`,`u`.`isavatar` AS `isavatar`,`c`.`name` AS `cname`,`c`.`id` AS `cmpid`,`p`.`comment` AS `comment` from ((`tbl_photos` `p` join `tbl_users` `u`) join `tbl_comp` `c`) where ((`p`.`userid` = `u`.`id`) and (`p`.`compid` = `c`.`id`) and (`p`.`confirm` = 1)) order by `p`.`id`);

-- --------------------------------------------------------

--
-- Structure for view `viw_prizeandfiles`
--
DROP TABLE IF EXISTS `viw_prizeandfiles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_prizeandfiles` AS (select `p`.`id` AS `id`,`p`.`comment` AS `comment`,`p`.`cmpid` AS `cmpid`,`pf`.`id` AS `pfid`,`pf`.`type` AS `type` from (`tbl_prize` `p` join `tbl_prizefiles` `pf`) where (`p`.`id` = `pf`.`prizeid`));

-- --------------------------------------------------------

--
-- Structure for view `viw_searchuser`
--
DROP TABLE IF EXISTS `viw_searchuser`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_searchuser` AS select `tbl_users`.`id` AS `id`,concat_ws('',`tbl_users`.`name`,' ',`tbl_users`.`family`) AS `name`,`tbl_users`.`username` AS `username`,`tbl_users`.`password` AS `password`,`tbl_users`.`melicode` AS `melicode`,`tbl_users`.`postcode` AS `postcode`,`tbl_users`.`address` AS `address`,`tbl_users`.`tel` AS `tel`,`tbl_users`.`mobile` AS `mobile`,`tbl_users`.`mail` AS `mail`,`tbl_users`.`isheader` AS `isheader`,`tbl_users`.`isavatar` AS `isavatar`,`tbl_users`.`userinfo` AS `userinfo`,`tbl_users`.`photonumber` AS `photonumber`,`tbl_users`.`confirm` AS `confirm`,`tbl_users`.`isban` AS `isban`,`tbl_users`.`isadmin` AS `isadmin`,`tbl_users`.`loginip` AS `loginip`,`tbl_users`.`lastlogin` AS `lastlogin` from `tbl_users` where 1;

-- --------------------------------------------------------

--
-- Structure for view `viw_userwin`
--
DROP TABLE IF EXISTS `viw_userwin`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_userwin` AS (select `w`.`id` AS `id`,`w`.`rate` AS `rate`,`w`.`price` AS `price`,`w`.`cmnt` AS `cmnt`,`w`.`uid` AS `uid`,`w`.`imgid` AS `imgid`,`w`.`cmpid` AS `cmpid`,`w`.`wintype` AS `wintype`,`u`.`name` AS `nam`,`u`.`family` AS `family`,`u`.`username` AS `username` from (`tbl_wins` `w` join `tbl_users` `u`) where (`w`.`uid` = `u`.`id`));

-- --------------------------------------------------------

--
-- Structure for view `viw_violat`
--
DROP TABLE IF EXISTS `viw_violat`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_violat` AS (select `v`.`id` AS `id`,`u`.`name` AS `name`,`u`.`id` AS `userid`,`u`.`family` AS `family`,`v`.`subjectv` AS `subject`,`v`.`comment` AS `comment`,`c`.`name` AS `cname`,`v`.`idpic` AS `idpic`,`u`.`isavatar` AS `isavatar`,`u`.`username` AS `username` from (((`tbl_violation` `v` join `tbl_users` `u`) join `tbl_photos` `p`) join `tbl_comp` `c`) where ((`v`.`idpic` = `p`.`id`) and (`v`.`uid` = `u`.`id`) and (`p`.`compid` = `c`.`id`)));

-- --------------------------------------------------------

--
-- Structure for view `viw_win`
--
DROP TABLE IF EXISTS `viw_win`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_win` AS select `tbl_wins`.`id` AS `id`,`tbl_wins`.`rate` AS `rate`,`tbl_wins`.`price` AS `price`,`tbl_wins`.`cmnt` AS `cmnt`,`tbl_wins`.`uid` AS `uid` from `tbl_wins` where `tbl_wins`.`uid` in (select `tbl_photos`.`id` from `tbl_photos` where (`tbl_photos`.`compid` = (select max(`tbl_comp`.`id`) from `tbl_comp` where (`tbl_comp`.`isopen` = 2))));

-- --------------------------------------------------------

--
-- Structure for view `viw_winph`
--
DROP TABLE IF EXISTS `viw_winph`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `viw_winph` AS (select `w`.`rate` AS `rate`,`w`.`price` AS `price`,`w`.`uid` AS `uid`,`w`.`imgid` AS `imgid`,`w`.`cmpid` AS `cmpid`,`w`.`wintype` AS `wintype`,`p`.`name` AS `name` from (`tbl_wins` `w` join `tbl_photos` `p`) where (`p`.`id` = `w`.`imgid`));

-- --------------------------------------------------------

--
-- Structure for view `whonots`
--
DROP TABLE IF EXISTS `whonots`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `whonots` AS (select `n`.`href` AS `href`,`un`.`id` AS `id`,`un`.`uid` AS `uid`,`un`.`nid` AS `nid`,`un`.`status` AS `status`,`n`.`id` AS `notid`,`n`.`text` AS `text`,`n`.`ndate` AS `date` from (`tbl_notify` `n` join `tbl_usernotify` `un`) where (`n`.`id` = `un`.`nid`) order by `un`.`id` desc);

-- --------------------------------------------------------

--
-- Structure for view `winphotos`
--
DROP TABLE IF EXISTS `winphotos`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `winphotos` AS (select `x`.`id` AS `id`,`x`.`rate` AS `rate`,`x`.`price` AS `price`,`x`.`cmnt` AS `cmnt`,`x`.`uid` AS `uid`,`x`.`photoid` AS `photoid`,`x`.`compid` AS `compid`,`x`.`pname` AS `pname`,`c`.`name` AS `compname` from (`x` left join `tbl_comp` `c` on((`c`.`id` = `x`.`compid`))));

-- --------------------------------------------------------

--
-- Structure for view `x`
--
DROP TABLE IF EXISTS `x`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `x` AS (select `w`.`id` AS `id`,`w`.`rate` AS `rate`,`w`.`price` AS `price`,`w`.`cmnt` AS `cmnt`,`w`.`uid` AS `uid`,`p`.`id` AS `photoid`,`p`.`compid` AS `compid`,`p`.`name` AS `pname` from (`tbl_wins` `w` join `tbl_photos` `p`) where ((`p`.`iswin` > 0) and (`p`.`userid` = `w`.`uid`)));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
