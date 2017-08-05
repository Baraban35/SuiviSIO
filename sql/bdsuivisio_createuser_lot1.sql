--
-- création de la Base de données Historique des stages
--
CREATE DATABASE portefeuille;

-- création compte d'utilisateurs
-- ayant tous les droits sur les données de la BD en local

CREATE USER 'portefeuille'@'localhost' IDENTIFIED BY 'secret';
GRANT USAGE ON *.* TO 'portefeuille'@'localhost' ;
GRANT SELECT , INSERT , UPDATE , DELETE ON bdsuivisio.* TO 'portefeuille'@'localhost';
