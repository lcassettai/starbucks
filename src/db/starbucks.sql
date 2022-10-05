-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-09-2022 a las 04:42:02
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `starbucks`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellido` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nombre`, `apellido`, `email`, `password`) VALUES
(1, ' Luciano', ' cassettai', 'demo@demo.com', 'demo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empleado`
--

CREATE TABLE `empleado` (
  `id_empleado` int(11) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `apellido` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `empleado`
--

INSERT INTO `empleado` (`id_empleado`, `nombre`, `apellido`) VALUES
(1, 'Guillermo', 'Navarro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estados_pedidos`
--

CREATE TABLE `estados_pedidos` (
  `id_estado` int(11) NOT NULL,
  `estado` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `estados_pedidos`
--

INSERT INTO `estados_pedidos` (`id_estado`, `estado`) VALUES
(1, 'SOLICITADO'),
(2, 'ENTREGADO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id_pedido` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_empleado` int(11) NOT NULL,
  `id_estado` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedidos`
--

INSERT INTO `pedidos` (`id_pedido`, `id_cliente`, `id_empleado`, `id_estado`, `fecha`) VALUES
(1, 1, 1, 1, '2022-09-22'),
(52, 1, 1, 2, '2022-09-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido_detalle`
--

CREATE TABLE `pedido_detalle` (
  `id_detalle` int(11) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `id_producto` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `pedido_detalle`
--

INSERT INTO `pedido_detalle` (`id_detalle`, `id_pedido`, `cantidad`, `precio`, `id_producto`) VALUES
(1, 1, 2, '200', 1),
(2, 1, 1, '400', 2),
(3, 52, 2, '400', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `producto` varchar(250) NOT NULL,
  `precio` decimal(10,0) NOT NULL,
  `descripcion` text NOT NULL,
  `stock` int(11) NOT NULL,
  `imagen` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `producto`, `precio`, `descripcion`,`stock`,`imagen`) VALUES
(1,'Skinny Vainilla Latte',382,'Skinny Vainilla Latte',38,''),
(2,'Cappuccino',347,'Cappuccino',25,''),
(3,'Flat White',338,'Flat White',16,''),
(4,'Americano',320,'Americano',7,''),
(5,'Latte Macchiato',388,'Latte Macchiato',24,''),
(6,'Mocha Blanco',316,'Mocha Blanco',40,''),
(7,'Café del día con leche',452,'Café del día con leche',35,''),
(8,'Avellana Shaken Espresso con Avena Helado',462,'Avellana Shaken Espresso con Avena Helado',28,''),
(9,'Skinny Caramel Macchiato Helado',406,'Skinny Caramel Macchiato Helado',15,''),
(10,'Cappuccino Helado',451,'Cappuccino Helado',12,''),
(11,'Skinny Vainilla Latte Helado',429,'Skinny Vainilla Latte Helado',8,''),
(12,'Cold Brew Cold Foam',303,'Cold Brew Cold Foam',23,''),
(13,'Americano Helado',438,'Americano Helado',4,''),
(14,'Mocha Blanco Helado',302,'Mocha Blanco Helado',13,''),
(15,'Café del día con leche Helado',456,'Café del día con leche Helado',9,''),
(16,'Café Frappuccino',287,'Café Frappuccino',20,''),
(17,'Chai Frappuccino',466,'Chai Frappuccino',2,''),
(18,'Mint Citrus',382,'Mint Citrus',11,''),
(19,'Chai',266,'Cha"i"',32,''),
(20,'Youthberry',414,'Youthberry',17,''),
(21,'Earl Grey',264,'Earl Grey',35,''),
(22,'Shaken Lemonade Hibiscus',369,'Shaken Lemonade Hibiscus',33,''),
(23,'Shaken Lemonade Green Tea',467,'Shaken Lemonade Green Tea',36,''),
(24,'Mango Dragonfruit Limonada',266,'Mango Dragonfruit Limonada',21,''),
(25,'Jugo de Manzana',301,'Jugo de Manzana',33,''),
(26,'Chocolate Caliente',315,'Chocolate Caliente',33,''),
(27,'Croissant Relleno con Crema de Avellanas',359,'Croissant Relleno con Crema de Avellanas',31,''),
(28,'Trenzado de Ricota y Citricos',270,'Trenzado de Ricota y Citricos',34,''),
(29,'CheeseAvocado Scon',318,'CheeseAvocado Scon',18,''),
(30,'Muffin de Arandanos',301,'Muffin de Arandanos',11,''),
(31,'Banana Loaf Cake',352,'Banana Loaf Cake',19,''),
(32,'Cheesecake Frutos Rojos',449,'Cheesecake Frutos Rojos',20,''),
(33,'Sandwich con Jamon y Queso en Pan Artesanal',420,'Sandwich con Jamon y Queso en Pan Artesanal',11,''),
(34,'Porridge Avena Chocolate y Mani',338,'Porridge Avena Chocolate y Mani',3,''),
(35,'Moneda de Chocolate',316,'Moneda de Chocolate',25,''),
(36,'Biscotti con Castañas',292,'Biscotti con Castañas',22,''),
(37,'Nicaragua Single Origin',439,'Nicaragua Single Origin',15,''),
(38,'Guatemala Casi Cielo',284,'Guatemala Casi Cielo',32,''),
(39,'Café Sumatra',435,'Café Sumatra',30,''),
(40,'Te Hibiscus',461,'Te Hibiscus',39,''),
(41,'Te Chai',309,'Te Chai',25,''),
(42,'Te Earl Grey',250,'Te Earl Grey',5,''),
(43,'Te Mint Citrus',402,'Te Mint Citrus',19,'');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`),
  ADD KEY `id_cliente` (`id_cliente`);

--
-- Indices de la tabla `empleado`
--
ALTER TABLE `empleado`
  ADD PRIMARY KEY (`id_empleado`);

--
-- Indices de la tabla `estados_pedidos`
--
ALTER TABLE `estados_pedidos`
  ADD PRIMARY KEY (`id_estado`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id_pedido`),
  ADD KEY `id_cliente` (`id_cliente`),
  ADD KEY `id_empleado` (`id_empleado`),
  ADD KEY `id_estado` (`id_estado`);

--
-- Indices de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD PRIMARY KEY (`id_detalle`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `empleado`
--
ALTER TABLE `empleado`
  MODIFY `id_empleado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `estados_pedidos`
--
ALTER TABLE `estados_pedidos`
  MODIFY `id_estado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  MODIFY `id_detalle` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=323;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`),
  ADD CONSTRAINT `pedidos_ibfk_3` FOREIGN KEY (`id_estado`) REFERENCES `estados_pedidos` (`id_estado`);

--
-- Filtros para la tabla `pedido_detalle`
--
ALTER TABLE `pedido_detalle`
  ADD CONSTRAINT `pedido_detalle_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `pedido_detalle_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos` (`id_pedido`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
