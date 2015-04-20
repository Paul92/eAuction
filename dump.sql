-- MySQL dump 10.15  Distrib 10.0.16-MariaDB, for Linux (x86_64)
--
-- Host: localhost    Database: 2014_comp10120_y7
-- ------------------------------------------------------
-- Server version	10.0.16-MariaDB-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `address`
--

DROP TABLE IF EXISTS `address`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `county` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `addressLine1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `addressLine2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `postCode` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `address`
--

LOCK TABLES `address` WRITE;
/*!40000 ALTER TABLE `address` DISABLE KEYS */;
INSERT INTO `address` (`id`, `country`, `county`, `city`, `addressLine1`, `addressLine2`, `postCode`) VALUES (34,'someCountry','someCounty','someCit','addrline1','','somePostCode'),(35,'contry','asdf','city','asfd','df','asdf'),(36,'Romania','Judet','Ghidfalau','Strada Graului, 12','','13800'),(37,'Romania','Judet','Ghidfalaufd','Strada Graului, 12','','13800'),(38,'Romania','Judet','Ghidfalaufdsdf','Strada Graului, 12','','13800'),(39,'sdfsa','asdfdas','sfdaadf','sdfgdaasdfsdaasdfsa','','fadfs'),(40,'fdafgasfd','dsgds','sdfdsa','fdasgda','','fadfs'),(41,'advaa','fadsfas','afdsaf','sfdsa','','adsfags'),(42,'asdfsdf','sdfasfdas','sad','afsda','','fdfs');
/*!40000 ALTER TABLE `address` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertisments`
--

DROP TABLE IF EXISTS `advertisments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertisments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertisments`
--

LOCK TABLES `advertisments` WRITE;
/*!40000 ALTER TABLE `advertisments` DISABLE KEYS */;
/*!40000 ALTER TABLE `advertisments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auctionType`
--

DROP TABLE IF EXISTS `auctionType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auctionType` (
  `id` int(1) DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auctionType`
--

LOCK TABLES `auctionType` WRITE;
/*!40000 ALTER TABLE `auctionType` DISABLE KEYS */;
INSERT INTO `auctionType` (`id`, `name`) VALUES (1,'English Auction'),(2,'Dutch Auction'),(3,'English Auction with hidden bids'),(4,'Vickery Auction'),(5,'Buy it now');
/*!40000 ALTER TABLE `auctionType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `bid`
--

DROP TABLE IF EXISTS `bid`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `bidderId` int(11) NOT NULL,
  `itemId` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bid`
--

LOCK TABLES `bid` WRITE;
/*!40000 ALTER TABLE `bid` DISABLE KEYS */;
INSERT INTO `bid` (`id`, `value`, `time`, `bidderId`, `itemId`) VALUES (1,20,'2015-03-10 01:20:04',1,1),(2,23,'2015-03-10 01:23:10',1,1),(3,30,'2015-03-10 11:19:35',1,1),(4,40,'2015-03-10 15:10:36',1,1),(5,321,'2015-03-10 15:11:14',1,1),(6,200,'2015-03-11 23:06:39',1,19),(7,200,'2015-03-13 04:17:31',1,25),(8,300,'2015-03-13 04:17:37',1,20),(9,500,'2015-03-13 04:17:43',1,20),(10,550,'2015-03-15 23:11:04',6,20);
/*!40000 ALTER TABLE `bid` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category`
--

DROP TABLE IF EXISTS `category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category`
--

LOCK TABLES `category` WRITE;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`id`, `name`) VALUES (1,'Antiques'),(2,'Art'),(3,'Baby'),(4,'Books Comics & Magazines'),(5,'Business Office & Industrial'),(6,'Cameras & Photography'),(7,'Cars Motorcycles & Vehicles'),(8,'Clothes Shoes & Accessories'),(9,'Coins'),(10,'Computers/Tablets & Networking'),(11,'DVDs Films & TV'),(12,'Event Tickets'),(13,'Garden & Outdoors'),(14,'Health & Beauty'),(15,'Home & Furniture'),(16,'Jewellery & Watches'),(17,'Mobile Phones & Communications'),(18,'Music'),(19,'Property'),(20,'Sporting Goods'),(21,'Toys & Games'),(22,'Vehicle Parts & Accessories'),(23,'Everything else');
/*!40000 ALTER TABLE `category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `files`
--

DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `files`
--

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `image`
--

DROP TABLE IF EXISTS `image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filePath` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `itemId` int(11) NOT NULL,
  `main` tinyint(1) DEFAULT '0',
  `size` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnailPath` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `thumbnailSize` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `itemId` (`itemId`),
  CONSTRAINT `image_ibfk_1` FOREIGN KEY (`itemId`) REFERENCES `item` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `image`
--

LOCK TABLES `image` WRITE;
/*!40000 ALTER TABLE `image` DISABLE KEYS */;
INSERT INTO `image` (`id`, `filePath`, `itemId`, `main`, `size`, `thumbnailPath`, `thumbnailSize`) VALUES (1,'permanentStorage/1_vim-shortcuts.png',1,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(2,'permanentStorage/2_scrn6.jpg',2,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(3,'permanentStorage/5_scrn4.jpg',5,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(4,'permanentStorage/5_scrn5.jpg',5,0,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(5,'permanentStorage/6_chair3.jpg',6,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(6,'permanentStorage/7_scrn4.jpg',7,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(7,'permanentStorage/8_scrn2.jpg',8,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(8,'permanentStorage/9_chair2.jpg',9,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(9,'permanentStorage/10_scrn3.jpg',10,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(10,'permanentStorage/11_scrn3.jpg',11,0,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(11,'permanentStorage/11_scrn6.jpg',11,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(12,'permanentStorage/12_scrn5.jpg',12,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(13,'permanentStorage/13_scrn5.jpg',13,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(14,'permanentStorage/14_scrn6.jpg',14,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(15,'permanentStorage/16_scrn6.jpg',16,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(16,'permanentStorage/17_scrn2.jpg',17,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(17,'permanentStorage/17_vim-shortcuts.png',17,0,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(18,'permanentStorage/18_scrn1.jpg',18,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(19,'permanentStorage/19_vim-shortcuts.png',19,1,'1024x1024','permanentStorage/thumbnail/30_lamp1.jpg',NULL),(20,'permanentStorage/20_vim-shortcuts.png',20,1,'1920x1200','thumbnail/20_vim-shortcuts.png',NULL),(21,'permanentStorage/21_laptop2.jpg',21,1,'260x194','thumbnail/21_laptop2.jpg',NULL),(22,'permanentStorage/22_camera2.jpg',22,1,'1500x1334','thumbnail/22_camera2.jpg',NULL),(23,'permanentStorage/22_lamp2.jpg',22,0,'1000x1000','thumbnail/22_lamp2.jpg',NULL),(24,'permanentStorage/23_headphones3.jpg',23,1,'225x225','thumbnail/23_headphones3.jpg',NULL),(25,'permanentStorage/24_chair2.jpg',24,1,'168x300','thumbnail/24_chair2.jpg','45x80'),(26,'permanentStorage/25_download.jpg',25,0,'225x225','thumbnail/25_download.jpg','80x80'),(27,'permanentStorage/25_headphones2.jpg',25,1,'328x450','thumbnail/25_headphones2.jpg','58x80'),(28,'permanentStorage/25_laptop1.jpg',25,0,'275x183','thumbnail/25_laptop1.jpg','80x53'),(29,'permanentStorage/26_logo1.png',26,1,'514x515','thumbnail/26_logo1.png','80x80'),(30,'permanentStorage/28_download (1).jpg',28,0,'173x291','permanentStorage/thumbnail/28_download (1).jpg','48x80'),(31,'permanentStorage/30_lamp1.jpg',30,0,'179x282','permanentStorage/thumbnail/30_lamp1.jpg','51x80'),(32,'permanentStorage/30_lamp2.jpg',30,0,'1000x1000','permanentStorage/thumbnail/30_lamp2.jpg','80x80'),(33,'permanentStorage/30_laptop1.jpg',30,0,'275x183','permanentStorage/thumbnail/30_laptop1.jpg','80x53'),(34,'permanentStorage/30_laptop2.jpg',30,0,'260x194','permanentStorage/thumbnail/30_laptop2.jpg','80x60'),(35,'permanentStorage/30_laptop3.jpg',30,1,'275x183','permanentStorage/thumbnail/30_laptop3.jpg','80x53'),(36,'permanentStorage/62_headphones1.jpg',62,0,'225x225','permanentStorage/thumbnail/62_headphones1.jpg','80x80'),(37,'permanentStorage/62_headphones2.jpg',62,0,'328x450','permanentStorage/thumbnail/62_headphones2.jpg','58x80'),(38,'permanentStorage/62_headphones3.jpg',62,0,'225x225','permanentStorage/thumbnail/62_headphones3.jpg','80x80'),(39,'permanentStorage/62_lamp1.jpg',62,1,'179x282','permanentStorage/thumbnail/62_lamp1.jpg','51x80');
/*!40000 ALTER TABLE `image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item`
--

DROP TABLE IF EXISTS `item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sellerId` int(11) DEFAULT NULL,
  `categoryId` int(2) DEFAULT NULL,
  `auctionType` int(1) DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `startPrice` int(4) DEFAULT NULL,
  `featured` tinyint(1) DEFAULT '0',
  `startDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_categoryId` (`categoryId`),
  KEY `sellerId_fk` (`sellerId`),
  CONSTRAINT `fk_categoryId` FOREIGN KEY (`categoryId`) REFERENCES `category` (`id`),
  CONSTRAINT `sellerId_fk` FOREIGN KEY (`sellerId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item`
--

LOCK TABLES `item` WRITE;
/*!40000 ALTER TABLE `item` DISABLE KEYS */;
INSERT INTO `item` (`id`, `name`, `description`, `sellerId`, `categoryId`, `auctionType`, `endDate`, `startPrice`, `featured`, `startDate`) VALUES (1,'daf','afd',1,1,1,'2015-03-15',10,1,'2015-03-07'),(2,'adfs','adf',1,1,1,'2015-03-19',12,1,'2015-03-07'),(3,'Photo Camera','This is a photo camera',1,6,1,'2015-03-17',300,1,'2015-03-07'),(4,'Camera2','adsf',1,6,1,'2015-03-08',23,1,'2015-03-07'),(5,'fasd','fdas',1,1,1,'2015-03-17',10,0,'2015-03-07'),(6,'asdf','asfdsa',1,1,1,'2015-03-10',123,0,'2015-03-07'),(7,'sdfas','dfas',1,1,1,'2015-03-10',213,1,'2015-03-07'),(8,'adfsfds','asdf',1,1,1,'2015-03-08',12,1,'2015-03-07'),(9,'fdawer','asdfs',1,1,1,'2015-03-09',1,1,'2015-03-07'),(10,'fsewfsd','asfds',1,1,1,'2015-03-10',324,1,'2015-03-07'),(11,'sgdff','fadsfdsa',1,1,1,'2015-03-30',100,1,'2015-03-07'),(12,'dutch item','this is an item sold in a Dutch auction',1,9,2,'2015-03-21',300,0,'2015-03-07'),(13,'English hidden','this is an English auction with hidden bids',1,9,1,'2015-03-31',200,0,NULL),(14,'english hidden 2','fdasfdsa',1,1,3,'2015-03-21',100,0,NULL),(15,'new item','some item',1,1,4,'2015-03-21',200,0,NULL),(16,'new item 2','fdsa',1,1,4,'2015-03-21',100,0,'2015-03-11'),(17,'some item','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id porta sapien. Sed hendrerit augue id dolor semper auctor. Phasellus mollis ex sit amet nunc blandit tempus. Sed ac lacus ut neque malesuada facilisis sed nec tortor. Nulla facilisi. Nullam rutrum, tellus eu vestibulum fermentum, augue leo maximus purus, eget efficitur.',1,1,1,'2015-03-21',200,0,'2015-03-11'),(18,'new item 2=3','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec id porta sapien. Sed hendrerit augue id dolor semper auctor. Phasellus mollis ex sit amet nunc blandit tempus. Sed ac lacus ut neque malesuada facilisis sed nec tortor. Nulla facilisi. Nullam rutrum, tellus eu vestibulum fermentum, augue leo maximus purus, eget efficitur.',1,1,1,'2015-03-21',100,0,'2015-03-11'),(19,'last item','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ut tellus mollis, consectetur lectus nec, eleifend ipsum. Suspendisse vitae volutpat nibh. Nam iaculis condimentum eros, et mollis nisl rutrum ac. Proin lobortis mauris nec tempus gravida. Sed feugiat non nisi et accumsan. Sed ultricies nisi odio, at ultricies nibh varius in. Curabitur malesuada libero lectus, eget vulputate sapien malesuada id. Sed a mauris a velit eleifend placerat eu lacinia lectus. Donec purus enim, tincidunt ut lacinia ut, accumsan quis felis. Nulla sed scelerisque orci. Phasellus commodo justo eu diam cursus, quis bibendum felis gravida. Etiam condimentum at tellus at consequat.',1,1,1,'2015-03-21',100,0,'2015-03-11'),(20,'some item2','asdf',1,1,1,'2015-03-22',10,0,'2015-03-12'),(21,'asfdsg','fdsa',1,1,1,'2015-03-22',10,0,'2015-03-12'),(22,'laptop','asdfa',1,1,1,'2015-03-13',20,0,'2015-03-12'),(23,'asdfs','fads',1,1,1,'2015-03-13',10,0,'2015-03-12'),(24,'sfads','fadf',1,1,1,'2015-03-13',10,0,'2015-03-12'),(25,'fdafdsa','fdafsd',1,1,1,'2015-03-22',10,0,'2015-03-12'),(26,'some','fddsa',1,1,1,'2015-03-13',10,0,'2015-03-12'),(27,'asdfsa','dfa',1,1,1,'2015-03-22',10,0,'2015-03-12'),(28,'asdfa','fdsaf',1,1,1,'2015-03-17',5,0,'2015-03-12'),(29,'some item 5','daffasdfa',1,1,1,'2015-03-22',10,0,'2015-03-12'),(30,'gvhjhb','gfdagfd',1,1,1,'2015-03-13',1,0,'2015-03-12'),(31,'dsf','afsd',1,1,1,'2015-03-14',1,0,'2015-03-13'),(32,'adsf','dafd',1,1,1,'2015-03-24',1,1,'2015-03-14'),(33,'adfasdfa','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(34,'adfasdfasfdd','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(35,'adfasdfasfddsd','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(36,'adfasdfasfddsds','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(37,'adfasdfasfddsdss','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(38,'adfasdfasdfa','afdsas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(39,'asdfarewavd','dfads',1,1,1,'2015-03-15',1,1,'2015-03-14'),(40,'fasdfas','fdsafdsa',1,1,1,'2015-03-15',1,0,'2015-03-14'),(41,'adfas','fda',1,1,1,'2015-03-15',1,1,'2015-03-14'),(42,'adfasfds','fda',1,1,1,'2015-03-15',1,1,'2015-03-14'),(43,'adfasfdsdfs','fda',1,1,1,'2015-03-15',1,1,'2015-03-14'),(44,'gdsfdg','fdas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(45,'gdsfdgsdf','fdas',1,1,1,'2015-03-15',1,1,'2015-03-14'),(46,'vzxcd','fdas',1,1,1,'2015-03-15',1,0,'2015-03-14'),(47,'fadssdfs','fdsa',1,1,1,'2015-03-15',1,1,'2015-03-14'),(48,'asdfas','sfd',1,1,1,'2015-03-15',1,1,'2015-03-14'),(49,'fdasfdas','fdsa',1,1,1,'2015-03-15',1,1,'2015-03-14'),(50,'fasfdas','fdasfa',1,1,1,'2015-03-15',100,1,'2015-03-14'),(51,'fasfdasfsd','fdasfa',1,1,1,'2015-03-15',100,1,'2015-03-14'),(52,'fadsfa','fasdf',1,1,1,'2015-03-15',1,1,'2015-03-14'),(53,'fadsfagf','fasdf',1,1,1,'2015-03-15',1,1,'2015-03-14'),(54,'fadsfagfgf','fasdf',1,1,1,'2015-03-15',1,1,'2015-03-14'),(55,'asdfdas','adfssa',1,1,1,'2015-03-15',1,1,'2015-03-14'),(56,'adsfs','fdsa',1,1,1,'2015-03-15',1,1,'2015-03-14'),(57,'adfsa','fdafd',1,1,1,'2015-03-16',1,1,'2015-03-14'),(58,'fasdfa','fadsfs',1,1,1,'2015-03-15',12,1,'2015-03-14'),(59,'asdfsafd','fdaf',1,1,1,'2015-03-16',2,1,'2015-03-14'),(60,'df','fdsa',1,1,1,'2015-04-04',12,1,'2015-03-14'),(61,'adsfas','adsfas',1,1,1,'2015-03-16',12312,1,'2015-03-14'),(62,'adsff','fdasfd',1,1,1,'2015-03-15',12,1,'2015-03-14'),(63,'sdfsds','dfas',1,1,1,'2015-03-19',2100,1,'2015-03-17');
/*!40000 ALTER TABLE `item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `messageId` int(5) NOT NULL AUTO_INCREMENT,
  `messageString` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` int(5) DEFAULT NULL,
  `seen` tinyint(1) DEFAULT '0',
  `auctionWon` int(5) DEFAULT NULL,
  PRIMARY KEY (`messageId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment` (
  `transactionId` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `token` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `userId` int(5) DEFAULT NULL,
  `itemName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paymentDescription` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `itemPrice` int(5) DEFAULT NULL,
  `grandTotal` int(5) DEFAULT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`transactionId`),
  KEY `userId` (`userId`),
  CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment`
--

LOCK TABLES `payment` WRITE;
/*!40000 ALTER TABLE `payment` DISABLE KEYS */;
INSERT INTO `payment` (`transactionId`, `token`, `userId`, `itemName`, `paymentDescription`, `itemPrice`, `grandTotal`, `time`) VALUES ('0KY88800JK990050U','EC-2PT98342JH833412R',1,NULL,NULL,NULL,NULL,'2015-03-14 22:33:55'),('0MB32984DS7968457','EC-1W681353X4876750E',1,'Featured payment','Featured payment for sdfsds',10,10,'2015-03-17 15:18:07'),('4LS519365S7550805','EC-3BK982026D070324V',1,'Featured payment','Featured payment for adsff',10,10,'2015-03-14 22:33:55');
/*!40000 ALTER TABLE `payment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report`
--

DROP TABLE IF EXISTS `report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report` (
  `data` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `userId` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `userId` (`userId`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report`
--

LOCK TABLES `report` WRITE;
/*!40000 ALTER TABLE `report` DISABLE KEYS */;
/*!40000 ALTER TABLE `report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `firstName` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `middleName` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `rating` int(11) DEFAULT '50',
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT '0',
  `billingAddress` int(11) DEFAULT NULL,
  `phone` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PayPalEmail` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billingAddress` (`billingAddress`),
  CONSTRAINT `billingAddress` FOREIGN KEY (`billingAddress`) REFERENCES `address` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `nickname`, `surname`, `firstName`, `middleName`, `title`, `rating`, `email`, `password`, `verified`, `billingAddress`, `phone`, `PayPalEmail`) VALUES (1,'john','surname','first','','Mr.',50,'email@something.com','qwer12',0,NULL,'0000000000','hasman2008ukseller1@hotmail.co.uk'),(2,'vlad','Advan','Mercedesa','Curaj','Mr.',50,'muceica@harvard.edu','12qw12',0,NULL,'0777777777','hasman2008ukseller1@hotmail.co.uk'),(3,'myNicknem','asdf','fda','sdfa','Mr.',50,'fd@fad.cdfa','qw12qw',0,NULL,'0000000000','hasman2008ukseller1@hotmail.co.uk'),(4,'asdfseerwf','fasdfa','safdsw','asdfsa','Mr.',50,'fdas@fda.cda','qw12qw',0,NULL,'0000000000','hasman2008ukseller1@hotmail.co.uk'),(5,'fadsfaa','adsfas','fafdsaf','asdfa','Ms.',50,'safd@mfda.fdasf','qw12qw',0,NULL,'0000000000','hasman2008ukseller1@hotmail.co.uk'),(6,'johnny','sadf','asdf','asdf','Mr.',50,'email@sth.com','qwer12',0,NULL,'0000000000','hasman2008ukseller1@hotmail.co.uk');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usersTEST`
--

DROP TABLE IF EXISTS `usersTEST`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usersTEST` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usersTEST`
--

LOCK TABLES `usersTEST` WRITE;
/*!40000 ALTER TABLE `usersTEST` DISABLE KEYS */;
INSERT INTO `usersTEST` (`id`, `login`, `password`) VALUES (1,'john','abc'),(2,'sam','12345');
/*!40000 ALTER TABLE `usersTEST` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wonAuctions`
--

DROP TABLE IF EXISTS `wonAuctions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wonAuctions` (
  `userId` int(5) DEFAULT NULL,
  `itemId` int(5) NOT NULL,
  `value` int(5) DEFAULT NULL,
  `payed` tinyint(1) DEFAULT '0',
  `date` date DEFAULT NULL,
  PRIMARY KEY (`itemId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wonAuctions`
--

LOCK TABLES `wonAuctions` WRITE;
/*!40000 ALTER TABLE `wonAuctions` DISABLE KEYS */;
INSERT INTO `wonAuctions` (`userId`, `itemId`, `value`, `payed`, `date`) VALUES (1,1,321,0,'2015-03-17');
/*!40000 ALTER TABLE `wonAuctions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-18 21:05:16
