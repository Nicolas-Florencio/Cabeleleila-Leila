-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema cabeleleila
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `cabeleleila` ;

-- -----------------------------------------------------
-- Schema cabeleleila
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cabeleleila` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci ;
USE `cabeleleila` ;

-- -----------------------------------------------------
-- Table `cabeleleila`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cabeleleila`.`usuario` (
  `idUsuario` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(80) CHARACTER SET 'utf8mb3' NOT NULL,
  `email` VARCHAR(45) CHARACTER SET 'utf8mb3' NOT NULL,
  `senha` VARCHAR(32) CHARACTER SET 'utf8mb3' NOT NULL,
  `nivelAcesso` CHAR(1) NULL DEFAULT '0',
  PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 13
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cabeleleila`.`agendamento`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cabeleleila`.`agendamento` (
  `dataAgendada` DATETIME NOT NULL,
  `status` CHAR(1) NULL DEFAULT NULL,
  `usuario_idusuario` INT NOT NULL,
  `idAgendamento` INT NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`idAgendamento`),
  INDEX `fk_agendamento_usuario1_idx` (`usuario_idusuario` ASC) VISIBLE,
  CONSTRAINT `fk_agendamento_usuario1`
    FOREIGN KEY (`usuario_idusuario`)
    REFERENCES `cabeleleila`.`usuario` (`idUsuario`))
ENGINE = InnoDB
AUTO_INCREMENT = 15
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cabeleleila`.`servicos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cabeleleila`.`servicos` (
  `idServicos` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) CHARACTER SET 'utf8mb3' NOT NULL,
  PRIMARY KEY (`idServicos`))
ENGINE = InnoDB
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


-- -----------------------------------------------------
-- Table `cabeleleila`.`agendamento_servicos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cabeleleila`.`agendamento_servicos` (
  `servicos_idservicos` INT NOT NULL,
  `agendamento_idAgendamento` INT NOT NULL,
  INDEX `fk_agendamento_servicos_servicos1_idx` (`servicos_idservicos` ASC) VISIBLE,
  INDEX `fk_agendamento_servicos_agendamento1_idx` (`agendamento_idAgendamento` ASC) VISIBLE,
  CONSTRAINT `fk_agendamento_servicos_agendamento1`
    FOREIGN KEY (`agendamento_idAgendamento`)
    REFERENCES `cabeleleila`.`agendamento` (`idAgendamento`),
  CONSTRAINT `fk_agendamento_servicos_servicos1`
    FOREIGN KEY (`servicos_idservicos`)
    REFERENCES `cabeleleila`.`servicos` (`idServicos`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_0900_ai_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
