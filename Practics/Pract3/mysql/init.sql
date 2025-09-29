CREATE DATABASE IF NOT EXISTS autoservice;

USE autoservice;

CREATE TABLE IF NOT EXISTS http_auth_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role ENUM('admin', 'manager', 'client') DEFAULT 'client',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_username (username),
    INDEX idx_role (role)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    duration INT NOT NULL COMMENT 'Длительность в минутах',
    category VARCHAR(50) NOT NULL,
    is_available BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_price (price)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    customer_email VARCHAR(100),
    car_brand VARCHAR(50) NOT NULL,
    car_model VARCHAR(50) NOT NULL,
    car_year INT,
    car_vin VARCHAR(17),
    service_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    appointment_time TIME NOT NULL,
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    total_price DECIMAL(10,2),
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE RESTRICT,
    INDEX idx_status (status),
    INDEX idx_date (appointment_date),
    INDEX idx_customer_phone (customer_phone)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    position VARCHAR(50) NOT NULL,
    phone VARCHAR(20),
    email VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    hire_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS appointment_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    appointment_id INT NOT NULL,
    employee_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES employees(id) ON DELETE CASCADE,
    UNIQUE KEY unique_assignment (appointment_id, employee_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    appointment_id INT,
    rating TINYINT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    comment TEXT,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (appointment_id) REFERENCES appointments(id) ON DELETE SET NULL,
    INDEX idx_rating (rating),
    INDEX idx_approved (is_approved)
) ENGINE=InnoDB;

INSERT INTO http_auth_users (username, password_hash, email, full_name, role) VALUES
('admin', SHA1('admin123'), 'admin@autoservice.local', 'Главный администратор', 'admin'),
('manager', SHA1('manager123'), 'manager@autoservice.local', 'Менеджер сервиса', 'manager'),
('user', SHA1('user123'), 'user@autoservice.local', 'Обычный пользователь', 'client');

INSERT INTO services (name, description, price, duration, category) VALUES
('Замена моторного масла', 'Полная замена моторного масла и масляного фильтра', 50.00, 45, 'Техническое обслуживание'),
('Замена воздушного фильтра', 'Замена воздушного фильтра двигателя', 25.00, 20, 'Техническое обслуживание'),
('Замена тормозных колодок', 'Замена передних и задних тормозных колодок', 120.00, 90, 'Тормозная система'),
('Замена тормозной жидкости', 'Полная замена тормозной жидкости с прокачкой', 60.00, 60, 'Тормозная система'),
('Развал-схождение', 'Регулировка углов установки колес', 80.00, 120, 'Ходовая часть'),
('Балансировка колес', 'Балансировка всех четырех колес', 40.00, 60, 'Ходовая часть'),
('Диагностика двигателя', 'Компьютерная диагностика двигателя', 40.00, 45, 'Диагностика'),
('Диагностика подвески', 'Полная диагностика ходовой части', 35.00, 30, 'Диагностика'),
('Замена аккумулятора', 'Замена автомобильного аккумулятора', 30.00, 30, 'Электрика'),
('Замена свечей зажигания', 'Замена комплекта свечей зажигания', 45.00, 40, 'Двигатель');

INSERT INTO employees (full_name, position, phone, email, hire_date) VALUES
('Иванов Петр Сергеевич', 'Мастер-приемщик', '+7-999-123-45-67', 'ivanov@autoservice.local', '2023-01-15'),
('Сидорова Анна Владимировна', 'Автомеханик', '+7-999-123-45-68', 'sidorova@autoservice.local', '2023-02-20'),
('Кузнецов Дмитрий Игоревич', 'Автоэлектрик', '+7-999-123-45-69', 'kuznetsov@autoservice.local', '2023-03-10'),
('Петрова Мария Александровна', 'Менеджер', '+7-999-123-45-70', 'petrova@autoservice.local', '2023-01-10');

INSERT INTO appointments (customer_name, customer_phone, car_brand, car_model, service_id, appointment_date, appointment_time, status) VALUES
('Смирнов Алексей', '+7-915-123-45-67', 'Toyota', 'Camry', 1, CURDATE() + INTERVAL 1 DAY, '10:00:00', 'confirmed'),
('Ковалева Ирина', '+7-915-123-45-68', 'Honda', 'CR-V', 3, CURDATE() + INTERVAL 2 DAY, '14:30:00', 'pending'),
('Федоров Сергей', '+7-915-123-45-69', 'BMW', 'X5', 5, CURDATE() + INTERVAL 3 DAY, '11:15:00', 'confirmed');

INSERT INTO appointment_assignments (appointment_id, employee_id) VALUES
(1, 2), (2, 2), (3, 3);

CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, INSERT, UPDATE, DELETE ON autoservice.* TO 'user'@'%';
FLUSH PRIVILEGES;

CREATE USER IF NOT EXISTS 'apache_auth'@'%' IDENTIFIED BY 'authpass';
GRANT SELECT ON autoservice.http_auth_users TO 'apache_auth'@'%';
FLUSH PRIVILEGES;
