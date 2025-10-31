-- Base de datos FruTamboExport
CREATE DATABASE IF NOT EXISTS frutamboexport CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE frutamboexport;

-- Usuarios (solo admin)
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(64) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('admin') NOT NULL DEFAULT 'admin'
);

-- Usuario admin por defecto (password: admin123)
INSERT INTO users (username, password_hash, role)
VALUES (
  'admin',
  '$2y$10$3G8a1nnI6WwZG9X1rZ9b0e3E2r9p7o5N5lZKxg8nQx3rQy7m4XQnK', -- hash de 'admin123'
  'admin'
) ON DUPLICATE KEY UPDATE username = username;

-- Clientes
CREATE TABLE IF NOT EXISTS clientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  email VARCHAR(120) NULL,
  telefono VARCHAR(50) NULL
);

-- Productos
CREATE TABLE IF NOT EXISTS productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  precio DECIMAL(10,2) NOT NULL DEFAULT 0
);

-- Ventas
CREATE TABLE IF NOT EXISTS ventas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente_id INT NOT NULL,
  producto_id INT NOT NULL,
  cantidad INT NOT NULL,
  fecha DATE NOT NULL,
  CONSTRAINT fk_cliente FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
  CONSTRAINT fk_producto FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);


