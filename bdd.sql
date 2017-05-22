CREATE DATABASE IF NOT EXISTS lokisalle;

USE lokisalle;

CREATE TABLE salle(
	id_salle INT(3) NOT NULL AUTO_INCREMENT,
	titre  VARCHAR(200) DEFAULT NULL,
	description TEXT DEFAULT NULL,
	photo VARCHAR(200) NOT NULL,
	pays VARCHAR(20) NOT NULL,
	ville VARCHAR (20) NOT NULL,
	adresse VARCHAR(50) NOT NULL,
	cp INT(5) NOT NULL,
	capacite INT(3) NOT NULL,
	categorie ENUM ("reunion","bureau","formation") NOT NULL,
	PRIMARY KEY(id_salle)
)ENGINE=InnoDB;


CREATE TABLE produit (
	id_produit INT(3) NOT NULL AUTO_INCREMENT,
	id_salle  INT(3) DEFAULT NULL,
	date_arrivee DATE DEFAULT NULL,
	date_depart DATE NOT NULL,
	prix INT(3) NOT NULL,
	etat ENUM ("libre","reservation") NOT NULL,
	PRIMARY KEY(id_produit)
)ENGINE=InnoDB;
	
	CREATE TABLE commande (
	id_commande INT(3)   NOT NULL AUTO_INCREMENT,
	id_membre INT(3) DEFAULT NULL,
	date_enregistrement DATE DEFAULT NULL,
	PRIMARY KEY(id_commande)
)ENGINE=InnoDB;

	CREATE TABLE avis (
	id_avis INT(3)   NOT NULL AUTO_INCREMENT,
	id_membre  INT(3) DEFAULT NULL,
	id_salle INT(3) DEFAULT NULL,
	commentaire TEXT NOT NULL,
	note INT(2) NOT NULL,
	date_enregistrement DATE DEFAULT NULL,
	PRIMARY KEY(id_avis)
)ENGINE=InnoDB;

	CREATE TABLE membre(
	id_membre INT(3)   NOT NULL AUTO_INCREMENT,
	pseudo  VARCHAR(20) DEFAULT NULL,
	mdp VARCHAR(60) DEFAULT NULL,
	nom VARCHAR(20) NOT NULL,
	email VARCHAR(50) NOT NULL,
	civilite ENUM ("m","f") NOT NULL,
	statut INT(1) NOT NULL,
	date_enregistrement DATE DEFAULT NULL,
	PRIMARY KEY(id_membre)
)ENGINE=InnoDB;