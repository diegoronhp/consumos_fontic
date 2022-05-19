-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
SHOW WARNINGS;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `operadores`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `operadores` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `operadores` (
  `id_operador` INT NOT NULL AUTO_INCREMENT,
  `nombre_operador` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_operador`))
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `lineas_registradas`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `lineas_registradas` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `lineas_registradas` (
  `numero_linea` BIGINT NOT NULL,
  `estado` INT NOT NULL DEFAULT 1,
  `id_operador` INT NOT NULL,
  PRIMARY KEY (`numero_linea`),
  FOREIGN KEY (`id_operador`) REFERENCES `operadores`(`id_operador`)
)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `archivos_claro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `archivos_claro` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `archivos_claro` (
  `id_archivo_claro` INT NOT NULL AUTO_INCREMENT,
  `nombre_archivo` VARCHAR(200) NOT NULL,
  `tipo_consumo` INT,
  `fecha_cargue` DATETIME NOT NULL,
  `fecha_procesamiento` DATETIME,
  `cantidad_insertados` INT NOT NULL DEFAULT 0,
  `cantidad_analizados` INT NOT NULL DEFAULT 0,
  `id_inicial` INT NOT NULL DEFAULT 0,
  `id_final` INT NOT NULL DEFAULT 0,
  `tipo_insercion` INT NOT NULL,
  PRIMARY KEY (`id_archivo_claro`)
)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `archivos_tigo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `archivos_tigo` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `archivos_tigo` (
  `id_archivo_plataforma` INT NOT NULL AUTO_INCREMENT,
  `nombre_archivo` VARCHAR(200) NOT NULL,
  `fecha_cargue` DATETIME NOT NULL,
  `fecha_procesamiento` DATETIME,
  `cant_insertados_voz` INT NOT NULL DEFAULT 0,
  `cant_insertados_datos` INT NOT NULL DEFAULT 0,
  `cant_analizados` INT NOT NULL DEFAULT 0,
  `cant_rechazados` INT NOT NULL DEFAULT 0,
  `tipo_archivo` INT NOT NULL,
  `tipo_insercion` INT NOT NULL,
  `id_inicial_voz` INT NOT NULL DEFAULT 0,
  `id_final_voz` INT NOT NULL DEFAULT 0,
  `id_inicial_datos` INT NOT NULL DEFAULT 0,
  `id_final_datos` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_archivo_plataforma`)
)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `consumos_voz`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consumos_voz` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `consumos_voz` (
  `id_consumo` INT NOT NULL AUTO_INCREMENT,
  `cantidad_consumo` DOUBLE NOT NULL,
  `fecha_consumo` DATE NOT NULL,
  `numero_linea` BIGINT NOT NULL,
  `id_archivo_claro` INT NOT NULL DEFAULT 0,
  `id_archivo_tigo_dash` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_consumo`),
  FOREIGN KEY (`numero_linea`) REFERENCES `lineas_registradas`(`numero_linea`)
)
ENGINE = InnoDB;

SHOW WARNINGS;

-- -----------------------------------------------------
-- Table `consumos_datos`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `consumos_datos` ;

SHOW WARNINGS;
CREATE TABLE IF NOT EXISTS `consumos_datos` (
  `id_consumo` INT NOT NULL AUTO_INCREMENT,
  `cantidad_consumo` DOUBLE NOT NULL,
  `fecha_consumo` DATE NOT NULL,
  `numero_linea` BIGINT NOT NULL,
  `id_archivo_claro` INT NOT NULL DEFAULT 0,
  `id_archivo_tigo_dash` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id_consumo`),
  FOREIGN KEY (`numero_linea`) REFERENCES `lineas_registradas`(`numero_linea`)
)
ENGINE = InnoDB;

SHOW WARNINGS;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
