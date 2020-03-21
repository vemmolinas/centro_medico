-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-01-2020 a las 21:56:24
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consulta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `idCita` int(11) NOT NULL,
  `citFecha` date NOT NULL,
  `citHora` time NOT NULL,
  `citPaciente` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `citMedico` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `citConsultorio` int(11) NOT NULL,
  `citEstado` enum('Asignado','Atendido') COLLATE utf8_spanish_ci NOT NULL DEFAULT 'Asignado',
  `CitObservaciones` text COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`idCita`, `citFecha`, `citHora`, `citPaciente`, `citMedico`, `citConsultorio`, `citEstado`, `CitObservaciones`) VALUES
(null, '2020-01-29', '10:30:00', '76438761E', '71703616Y', 2, 'Asignado', ''),
(null, '2019-01-23', '10:45:00', '12345678D', '71703616Y', 3, 'Atendido', ' REVISIÓN'),
(null, '2020-01-23', '10:45:00', '12345678D', '76045799P', 5, 'Asignado', ' '),
(null, '2019-11-23', '10:45:00', '12345678D', '71703616Y', 5, 'Atendido', 'ALERGIA'),
(null, '2020-02-28', '11:15:00', '04548557P', '71703616Y', 3, 'Atendido', 'AVERIAO'),
(null, '2010-01-23', '11:15:00', '46733454H', '71703616Y', 3, 'Asignado', ' '),
(null, '2020-02-20', '11:00:00', '48362893G', '45343443O', 5, 'Asignado', ''),
(null, '2020-01-31', '11:45:00', '12345678D', '45343443O', 1, 'Asignado', ' ');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE `consultorios` (
  `idConsultorio` int(11) NOT NULL,
  `conNombre` char(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `consultorios`
--

INSERT INTO `consultorios` (`idConsultorio`, `conNombre`) VALUES
(1, 'Centro de Salud Oviedo'),
(2, 'Centro de Salud Corvera'),
(3, 'Centro de Salud Aviles'),
(4, 'Centro de Salud Gijon'),
(5, 'Centro de Salud Luarca'),
(6, 'Hospital Universitario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `medicos`
--

CREATE TABLE `medicos` (
  `dniMed` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `medNombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medApellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medEspecialidad` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `medTelefono` char(15) COLLATE utf8_spanish_ci NOT NULL,
  `medCorreo` varchar(50) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `medicos`
--

INSERT INTO `medicos` (`dniMed`, `medNombres`, `medApellidos`, `medEspecialidad`, `medTelefono`, `medCorreo`) VALUES
('45343443O', 'PACO', 'PACOMER', 'ENFERMERO', '748292738', 'paquito@chocolatero.com'),
('71703616Y', 'BORJA', 'LARA MENENDEZ', 'PEDIATRÍA', '666666666', 'borja@gmail.com'),
('76045799P', 'DAVID', 'RODRÍGUEZ ROMERO', 'DENTISTA', '656565656', 'david@gmail.com');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE `pacientes` (
  `dniPac` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `pacNombres` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pacApellidos` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `pacFechaNacimiento` date NOT NULL,
  `pacSexo` enum('Masculino','Femenino') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `pacientes`
--

INSERT INTO `pacientes` (`dniPac`, `pacNombres`, `pacApellidos`, `pacFechaNacimiento`, `pacSexo`) VALUES
('04548557P', 'VICTOR', 'GIUNTA', '1986-06-28', 'Masculino'),
('12345678D', 'AGATKO', 'LISOWSKA', '1985-06-28', 'Femenino'),
('18922230R', 'ALTEREGG', 'MOLINKAS', '1980-11-03', 'Femenino'),
('22212222F', 'GRIJANDER', 'CONDE MOR', '1975-03-05', 'Masculino'),
('46733454H', 'JESÚS', 'MUÑOZ', '1953-05-05', 'Masculino'),
('48362893G', 'ALEXANDRA', 'LISOWSKA', '1980-04-04', 'Femenino'),
('65345643F', 'PIOTR', 'JOÑO JOÑÓ', '1974-05-04', 'Masculino'),
('73424349H', 'PEDRO', 'PALACIOS', '1986-03-05', 'Masculino'),
('76438761E', 'ALBERTO MAXIMILIANO', 'MOLINAS', '1990-11-23', 'Masculino');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `dniUsu` varchar(10) COLLATE utf8_spanish_ci NOT NULL,
  `usuLogin` char(15) COLLATE utf8_spanish_ci NOT NULL,
  `usuPassword` varchar(157) COLLATE utf8_spanish_ci NOT NULL,
  `usuEstado` enum('Activo','Inactivo') COLLATE utf8_spanish_ci NOT NULL,
  `usutipo` enum('Administrador','Asistente','Medico','Paciente') COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`dniUsu`, `usuLogin`, `usuPassword`, `usuEstado`, `usutipo`) VALUES
('04548557P', 'VICTOR', '123456', 'Activo', 'Paciente'),
('12345678D', 'JAJKO123', 'RYBAK123', 'Activo', 'Paciente'),
('18922230R', 'jajucho', '123456', 'Activo', 'Paciente'),
('22212222F', 'chiquito', '123456', 'Activo', 'Paciente'),
('33333335V', 'YOLANDA', '1234', 'Activo', 'Asistente'),
('45343443O', 'paquito', '123456', 'Activo', 'Medico'),
('46733454H', 'yisusitu', '123456', 'Activo', 'Paciente'),
('48362893G', 'wuwek.', '123456', 'Activo', 'Paciente'),
('65345643F', 'rambito', '123456', 'Activo', 'Paciente'),
('71703616Y', 'MEDICO1', '1', 'Activo', 'Medico'),
('73424349h', 'PERICO', '123456', 'Activo', 'Paciente'),
('76045799P', 'MEDICO2', '1', 'Activo', 'Medico'),
('76438761E', 'maxi1990', '1', 'Activo', 'Paciente'),
('x4548557P', 'EMMANUEL', '123456', 'Activo', 'Administrador');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`idCita`),
  ADD KEY `citPaciente` (`citPaciente`,`citMedico`,`citConsultorio`),
  ADD KEY `citMedico` (`citMedico`),
  ADD KEY `citConsultorio` (`citConsultorio`);

--
-- Indices de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`idConsultorio`);

--
-- Indices de la tabla `medicos`
--
ALTER TABLE `medicos`
  ADD PRIMARY KEY (`dniMed`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`dniPac`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`dniUsu`,`usuLogin`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `idCita` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`citPaciente`) REFERENCES `pacientes` (`dniPac`),
  ADD CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`citMedico`) REFERENCES `medicos` (`dniMed`),
  ADD CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`citConsultorio`) REFERENCES `consultorios` (`idConsultorio`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


# Privilegios para `Administrador`@`localhost`

GRANT USAGE ON *.* TO 'Administrador'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT ALL PRIVILEGES ON `consulta`.* TO 'Administrador'@'localhost';


# Privilegios para `Asistente`@`localhost`

GRANT USAGE ON *.* TO 'Asistente'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT, INSERT ON `consulta`.`pacientes` TO 'Asistente'@'localhost';

GRANT SELECT, INSERT, UPDATE, REFERENCES ON `consulta`.`medicos` TO 'Asistente'@'localhost' WITH GRANT OPTION;

GRANT SELECT ON `consulta`.`consultorios` TO 'Asistente'@'localhost';

GRANT INSERT ON `consulta`.`usuarios` TO 'Asistente'@'localhost';

GRANT SELECT, INSERT ON `consulta`.`citas` TO 'Asistente'@'localhost';


# Privilegios para `Medico`@`localhost`

GRANT USAGE ON *.* TO 'Medico'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT ON `consulta`.`pacientes` TO 'Medico'@'localhost';

GRANT SELECT ON `consulta`.`consultorios` TO 'Medico'@'localhost' WITH GRANT OPTION;

GRANT SELECT, INSERT, UPDATE, REFERENCES ON `consulta`.`medicos` TO 'Medico'@'localhost' WITH GRANT OPTION;

GRANT SELECT, UPDATE ON `consulta`.`citas` TO 'Medico'@'localhost';


# Privilegios para `Paciente`@`localhost`

GRANT USAGE ON *.* TO 'Paciente'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT ON `consulta`.`citas` TO 'Paciente'@'localhost';

GRANT SELECT ON `consulta`.`consultorios` TO 'Paciente'@'localhost';

GRANT SELECT ON `consulta`.`medicos` TO 'Paciente'@'localhost';

GRANT SELECT ON `consulta`.`pacientes` TO 'Paciente'@'localhost';


# Privilegios para `acceso`@`localhost`

GRANT USAGE ON *.* TO 'acceso'@'localhost' IDENTIFIED BY PASSWORD '*A4B6157319038724E3560894F7F932C8886EBFCF';

GRANT SELECT (usutipo, usuLogin, dniUsu, usuPassword) ON `consulta`.`usuarios` TO 'acceso'@'localhost';