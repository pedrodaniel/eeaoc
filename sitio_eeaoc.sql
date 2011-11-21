# SQL Manager 2007 for MySQL 4.1.2.1
# ---------------------------------------
# Host     : localhost
# Port     : 3306
# Database : sitio_eeaoc


SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE `sitio_eeaoc`
    CHARACTER SET 'utf8'
    COLLATE 'utf8_general_ci';

USE `sitio_eeaoc`;

#
# Structure for the `caract_rubro` table : 
#

CREATE TABLE `caract_rubro` (
  `id` int(11) NOT NULL auto_increment,
  `rubro_id` int(11) default NULL,
  `caracteristica_id` int(11) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `caracteristica` table : 
#

CREATE TABLE `caracteristica` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `descripcion` text,
  `imagen` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `foto_novedades` table : 
#

CREATE TABLE `foto_novedades` (
  `id` int(11) NOT NULL auto_increment,
  `imagen` varchar(50) default NULL,
  `ruta` varchar(50) default NULL,
  `novedad_id` int(11) default NULL,
  `titulo` varchar(100) default NULL,
  `descripcion` text,
  `destacada` int(11) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `imagen_producto` table : 
#

CREATE TABLE `imagen_producto` (
  `id` int(11) NOT NULL auto_increment,
  `imagen` varchar(50) default NULL,
  `ruta` varchar(50) default NULL,
  `producto_id` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `modulos` table : 
#

CREATE TABLE `modulos` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `orden` int(2) default NULL,
  `padre_id` int(11) default NULL,
  `menu` int(1) default NULL,
  `accion` varchar(50) default NULL,
  `hijos` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Structure for the `novedades` table : 
#

CREATE TABLE `novedades` (
  `id` int(11) NOT NULL auto_increment,
  `tipo` int(11) default NULL,
  `tematica_id` int(11) default NULL,
  `titulo` varchar(100) default NULL,
  `bajada` varchar(250) default NULL,
  `texto` text,
  `fecha` datetime default NULL,
  `home` int(11) default NULL,
  `adjunto` varchar(50) default NULL,
  `destacado` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `pagina` table : 
#

CREATE TABLE `pagina` (
  `id` int(11) NOT NULL auto_increment,
  `titulo` int(11) default NULL,
  `orden` int(11) default NULL,
  `imagen` varchar(50) default NULL,
  `padre_id` int(11) default '0',
  `contenido` text,
  `tipo` int(11) default NULL COMMENT '1- Menu principal\r\n2- Submenu\r\n3- Tercer Menu',
  `accion` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `perfil` table : 
#

CREATE TABLE `perfil` (
  `id` int(11) NOT NULL auto_increment,
  `perfil` varchar(20) default NULL,
  `habilitado` tinyint(1) default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Structure for the `permiso` table : 
#

CREATE TABLE `permiso` (
  `id` int(11) NOT NULL auto_increment,
  `perfil_id` int(11) default NULL,
  `modulo_id` int(11) default NULL,
  `Alta` int(1) default NULL,
  `Baja` int(1) default NULL,
  `Modificacion` int(1) default NULL,
  `Listado` int(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Structure for the `producto` table : 
#

CREATE TABLE `producto` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `descripcion` text,
  `tematica_id` int(11) default NULL,
  `seccion_id` int(11) default NULL,
  `tipo` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `producto_rubro` table : 
#

CREATE TABLE `producto_rubro` (
  `id` int(11) NOT NULL auto_increment,
  `rubro_id` int(11) default NULL,
  `producto_id` int(11) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `rubro` table : 
#

CREATE TABLE `rubro` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `descripcion` text,
  `imagen` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `servicio` table : 
#

CREATE TABLE `servicio` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `descripcion` text,
  `imagen` varchar(50) default NULL,
  `color` varchar(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `servicio_rubro` table : 
#

CREATE TABLE `servicio_rubro` (
  `id` int(11) NOT NULL auto_increment,
  `rubro_id` int(11) default NULL,
  `servicio_id` int(11) default NULL,
  `orden` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `tematica` table : 
#

CREATE TABLE `tematica` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `descripcion` text,
  `imagen` varchar(50) default NULL,
  `padre_id` int(11) default NULL,
  `hijos` tinyint(1) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Structure for the `tipo_novedad` table : 
#

CREATE TABLE `tipo_novedad` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Structure for the `usuario` table : 
#

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL auto_increment,
  `nombre` varchar(50) default NULL,
  `apellido` varchar(50) default NULL,
  `email` varchar(50) default NULL,
  `password` varchar(50) default NULL,
  `perfil_id` int(11) default NULL,
  `habilitado` tinyint(1) default '0',
  `fecha_alta` datetime default NULL,
  `ultimo_acceso` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

#
# Data for the `modulos` table  (LIMIT 0,500)
#

INSERT INTO `modulos` (`id`, `nombre`, `orden`, `padre_id`, `menu`, `accion`, `hijos`) VALUES 
  (1,'Administración',1,0,1,'usuarios',1),
  (2,'Usuarios',1,1,1,'usuarios',0),
  (3,'Perfiles',2,1,1,'perfiles',0),
  (4,'Permisos',3,1,1,'permisos',0),
  (5,'Módulos',4,1,1,'modulos',0),
  (6,'Tematicas',2,0,1,'tematicas',0);

COMMIT;

#
# Data for the `perfil` table  (LIMIT 0,500)
#

INSERT INTO `perfil` (`id`, `perfil`, `habilitado`) VALUES 
  (1,'Administrador',1);

COMMIT;

#
# Data for the `permiso` table  (LIMIT 0,500)
#

INSERT INTO `permiso` (`id`, `perfil_id`, `modulo_id`, `Alta`, `Baja`, `Modificacion`, `Listado`) VALUES 
  (1,1,1,0,0,0,1),
  (2,1,2,1,1,1,1),
  (3,1,3,1,1,1,1),
  (4,1,4,1,1,1,1),
  (5,1,5,1,1,1,1),
  (6,1,6,1,1,1,1);

COMMIT;

#
# Data for the `tipo_novedad` table  (LIMIT 0,500)
#

INSERT INTO `tipo_novedad` (`id`, `nombre`) VALUES 
  (1,'Campañas'),
  (2,'Convocatorias'),
  (3,'Inf. y Publicaciones');

COMMIT;

#
# Data for the `usuario` table  (LIMIT 0,500)
#

INSERT INTO `usuario` (`id`, `nombre`, `apellido`, `email`, `password`, `perfil_id`, `habilitado`, `fecha_alta`, `ultimo_acceso`) VALUES 
  (1,'Pedro Daniel','Romano Correa','pdrc83@gmail.com','32f972344bc7de6a9f0f0f0123883798',1,1,'2011-10-01','2011-11-18 21:03:15');

COMMIT;

