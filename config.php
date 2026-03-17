<?php
/**
 * Configuración de Base de Datos
 * 
 * Si existe un archivo .env, se cargan las variables desde ahí.
 * Si no, se usan los valores por defecto (para desarrollo local).
 */

// Cargar variables de entorno desde .env si existe
if (file_exists(__DIR__ . '/.env')) {
    require_once __DIR__ . '/vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->safeLoad();
}

// Configuración de Base de Datos
// Usa variables de entorno si existen, sino valores por defecto
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_NAME', $_ENV['DB_NAME'] ?? 'zoo_arcadia');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'root');

