# --------------------------------------------------------
# Host:                         127.0.0.1
# Server version:               5.1.41
# Server OS:                    Win32
# HeidiSQL version:             6.0.0.3839
# Date/time:                    2011-05-24 14:06:24
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

# Dumping database structure for imssisc_desarrollo
CREATE DATABASE IF NOT EXISTS `imssisc_desarrollo` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `imssisc_desarrollo`;


# Dumping structure for table imssisc_desarrollo.acta_recepcion
CREATE TABLE IF NOT EXISTS `acta_recepcion` (
  `idacta` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fch_hora` datetime NOT NULL,
  `nom_ape_chfer` varchar(255) NOT NULL,
  `cedula` int(8) NOT NULL,
  `transporte` varchar(255) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `origen` varchar(45) DEFAULT NULL,
  `factpack` varchar(45) DEFAULT NULL,
  `nula` int(1) unsigned NOT NULL DEFAULT '0',
  `auditoria` int(4) DEFAULT NULL,
  `mod` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codigo_b_actas` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  PRIMARY KEY (`idacta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.acta_recepcion_cg
CREATE TABLE IF NOT EXISTS `acta_recepcion_cg` (
  `idacta` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fch_hora` datetime NOT NULL,
  `nom_ape_chfer` varchar(255) NOT NULL,
  `cedula` int(8) unsigned NOT NULL,
  `transporte` varchar(255) NOT NULL,
  `placa` varchar(7) NOT NULL,
  `fact_pack` varchar(45) DEFAULT NULL,
  `consignatario` int(4) unsigned zerofill NOT NULL,
  `BL` varchar(50) NOT NULL,
  `origen` varchar(255) NOT NULL,
  `linea` int(4) NOT NULL,
  `buque` int(4) NOT NULL,
  `viaje` int(8) NOT NULL,
  `observ` mediumtext,
  `operador` varchar(255) NOT NULL,
  `anulado` int(1) NOT NULL,
  `codigo_b_actas` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  PRIMARY KEY (`idacta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.asignaciones
CREATE TABLE IF NOT EXISTS `asignaciones` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `equinv` int(10) unsigned zerofill NOT NULL DEFAULT '0000000000',
  `booking` varchar(10) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL,
  `cliente` int(10) unsigned DEFAULT '0',
  `auditoria` int(10) unsigned NOT NULL DEFAULT '0',
  `mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `equinv` (`equinv`),
  KEY `cliente` (`cliente`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.asignados
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `asignados` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`linea` INT(4) UNSIGNED NOT NULL,
	`nlinea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`estatus` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`condicion` VARCHAR(4) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`fdm` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`fdespims` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`eir_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'eir despacho',
	`booking` VARCHAR(10) NOT NULL DEFAULT '0' COLLATE 'utf8_general_ci',
	`cliente` VARCHAR(45) NOT NULL COMMENT 'Nombre de la empresa' COLLATE 'utf8_general_ci',
	`dpais` INT(7) NULL DEFAULT NULL,
	`dpatio` INT(7) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.auditoria
CREATE TABLE IF NOT EXISTS `auditoria` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` int(4) unsigned NOT NULL DEFAULT '0',
  `session` varchar(255) NOT NULL DEFAULT '',
  `fini` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ffin` datetime DEFAULT NULL,
  `status` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.buques
CREATE TABLE IF NOT EXISTS `buques` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `linea` int(4) unsigned NOT NULL DEFAULT '0' COMMENT 'Linea del Buque / CompaÃƒÆ’Ã‚Â±ia',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre del buque',
  `observaciones` text COMMENT 'Observaciones',
  `auditoria` int(4) unsigned DEFAULT NULL,
  `delete` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.checkdigit
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `checkdigit` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`owner` VARCHAR(4) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`number` VARCHAR(6) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`digit` VARCHAR(1) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`checkdigit` DECIMAL(20,0) NULL DEFAULT NULL,
	`yard` VARCHAR(3) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`borrado` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'borrado'
) ENGINE=MyISAM;


# Dumping structure for procedure imssisc_desarrollo.cleaner_routine
DELIMITER //
CREATE DEFINER=`imssisc`@`localhost` PROCEDURE `cleaner_routine`()
    COMMENT 'Rutina_limpiar'
BEGIN
update inventario set precinto = NULL where precinto = '';
update inventario set precinto = NULL where precinto = 'S/P';
update inventario set bl = null where bl = '';
update inventario set obs = null where obs = '';
update inventario set ubicacion = null where ubicacion = '';
update inventario set ubicacion = null where ubicacion = '0';
update inventario set mrep = null where mrep = '';
update inventario set mrep = null where mrep = '0';
update inventario set fdespims = null where fdespims = '0000-00-00';
update inventario set eir_d = null where eir_d = 0;
update inventario set status_d = null where status_d is not null and fdespims is null;
update inventario set booking = null where booking = '0';
update inventario set booking = null where booking = '';
END//
DELIMITER ;


# Dumping structure for table imssisc_desarrollo.cod_puertos
CREATE TABLE IF NOT EXISTS `cod_puertos` (
  `id` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `codigo` varchar(6) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `activo` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.consignatario
CREATE TABLE IF NOT EXISTS `consignatario` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `rif` varchar(12) NOT NULL DEFAULT 'J-00000000-0' COMMENT 'Registro de informacion fiscal',
  `nombre` varchar(45) NOT NULL COMMENT 'Nombre de la empresa',
  `libre` int(2) unsigned DEFAULT NULL,
  `pcontacto` varchar(45) DEFAULT NULL COMMENT 'Persona contacto',
  `email` varchar(80) DEFAULT NULL COMMENT 'Correo electronico de contacto',
  `telf` char(12) DEFAULT NULL COMMENT 'Telefono de contacto',
  `auditoria` int(4) unsigned DEFAULT NULL,
  `delete` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for procedure imssisc_desarrollo.consulta_asignacion
DELIMITER //
CREATE DEFINER=`imssisc`@`localhost` PROCEDURE `consulta_asignacion`(IN `varLinea` INT)
BEGIN
SELECT inventario.id, inventario.linea AS linea_id, lineas.nombre AS linea, inventario.contenedor, tequipos.tipo,  case `inventario`.`status` when 0 then 'VACIO' when 1 then 'FULL' end AS estatus,case `inventario`.`condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' end AS `condicion`, inventario.frd AS recepcion, inventario.eir_r AS eir,
DATEDIFF(CURRENT_DATE,inventario.fdb) AS DIC, DATEDIFF(CURRENT_DATE,inventario.frd) AS DIY
FROM inventario, tequipos, lineas
WHERE inventario.c = 0 
AND inventario.`delete` = 0
AND inventario.tcont = tequipos.id
AND inventario.linea = lineas.id
AND inventario.condicion > 0
AND inventario.linea = varLinea
ORDER BY inventario.condicion;
END//
DELIMITER ;


# Dumping structure for view imssisc_desarrollo.consulta_x_consignatario
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `consulta_x_consignatario` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`estatus` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`condicion` VARCHAR(4) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`eirR` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`descarga` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`despacho` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`recepcion` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`devolucion` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`eirD` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'eir despacho',
	`ubicacion` VARCHAR(12) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci',
	`linea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`consig_id` INT(4) UNSIGNED NOT NULL DEFAULT '0',
	`consignatario` VARCHAR(45) NOT NULL COMMENT 'Nombre de la empresa' COLLATE 'utf8_general_ci',
	`c` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'cuenta para inventario',
	`DIC` INT(7) NULL DEFAULT NULL,
	`DIY` INT(7) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.despachados
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `despachados` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`linea` INT(4) UNSIGNED NOT NULL,
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`status` INT(1) UNSIGNED NOT NULL COMMENT 'full, empty',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`fdespims` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`eir_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'eir despacho',
	`status_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'status_despacho',
	`booking` VARCHAR(10) NULL DEFAULT NULL COMMENT 'booking' COLLATE 'utf8_general_ci',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci',
	`dic` INT(7) NULL DEFAULT NULL,
	`diy` INT(7) NULL DEFAULT NULL,
	`acopio` VARBINARY(8) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.eir
CREATE TABLE IF NOT EXISTS `eir` (
  `ideir` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `eir_acta` int(6) unsigned zerofill DEFAULT '000000',
  `eir_pase` int(6) unsigned zerofill DEFAULT '000000',
  `eir_contenedor` varchar(13) DEFAULT NULL,
  `eir_estado` int(1) DEFAULT '0',
  `eir_precinto` int(10) DEFAULT '0',
  `eir_pase_salida` int(6) unsigned zerofill DEFAULT '000000',
  `eir_numchasis` int(13) unsigned zerofill DEFAULT '0000000000000',
  `eir_chasis_estado` int(1) DEFAULT '0',
  `eir_BL` varchar(50) DEFAULT NULL,
  `eir_booking` varchar(50) DEFAULT NULL,
  `eir_buque` varchar(50) DEFAULT NULL,
  `eir_viaje` varchar(50) DEFAULT NULL,
  `eir_puerto` varchar(50) DEFAULT NULL,
  `eir_hora` time DEFAULT NULL,
  `eir_fecha` date DEFAULT NULL,
  `eir_cliente` varchar(50) DEFAULT NULL,
  `eir_dir_final` varchar(255) DEFAULT NULL,
  `eir_tam_cont` varchar(10) DEFAULT NULL,
  `eir_peso_cont` varchar(255) DEFAULT NULL,
  `eir_sobrepeso` int(1) unsigned zerofill DEFAULT NULL,
  `eir_sobrealto` int(1) unsigned zerofill DEFAULT NULL,
  `eir_sobrelargo` int(1) unsigned DEFAULT NULL,
  `eir_sobreancho` int(1) unsigned DEFAULT NULL,
  `eir_cargadanger` int(1) unsigned DEFAULT NULL,
  `eir_calcomania` int(1) unsigned DEFAULT NULL,
  `eir_func_genset` int(1) unsigned DEFAULT NULL,
  `eir_bateria` int(1) unsigned DEFAULT NULL,
  `eir_genset_horas` time DEFAULT NULL,
  `eir_condiciones` int(10) unsigned zerofill DEFAULT NULL,
  `eir_agente_ad` varchar(255) DEFAULT NULL,
  `eir_transportista` varchar(255) DEFAULT NULL,
  `eir_ag_naviero` varchar(255) DEFAULT NULL,
  `eir_observ_entrega` text,
  `eir_fecha_entrega` date DEFAULT NULL,
  `eir_placa_entrega` varchar(7) DEFAULT NULL,
  `eir_rep_trans_entrega` varchar(255) DEFAULT NULL,
  `eir_cedula_entrega` int(8) unsigned zerofill DEFAULT NULL,
  `eir_observ_devol` text,
  `eir_fecha_devol` date DEFAULT NULL,
  `eir_placa_devol` date DEFAULT NULL,
  `eir_rep_trans_devol` date DEFAULT NULL,
  `eir_cedula_devol` date DEFAULT NULL,
  `codigo_b_actas` int(12) unsigned zerofill DEFAULT '000000000000',
  `codigo_b_pases` int(12) unsigned zerofill DEFAULT '000000000000',
  `codigo_b_eir` int(12) unsigned zerofill DEFAULT '000000000000',
  `nulo` int(1) unsigned zerofill DEFAULT '0',
  PRIMARY KEY (`ideir`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.embalajes
CREATE TABLE IF NOT EXISTS `embalajes` (
  `idembalajes` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `embalaje` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `comentario` text,
  `inactivo` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  PRIMARY KEY (`idembalajes`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.existencia
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `existencia` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`acta` INT(6) UNSIGNED NOT NULL,
	`linea` INT(4) UNSIGNED NOT NULL,
	`nlinea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`idconsignatario` INT(4) UNSIGNED NOT NULL DEFAULT '0',
	`consignatario` VARCHAR(45) NOT NULL COMMENT 'Nombre de la empresa' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`status` INT(1) UNSIGNED NOT NULL COMMENT 'full, empty',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`patio` INT(4) NOT NULL COMMENT 'patio',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci',
	`vaciado` INT(10) NULL DEFAULT NULL COMMENT 'fecha despacho iims'
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.existenciaconsig
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `existenciaconsig` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`acta` BIGINT(12) NULL DEFAULT NULL,
	`pase` BIGINT(12) NULL DEFAULT NULL,
	`linea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`fdm` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`estatus` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`condicion` VARCHAR(4) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`patio` VARCHAR(12) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`consignatario` INT(4) UNSIGNED NOT NULL COMMENT 'Consignatario',
	`consignom` VARCHAR(45) NOT NULL COMMENT 'Nombre de la empresa' COLLATE 'utf8_general_ci',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.existenciadevolucion
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `existenciadevolucion` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`linea` INT(4) UNSIGNED NOT NULL,
	`nombre_linea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`estatus` VARCHAR(5) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`condicion` VARCHAR(4) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`fdm` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`patio` INT(4) NOT NULL COMMENT 'patio',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci',
	`DIC` INT(7) NULL DEFAULT NULL,
	`DIY` INT(7) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.existenciagral
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `existenciagral` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`linea` INT(4) UNSIGNED NOT NULL,
	`nlinea` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`estatus` INT(1) UNSIGNED NOT NULL COMMENT 'full, empty',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`consignatario` VARCHAR(45) NOT NULL COMMENT 'Nombre de la empresa' COLLATE 'utf8_general_ci',
	`patio` VARCHAR(12) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`obs` TEXT NULL DEFAULT NULL COMMENT 'observaciones' COLLATE 'utf8_general_ci',
	`dpais` INT(7) NULL DEFAULT NULL,
	`dpatio` INT(7) NULL DEFAULT NULL
) ENGINE=MyISAM;


# Dumping structure for procedure imssisc_desarrollo.GateIn
DELIMITER //
CREATE DEFINER=`imssisc`@`localhost` PROCEDURE `GateIn`(IN `varLinea` INT, IN `varFini` DATE, IN `varFfin` DATE)
BEGIN
SELECT inventario.id, inventario.linea, lineas.nombre, inventario.contenedor, tequipos.tipo, 
(CASE inventario.`status` WHEN 0 THEN 'VACIO' WHEN 1 THEN 'FULL' END) AS estatus, 
(CASE inventario.condicion WHEN 0 THEN 'DMG' WHEN 1 THEN 'OPR1' WHEN 2 THEN 'OPR2' WHEN 3 THEN 'OPR3' END) AS condicion,
inventario.precinto, inventario.bl, inventario.fdb, inventario.frd, inventario.eir_r, 
if(consignatario.nombre='INDETERMINADO',lineas.agencia,consignatario.nombre) as `consignatario`,
DATEDIFF(CURRENT_DATE,inventario.fdb) AS dpais, DATEDIFF(CURRENT_DATE,inventario.frd) AS dpatio
FROM inventario, lineas, tequipos, consignatario
WHERE inventario.linea = varLinea
AND inventario.frd BETWEEN varFini AND varFfin
AND inventario.`delete` = 0
AND inventario.linea = lineas.id
AND inventario.tcont = tequipos.id
AND inventario.consignatario = consignatario.id;
END//
DELIMITER ;


# Dumping structure for procedure imssisc_desarrollo.GateOut
DELIMITER //
CREATE DEFINER=`imssisc`@`localhost` PROCEDURE `GateOut`(IN `varLinea` INT, IN `varFini` DATE, IN `varFfin` DATE)
BEGIN
SELECT inventario.id, inventario.linea, lineas.nombre, inventario.contenedor, tequipos.tipo, 
(CASE inventario.`status` WHEN 0 THEN 'VACIO' WHEN 1 THEN 'FULL' END) AS estatus, 
(CASE inventario.condicion WHEN 0 THEN 'DMG' WHEN 1 THEN 'OPR1' WHEN 2 THEN 'OPR2' WHEN 3 THEN 'OPR3' END) AS condicion,
inventario.precinto, inventario.bl, inventario.fdb, inventario.frd, inventario.fdespims, 
inventario.eir_d,if(consignatario.nombre='INDETERMINADO',lineas.agencia,consignatario.nombre) as `consignatario`,
DATEDIFF(inventario.fdespims,inventario.fdb) AS dpais, DATEDIFF(inventario.fdespims,inventario.frd) AS dpatio,
IF(DATEDIFF(inventario.fdespims,inventario.frd)>30,DATEDIFF(inventario.fdespims,inventario.frd)-30,'') AS acopio
FROM inventario, lineas, tequipos, consignatario
WHERE inventario.linea = varLinea
AND inventario.fdespims BETWEEN varFini AND varFfin
AND inventario.`delete` = 0
AND inventario.linea = lineas.id
AND inventario.tcont = tequipos.id
AND inventario.consignatario = consignatario.id
AND inventario.expo is null
ORDER BY inventario.contenedor ASC;
END//
DELIMITER ;


# Dumping structure for view imssisc_desarrollo.historial
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `historial` (
	`lineaId` INT(4) NOT NULL DEFAULT '0' COMMENT 'Identificacion de la linea',
	`nombre` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`agencia` VARCHAR(50) NULL DEFAULT NULL COMMENT 'Agencia' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`fdm` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`patio` INT(4) NOT NULL COMMENT 'patio',
	`status_in` VARCHAR(5) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`fdespims` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`booking` VARCHAR(10) NULL DEFAULT NULL COMMENT 'booking' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.inventario
CREATE TABLE IF NOT EXISTS `inventario` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `acta` int(6) unsigned NOT NULL,
  `pase` int(6) unsigned NOT NULL,
  `linea` int(4) unsigned NOT NULL,
  `buque` int(4) unsigned NOT NULL,
  `viaje` int(8) unsigned NOT NULL,
  `tcont` int(2) unsigned NOT NULL,
  `contenedor` varchar(11) NOT NULL,
  `fdb` date NOT NULL COMMENT 'fecha descarga del buque',
  `fdm` date NOT NULL COMMENT 'fecha despacho muelle',
  `frd` date NOT NULL COMMENT 'fecha de recepcion iims',
  `eir_r` int(6) unsigned NOT NULL COMMENT 'eir iims',
  `rep_dano` varchar(50) DEFAULT NULL,
  `status` int(1) unsigned NOT NULL COMMENT 'full, empty',
  `condicion` int(1) unsigned NOT NULL COMMENT 'opr o dmg',
  `precinto` varchar(15) DEFAULT NULL COMMENT 'numero de precinto',
  `bl` varchar(15) DEFAULT NULL,
  `patio` int(4) NOT NULL COMMENT 'patio',
  `ubicacion` int(10) unsigned DEFAULT NULL COMMENT 'ubicacion',
  `consignatario` int(4) unsigned NOT NULL COMMENT 'Consignatario',
  `obs` text COMMENT 'observaciones',
  `mrep` int(10) unsigned DEFAULT NULL COMMENT 'Monto de Reparacion',
  `fdespims` date DEFAULT NULL COMMENT 'fecha despacho iims',
  `vaciado` int(10) DEFAULT NULL COMMENT 'fecha despacho iims',
  `eir_d` int(10) unsigned DEFAULT NULL COMMENT 'eir despacho',
  `status_d` int(10) unsigned DEFAULT NULL COMMENT 'status_despacho',
  `precintodesp` varchar(15) DEFAULT NULL COMMENT 'status_despacho',
  `expo` int(1) unsigned DEFAULT NULL,
  `booking` varchar(10) DEFAULT NULL COMMENT 'booking',
  `auditoria` int(4) unsigned DEFAULT NULL COMMENT 'auditoria',
  `c` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'cuenta para inventario',
  `delete` int(1) unsigned NOT NULL DEFAULT '0' COMMENT 'borrado',
  `mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'borrado',
  `codigo_b_actas` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  `codigo_b_pases` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  PRIMARY KEY (`id`),
  KEY `contenedor` (`contenedor`),
  KEY `eir_r` (`eir_r`),
  KEY `eir_d` (`eir_d`),
  KEY `linea` (`linea`),
  KEY `frd` (`frd`),
  KEY `fdespims` (`fdespims`),
  KEY `c` (`c`),
  KEY `delete` (`delete`),
  KEY `expo` (`expo`),
  KEY `acta` (`acta`),
  KEY `pase` (`pase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.inventario_cg
CREATE TABLE IF NOT EXISTS `inventario_cg` (
  `idinventario_cs` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `idacta` int(6) unsigned zerofill NOT NULL,
  `fecha_acta` datetime NOT NULL,
  `idpase` int(6) unsigned zerofill DEFAULT NULL,
  `fecha_pase` datetime DEFAULT NULL,
  `fact_pack` varchar(50) DEFAULT NULL,
  `BL` varchar(50) NOT NULL,
  `embalaje` varchar(45) DEFAULT NULL,
  `consignatario` int(4) unsigned zerofill DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  `cont_x_embalaje` varchar(45) DEFAULT NULL,
  `alto_emb` decimal(3,2) unsigned zerofill DEFAULT NULL,
  `ancho_emb` decimal(3,2) unsigned zerofill DEFAULT NULL,
  `largo_emb` decimal(3,2) unsigned zerofill DEFAULT NULL,
  `peso` int(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `volumen` int(6) unsigned zerofill NOT NULL DEFAULT '000000',
  `m2` decimal(3,2) NOT NULL,
  `m3` decimal(3,2) NOT NULL,
  `cantidad` int(3) DEFAULT '0',
  `operador` varchar(255) NOT NULL,
  `anulado` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `codigo_b_actas` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  `codigo_b_pases` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  `in_out` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idinventario_cs`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.lineas
CREATE TABLE IF NOT EXISTS `lineas` (
  `id` int(4) NOT NULL AUTO_INCREMENT COMMENT 'Identificacion de la linea',
  `rif` varchar(12) NOT NULL DEFAULT 'J-00000000-0' COMMENT 'Registro de informacion fiscal',
  `nombre` varchar(80) NOT NULL COMMENT 'Nombre de la linea',
  `auditoria` int(4) unsigned DEFAULT NULL,
  `delete` int(1) unsigned DEFAULT NULL,
  `agencia` varchar(50) DEFAULT NULL COMMENT 'Agencia',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.pase_salida
CREATE TABLE IF NOT EXISTS `pase_salida` (
  `idpase` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `orden_despacho` int(6) unsigned zerofill DEFAULT '000000',
  `fch_hora` datetime NOT NULL,
  `nom_ape_chfer` varchar(255) NOT NULL,
  `cedula` int(8) NOT NULL,
  `transporte` varchar(255) NOT NULL,
  `placa` varchar(45) NOT NULL,
  `observ` mediumtext,
  `codigo_b_actas` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  `codigo_b_pases` int(12) unsigned zerofill NOT NULL DEFAULT '000000000000',
  `anulado` int(1) NOT NULL DEFAULT '0',
  `operador` varchar(255) NOT NULL,
  `consignatario` varchar(255) NOT NULL,
  PRIMARY KEY (`idpase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.pase_salida_cont
CREATE TABLE IF NOT EXISTS `pase_salida_cont` (
  `idpase` int(6) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `fch_hora` datetime NOT NULL,
  `nom_ape_chfer` varchar(255) NOT NULL,
  `cedula` int(8) NOT NULL,
  `transporte` varchar(255) NOT NULL,
  `placa` varchar(45) NOT NULL,
  `nula` int(1) unsigned NOT NULL DEFAULT '0',
  `auditoria` int(4) DEFAULT NULL,
  `mod` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `codigo_b_pases` int(12) unsigned zerofill DEFAULT '000000000000',
  PRIMARY KEY (`idpase`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.patios
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `patios` (
	`id` INT(8) NOT NULL DEFAULT '0',
	`patio` VARCHAR(12) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.queryiso6346
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `queryiso6346` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`c1` INT(2) NULL DEFAULT NULL,
	`c2` INT(2) NULL DEFAULT NULL,
	`c3` INT(2) NULL DEFAULT NULL,
	`c4` INT(2) NULL DEFAULT NULL,
	`c5` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c6` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c7` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c8` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c9` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c10` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`c11` INT(3) UNSIGNED NOT NULL DEFAULT '0',
	`yard` VARCHAR(3) NOT NULL DEFAULT '' COLLATE 'utf8_general_ci',
	`delete` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'borrado'
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.reparaciones
CREATE TABLE IF NOT EXISTS `reparaciones` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `idcontenedor` int(11) NOT NULL,
  `reparacion` int(1) NOT NULL,
  `fecha` date NOT NULL,
  `condicion` int(1) NOT NULL,
  `antobs` text,
  `monto` decimal(10,2) DEFAULT NULL,
  `auditoria` int(4) NOT NULL,
  `inhabilitado` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idcontenedor` (`idcontenedor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.reportcliente
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `reportcliente` (
	`id` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`linea` INT(4) UNSIGNED NOT NULL,
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`status` INT(1) UNSIGNED NOT NULL COMMENT 'full, empty',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`bl` VARCHAR(15) NULL DEFAULT NULL COLLATE 'utf8_general_ci',
	`precinto` VARCHAR(15) NULL DEFAULT NULL COMMENT 'numero de precinto' COLLATE 'utf8_general_ci',
	`buque` VARCHAR(45) NOT NULL COMMENT 'Nombre del buque' COLLATE 'utf8_general_ci',
	`viaje` VARCHAR(5) NOT NULL COMMENT 'Viaje' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`fdm` DATE NOT NULL COMMENT 'fecha despacho muelle',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`patio` INT(4) NOT NULL COMMENT 'patio',
	`fdespims` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`eir_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'eir despacho',
	`booking` VARCHAR(10) NULL DEFAULT NULL COMMENT 'booking' COLLATE 'utf8_general_ci'
) ENGINE=MyISAM;


# Dumping structure for view imssisc_desarrollo.temp_asig
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `temp_asig` (
	`idinv` INT(10) UNSIGNED NOT NULL DEFAULT '0',
	`booking` VARCHAR(10) NULL DEFAULT NULL COMMENT 'booking' COLLATE 'utf8_general_ci',
	`fecha` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`auditoria` INT(4) UNSIGNED NULL DEFAULT NULL COMMENT 'auditoria'
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.tequipos
CREATE TABLE IF NOT EXISTS `tequipos` (
  `id` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo',
  `descripcion` text COMMENT 'Descripcion',
  `teus` int(10) unsigned DEFAULT NULL COMMENT 'TEUS',
  `auditoria` int(4) unsigned zerofill NOT NULL DEFAULT '0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.tipo_cont
CREATE TABLE IF NOT EXISTS `tipo_cont` (
  `idtipo_cont` int(4) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `tamaÃ±o` varchar(255) DEFAULT NULL,
  `tipo` varchar(255) DEFAULT NULL,
  `codiso` varchar(4) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`idtipo_cont`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.tracking
# Creating temporary table to overcome VIEW dependency errors
CREATE TABLE `tracking` (
	`id` INT(4) NOT NULL DEFAULT '0' COMMENT 'Identificacion de la linea',
	`nombre` VARCHAR(80) NOT NULL COMMENT 'Nombre de la linea' COLLATE 'utf8_general_ci',
	`contenedor` VARCHAR(11) NOT NULL COLLATE 'utf8_general_ci',
	`tipo` VARCHAR(13) NOT NULL DEFAULT '' COMMENT 'Tipo de equipo' COLLATE 'utf8_general_ci',
	`fdb` DATE NOT NULL COMMENT 'fecha descarga del buque',
	`frd` DATE NOT NULL COMMENT 'fecha de recepcion iims',
	`eir_r` INT(6) UNSIGNED NOT NULL COMMENT 'eir iims',
	`status` INT(1) UNSIGNED NOT NULL COMMENT 'full, empty',
	`condicion` INT(1) UNSIGNED NOT NULL COMMENT 'opr o dmg',
	`patio` INT(4) NOT NULL COMMENT 'patio',
	`consignatario` INT(4) UNSIGNED NOT NULL COMMENT 'Consignatario',
	`fdespims` DATE NULL DEFAULT NULL COMMENT 'fecha despacho iims',
	`eir_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'eir despacho',
	`status_d` INT(10) UNSIGNED NULL DEFAULT NULL COMMENT 'status_despacho',
	`booking` VARCHAR(10) NULL DEFAULT NULL COMMENT 'booking' COLLATE 'utf8_general_ci',
	`c` INT(1) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'cuenta para inventario'
) ENGINE=MyISAM;


# Dumping structure for table imssisc_desarrollo.transporte
CREATE TABLE IF NOT EXISTS `transporte` (
  `id` int(4) unsigned zerofill NOT NULL,
  `transporte` varchar(50) NOT NULL,
  `rif` varchar(12) NOT NULL,
  `direccion` text NOT NULL,
  `observaciones` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.ubicacion
CREATE TABLE IF NOT EXISTS `ubicacion` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `codiata` int(4) unsigned zerofill NOT NULL DEFAULT '0000',
  `codigo` varchar(6) NOT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`),
  KEY `codiata` (`codiata`),
  KEY `codigo` (`codigo`),
  CONSTRAINT `FK_ubicacion_cod_puertos` FOREIGN KEY (`codiata`) REFERENCES `cod_puertos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(25) NOT NULL DEFAULT '',
  `apellido` varchar(25) NOT NULL DEFAULT '',
  `tlf` int(11) unsigned zerofill DEFAULT '00000000000',
  `email` varchar(50) DEFAULT NULL,
  `login` varchar(12) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `linea` int(2) NOT NULL COMMENT 'Linea',
  `nivel` int(1) NOT NULL DEFAULT '0',
  `auditoria` int(4) unsigned zerofill NOT NULL DEFAULT '0000',
  `delete` int(1) unsigned zerofill NOT NULL DEFAULT '0',
  `c_imssis` int(3) unsigned zerofill NOT NULL DEFAULT '111' COMMENT 'Cliente imssis',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for table imssisc_desarrollo.vaciado
CREATE TABLE IF NOT EXISTS `vaciado` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `actacont` int(6) unsigned zerofill NOT NULL,
  `actacg` int(6) unsigned zerofill NOT NULL,
  `fecha` datetime NOT NULL,
  `mod` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `auditoria` int(10) unsigned NOT NULL,
  `c` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for procedure imssisc_desarrollo.validaEquipo
DELIMITER //
CREATE DEFINER=`imssisc`@`localhost` PROCEDURE `validaEquipo`(IN `equipo` VARCHAR(11))
BEGIN
SELECT IF(COUNT(contenedor) > 1,1,0)AS validado FROM inventario WHERE contenedor = equipo AND c = 0 GROUP BY contenedor;
END//
DELIMITER ;


# Dumping structure for table imssisc_desarrollo.viajes
CREATE TABLE IF NOT EXISTS `viajes` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `viaje` varchar(5) NOT NULL COMMENT 'Viaje',
  `buque` int(4) unsigned NOT NULL,
  `eta` date DEFAULT NULL COMMENT 'Fecha estimada del arribo del buque',
  `ad` date DEFAULT NULL COMMENT 'Fecha estimada del arribo del buque',
  `auditoria` int(4) unsigned DEFAULT NULL,
  `delete` int(1) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `buque` (`buque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

# Data exporting was unselected.


# Dumping structure for view imssisc_desarrollo.asignados
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `asignados`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `asignados` AS select `inventario`.`id` AS `id`,`inventario`.`linea` AS `linea`,`lineas`.`nombre` AS `nlinea`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,(case `inventario`.`status` when 0 then 'VACIO' when 1 then 'FULL' end) AS `estatus`,(case `inventario`.`condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' end) AS `condicion`,`inventario`.`fdb` AS `fdb`,`inventario`.`fdm` AS `fdm`,`inventario`.`frd` AS `frd`,`inventario`.`eir_r` AS `eir_r`,`inventario`.`fdespims` AS `fdespims`,`inventario`.`eir_d` AS `eir_d`,`asignaciones`.`booking` AS `booking`,`consignatario`.`nombre` AS `cliente`,(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`fdb`)) AS `dpais`,(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`frd`)) AS `dpatio` from ((((`asignaciones` join `inventario`) join `consignatario`) join `tequipos`) join `lineas`) where ((`inventario`.`id` = `asignaciones`.`equinv`) and (`consignatario`.`id` = `asignaciones`.`cliente`) and (`tequipos`.`id` = `inventario`.`tcont`) and (`inventario`.`linea` = `lineas`.`id`));


# Dumping structure for view imssisc_desarrollo.checkdigit
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `checkdigit`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `checkdigit` AS select `queryiso6346`.`id` AS `id`,substr(`queryiso6346`.`contenedor`,1,4) AS `owner`,substr(`queryiso6346`.`contenedor`,5,6) AS `number`,substr(`queryiso6346`.`contenedor`,-(1)) AS `digit`,if(((((((((((((`queryiso6346`.`c1` * 1) + (`queryiso6346`.`c2` * 2)) + (`queryiso6346`.`c3` * 4)) + (`queryiso6346`.`c4` * 8)) + (`queryiso6346`.`c5` * 16)) + (`queryiso6346`.`c6` * 32)) + (`queryiso6346`.`c7` * 64)) + (`queryiso6346`.`c8` * 128)) + (`queryiso6346`.`c9` * 256)) + (`queryiso6346`.`c10` * 512)) % 11) = 10),0,(((((((((((`queryiso6346`.`c1` * 1) + (`queryiso6346`.`c2` * 2)) + (`queryiso6346`.`c3` * 4)) + (`queryiso6346`.`c4` * 8)) + (`queryiso6346`.`c5` * 16)) + (`queryiso6346`.`c6` * 32)) + (`queryiso6346`.`c7` * 64)) + (`queryiso6346`.`c8` * 128)) + (`queryiso6346`.`c9` * 256)) + (`queryiso6346`.`c10` * 512)) % 11)) AS `checkdigit`,`queryiso6346`.`yard` AS `yard`,`queryiso6346`.`delete` AS `borrado` from `queryiso6346`;


# Dumping structure for view imssisc_desarrollo.consulta_x_consignatario
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `consulta_x_consignatario`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `consulta_x_consignatario` AS select `inventario`.`id` AS `id`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,(case `inventario`.`status` when 0 then 'VACIO' when 1 then 'FULL' end) AS `estatus`,(case `inventario`.`condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' end) AS `condicion`,`inventario`.`eir_r` AS `eirR`,`inventario`.`fdb` AS `descarga`,`inventario`.`fdm` AS `despacho`,`inventario`.`frd` AS `recepcion`,`inventario`.`fdespims` AS `devolucion`,`inventario`.`eir_d` AS `eirD`,`patios`.`patio` AS `ubicacion`,`inventario`.`obs` AS `obs`,`lineas`.`nombre` AS `linea`,`buques`.`nombre` AS `buque`,`viajes`.`viaje` AS `viaje`,`consignatario`.`id` AS `consig_id`,`consignatario`.`nombre` AS `consignatario`,`inventario`.`c` AS `c`,if((`inventario`.`c` = 0),(to_days(curdate()) - to_days(`inventario`.`fdb`)),(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`fdb`))) AS `DIC`,if((`inventario`.`c` = 0),(to_days(curdate()) - to_days(`inventario`.`frd`)),(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`frd`))) AS `DIY` from ((((((`inventario` join `tequipos`) join `lineas`) join `buques`) join `viajes`) join `consignatario`) join `patios`) where ((`inventario`.`tcont` = `tequipos`.`id`) and (`inventario`.`linea` = `lineas`.`id`) and (`inventario`.`buque` = `buques`.`id`) and (`inventario`.`viaje` = `viajes`.`id`) and (`inventario`.`consignatario` = `consignatario`.`id`) and (`inventario`.`patio` = `patios`.`patio`));


# Dumping structure for view imssisc_desarrollo.despachados
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `despachados`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `despachados` AS select `inventario`.`id` AS `id`,`inventario`.`linea` AS `linea`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`status` AS `status`,`inventario`.`condicion` AS `condicion`,`inventario`.`fdb` AS `fdb`,`inventario`.`frd` AS `frd`,`inventario`.`precinto` AS `precinto`,`inventario`.`bl` AS `bl`,`inventario`.`fdespims` AS `fdespims`,`inventario`.`eir_d` AS `eir_d`,`inventario`.`status_d` AS `status_d`,`inventario`.`booking` AS `booking`,`inventario`.`obs` AS `obs`,(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`fdb`)) AS `dic`,(to_days(`inventario`.`fdespims`) - to_days(`inventario`.`frd`)) AS `diy`,if(((to_days(`inventario`.`fdespims`) - to_days(`inventario`.`frd`)) > 30),((to_days(`inventario`.`fdespims`) - to_days(`inventario`.`frd`)) - 30),_utf8'') AS `acopio` from (((`inventario` join `tequipos`) join `buques`) join `viajes`) where ((`inventario`.`tcont` = `tequipos`.`id`) and (`inventario`.`buque` = `buques`.`id`) and (`inventario`.`viaje` = `viajes`.`id`) and (`inventario`.`c` = 1) and (`inventario`.`delete` = 0));


# Dumping structure for view imssisc_desarrollo.existencia
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `existencia`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `existencia` AS select `inventario`.`id` AS `id`,`inventario`.`acta` AS `acta`,`inventario`.`linea` AS `linea`,`lineas`.`nombre` AS `nlinea`,`consignatario`.`id` AS `idconsignatario`,`consignatario`.`nombre` AS `consignatario`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`status` AS `status`,`inventario`.`condicion` AS `condicion`,`buques`.`nombre` AS `buque`,`viajes`.`viaje` AS `viaje`,`inventario`.`fdb` AS `fdb`,`inventario`.`frd` AS `frd`,`inventario`.`bl` AS `bl`,`inventario`.`precinto` AS `precinto`,`inventario`.`eir_r` AS `eir_r`,`inventario`.`patio` AS `patio`,`inventario`.`obs` AS `obs`,`inventario`.`vaciado` AS `vaciado` from (((((`inventario` join `tequipos`) join `buques`) join `viajes`) join `lineas`) join `consignatario`) where ((`inventario`.`c` = 0) and (`inventario`.`delete` = 0) and (`tequipos`.`id` = `inventario`.`tcont`) and (`buques`.`id` = `inventario`.`buque`) and (`viajes`.`id` = `inventario`.`viaje`) and (`lineas`.`id` = `inventario`.`linea`) and (`consignatario`.`id` = `inventario`.`consignatario`)) order by `inventario`.`frd`;


# Dumping structure for view imssisc_desarrollo.existenciaconsig
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `existenciaconsig`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `existenciaconsig` AS select `inventario`.`id` AS `id`,if((`inventario`.`acta` > 0),`inventario`.`acta`,NULL) AS `acta`,if((`inventario`.`pase` > 0),`inventario`.`pase`,NULL) AS `pase`,`lineas`.`nombre` AS `linea`,`buques`.`nombre` AS `buque`,`viajes`.`viaje` AS `viaje`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`eir_r` AS `eir_r`,`inventario`.`fdb` AS `fdb`,`inventario`.`fdm` AS `fdm`,`inventario`.`frd` AS `frd`,(case `inventario`.`status` when 0 then 'Vacio' when 1 then 'Full' end) AS `estatus`,(case `inventario`.`condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' end) AS `condicion`,`inventario`.`precinto` AS `precinto`,`inventario`.`bl` AS `bl`,`patios`.`patio` AS `patio`,`inventario`.`consignatario` AS `consignatario`,`consignatario`.`nombre` AS `consignom`,`inventario`.`obs` AS `obs` from ((((((`inventario` join `lineas`) join `buques`) join `viajes`) join `tequipos`) join `patios`) join `consignatario`) where ((`inventario`.`c` = 0) and (`inventario`.`linea` = `lineas`.`id`) and (`inventario`.`buque` = `buques`.`id`) and (`inventario`.`viaje` = `viajes`.`id`) and (`inventario`.`tcont` = `tequipos`.`id`) and (`inventario`.`patio` = `patios`.`id`) and (`inventario`.`consignatario` = `consignatario`.`id`));


# Dumping structure for view imssisc_desarrollo.existenciadevolucion
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `existenciadevolucion`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `existenciadevolucion` AS select `imssisc_desarrollo`.`inventario`.`id` AS `id`,`imssisc_desarrollo`.`inventario`.`linea` AS `linea`,`imssisc_desarrollo`.`lineas`.`nombre` AS `nombre_linea`,`imssisc_desarrollo`.`inventario`.`contenedor` AS `contenedor`,`imssisc_desarrollo`.`tequipos`.`tipo` AS `tipo`,(case `imssisc_desarrollo`.`inventario`.`status` when 0 then 'Vacio' when 1 then 'FULL' end) AS `estatus`,(case `imssisc_desarrollo`.`inventario`.`condicion` when 0 then 'DMG' when 1 then 'OPR1' when 2 then 'OPR2' when 3 then 'OPR3' end) AS `condicion`,`imssisc_desarrollo`.`buques`.`nombre` AS `buque`,`imssisc_desarrollo`.`viajes`.`viaje` AS `viaje`,`imssisc_desarrollo`.`inventario`.`fdb` AS `fdb`,`imssisc_desarrollo`.`inventario`.`fdm` AS `fdm`,`imssisc_desarrollo`.`inventario`.`frd` AS `frd`,`imssisc_desarrollo`.`inventario`.`precinto` AS `precinto`,`imssisc_desarrollo`.`inventario`.`bl` AS `bl`,`imssisc_desarrollo`.`inventario`.`eir_r` AS `eir_r`,`imssisc_desarrollo`.`inventario`.`patio` AS `patio`,`imssisc_desarrollo`.`inventario`.`obs` AS `obs`,(to_days(curdate()) - to_days(`imssisc_desarrollo`.`inventario`.`fdb`)) AS `DIC`,(to_days(curdate()) - to_days(`imssisc_desarrollo`.`inventario`.`frd`)) AS `DIY` from ((((`inventario` join `lineas`) join `buques`) join `viajes`) join `tequipos`) where ((`imssisc_desarrollo`.`inventario`.`c` = 0) and (`imssisc_desarrollo`.`inventario`.`linea` = `imssisc_desarrollo`.`lineas`.`id`) and (`imssisc_desarrollo`.`inventario`.`buque` = `imssisc_desarrollo`.`buques`.`id`) and (`imssisc_desarrollo`.`inventario`.`viaje` = `imssisc_desarrollo`.`viajes`.`id`) and (`imssisc_desarrollo`.`inventario`.`tcont` = `imssisc_desarrollo`.`tequipos`.`id`)) order by (to_days(curdate()) - to_days(`imssisc_desarrollo`.`inventario`.`fdb`)) desc;


# Dumping structure for view imssisc_desarrollo.existenciagral
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `existenciagral`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `existenciagral` AS select `inventario`.`id` AS `id`,`inventario`.`linea` AS `linea`,`lineas`.`nombre` AS `nlinea`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`status` AS `estatus`,`inventario`.`condicion` AS `condicion`,`buques`.`nombre` AS `buque`,`viajes`.`viaje` AS `viaje`,`inventario`.`fdb` AS `fdb`,`inventario`.`frd` AS `frd`,`inventario`.`precinto` AS `precinto`,`inventario`.`bl` AS `bl`,`inventario`.`eir_r` AS `eir_r`,`consignatario`.`nombre` AS `consignatario`,`patios`.`patio` AS `patio`,`inventario`.`obs` AS `obs`,(to_days(curdate()) - to_days(`inventario`.`fdb`)) AS `dpais`,(to_days(curdate()) - to_days(`inventario`.`frd`)) AS `dpatio` from ((((((`inventario` join `tequipos`) join `buques`) join `viajes`) join `lineas`) join `consignatario`) join `patios`) where ((`inventario`.`c` = 0) and (`inventario`.`delete` = 0) and (`tequipos`.`id` = `inventario`.`tcont`) and (`buques`.`id` = `inventario`.`buque`) and (`viajes`.`id` = `inventario`.`viaje`) and (`lineas`.`id` = `inventario`.`linea`) and (`consignatario`.`id` = `inventario`.`consignatario`) and (`patios`.`id` = `inventario`.`patio`)) order by `inventario`.`frd`;


# Dumping structure for view imssisc_desarrollo.historial
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `historial`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `historial` AS select `lineas`.`id` AS `lineaId`,`lineas`.`nombre` AS `nombre`,`lineas`.`agencia` AS `agencia`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`fdb` AS `fdb`,`inventario`.`fdm` AS `fdm`,`inventario`.`frd` AS `frd`,`inventario`.`patio` AS `patio`,if((`inventario`.`status` = 0),_utf8'EMPTY',_utf8'FULL') AS `status_in`,`inventario`.`condicion` AS `condicion`,`inventario`.`precinto` AS `precinto`,`inventario`.`bl` AS `bl`,`inventario`.`fdespims` AS `fdespims`,`inventario`.`booking` AS `booking` from ((`inventario` join `tequipos`) join `lineas`) where ((`tequipos`.`id` = `inventario`.`tcont`) and (`lineas`.`id` = `inventario`.`linea`) and (`inventario`.`delete` = 0)) order by `inventario`.`contenedor`;


# Dumping structure for view imssisc_desarrollo.patios
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `patios`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `patios` AS select `ubicacion`.`id` AS `id`,concat(`cod_puertos`.`codigo`,`ubicacion`.`codigo`) AS `patio` from (`ubicacion` join `cod_puertos`) where (`ubicacion`.`codiata` = `cod_puertos`.`id`);


# Dumping structure for view imssisc_desarrollo.queryiso6346
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `queryiso6346`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `queryiso6346` AS select `inventario`.`id` AS `id`,`inventario`.`contenedor` AS `contenedor`,(case substr(`inventario`.`contenedor`,1,1) when _utf8'A' then 10 when _utf8'B' then 12 when _utf8'C' then 13 when _utf8'D' then 14 when _utf8'E' then 15 when _utf8'F' then 16 when _utf8'G' then 17 when _utf8'H' then 18 when _utf8'I' then 19 when _utf8'J' then 20 when _utf8'K' then 21 when _utf8'L' then 23 when _utf8'M' then 24 when _utf8'N' then 25 when _utf8'O' then 26 when _utf8'P' then 27 when _utf8'Q' then 28 when _utf8'R' then 29 when _utf8'S' then 30 when _utf8'T' then 31 when _utf8'U' then 32 when _utf8'V' then 34 when _utf8'W' then 35 when _utf8'X' then 36 when _utf8'Y' then 37 when _utf8'Z' then 38 end) AS `c1`,(case substr(`inventario`.`contenedor`,2,1) when _utf8'A' then 10 when _utf8'B' then 12 when _utf8'C' then 13 when _utf8'D' then 14 when _utf8'E' then 15 when _utf8'F' then 16 when _utf8'G' then 17 when _utf8'H' then 18 when _utf8'I' then 19 when _utf8'J' then 20 when _utf8'K' then 21 when _utf8'L' then 23 when _utf8'M' then 24 when _utf8'N' then 25 when _utf8'O' then 26 when _utf8'P' then 27 when _utf8'Q' then 28 when _utf8'R' then 29 when _utf8'S' then 30 when _utf8'T' then 31 when _utf8'U' then 32 when _utf8'V' then 34 when _utf8'W' then 35 when _utf8'X' then 36 when _utf8'Y' then 37 when _utf8'Z' then 38 end) AS `c2`,(case substr(`inventario`.`contenedor`,3,1) when _utf8'A' then 10 when _utf8'B' then 12 when _utf8'C' then 13 when _utf8'D' then 14 when _utf8'E' then 15 when _utf8'F' then 16 when _utf8'G' then 17 when _utf8'H' then 18 when _utf8'I' then 19 when _utf8'J' then 20 when _utf8'K' then 21 when _utf8'L' then 23 when _utf8'M' then 24 when _utf8'N' then 25 when _utf8'O' then 26 when _utf8'P' then 27 when _utf8'Q' then 28 when _utf8'R' then 29 when _utf8'S' then 30 when _utf8'T' then 31 when _utf8'U' then 32 when _utf8'V' then 34 when _utf8'W' then 35 when _utf8'X' then 36 when _utf8'Y' then 37 when _utf8'Z' then 38 end) AS `c3`,(case substr(`inventario`.`contenedor`,4,1) when _utf8'A' then 10 when _utf8'B' then 12 when _utf8'C' then 13 when _utf8'D' then 14 when _utf8'E' then 15 when _utf8'F' then 16 when _utf8'G' then 17 when _utf8'H' then 18 when _utf8'I' then 19 when _utf8'J' then 20 when _utf8'K' then 21 when _utf8'L' then 23 when _utf8'M' then 24 when _utf8'N' then 25 when _utf8'O' then 26 when _utf8'P' then 27 when _utf8'Q' then 28 when _utf8'R' then 29 when _utf8'S' then 30 when _utf8'T' then 31 when _utf8'U' then 32 when _utf8'V' then 34 when _utf8'W' then 35 when _utf8'X' then 36 when _utf8'Y' then 37 when _utf8'Z' then 38 end) AS `c4`,cast(substr(`inventario`.`contenedor`,5,1) as unsigned) AS `c5`,cast(substr(`inventario`.`contenedor`,6,1) as unsigned) AS `c6`,cast(substr(`inventario`.`contenedor`,7,1) as unsigned) AS `c7`,cast(substr(`inventario`.`contenedor`,8,1) as unsigned) AS `c8`,cast(substr(`inventario`.`contenedor`,9,1) as unsigned) AS `c9`,cast(substr(`inventario`.`contenedor`,10,1) as unsigned) AS `c10`,cast(substr(`inventario`.`contenedor`,-(1)) as unsigned) AS `c11`,if((`inventario`.`c` = 1),_utf8'OUT',_utf8'IN') AS `yard`,`inventario`.`delete` AS `delete` from `inventario`;


# Dumping structure for view imssisc_desarrollo.reportcliente
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `reportcliente`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `reportcliente` AS select `inventario`.`id` AS `id`,`inventario`.`linea` AS `linea`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`status` AS `status`,`inventario`.`condicion` AS `condicion`,`inventario`.`bl` AS `bl`,`inventario`.`precinto` AS `precinto`,`buques`.`nombre` AS `buque`,`viajes`.`viaje` AS `viaje`,`inventario`.`fdb` AS `fdb`,`inventario`.`fdm` AS `fdm`,`inventario`.`frd` AS `frd`,`inventario`.`eir_r` AS `eir_r`,`inventario`.`patio` AS `patio`,`inventario`.`fdespims` AS `fdespims`,`inventario`.`eir_d` AS `eir_d`,`inventario`.`booking` AS `booking` from (((`inventario` join `tequipos`) join `buques`) join `viajes`) where ((`inventario`.`delete` = 0) and (`inventario`.`tcont` = `tequipos`.`id`) and (`inventario`.`buque` = `buques`.`id`) and (`inventario`.`viaje` = `viajes`.`id`));


# Dumping structure for view imssisc_desarrollo.temp_asig
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `temp_asig`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `temp_asig` AS select `inventario`.`id` AS `idinv`,`inventario`.`booking` AS `booking`,`inventario`.`fdespims` AS `fecha`,`inventario`.`auditoria` AS `auditoria` from `inventario` where ((`inventario`.`booking` is not null) and (`inventario`.`delete` = 0)) order by `inventario`.`id`;


# Dumping structure for view imssisc_desarrollo.tracking
# Removing temporary table and create final VIEW structure
DROP TABLE IF EXISTS `tracking`;
CREATE ALGORITHM=UNDEFINED DEFINER=`imssisc`@`localhost` SQL SECURITY DEFINER VIEW `tracking` AS select `lineas`.`id` AS `id`,`lineas`.`nombre` AS `nombre`,`inventario`.`contenedor` AS `contenedor`,`tequipos`.`tipo` AS `tipo`,`inventario`.`fdb` AS `fdb`,`inventario`.`frd` AS `frd`,`inventario`.`eir_r` AS `eir_r`,`inventario`.`status` AS `status`,`inventario`.`condicion` AS `condicion`,`inventario`.`patio` AS `patio`,`inventario`.`consignatario` AS `consignatario`,`inventario`.`fdespims` AS `fdespims`,`inventario`.`eir_d` AS `eir_d`,`inventario`.`status_d` AS `status_d`,`inventario`.`booking` AS `booking`,`inventario`.`c` AS `c` from ((`inventario` join `lineas`) join `tequipos`) where ((`inventario`.`delete` = 0) and (`lineas`.`id` = `inventario`.`linea`) and (`tequipos`.`id` = `inventario`.`tcont`)) order by `inventario`.`fdespims`;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
