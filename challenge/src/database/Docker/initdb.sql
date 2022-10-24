CREATE DATABASE IF NOT EXISTS ow_interactive;

USE ow_interactive;

CREATE TABLE IF NOT EXISTS `user` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(200) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `birthday` DATE NOT NULL,
    `createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `updatedAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE
);

INSERT INTO `user` (`name`, `email`, `birthday`) VALUES ('teste', 'teste@email.com.br', '1990-01-01');
INSERT INTO `user` (`name`, `email`, `birthday`) VALUES ('teste 2', 'teste2@email.com.br', '1991-01-01');