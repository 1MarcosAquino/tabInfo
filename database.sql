CREATE DATABASE IF NOT EXISTS tabInfo;

USE tabInfo;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    pass VARCHAR(255) NOT NULL,
    contact VARCHAR(50),
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES addresses(id)
);

CREATE TABLE IF NOT EXISTS addresses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    state VARCHAR(100),
    city VARCHAR(100),
    country VARCHAR(100),
    street VARCHAR(255),
    number VARCHAR(20),
    complement VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    image VARCHAR(255),
    ia BOOLEAN DEFAULT FALSE,
    qtd INT DEFAULT 0,
    price DECIMAL(10, 2),
    lot VARCHAR(50),
    supplier_id INT,
    codBar VARCHAR(255),
    FOREIGN KEY (supplier_id) REFERENCES suppliers(id)
);

CREATE TABLE IF NOT EXISTS suppliers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(50),
    address_id INT,
    FOREIGN KEY (address_id) REFERENCES addresses(id)
);
