-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Дек 15 2014 г., 14:55
-- Версия сервера: 5.6.17
-- Версия PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `purchasing_department`
--

-- --------------------------------------------------------

--
-- Структура таблицы `bin`
--

CREATE TABLE IF NOT EXISTS `bin` (
  `Login` varchar(20) NOT NULL,
  `Product` varchar(30) NOT NULL,
  `Number` varchar(5) NOT NULL,
  `Cost` varchar(10) NOT NULL,
  `Status` varchar(20) NOT NULL,
  PRIMARY KEY (`Login`,`Product`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

-- --------------------------------------------------------

--
-- Структура таблицы `manufacturers`
--

CREATE TABLE IF NOT EXISTS `manufacturers` (
  `Firm` varchar(20) NOT NULL,
  `Representer` varchar(20) NOT NULL,
  `Address` varchar(50) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  PRIMARY KEY (`Firm`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `manufacturers`
--

INSERT INTO `manufacturers` (`Firm`, `Representer`, `Address`, `Phone`) VALUES
('Appsy', 'Штопор В.П.', 'Profsouyznaya, 96', '8-495-788-99-22'),
('MasterPhys', 'Топоров А.В.', 'ул.Малоземская, 20', '8-495-781-29-29'),
('Micro', 'Пупкин С.П.', 'ул.Сорокинская, 19', '8-495-999-00-64'),
('Топоры', 'Кукушкина М.В.', 'Лукоморье', '123');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `Product` varchar(20) NOT NULL,
  `Firm` varchar(20) NOT NULL,
  `Price` varchar(10) NOT NULL,
  `Number` varchar(5) NOT NULL,
  `Image_address` varchar(50) NOT NULL,
  PRIMARY KEY (`Product`,`Firm`)
) ENGINE=InnoDB DEFAULT CHARSET=cp1251;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`Product`, `Firm`, `Price`, `Number`, `Image_address`) VALUES
('Lamp', 'Micro', '250', '40', 'images/lamp.jpg'),
('Lamp', 'Топоры', '200', '14', 'images/lamp.jpg'),
('Клавиатура', 'Топоры', '600', '10', 'images/keyboard.jpg'),
('Колба', 'MasterPhys', '90', '400', 'images/colb.jpg'),
('Микроскоп', 'Micro', '2500', '8', 'images/microscope1.jpeg'),
('Радиатор', 'Micro', '1400', '5', 'images/radiator.jpg'),
('Резистор', 'Appsy', '140', '400', 'images/resistor.jpg'),
('Тостер', 'Micro', '600', '68', 'images/toster.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Login` varchar(20) NOT NULL,
  `E-mail` varchar(30) NOT NULL,
  `Password` varchar(50) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=InnoDB  DEFAULT CHARSET=cp1251 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`ID`, `Login`, `E-mail`, `Password`) VALUES
(1, 'admin', 'admin@gmail.com', 'd8578edf8458ce06fbc5bb76a58c5ca4'),
(2, 'Anna', 'anna@gmail.com', 'b59c67bf196a4758191e42f76670ceba'),
(3, 'zhenya', 'zhenya@yandex.ru', '81dc9bdb52d04dc20036dbd8313ed055');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
