@echo off
REM ============================================
REM Script de Despliegue de Base de Datos
REM Zoo Arcadia (Windows)
REM ============================================

setlocal enabledelayedexpansion

REM Variables de conexión
if "%DB_HOST%"=="" set DB_HOST=localhost
if "%DB_NAME%"=="" set DB_NAME=zoo_arcadia
if "%DB_USER%"=="" set DB_USER=root
if "%DB_PASS%"=="" set DB_PASS=root
if "%DB_PORT%"=="" set DB_PORT=3306

echo ========================================
echo Despliegue de Base de Datos Zoo Arcadia
echo ========================================
echo.

REM 1. Inicializar base de datos
echo [1/7] Ejecutando inicialización de base de datos...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% < database\01_init.sql
if errorlevel 1 (
    echo ERROR: Fallo en inicialización
    exit /b 1
)
echo OK: Inicialización completada
echo.

REM 2. Crear tablas
echo [2/7] Ejecutando creación de tablas...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\02_tables.sql
if errorlevel 1 (
    echo ERROR: Fallo en creación de tablas
    exit /b 1
)
echo OK: Tablas creadas
echo.

REM 3. Añadir constraints
echo [3/7] Ejecutando constraints y claves foráneas...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\03_constraints.sql
if errorlevel 1 (
    echo ERROR: Fallo en constraints
    exit /b 1
)
echo OK: Constraints añadidos
echo.

REM 4. Añadir índices
echo [4/7] Ejecutando índices...
if exist "database\04_indexes.sql" (
    mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\04_indexes.sql
    if errorlevel 1 (
        echo ADVERTENCIA: Fallo en índices (continuando...)
    ) else (
        echo OK: Índices añadidos
    )
) else (
    echo ADVERTENCIA: Archivo de índices no encontrado (saltando...)
)
echo.

REM 5. Procedimientos almacenados
echo [5/7] Ejecutando procedimientos almacenados...
if exist "database\05_procedures.sql" (
    mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\05_procedures.sql
    if errorlevel 1 (
        echo ADVERTENCIA: Fallo en procedimientos (continuando...)
    ) else (
        echo OK: Procedimientos creados
    )
) else (
    echo ADVERTENCIA: Archivo de procedimientos no encontrado (saltando...)
)
echo.

REM 6. Datos de seed
echo [6/7] Ejecutando datos iniciales (Seed data)...
mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\06_seed_data.sql
if errorlevel 1 (
    echo ERROR: Fallo en datos de seed
    exit /b 1
)
echo OK: Datos iniciales insertados
echo.

REM 7. Limpieza
echo [7/7] Ejecutando limpieza...
if exist "database\07_cleanup.sql" (
    mysql -h%DB_HOST% -P%DB_PORT% -u%DB_USER% -p%DB_PASS% %DB_NAME% < database\07_cleanup.sql
    if errorlevel 1 (
        echo ADVERTENCIA: Fallo en limpieza (continuando...)
    ) else (
        echo OK: Limpieza completada
    )
) else (
    echo ADVERTENCIA: Archivo de limpieza no encontrado (saltando...)
)
echo.

echo ========================================
echo Despliegue completado exitosamente
echo ========================================

