-- Schéma de base de données pour l'application de gestion des courses familiales

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_courses_famille;
USE gestion_courses_famille;

-- Table des membres de la famille
CREATE TABLE Membre (
    idMembre INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL
);

-- Table des catégories de produits
CREATE TABLE Categorie (
    idCategorie INT AUTO_INCREMENT PRIMARY KEY,
    nomCategorie VARCHAR(50) NOT NULL
);

-- Table des produits
CREATE TABLE Produit (
    idProduit INT AUTO_INCREMENT PRIMARY KEY,
    nomProduit VARCHAR(100) NOT NULL,
    idCategorie INT NOT NULL,
    FOREIGN KEY (idCategorie) REFERENCES Categorie(idCategorie)
);

-- Table des achats
CREATE TABLE Achat (
    idAchat INT AUTO_INCREMENT PRIMARY KEY,
    dateAchat DATE NOT NULL,
    idMembre INT NOT NULL,
    FOREIGN KEY (idMembre) REFERENCES Membre(idMembre)
);

-- Table des lignes d'achat
CREATE TABLE LigneAchat (
    idLigne INT AUTO_INCREMENT PRIMARY KEY,
    idAchat INT NOT NULL,
    idProduit INT NOT NULL,
    quantite DECIMAL(10,2) NOT NULL CHECK (quantite > 0),
    prixUnitaire DECIMAL(10,2) NOT NULL CHECK (prixUnitaire >= 0),
    FOREIGN KEY (idAchat) REFERENCES Achat(idAchat),
    FOREIGN KEY (idProduit) REFERENCES Produit(idProduit)
);

-- Insertion de données de test
INSERT INTO Membre (nom, prenom) VALUES
('Dupont', 'Jean'),
('Dupont', 'Marie'),
('Dupont', 'Pierre'),
('Dupont', 'Sophie');

INSERT INTO Categorie (nomCategorie) VALUES
('Fruits'),
('Légumes'),
('Viandes'),
('Produits laitiers'),
('Épicerie');

INSERT INTO Produit (nomProduit, idCategorie) VALUES
('Pomme', 1),
('Banane', 1),
('Orange', 1),
('Tomate', 2),
('Carotte', 2),
('Salade', 2),
('Poulet', 3),
('Boeuf', 3),
('Lait', 4),
('Fromage', 4),
('Pain', 5),
('Riz', 5);

-- Créer quelques achats de test
INSERT INTO Achat (dateAchat, idMembre) VALUES
('2023-10-01', 1),
('2023-10-01', 2),
('2023-10-02', 3),
('2023-10-02', 1),
('2023-10-03', 2);

INSERT INTO LigneAchat (idAchat, idProduit, quantite, prixUnitaire) VALUES
(1, 1, 3, 2.50),
(1, 2, 2, 1.80),
(2, 3, 4, 3.20),
(3, 4, 2, 1.50),
(3, 5, 1, 2.00),
(4, 6, 1, 1.20),
(5, 7, 1, 8.50);
