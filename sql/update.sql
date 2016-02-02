SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

USE `eleicao` ;
ALTER TABLE `eleicao`.`eleitor` DROP COLUMN `cpf` , CHANGE COLUMN `email` `email` VARCHAR(250) NOT NULL  AFTER `ideleitor` 
, DROP PRIMARY KEY 
, ADD PRIMARY KEY (`ideleitor`) ;

ALTER TABLE `eleicao`.`candidato` DROP FOREIGN KEY `candidato_tipo_fk` ;

ALTER TABLE `eleicao`.`candidato` 
  ADD CONSTRAINT `candidato_tipo_fk`
  FOREIGN KEY (`idtipo_tipo` )
  REFERENCES `eleicao`.`tipo` (`idtipo` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `eleicao`.`votacao` CHANGE COLUMN `registrado` `registrado` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
               ON UPDATE CURRENT_TIMESTAMP  , DROP FOREIGN KEY `votacao_parametro_fk` ;

ALTER TABLE `eleicao`.`votacao` 
  ADD CONSTRAINT `votacao_parametro_fk`
  FOREIGN KEY (`idparametro_parametro` )
  REFERENCES `eleicao`.`parametro` (`idparametro` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `eleicao`.`parametro` CHANGE COLUMN `status` `status` CHAR NOT NULL  ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
