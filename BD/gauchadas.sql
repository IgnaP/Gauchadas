-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-05-2017 a las 02:21:30
-- Versión del servidor: 10.1.21-MariaDB
-- Versión de PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gauchadas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `ID` int(11) NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`ID`, `Nombre`) VALUES
(1, 'Mascotas'),
(2, 'Deportes'),
(3, 'Reparaciones'),
(4, 'Fuerza'),
(5, 'Varios');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudades`
--

CREATE TABLE `ciudades` (
  `ID` int(11) NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `ciudades`
--

INSERT INTO `ciudades` (`ID`, `Nombre`) VALUES
(1, 'Buenos Aires'),
(2, 'La Plata'),
(3, 'Mar del Plata'),
(4, 'Necochea');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `ID` int(11) NOT NULL,
  `Pregunta` text COLLATE utf8_spanish_ci NOT NULL,
  `Respuesta` text COLLATE utf8_spanish_ci NOT NULL,
  `Publicacion` int(11) NOT NULL,
  `UsuarioID` int(11) NOT NULL,
  `Vista` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`ID`, `Pregunta`, `Respuesta`, `Publicacion`, `UsuarioID`, `Vista`) VALUES
(1, 'El al lo suspiraban le partiquina ordinarios. Cabo gran veia celo tio ido. Los manchar incapaz las intenso dientes carrera. Cincuenta homenajes era enamorado aburrirse degenerar ser ido fue.', 'Nada mero sofa ti fe cuya se dijo. Ton tenia llama las era muero fondo ola duras almas.', 4, 1, 1),
(2, 'Del agradecio naufragos obsequios declaraba mar estrellas ano tan. Dinero marido acerco sin pie. Entre usase por casar ley dos mimar. Dio pariente gobierno chi acataban. Ya retrato en en si rededor.', 'Sencillez degenerar mostraban vio tio indefenso recuerdos. Si encontrado sobrevenir ha ceremonial se. Negarselo hermosura artefacto so el si.', 4, 1, 1),
(3, 'Ah duda gato quel fino me la. Verle de el algos la sacar dices. Le cada yo pues os ti hijo. Ola iba aritmetico caballeros dio castellano sin extraviada elocuencia. Pantalones consistido sr tropezando.', '', 4, 1, 1),
(4, 'Incesante la adquirido protegida idealismo ocupacion no. Cuentos suertes iba natural sus castana asi han. Decian medica leguas ano vez decida las ganado dejaba. No blandas sacudio va ex aquella.', '', 4, 1, 1),
(5, 'Entrar una fijeza nacido fueron dio. Ma te ir para tono fosa la. Compas ma la me limpia activo. Inquilinos fantastico compadecia enmendaban de llamaradas ignorancia en???', '', 1, 3, 1),
(6, 'Un reconocian titiritero domesticos holocausto la cementerio. Iba temprano ruisenor familiar rey las don escandon. Adonde actual mangas ver que puerta fue tan ribera pronto? Podria corria agosto?', '', 1, 3, 1),
(7, 'Colchon los contado don comodas referia promesa dio. Duros eso rio vista dejar mar. Morir el mando antes jamas debia la. Yendo ya ir asise mimar so la??', '', 4, 4, 1),
(8, 'Ma fortuna se fijaran acabara quejaba relator yo noticia. Se espanto hermosa la la abogado tuviese decirlo?', 'Indicarse resonaban sin reconocio complacia tio sea tormentos irascible. Esclavo glorias voz oro agujero tufillo muy ano encogia. El os brillaron indicarse se guardando. Negarle era dos hay luz.', 1, 4, 1),
(9, 'Hoja ay oh tipo gris fiar un. Montaraces pentagrama expresivas vez ahi mia rio. Si sois digo te paga baja rito?', '', 1, 3, 1),
(10, 'Pagarselos ido han ton pedantesca silencioso adivinarle. Lacrimoso castrillo ofenderle aplaudian le ti de periodico?', 'Madera balcon las fisico mal hurana asi mas. Lo no pasadas no le quienes repente empresa levitas. Recordar il pensados gabinete tu yo guitarra.', 4, 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `postulantes`
--

CREATE TABLE `postulantes` (
  `publicacionID` int(11) NOT NULL,
  `usuarioID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas`
--

CREATE TABLE `preguntas` (
  `ID` int(11) NOT NULL,
  `Pregunta` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `preguntas`
--

INSERT INTO `preguntas` (`ID`, `Pregunta`) VALUES
(1, 'Nombre de mi mascota?'),
(2, 'Lugar de primeras vacaciones?'),
(3, 'Nombre de tu escuela primaria?'),
(4, 'Ciudad favorita?');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publicaciones`
--

CREATE TABLE `publicaciones` (
  `ID` int(11) NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Ciudad` int(11) NOT NULL,
  `FechaLimite` date NOT NULL,
  `Categoria` int(11) NOT NULL,
  `Descripcion` text COLLATE utf8_spanish_ci NOT NULL,
  `Imagen` text COLLATE utf8_spanish_ci,
  `Activa` tinyint(1) NOT NULL DEFAULT '1',
  `usuario` int(11) NOT NULL,
  `Vista` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `publicaciones`
--

INSERT INTO `publicaciones` (`ID`, `Nombre`, `Ciudad`, `FechaLimite`, `Categoria`, `Descripcion`, `Imagen`, `Activa`, `usuario`, `Vista`) VALUES
(1, 'La gran gauchada', 1, '2017-04-20', 1, 'Esta es la descripcion de la gran gauchada para la que necesito ayuda', '', 1, 1, 1),
(2, 'Necesito Ayuda', 2, '2017-04-21', 3, 'Se me rompio la ducha. Necesito a alguien que sepa como arreglarla.', '', 1, 1, 1),
(3, 'Entrenador de tenis', 3, '2017-04-29', 2, 'Necesito que alguien me enseÃ±e a jugar tenis', NULL, 1, 1, 1),
(4, 'Ayudaaaaaaaa', 2, '2017-04-27', 4, 'Necesito ayuda para mover la heladera de la cocina al garage', NULL, 1, 3, 1),
(5, 'Esta es de prueba', 3, '2017-04-21', 5, 'Sin obsequios insultaba una rey italianos altamente. Pastas oyo vieron asi siglos una. Rey prestadas iconoteca levantaba traspunte ocasiones aptitudes pie ser uso. Civil idolo dia dio opaca poeta paso', NULL, 0, 1, 1),
(6, 'Prueba de creditos', 4, '2017-04-30', 5, 'El de feroces si limites es montana. Muy titubear entonces aquellos arrugada asi. Son confesarse resolverse etc ton apariencia. Ya acaricia el pintados continuo sentaban mi no. Trajes buenas ser pre buscar una manana. Amenazaban no caballeros es si escuchando constituia encontrado prescindir. Rio elocuencia abandonaba distinguir pertenecia tentandole etc. Voz ahi ano seguia formas cundio suegro.', NULL, 0, 1, 1),
(7, 'Prueba', 3, '2017-04-27', 5, 'Confundido un adivinarle lechuguino so. Hoja el pide se tome. Embocadura molestando el el espiritual extranjero escuchando ya lo apasionada. Preocupado devolucion desafinaba contrastes he se ti ch. Tu no puntiaguda ingratitud romanticos electricas ay es. Ma hablandose adivinarle ahogandose ex le vericuetos logaritmos. Sol bueno veces corte ano han antes media. Espontanea acompanaba con cigarrillo.', NULL, 0, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reputacion`
--

CREATE TABLE `reputacion` (
  `ID` int(11) NOT NULL,
  `Nombre` text COLLATE utf8_spanish_ci NOT NULL,
  `Puntos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `reputacion`
--

INSERT INTO `reputacion` (`ID`, `Nombre`, `Puntos`) VALUES
(1, 'Negativa', -1),
(2, 'Observador', 0),
(3, 'Buen tipo', 1),
(4, 'Gran tipo', 2),
(5, 'Tipaso', 5),
(6, 'Heroe', 10),
(7, 'Nobleza gaucha', 20),
(8, 'Dios', 50);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `ID` int(11) NOT NULL,
  `Email` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `Clave` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `Nombre` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `Apellido` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `FechaDeNacimiento` date NOT NULL,
  `Telefono` int(11) NOT NULL,
  `PreguntaDeSeguridad` int(11) NOT NULL,
  `Respuesta` mediumtext COLLATE utf8_spanish_ci NOT NULL,
  `Administrador` tinyint(1) NOT NULL DEFAULT '0',
  `Bloqueada` tinyint(1) NOT NULL DEFAULT '0',
  `Borrada` tinyint(1) NOT NULL DEFAULT '0',
  `Reputacion` int(11) NOT NULL DEFAULT '0',
  `Creditos` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci ROW_FORMAT=COMPACT;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`ID`, `Email`, `Clave`, `Nombre`, `Apellido`, `FechaDeNacimiento`, `Telefono`, `PreguntaDeSeguridad`, `Respuesta`, `Administrador`, `Bloqueada`, `Borrada`, `Reputacion`, `Creditos`) VALUES
(1, 'homero@mail.com', 'asd', 'Homero', 'Simpson', '1950-10-10', 4567890, 3, 'zxc', 0, 0, 0, 18, 8),
(2, 'admin@mail.com', 'asd', 'Administrador', 'Algo', '1980-04-12', 1234567, 2, 'Resp', 1, 0, 0, 0, 1),
(3, 'marge@mail.com', 'asd', 'Marge', 'Simpson', '1955-01-04', 1234567, 2, 'qwe', 0, 0, 0, 0, 1),
(4, 'bart@mail.com', 'asd', 'Bart', 'Simpson', '1990-05-15', 4566543, 1, 'qwe', 0, 0, 0, -3, 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `reputacion`
--
ALTER TABLE `reputacion`
  ADD PRIMARY KEY (`ID`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `ciudades`
--
ALTER TABLE `ciudades`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `comentarios`
--
ALTER TABLE `comentarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT de la tabla `preguntas`
--
ALTER TABLE `preguntas`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `publicaciones`
--
ALTER TABLE `publicaciones`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT de la tabla `reputacion`
--
ALTER TABLE `reputacion`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
