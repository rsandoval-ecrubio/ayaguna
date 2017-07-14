CREATE TABLE `select_1` (
  `id` int(2) NOT NULL default '0',
  `opcion` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO `select_1` (`id`, `opcion`) VALUES (1, 'Opci�n 1'),
(2, 'Opci�n 2'),
(3, 'Opci�n 3'),
(4, 'Opci�n 4');

CREATE TABLE `select_2` (
  `id` int(2) NOT NULL default '0',
  `opcion` varchar(255) NOT NULL default '',
  `relacion` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO `select_2` (`id`, `opcion`, `relacion`) VALUES (1, 'Opci�n 1.1', 1),
(2, 'Opci�n 1.2', 1),
(3, 'Opci�n 1.3', 1),
(4, 'Opci�n 1.4', 1),
(5, 'Opci�n 2.1', 2),
(6, 'Opci�n 2.2', 2),
(7, 'Opci�n 3.1', 3),
(8, 'Opci�n 3.2', 3),
(9, 'Opci�n 3.3', 3),
(10, 'Opci�n 3.4', 3),
(11, 'Opci�n 4.1', 4),
(12, 'Opci�n 4.2', 4);

CREATE TABLE `select_3` (
  `id` int(2) NOT NULL default '0',
  `opcion` varchar(255) NOT NULL default '',
  `relacion` int(2) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO `select_3` (`id`, `opcion`, `relacion`) VALUES (1, 'Opci�n 1.1.1', 1),
(2, 'Opci�n 1.1.2', 1),
(3, 'Opci�n 1.2.1', 2),
(4, 'Opci�n 1.2.2', 2),
(5, 'Opci�n 1.3.1', 3),
(6, 'Opci�n 1.3.2', 3),
(7, 'Opci�n 1.4.1', 4),
(8, 'Opci�n 1.4.2', 4),
(9, 'Opci�n 2.1.1', 5),
(10, 'Opci�n 2.1.2', 5),
(11, 'Opci�n 2.2.1', 6),
(12, 'Opci�n 2.2.2', 6),
(13, 'Opci�n 3.1.1', 7),
(14, 'Opci�n 3.1.2', 7),
(15, 'Opci�n 3.2.1', 8),
(16, 'Opci�n 3.2.2', 8),
(17, 'Opci�n 3.3.1', 9),
(18, 'Opci�n 3.3.2', 9),
(19, 'Opci�n 3.4.1', 10),
(20, 'Opci�n 3.4.2', 10),
(21, 'Opci�n 4.1.1', 11),
(22, 'Opci�n 4.1.2', 11),
(23, 'Opci�n 4.2.1', 12),
(24, 'Opci�n 4.2.2', 12);