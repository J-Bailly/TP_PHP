-- Si vous voulez nettoyer la base avant, vous pouvez ajouter les DROP TABLE :
DROP TABLE IF EXISTS Questions;
DROP TABLE IF EXISTS Quiz;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Utilisateur;

-- Table pour les utilisateurs
CREATE TABLE Utilisateur (
    id TEXT PRIMARY KEY AUTOINCREMENT,
    mot_de_passe TEXT NOT NULL,
    score INTEGER DEFAULT 0
);

-- Table pour les administrateurs
CREATE TABLE Admin (
    id TEXT PRIMARY KEY,
    mot_de_passe TEXT NOT NULL
);

-- Table pour les catégories de quiz
CREATE TABLE Categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL
);

-- Table pour les quiz
CREATE TABLE Quiz (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    titre TEXT NOT NULL,
    categorie_id INTEGER,
    FOREIGN KEY (categorie_id) REFERENCES Categories(id)
        ON DELETE SET NULL
);

-- Table pour les types de questions (vrai/faux, QCM, écriture)
CREATE TABLE TypeQuestion (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    type_question TEXT NOT NULL
);

-- Insertion des types de questions
INSERT INTO TypeQuestion (type_question) VALUES
('ecriture'),
('vrai/faux'),
('qcm');

-- Table pour les questions
CREATE TABLE Questions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    quiz_id INTEGER,
    type_question_id INTEGER,
    question TEXT NOT NULL,
    reponse_correcte TEXT NOT NULL,
    reponse_1 TEXT,
    reponse_2 TEXT,
    reponse_3 TEXT,
    FOREIGN KEY (quiz_id) REFERENCES Quiz(id) ON DELETE CASCADE,
    FOREIGN KEY (type_question_id) REFERENCES TypeQuestion(id)
);

-- Insérer des catégories
INSERT INTO Categories (nom) VALUES 
('Culture Générale'), 
('Mathématiques'), 
('Informatique');

-- Insérer des quiz
INSERT INTO Quiz (titre, categorie_id) VALUES 
('Quiz sur la France', 1), -- Catégorie : Culture Générale
('Calculs Simples', 2),    -- Catégorie : Mathématiques
('Langages de Programmation', 3); -- Catégorie : Informatique

-- Insérer des utilisateurs
INSERT INTO Utilisateur (id, mot_de_passe, score) VALUES 
('user1', 'password123', 10),
('user2', 'mypassword', 20);

-- Insérer des administrateurs
INSERT INTO Admin (id, mot_de_passe) VALUES 
('admin1', 'adminpassword'),
('admin2', 'securepassword');

-- Insérer des questions

-- Quiz sur la France (ID du quiz = 1, Culture Générale)
INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte, reponse_1, reponse_2, reponse_3) VALUES 
(1, 3, 'Quelle est la capitale de la France ?', 'Paris', 'Paris', 'Londres', 'Berlin');

INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte) VALUES 
(1, 2, 'La Tour Eiffel est à Paris.', 'vrai');

-- Calculs Simples (ID du quiz = 2, Mathématiques)
INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte, reponse_1, reponse_2, reponse_3) VALUES 
(2, 3, 'Combien font 2 + 2 ?', '4', '3', '4', '5');

INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte) VALUES 
(2, 2, '10 est divisible par 5.', 'vrai');

-- Langages de Programmation (ID du quiz = 3, Informatique)
INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte) VALUES 
(3, 1, 'Nommez un langage de programmation populaire.', 'Python');

INSERT INTO Questions (quiz_id, type_question_id, question, reponse_correcte) VALUES 
(3, 2, 'Python est un langage compilé.', 'faux');
