
--
-- Database: `book` and php web application user
CREATE DATABASE book;
GRANT USAGE ON *.* TO 'appuser'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON demo.* TO 'appuser'@'localhost';
FLUSH PRIVILEGES;

USE book;
--
-- Table structure for table `books`
--

CREATE TABLE IF NOT EXISTS `books` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `stock` int(10) NOT NULL,
  `publishDate` DATE NOT NULL,
  `picture` varchar(255),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `title`, `author`, `stock`, `publishDate`, `picture`) VALUES
(1, 'Fairy Tale', 'Stephen King', 50, '2021-02-03','images/fairy.jpg'),
(2, 'Book Lovers', 'Emily Henry', 65, '2022-05-08','images/booklover.jpg'),
(3, 'Lessons in Chemistry', 'Bonnie Garmus ', 80, '2023-04-03','images/chemistry.jpg');

