CREATE DATABASE IF NOT EXISTS autoservice;
USE autoservice;

CREATE TABLE IF NOT EXISTS http_auth_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role ENUM('admin', 'manager', 'client') DEFAULT 'client'
);

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    duration INT NOT NULL COMMENT 'Длительность в минутах',
    category VARCHAR(50) NOT NULL
);

INSERT INTO http_auth_users (username, password_hash, email, role) VALUES
('admin', SHA1('admin123'), 'admin@autoservice.local', 'admin'),
('manager', SHA1('manager123'), 'manager@autoservice.local', 'manager'),
('user', SHA1('user123'), 'user@autoservice.local', 'client');

INSERT INTO services (name, description, price, duration, category) VALUES
('Замена моторного масла', 'Полная замена моторного масла и масляного фильтра', 50.00, 45, 'Техническое обслуживание'),
('Замена воздушного фильтра', 'Замена воздушного фильтра двигателя', 25.00, 20, 'Техническое обслуживание'),
('Замена тормозной жидкости', 'Полная замена тормозной жидкости с прокачкой', 60.00, 60, 'Тормозная система'),
('Балансировка колес', 'Балансировка всех четырех колес', 40.00, 60, 'Ходовая часть'),
('Диагностика подвески', 'Полная диагностика ходовой части', 35.00, 30, 'Диагностика'),
('Замена аккумулятора', 'Замена автомобильного аккумулятора', 30.00, 30, 'Электрика'),
('Замена свечей зажигания', 'Замена комплекта свечей зажигания', 45.00, 40, 'Двигатель');

CREATE TABLE IF NOT EXISTS order_stats (
    id INT AUTO_INCREMENT PRIMARY KEY, customer_name VARCHAR (100),
    service_category VARCHAR (50),
    order_date DATE,
    revenue DECIMAL (10, 2),
    status ENUM ('completed', 'canceled', 'refunded')
);