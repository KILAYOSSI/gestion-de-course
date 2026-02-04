-- Schéma de base de données pour l'application de gestion des courses familiales

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_courses_famille;
USE gestion_courses_famille;

-- Table simple des achats
CREATE TABLE Achats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom_produit VARCHAR(255) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_achat DATE NOT NULL
);

-- Insertion de données de test
INSERT INTO Achats (nom_produit, prix, date_achat) VALUES
('Pain', 1500, '2024-01-01'),
('Lait', 2000, '2024-01-01'),
('Bananes', 3000, '2024-01-02'),
('Tomates', 2500, '2024-01-02'),
('Fromage', 4500, '2024-01-03');
