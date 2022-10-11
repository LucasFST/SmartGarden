/* Dropping existing tables */


DROP TABLE IF EXISTS Jardin;
DROP TABLE IF EXISTS Verger;
DROP TABLE IF EXISTS Ornement; 
DROP TABLE IF EXISTS Parcelle; 
DROP TABLE IF EXISTS Sol; 
DROP TABLE IF EXISTS Rang;
DROP TABLE IF EXISTS Plante;
DROP TABLE IF EXISTS Menace;
DROP TABLE IF EXISTS Variété; 
DROP TABLE IF EXISTS Version; 
DROP TABLE IF EXISTS Semencier; 
DROP TABLE IF EXISTS MiseEnPlace;
DROP TABLE IF EXISTS Photo; 
DROP TABLE IF EXISTS Potager;
DROP TABLE IF EXISTS Adapter;
DROP TABLE IF EXISTS Couvrir; 
DROP TABLE IF EXISTS Association; 
DROP TABLE IF EXISTS Subir; 
DROP TABLE IF EXISTS Produire;
DROP TABLE IF EXISTS Cultiver;
DROP TABLE IF EXISTS Récolte;
DROP TABLE IF EXISTS PériodeMEP; 
DROP TABLE IF EXISTS PériodeR; 

/* Creating tables */ 


CREATE TABLE Jardin(
   idJ INT AUTO_INCREMENT,
   nomJ VARCHAR(50) ,
   surfaceJ DOUBLE,
   PRIMARY KEY(idJ)
);

CREATE TABLE Verger(
   idJ INT,
   hauteurMax DOUBLE,
   PRIMARY KEY(idJ),
   FOREIGN KEY(idJ) REFERENCES Jardin(idJ)
);

CREATE TABLE Ornement(
   idJ INT,
   PRIMARY KEY(idJ),
   FOREIGN KEY(idJ) REFERENCES Jardin(idJ)
);

CREATE TABLE Parcelle(
   idPa INT AUTO_INCREMENT,
   coordP VARCHAR(50) ,
   dimP VARCHAR(50) ,
   idJ INT,
   PRIMARY KEY(idPa),
   FOREIGN KEY(idJ) REFERENCES Jardin(idJ)
);

CREATE TABLE Sol(
   idSol INT AUTO_INCREMENT,
   typeS VARCHAR(50) ,
   PRIMARY KEY(idSol)
);

CREATE TABLE Rang(
   idPa INT,
   numR INT,
   coordR VARCHAR(50) ,
   PRIMARY KEY(idPa, numR),
   FOREIGN KEY(idPa) REFERENCES Parcelle(idPa)
);

CREATE TABLE Plante(
   idPl INT AUTO_INCREMENT,
   nomP VARCHAR(100) ,
   nomL VARCHAR(100) ,
   catégorieP VARCHAR(50) ,
   typeP VARCHAR(50) ,
   sous_typeP VARCHAR(50) ,
   PRIMARY KEY(idPl)
);

CREATE TABLE Menace(
   idM INT AUTO_INCREMENT,
   description VARCHAR(100) ,
   solution VARCHAR(100) ,
   PRIMARY KEY(idM)
);

CREATE TABLE Variété(
   idVa INT AUTO_INCREMENT,
   nomV VARCHAR(50) ,
   année YEAR ,
   précocité VARCHAR(50) ,
   semis VARCHAR(50) ,
   plantation VARCHAR(50) ,
   entretien VARCHAR(50) ,
   récolte VARCHAR(50) ,
   nbjourslevée INT,
   commentaire VARCHAR(100) ,
   idPl INT NOT NULL,
   PRIMARY KEY(idVa),
   FOREIGN KEY(idPl) REFERENCES Plante(idPl)
);

CREATE TABLE Version(
   idVe INT AUTO_INCREMENT,
   typeVe VARCHAR(50) ,
   PRIMARY KEY(idVe)
);

CREATE TABLE Semencier(
   idS INT AUTO_INCREMENT,
   nomS VARCHAR(50) ,
   site VARCHAR(100) ,
   PRIMARY KEY(idS)
);

CREATE TABLE MiseEnPlace(
   idMEP INT AUTO_INCREMENT,
   typeMEP VARCHAR(50) ,
   PRIMARY KEY(idMEP)
);

CREATE TABLE Photo(
   idPh INT AUTO_INCREMENT,
   url VARCHAR(250) ,
   idPl INT,
   PRIMARY KEY(idPh),
   FOREIGN KEY(idPl) REFERENCES Plante(idPl)
);

CREATE TABLE Potager(
   idJ INT,
   idSol INT NOT NULL,
   PRIMARY KEY(idJ),
   FOREIGN KEY(idJ) REFERENCES Jardin(idJ),
   FOREIGN KEY(idSol) REFERENCES Sol(idSol)
);

CREATE TABLE Adapter(
   idSol INT,
   idVa INT,
   nivAdapt VARCHAR(50) ,
   PRIMARY KEY(idSol, idVa),
   FOREIGN KEY(idSol) REFERENCES Sol(idSol),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa)
);

CREATE TABLE Couvrir(
   idPa INT,
   numR INT,
   idPl INT,
   dateDébut DATE,
   dateFin DATE,
   PRIMARY KEY(idPa, numR, idPl, dateDébut, dateFin),
   FOREIGN KEY(idPa, numR) REFERENCES Rang(idPa, numR),
   FOREIGN KEY(idPl) REFERENCES Plante(idPl)
);

CREATE TABLE Association(
   idPl INT,
   idPl_1 INT,
   typeAssoc VARCHAR(50) ,
   PRIMARY KEY(idPl, idPl_1),
   FOREIGN KEY(idPl) REFERENCES Plante(idPl),
   FOREIGN KEY(idPl_1) REFERENCES Plante(idPl)
);

CREATE TABLE Subir(
   idPl INT,
   idM INT,
   PRIMARY KEY(idPl, idM),
   FOREIGN KEY(idPl) REFERENCES Plante(idPl),
   FOREIGN KEY(idM) REFERENCES Menace(idM)
);

CREATE TABLE Produire(
   idVa INT,
   idVe INT,
   idS INT,
   PRIMARY KEY(idVa, idVe, idS),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa),
   FOREIGN KEY(idVe) REFERENCES Version(idVe),
   FOREIGN KEY(idS) REFERENCES Semencier(idS)
);

CREATE TABLE Cultiver(
   idPa INT,
   numR INT,
   idVa INT,
   idMEP INT,
   dateDébut DATE,
   dateFin DATE,
   PRIMARY KEY(idPa, numR, idVa, idMEP, dateDébut, dateFin),
   FOREIGN KEY(idPa, numR) REFERENCES Rang(idPa, numR),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa),
   FOREIGN KEY(idMEP) REFERENCES MiseEnPlace(idMEP)
);

CREATE TABLE Récolte(
   idPa INT,
   numR INT,
   idVa INT,
   dateRécolte DATE,
   quantitéPro DOUBLE,
   qualitéGus VARCHAR(100) ,
   commentaire VARCHAR(100) ,
   PRIMARY KEY(idPa, numR, idVa, dateRécolte),
   FOREIGN KEY(idPa, numR) REFERENCES Rang(idPa, numR),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa)
);

CREATE TABLE PériodeMEP(
   idVa INT,
   dateDébut DATE,
   dateFin DATE,
   PRIMARY KEY(idVa, dateDébut, dateFin),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa)
);

CREATE TABLE PériodeR(
   idVa INT,
   dateDébut DATE,
   dateFin DATE,
   PRIMARY KEY(idVa, dateDébut, dateFin),
   FOREIGN KEY(idVa) REFERENCES Variété(idVa)
);
