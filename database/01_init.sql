-- ========================================
-- Database Initialization Script
-- Project: Zoo Arcadia
-- Created: 2025-01-19
-- Author: [Dumitru Stefan Fernando]
-- ========================================

-- Desactivar temporalmente las restricciones de claves foráneas
SET FOREIGN_KEY_CHECKS = 0;

-- Eliminar la base de datos si ya existe
DROP DATABASE IF EXISTS zoo_arcadia;

-- Crear la base de datos nueva con configuración específica
CREATE DATABASE zoo_arcadia
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

-- Usar la base de datos
USE zoo_arcadia;

-- Activar restricciones de claves foráneas
SET FOREIGN_KEY_CHECKS = 1;

-- Configuraciones generales de la base de datos
SET SQL_MODE = 'STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';
SET time_zone = '+00:00';
SET default_storage_engine = InnoDB;
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

-- Crear usuarios y asignar permisos
CREATE USER IF NOT EXISTS 'zoo_admin'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON zoo_arcadia.* TO 'zoo_admin'@'localhost';

CREATE USER IF NOT EXISTS 'zoo_app'@'localhost' IDENTIFIED BY 'app_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON zoo_arcadia.* TO 'zoo_app'@'localhost';

-- Aplicar cambios de privilegios
FLUSH PRIVILEGES;

-- Registro de inicialización exitosa
SELECT 'Database zoo_arcadia initialized successfully' AS 'Init Status';
