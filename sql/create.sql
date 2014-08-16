SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `eleicao` ;
CREATE SCHEMA IF NOT EXISTS `eleicao` DEFAULT CHARACTER SET latin1 ;
USE `eleicao` ;

-- -----------------------------------------------------
-- Table `eleicao`.`pais`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`pais` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`pais` (
  `idpais` INT NOT NULL ,
  `nome` VARCHAR(60) NOT NULL ,
  `sigla` VARCHAR(3) NOT NULL ,
  PRIMARY KEY (`idpais`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`estado`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`estado` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`estado` (
  `idestado` INT NOT NULL ,
  `nome` VARCHAR(75) NOT NULL ,
  `uf` VARCHAR(2) NOT NULL ,
  `idpais_pais` INT NOT NULL ,
  PRIMARY KEY (`idestado`) ,
  INDEX `estado_pais_fk` (`idpais_pais` ASC) ,
  CONSTRAINT `estado_pais_fk`
    FOREIGN KEY (`idpais_pais` )
    REFERENCES `eleicao`.`pais` (`idpais` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`cidade`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`cidade` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`cidade` (
  `idcidade` INT NOT NULL ,
  `nome` VARCHAR(120) NOT NULL ,
  `idestado_estado` INT NOT NULL ,
  PRIMARY KEY (`idcidade`) ,
  INDEX `cidade_estado_fk` (`idestado_estado` ASC) ,
  CONSTRAINT `fk_cidade_estado1`
    FOREIGN KEY (`idestado_estado` )
    REFERENCES `eleicao`.`estado` (`idestado` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`eleitor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`eleitor` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`eleitor` (
  `ideleitor` INT NOT NULL AUTO_INCREMENT ,
  `cpf` CHAR(11) NOT NULL ,
  `nome` VARCHAR(60) NOT NULL ,
  `sobrenome` VARCHAR(60) NOT NULL ,
  `email` VARCHAR(250) NOT NULL ,
  `idade` CHAR(3) NOT NULL ,
  `idcidade_cidade` INT NOT NULL ,
  INDEX `eleitor_cidade_fk` (`idcidade_cidade` ASC) ,
  PRIMARY KEY (`ideleitor`) ,
  CONSTRAINT `eleitor_cidade_fk`
    FOREIGN KEY (`idcidade_cidade` )
    REFERENCES `eleicao`.`cidade` (`idcidade` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`tipo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`tipo` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`tipo` (
  `idtipo` INT NOT NULL ,
  `nome` VARCHAR(50) NOT NULL ,
  PRIMARY KEY (`idtipo`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`partido`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`partido` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`partido` (
  `idpartido` INT NOT NULL AUTO_INCREMENT ,
  `sigla` VARCHAR(20) NOT NULL ,
  `descricao` VARCHAR(80) NOT NULL ,
  `legenda` CHAR(2) NOT NULL ,
  PRIMARY KEY (`idpartido`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `eleicao`.`candidato`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`candidato` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`candidato` (
  `idcandidato` INT NOT NULL AUTO_INCREMENT ,
  `nome` VARCHAR(60) NOT NULL ,
  `sobrenome` VARCHAR(60) NOT NULL ,
  `face` VARCHAR(50) NULL ,
  `twitter` VARCHAR(50) NULL ,
  `idade` CHAR(3) NOT NULL ,
  `url_foto` VARCHAR(250) NOT NULL ,
  `idcidade_cidade` INT NOT NULL ,
  `idtipo_tipo` INT NOT NULL ,
  `idpartido_partido` INT NOT NULL ,
  PRIMARY KEY (`idcandidato`) ,
  INDEX `candidato_cidade_fk` (`idcidade_cidade` ASC) ,
  INDEX `candidato_tipo_fk` (`idtipo_tipo` ASC) ,
  INDEX `candidato_partido_fk` (`idpartido_partido` ASC) ,
  CONSTRAINT `candidato_cidade_fk`
    FOREIGN KEY (`idcidade_cidade` )
    REFERENCES `eleicao`.`cidade` (`idcidade` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `candidato_tipo_fk`
    FOREIGN KEY (`idtipo_tipo` )
    REFERENCES `eleicao`.`tipo` (`idtipo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `candidato_partido_fk`
    FOREIGN KEY (`idpartido_partido` )
    REFERENCES `eleicao`.`partido` (`idpartido` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eleicao`.`parametro`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`parametro` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`parametro` (
  `idparametro` INT NOT NULL AUTO_INCREMENT ,
  `status` CHAR NOT NULL ,
  `data_abertura` DATE NOT NULL ,
  `data_encerramento` DATE NOT NULL ,
  `idtipo_tipo` INT NOT NULL ,
  PRIMARY KEY (`idparametro`) ,
  INDEX `parametro_tipo_fk` (`idtipo_tipo` ASC) ,
  CONSTRAINT `parametro_tipo_fk`
    FOREIGN KEY (`idtipo_tipo` )
    REFERENCES `eleicao`.`tipo` (`idtipo` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `eleicao`.`votacao`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `eleicao`.`votacao` ;

CREATE  TABLE IF NOT EXISTS `eleicao`.`votacao` (
  `idcandidato_candidato` INT NOT NULL ,
  `ideleitor_eleitor` INT NOT NULL ,
  `registrado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
               ON UPDATE CURRENT_TIMESTAMP ,
  `idparametro_parametro` INT NOT NULL ,
  PRIMARY KEY (`idcandidato_candidato`, `ideleitor_eleitor`) ,
  INDEX `votacao_candidato_fk` (`idcandidato_candidato` ASC) ,
  INDEX `votacao_parametro_fk` (`idparametro_parametro` ASC) ,
  INDEX `votacao_eleitor_fk` (`ideleitor_eleitor` ASC) ,
  CONSTRAINT `votacao_candidato_fk`
    FOREIGN KEY (`idcandidato_candidato` )
    REFERENCES `eleicao`.`candidato` (`idcandidato` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `votacao_parametro_fk`
    FOREIGN KEY (`idparametro_parametro` )
    REFERENCES `eleicao`.`parametro` (`idparametro` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `votacao_eleitor_fk`
    FOREIGN KEY (`ideleitor_eleitor` )
    REFERENCES `eleicao`.`eleitor` (`ideleitor` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
