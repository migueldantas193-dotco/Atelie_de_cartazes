CREATE DATABASE atelie_cartazes;
USE atelie_cartazes;

CREATE TABLE cartazes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    caminho_imagem VARCHAR(255) NOT NULL,
    data_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);