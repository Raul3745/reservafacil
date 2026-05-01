# ReservaFacil

Aplicación web desarrollada en PHP y MySQL para la gestión de reservas.

## Funcionalidades

- Registro e inicio de sesión
- Gestión de reservas
- Control de roles (usuario/admin)
- Panel de administración
- Calendario interactivo

## Tecnologías

- HTML, CSS, JavaScript
- PHP
- MySQL
- FullCalendar

## Instalación

1. Instalar XAMPP
2. Copiar el proyecto en /htdocs
3. Crear base de datos
4. Acceder a http://localhost/reservafacil

##Tablas necesarias

CREATE DATABASE reservafacil;

USE reservafacil;

-- Usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin','user') DEFAULT 'user'
);

-- Servicios
CREATE TABLE services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    description TEXT
);

-- Reservas
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    service_id INT,
    date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);
