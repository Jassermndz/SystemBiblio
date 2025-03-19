-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-03-2025 a las 18:25:57
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bibliotecadb`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `administradores`
--

CREATE TABLE `administradores` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `rol` enum('Administrador','Empleado') DEFAULT 'Empleado',
  `imagen` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `administradores`
--

INSERT INTO `administradores` (`id`, `usuario`, `contrasena`, `rol`, `imagen`) VALUES
(1, 'KMENDEZ', '$2y$10$WXNyK6URi2LXOpXVxgjZjeIJ3RTmjz1zXjUOuVhD1QQLlBQjOoE6a', 'Administrador', '../uploads/67b0f1e0c3d1d-5460794.png'),
(2, 'NPALMA', '$2y$10$Rl9wpADg1SVn9/EtXNAVgOm0DhlGfs/rN3n/Dn.WVCV/2WBkd9Zq6', 'Empleado', '../uploads/67a675808ca95-imgperfil.png'),
(3, 'AREYES', '$2y$10$ZdsCAAn7obgnNyh6z.Yyc.EfxIioV5O.WHxrNKlQSPNH7okqexilK', 'Administrador', '../uploads/67a5942cc8502-ASDAD.png'),
(4, 'OMARADIAGA', '$2y$10$LU4fkv7k6YQ8w8Qyh3UYjuISpb9q0Nw4UMVlpC0kfzuHYX7nY5/8i', 'Administrador', '../uploads/67a653ad93a6e-Imagen de WhatsApp 2025-01-22 a las 15.37.20_c8a1855d.jpg'),
(5, 'MVAZQUES', '$2y$10$/0ALDMw9esWWsTsjOv1vGO5otuLgN9yOepGwEuE5X/M7sTtMzYsPu', 'Administrador', NULL),
(6, 'JLUIS', '$2y$10$de3R0RoUZ8Z/bZx6CVFUcuIpi2yzo.dd.hhsM4wRoDm13f2JnvUb6', 'Administrador', NULL),
(7, 'SCRUZ', '$2y$10$2ayfo7L1M0UAtRWVS2oxJewDrwBLHoIsGoiaoatisdgaVcqdTR0Xu', 'Administrador', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(5, 'Arte'),
(2, 'Ciencia'),
(1, 'Ficción'),
(6, 'Filosofía'),
(3, 'Historia'),
(7, 'Literatura'),
(10, 'Metafísica'),
(8, 'Misterio'),
(11, 'Poesia'),
(9, 'Sociales'),
(12, 'Sociedad'),
(4, 'Tecnología');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `devoluciones`
--

CREATE TABLE `devoluciones` (
  `id` int(11) NOT NULL,
  `id_prestamo` int(11) DEFAULT NULL,
  `fecha_devolucion` date DEFAULT curdate(),
  `observaciones` text DEFAULT NULL,
  `estado` enum('Devuelto','No Devuelto') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `libros`
--

CREATE TABLE `libros` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `autor` varchar(255) NOT NULL,
  `editorial` varchar(255) DEFAULT NULL,
  `anio_publicacion` int(11) DEFAULT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `cantidad_disponible` int(11) DEFAULT 0,
  `estanteria` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `pdf` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `libros`
--

INSERT INTO `libros` (`id`, `titulo`, `autor`, `editorial`, `anio_publicacion`, `isbn`, `cantidad_disponible`, `estanteria`, `id_categoria`, `imagen`, `pdf`) VALUES
(1, 'Alas de ónix (Empíreo 3)', 'Oniel Reyes ', 'Perla Negra', 2025, '50446-47896-7895', 25, '2', 1, 'uploads/67a659cb70643.png', NULL),
(20, 'Un animal salvaje', 'Dicker, Joël', 'ALFAGUARA', 2024, ' 978-84-204-7684-1', 25, '3', 1, 'uploads/679ef2ca4efd8.png', NULL),
(21, 'La grieta del silencio', ' Castillo, Javier', ' SUMA', 2024, ' 978-84-9129-601-0', 35, '5', 8, 'uploads/679ef302e148e.png', NULL),
(22, 'El hijo olvidado', ' Santiago, Mikel', 'B', 2024, '978-84-666-7731-8', 45, '1', 3, 'uploads/679ef3567edd3.png', NULL),
(23, 'La casa de la noche', ' Nesbo, Jo', ' RESERVOIR BOOKS', 2024, ' 978-84-19437-70-9', 25, '3', 8, 'uploads/679ef3abaf22d.png', NULL),
(25, 'La península de las casas vacías', 'Uclés, David', ' Siruela', 2025, ' 978-84-19942-31-9', 25, '3', 3, 'uploads/67a649b34af24.png', NULL),
(26, 'La vegetariana', 'Kang, Han', 'Random House', 2024, '978-84-397-4389-7', 60, '2', 1, 'uploads/67a651ad908bc.png', NULL),
(27, 'Matematicas 7', 'Secretaría de Educación', 'Secretaría de Educación', 2020, '789-563-21', 250, '3', 10, 'uploads/67c67d191f2d0.jpg', 'uploads/pdfs/67c67d191fabd.pdf');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensajes`
--

CREATE TABLE `mensajes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `asunto` varchar(255) NOT NULL,
  `mensaje` text NOT NULL,
  `fecha_envio` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensajes`
--

INSERT INTO `mensajes` (`id`, `nombre`, `email`, `asunto`, `mensaje`, `fecha_envio`) VALUES
(1, 'Marco Vazques', 'ipod20314@gmail.com', 'ENVIO DE PINGIN', 'PINGIN ENVIADO', '2025-03-07 05:28:10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `prestamos`
--

CREATE TABLE `prestamos` (
  `id` int(11) NOT NULL,
  `id_libro` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha_prestamo` date DEFAULT curdate(),
  `fecha_devolucion` date DEFAULT NULL,
  `estado` enum('Prestado','Devuelto') DEFAULT 'Prestado'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `prestamos`
--

INSERT INTO `prestamos` (`id`, `id_libro`, `id_usuario`, `fecha_prestamo`, `fecha_devolucion`, `estado`) VALUES
(12, 1, 2, '2025-02-06', '2025-02-05', 'Prestado'),
(14, 1, 4, '2025-02-23', '2025-03-08', 'Prestado'),
(16, 20, 1, '2025-02-28', '2025-03-07', 'Prestado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `tipo` enum('Estudiante','Profesor','Publico') NOT NULL,
  `password` varchar(255) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `email`, `telefono`, `direccion`, `tipo`, `password`, `fecha_registro`) VALUES
(1, 'Marco ', 'Marcvazques@gmail.com', '98456323', 'Santa Marta', 'Estudiante', '$2y$10$QGxvaGkD2iJesJ1sMNvnkuO1BxVCY3VaZwBuLVZKrEFva1wxxh52K', '2025-03-06 22:39:37'),
(2, 'Klisman Mendez', 'klismanmendez530@gmail.com', '8945-5939', 'Barrio El Estadio ', 'Publico', '$2y$10$9zR6DTz5FXKZygM4eZC69uADimtskbv6p/19YgKBdNEhvY8HLa56u', '2025-03-06 22:35:34'),
(4, 'Oniel Maradiaga', 'OnielReyes@gmail.com', '4568-4589', 'Namasigue', 'Estudiante', '', '2025-01-31 05:50:27'),
(11, 'Adrian Reyes', 'Adrianreyes@gmail.com', '8545-2536', 'B Venecia', 'Estudiante', '', '2025-02-05 21:22:30'),
(12, 'Freddys Flores', 'aldair@gmail.com', '3256-4563', 'San jeronimo', 'Profesor', '', '2025-02-05 21:24:18'),
(13, 'Karina Alvarez', 'karina@gmail.com', '7895-4536', 'San jeronimo ', 'Estudiante', '', '2025-02-07 19:28:34'),
(14, 'Lizeth De Reyes', 'lizethReyes@gmail.com', '5489-4586', 'Namasigue', 'Publico', '$2y$10$fsDNBZonQGI2m4t0cjSin.w5N7cMCgOUZ.hRZBaDd9nqXuqvkNc6C', '2025-03-03 01:28:32'),
(15, 'Luis Miguel', 'luismi12@gmail.com', '2247-4302', 'A la par del estadio.', 'Publico', '$2y$10$dQJmxX5FsZuEk.rkiBqqI.NqKh4w2lfh9lZ3zcstQDQsWm0Yj4aCy', '2025-03-05 01:51:33');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `administradores`
--
ALTER TABLE `administradores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usuario` (`usuario`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_prestamo` (`id_prestamo`);

--
-- Indices de la tabla `libros`
--
ALTER TABLE `libros`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `isbn` (`isbn`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Indices de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_libro` (`id_libro`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `administradores`
--
ALTER TABLE `administradores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `libros`
--
ALTER TABLE `libros`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `mensajes`
--
ALTER TABLE `mensajes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `prestamos`
--
ALTER TABLE `prestamos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `devoluciones`
--
ALTER TABLE `devoluciones`
  ADD CONSTRAINT `devoluciones_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamos` (`id`);

--
-- Filtros para la tabla `libros`
--
ALTER TABLE `libros`
  ADD CONSTRAINT `libros_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`);

--
-- Filtros para la tabla `prestamos`
--
ALTER TABLE `prestamos`
  ADD CONSTRAINT `fk_libro` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `prestamos_ibfk_1` FOREIGN KEY (`id_libro`) REFERENCES `libros` (`id`),
  ADD CONSTRAINT `prestamos_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
