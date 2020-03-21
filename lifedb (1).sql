-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2014 at 08:02 PM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lifedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  `firstname` text,
  `lastname` text,
  `position` text,
  `admintype` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  `active` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `firstname`, `lastname`, `position`, `admintype`, `rhemabranchid`, `active`) VALUES
(1, 'admin', 'admin', 'jide', 'akin', 'mainadmin', 'Super Admin', 1, NULL),
(4, 'admin', 'admin', 'caleb', 'Ayinla', 'Head Pastor', 'Pastor', 1, 1),
(5, 'JAIDO', 'PASSWORD', 'JIDE', 'AKINDEJOYE', 'Unknown', 'PASTOR', 1, 1),
(6, 'ADMIN', 'ADMIN', 'FELIX', 'AKINDEJOYE', '', 'HOD', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `continent`
--

CREATE TABLE IF NOT EXISTS `continent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `continent`
--

INSERT INTO `continent` (`id`, `name`) VALUES
(1, 'Africa'),
(2, 'Asia'),
(3, 'Australia'),
(4, 'Europe'),
(5, 'North America'),
(6, 'South America');

-- --------------------------------------------------------

--
-- Table structure for table `controladmin`
--

CREATE TABLE IF NOT EXISTS `controladmin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` text,
  `password` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `controladmin`
--

INSERT INTO `controladmin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin'),
(2, 'admin', 'xxgoJ59HneuEo');

-- --------------------------------------------------------

--
-- Table structure for table `country`
--

CREATE TABLE IF NOT EXISTS `country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` char(5) DEFAULT NULL,
  `name` text,
  `language` text,
  `continentid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `country`
--

INSERT INTO `country` (`id`, `Code`, `name`, `language`, `continentid`) VALUES
(1, NULL, 'Nigeria', '', 1),
(2, NULL, 'Ghana', '', 1),
(3, NULL, 'Senegal', '', 1),
(4, NULL, 'Lake Chad', '', 1),
(5, NULL, 'South Africa', '', 1),
(6, NULL, 'Cameroon', '', 1),
(7, 'WAR', 'WESTERN AFRICA REPUBLIC', 'SUAHELEE', 1),
(8, 'FG', 'FRAGE', 'FRENCH', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text,
  `message` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  `memberid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=19 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`id`, `title`, `message`, `rhemabranchid`, `memberid`) VALUES
(14, 'Improve', 'I want you to improve the application', 1, 42),
(15, 'chat part', 'I need a live chat on the mobile app', 1, 43),
(16, 'I love', 'I really love your services. I want you to improve', 1, 44),
(17, 'Add virtual room', 'I would  like you to add a virtual chat room to  the application', 0, 64),
(18, 'love your app', 'Please try to improve you services', 0, 64);

-- --------------------------------------------------------

--
-- Table structure for table `fellowship`
--

CREATE TABLE IF NOT EXISTS `fellowship` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `head` char(50) DEFAULT NULL,
  `rhemabranchid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=30 ;

--
-- Dumping data for table `fellowship`
--

INSERT INTO `fellowship` (`id`, `name`, `head`, `rhemabranchid`) VALUES
(1, 'Youth Fellowship', 'Brother Poju', 1),
(2, 'Men Fellowship', 'Femi', 1),
(6, 'women''s fellowship', 'Banilola', 1),
(7, 'Single''s Fellowship', 'banke', 1),
(9, 'Intercessor Fellowship', 'Jide', 1),
(29, 'Social Media Fellowship', 'Ayo Salisu', 1);

-- --------------------------------------------------------

--
-- Table structure for table `fellowshipinfo`
--

CREATE TABLE IF NOT EXISTS `fellowshipinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `information` text,
  `fellowshipid` int(11) DEFAULT NULL,
  `rhemabranchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `fellowshipinfo`
--

INSERT INTO `fellowshipinfo` (`id`, `information`, `fellowshipid`, `rhemabranchid`) VALUES
(1, 'youths should wait behind', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fellowshiplocation`
--

CREATE TABLE IF NOT EXISTS `fellowshiplocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Location` text,
  `num` int(11) DEFAULT NULL,
  `rhemabranchid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `fellowshiplocation`
--

INSERT INTO `fellowshiplocation` (`id`, `Location`, `num`, `rhemabranchid`) VALUES
(4, 'KETU', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `fellowshiplocationaddress`
--

CREATE TABLE IF NOT EXISTS `fellowshiplocationaddress` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `centeraddress` text,
  `centername` text,
  `fellowshiplocationid` int(11) DEFAULT NULL,
  `branchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `fellowshiplocationaddress`
--

INSERT INTO `fellowshiplocationaddress` (`id`, `centeraddress`, `centername`, `fellowshiplocationid`, `branchid`) VALUES
(10, 'IKOSI KETU, LAGOS', 'CENTER 1', 4, 1),
(11, 'ALAPERE KETU', 'CENTER 2', 4, 1),
(12, 'IBARAPA STREET', 'CENTER 3', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `letschat`
--

CREATE TABLE IF NOT EXISTS `letschat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ldate` date DEFAULT NULL,
  `summary` text,
  `information` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `letschat`
--

INSERT INTO `letschat` (`id`, `ldate`, `summary`, `information`, `rhemabranchid`) VALUES
(2, '0000-00-00', '', '', 1),
(3, '0000-00-00', '', '', 1),
(5, '2013-01-01', 'Single''s should stay away from sex.', 'Let''s chat would begin by 7:am prompt.', 1);

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE IF NOT EXISTS `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` char(70) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `timecreated` time DEFAULT NULL,
  `mediatype` char(20) DEFAULT NULL,
  `preacherid` int(11) DEFAULT NULL,
  `medianame` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `title`, `datecreated`, `timecreated`, `mediatype`, `preacherid`, `medianame`, `rhemabranchid`) VALUES
(14, 'God''s love', '2014-01-14', '23:01:34', 'video', 12, '../Upload/video/32602 THE SECRET LIFE OF TREES  RELAX and CHILL OUT to 75 mins of music by film composer Tracy Bartelle.mp4', NULL),
(15, 'What we need in life', '2014-01-14', '23:01:12', 'audio', 12, '../Upload/audio/29805Sleep Away.mp3', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `username` char(60) NOT NULL,
  `name` text,
  `phone` char(40) DEFAULT NULL,
  `email` char(100) NOT NULL,
  `devicetype` text,
  `mobileapptypeID` int(11) DEFAULT NULL,
  `pushregid` text,
  `rhemabranchid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `continentid` int(11) NOT NULL,
  `countryid` int(11) NOT NULL,
  `ismember` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=66 ;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`username`, `name`, `phone`, `email`, `devicetype`, `mobileapptypeID`, `pushregid`, `rhemabranchid`, `id`, `continentid`, `countryid`, `ismember`) VALUES
('kola', 'Kola', '08131528807', 'kola@yahoo.com', NULL, NULL, NULL, 1, 63, 1, 1, 0),
('kole', 'kola', '08123232323', 'skliz@yahoo.com', NULL, NULL, NULL, 0, 64, 1, 9, 0),
('skliz', 'Kayode', '0813143343434', 'skliz4rel@yahoo.com', NULL, NULL, NULL, 1, 65, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `message`
--

CREATE TABLE IF NOT EXISTS `message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdate` date DEFAULT NULL,
  `title` text,
  `scriptures` text,
  `message` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  `preacherid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`id`, `mdate`, `title`, `scriptures`, `message`, `rhemabranchid`, `preacherid`) VALUES
(6, '2013-11-18', 'Love', 'Ps 2:11', 'I want to work for God', 1, 7),
(7, '2013-11-18', 'Hatred', 'Ps 2:34', 'I don''t have to hate my friends.', 1, 7),
(9, '2014-01-01', 'Love of God is important', 'Ps 114:1-20,Jn1:2-20', 'The love of God is the greatest gift in the world to happen to mankind.', 1, 15);

-- --------------------------------------------------------

--
-- Table structure for table `mobileapptype`
--

CREATE TABLE IF NOT EXISTS `mobileapptype` (
  `type` char(50) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `mobileapptype`
--

INSERT INTO `mobileapptype` (`type`, `id`) VALUES
('nativeandroid', 1),
('html5', 2);

-- --------------------------------------------------------

--
-- Table structure for table `preacher`
--

CREATE TABLE IF NOT EXISTS `preacher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text,
  `residentPastor` tinyint(1) DEFAULT NULL,
  `rhemabranchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `preacher`
--

INSERT INTO `preacher` (`id`, `name`, `residentPastor`, `rhemabranchid`) VALUES
(12, 'Pastor Caleb ayinla', 1, NULL),
(15, 'REV GEORGE ADEBOYE', 1, NULL),
(16, 'MINISTER DAVID Akindejoye', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `publicmessage`
--

CREATE TABLE IF NOT EXISTS `publicmessage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chatname` text,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

--
-- Dumping data for table `publicmessage`
--

INSERT INTO `publicmessage` (`id`, `chatname`, `message`) VALUES
(1, 'Femi', 'Femi'),
(2, 'Femi', 'Femi'),
(3, 'Femi', 'Femi'),
(4, 'Peter', 'Peter'),
(5, 'Bode', 'Bode'),
(6, 'Chima', 'Chima'),
(7, 'Chima', 'Chima'),
(8, 'Chima', 'Chima'),
(9, 'Chima', 'Chima'),
(10, 'Chima', 'Chima'),
(11, 'Femi', 'asdfasdf'),
(12, 'Felixu', 'how are yo'),
(13, 'Felixu', 'what is this my friend'),
(14, 'Felixu', 'GO on to make this happen'),
(15, 'Felixu', 'When are you coming home my friend'),
(16, 'Felixu', 'good'),
(17, NULL, ''),
(18, NULL, 'what are you saying'),
(19, NULL, 'This is really nice my friend'),
(20, 'Jide', 'my name is jaido'),
(21, 'Jide', 'what do you think friend'),
(22, 'Felix', 'nothing oo padimi'),
(23, 'Felix', 'what are you making this to work for you friend'),
(24, 'Jide', 'me I dont know oo'),
(25, 'Fela', 'what is this'),
(26, 'Fela', 'This is very nice for me my friend'),
(27, 'Felix', 'This is really nice my bro'),
(28, 'Fela', 'I can win this contest men'),
(29, 'Fela', 'I really can my friend'),
(30, 'Felix', 'Look at what I built this is really nice my friend');

-- --------------------------------------------------------

--
-- Table structure for table `question`
--

CREATE TABLE IF NOT EXISTS `question` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ques` text,
  `response` text,
  `messageid` int(11) DEFAULT NULL,
  `memberid` int(11) DEFAULT NULL,
  `qTime` time DEFAULT NULL,
  `qDate` date DEFAULT NULL,
  `rDate` date DEFAULT NULL,
  `rTime` time DEFAULT NULL,
  `rhemabranchid` int(11) DEFAULT NULL,
  `ResponseState` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `question`
--

INSERT INTO `question` (`id`, `ques`, `response`, `messageid`, `memberid`, `qTime`, `qDate`, `rDate`, `rTime`, `rhemabranchid`, `ResponseState`) VALUES
(2, 'What is the meaning of sex', NULL, 9, 63, NULL, NULL, NULL, NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `rhemabranch`
--

CREATE TABLE IF NOT EXISTS `rhemabranch` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `branchname` text,
  `branchaddress` text,
  `countryid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `rhemabranch`
--

INSERT INTO `rhemabranch` (`id`, `branchname`, `branchaddress`, `countryid`) VALUES
(1, 'National Head Quarter', 'Ebute metta west, off filling station', 1),
(2, 'International Head Quarter', 'Illorin, Lokoja, Kwara', 1);

-- --------------------------------------------------------

--
-- Table structure for table `scriptures`
--

CREATE TABLE IF NOT EXISTS `scriptures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `scriptures` text NOT NULL,
  `rhemabranchid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `scriptures`
--


-- --------------------------------------------------------

--
-- Table structure for table `servicelogin`
--

CREATE TABLE IF NOT EXISTS `servicelogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `servicelogin`
--

INSERT INTO `servicelogin` (`id`, `username`, `password`) VALUES
(1, 'skliz', 'xxgoJ59HneuEo'),
(2, 'skliz', 'xxgoJ59HneuEo');

-- --------------------------------------------------------

--
-- Table structure for table `socialchannel`
--

CREATE TABLE IF NOT EXISTS `socialchannel` (
  `name` text,
  `activateState` tinyint(1) DEFAULT NULL,
  `fellowshipid` int(11) DEFAULT NULL,
  `logo` text,
  `rhemabranchid` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `socialchannel`
--

INSERT INTO `socialchannel` (`name`, `activateState`, `fellowshipid`, `logo`, `rhemabranchid`, `id`) VALUES
('test fellowship', 0, 12, '', 1, 1),
('Femilocal', 0, 26, '../Upload/fellowshiplogo/11543PAS1.jpg', 1, 2),
('test fellowship', 0, 27, '../Upload/fellowshiplogo/18705PAS1.jpg', 1, 3),
('Medical Channel', 0, 28, '../Upload/fellowshiplogo/31350PAS1.jpg', 1, 4),
('Social Media Channel', 0, 29, '../Upload/fellowshiplogo/15894PAS1.jpg', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `state`
--

CREATE TABLE IF NOT EXISTS `state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` text,
  `countryid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `state`
--

INSERT INTO `state` (`id`, `Name`, `countryid`) VALUES
(5, 'EDO STATE', 1);

-- --------------------------------------------------------

--
-- Table structure for table `wedding`
--

CREATE TABLE IF NOT EXISTS `wedding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bride` char(70) NOT NULL,
  `groom` char(70) NOT NULL,
  `weddingtime` time DEFAULT NULL,
  `weddingdate` date DEFAULT NULL,
  `weddingaddress` text,
  `receptiondate` date DEFAULT NULL,
  `receptiontime` time DEFAULT NULL,
  `receptionaddress` text,
  `marriedstatus` tinyint(1) DEFAULT NULL,
  `rhemabranchid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `wedding`
--

INSERT INTO `wedding` (`id`, `bride`, `groom`, `weddingtime`, `weddingdate`, `weddingaddress`, `receptiondate`, `receptiontime`, `receptionaddress`, `marriedstatus`, `rhemabranchid`) VALUES
(1, 'Toke', 'Daniel', '01:00:00', '2013-11-23', '13, Ibarapa street, ebute metta west/', '2013-11-23', '02:00:00', 'yaba, lagos', 0, 1),
(2, 'Sanmi', 'Jide', '07:30:00', '2013-11-30', 'yaba, lagos', '2013-11-24', '04:00:00', 'yaba, lagos', 0, 1),
(3, 'Linda', 'Bode', '03:00:00', '2013-11-24', 'ebute metta west', '2013-11-24', '13:00:00', 'ebute metta west', 1, 1),
(4, 'Sister Romoke', 'Brother Seun', '14:00:00', '2014-01-30', '13, Ibarapa street, ebute metta west, Lagos.', '2014-01-15', '12:00:00', '14, badebo street, railway compound, ebute metta west.', 0, 1),
(5, 'Linda Solamide', 'Bode Akindejoye', '03:00:00', '2013-11-24', 'ebute metta west', '2013-11-24', '13:00:00', 'Ketu Lagos.', 0, 1);
