SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";
  
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

CREATE TABLE `sys_core_cab_01_users` (
  `id_syscore01` int(11) NOT NULL AUTO_INCREMENT,  
  `syscore01_nombre` varchar(255) NOT NULL,
  `syscore01_user` varchar(255) NOT NULL,
  `syscore01_pass` varchar(255) NOT NULL,
  `syscore01_last_login` DATETIME,
  PRIMARY KEY (`id_syscore01`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sys_core_cab_01_users` (`syscore01_nombre`, `syscore01_user`, `syscore01_pass`, `syscore01_last_login`) VALUES
('Usuario 1','userApi','e3e7853b7f2442ea17917dd32c3858ff',NULL);
 
CREATE TABLE `sys_farm_cab_01_farmacias` (
  `id_sysfarm01` int(11) NOT NULL AUTO_INCREMENT,  
  `sysfarm01_nombre` varchar(255) NOT NULL,
  `sysfarm01_direccion` varchar(255) NOT NULL,
  `sysfarm01_latitud` varchar(255) NOT NULL,
  `sysfarm01_longitud` varchar(255) NOT NULL,
  PRIMARY KEY (`id_sysfarm01`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `sys_farm_cab_01_farmacias` (`id_sysfarm01`, `sysfarm01_nombre`, `sysfarm01_direccion`, `sysfarm01_latitud`, `sysfarm01_longitud`) VALUES
(1, 'Farmacia - Perfumeria Argentina','Av. González Lelong 714, P3600 Formosa','-26.176310356441423','-58.17533126167371'),
(2, 'Farmacia - La Nueva Estrella','Av. Juan Domingo Perón 1297, P3600 Formosa','-26.163531722730962','-58.182116821623744');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;