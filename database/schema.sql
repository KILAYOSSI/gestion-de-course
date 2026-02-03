-- Schéma de base de données pour l'application de gestion des courses familiales

-- Création de la base de données
CREATE DATABASE IF NOT EXISTS gestion_courses_famille;
USE gestion_courses_famille;

-- Table des membres de la famille
CREATE TABLE membres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des catégories de produits
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table des produits
CREATE TABLE produits (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    categorie_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categorie_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Table des achats
CREATE TABLE achats (
    id INT AUTO_INCREMENT PRIMARY KEY,
    produit_id INT NOT NULL,
    membre_id INT NOT NULL,
    quantite DECIMAL(10,2) NOT NULL,
    prix DECIMAL(10,2) NOT NULL,
    date_achat DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (produit_id) REFERENCES produits(id) ON DELETE CASCADE,
    FOREIGN KEY (membre_id) REFERENCES membres(id) ON DELETE CASCADE
);

-- Insertion de données de test
INSERT INTO membres (nom) VALUES ('Papa'), ('Maman'), ('Enfant1'), ('Enfant2');

INSERT INTO categories (nom) VALUES ('Fruits'), ('Légumes'), ('Viandes'), ('Produits laitiers'), ('Épicerie');

INSERT INTO produits (nom, categorie_id) VALUES
('Pomme', 1), ('Banane', 1), ('Orange', 1),
('Tomate', 2), ('Carotte', 2), ('Salade', 2),
('Poulet', 3), ('Boeuf', 3),
('Lait', 4), ('Fromage', 4),
('Pain', 5), ('Riz', 5);

INSERT INTO achats (produit_id, membre_id, quantite, prix, date_achat) VALUES
(1, 1, 2.5, 3.50, '2023-10-01'),
(2, 2, 1.0, 2.00, '2023-10-01'),
(3, 3, 3.0, 4.50, '2023-10-02'),
(4, 1, 1.5, 2.00, '2023-10-02'),
(5, 2, 2.0, 1.50, '2023-10-03');
