-- Base de datos: tienda
CREATE DATABASE IF NOT EXISTS tienda;
USE tienda;

-- Tabla de productos en español
CREATE TABLE IF NOT EXISTS productoses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL
);

-- Tabla de productos en inglés
CREATE TABLE IF NOT EXISTS productosen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

-- Datos de ejemplo para productoses (español)
INSERT INTO productoses (nombre, descripcion, precio) VALUES
('Laptop', 'Computadora portátil de alto rendimiento con procesador Intel Core i7', 899.99),
('Mouse Inalámbrico', 'Mouse ergonómico sin cables con batería de larga duración', 25.50),
('Teclado Mecánico', 'Teclado gaming con retroiluminación RGB y switches mecánicos', 89.99),
('Monitor LED', 'Pantalla LED de 24 pulgadas Full HD con tecnología anti-reflejo', 179.99),
('Auriculares', 'Auriculares con cancelación de ruido y micrófono integrado', 59.99),
('Webcam HD', 'Cámara web de alta definición 1080p con micrófono estéreo', 45.00),
('Disco Duro Externo', 'Almacenamiento portátil de 1TB con conexión USB 3.0', 65.00),
('Impresora Multifunción', 'Impresora láser con escáner y copiadora integrados', 199.99),
('Router WiFi', 'Router de doble banda con tecnología WiFi 6 de última generación', 120.00),
('Tablet', 'Tablet de 10 pulgadas con pantalla táctil y 64GB de almacenamiento', 299.99);

-- Datos de ejemplo para productosen (inglés)
INSERT INTO productosen (name, description, price) VALUES
('Laptop', 'High-performance laptop computer with Intel Core i7 processor', 899.99),
('Wireless Mouse', 'Ergonomic wireless mouse with long-lasting battery', 25.50),
('Mechanical Keyboard', 'Gaming keyboard with RGB backlight and mechanical switches', 89.99),
('LED Monitor', '24-inch Full HD LED display with anti-glare technology', 179.99),
('Headphones', 'Noise-canceling headphones with integrated microphone', 59.99),
('HD Webcam', 'High-definition 1080p webcam with stereo microphone', 45.00),
('External Hard Drive', 'Portable 1TB storage with USB 3.0 connection', 65.00),
('Multifunction Printer', 'Laser printer with integrated scanner and copier', 199.99),
('WiFi Router', 'Dual-band router with latest generation WiFi 6 technology', 120.00),
('Tablet', '10-inch tablet with touchscreen and 64GB storage', 299.99);
