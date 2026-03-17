@echo off
echo Deploying database...

REM Configuracion
set MYSQL_USER=root
set MYSQL_PASS=root
set DB_NAME=zoo_arcadia

REM Rutas comunes de MySQL/MariaDB
set MYSQL_PATH_MARIADB="C:\Program Files\MariaDB 11.4\bin\mariadb.exe"
set MYSQL_PATH_XAMPP="C:\xampp\mysql\bin\mysql.exe"
set MYSQL_PATH_WAMP="C:\wamp64\bin\mysql\mysql8.0.31\bin\mysql.exe"

REM Detectar cual esta disponible
if exist %MYSQL_PATH_MARIADB% (
    set MYSQL_CMD=%MYSQL_PATH_MARIADB%
) else if exist %MYSQL_PATH_XAMPP% (
    set MYSQL_CMD=%MYSQL_PATH_XAMPP%
) else if exist %MYSQL_PATH_WAMP% (
    set MYSQL_CMD=%MYSQL_PATH_WAMP%
) else (
    echo ERROR: No se encontro MySQL/MariaDB instalado
    pause
    exit /b 1
)

echo Usando: %MYSQL_CMD%

REM Ejecutar scripts en orden
echo 1. Inicializando base de datos...
%MYSQL_CMD% -u %MYSQL_USER% -p%MYSQL_PASS% < database/01_init.sql

echo 2. Creando tablas...
%MYSQL_CMD% -u %MYSQL_USER% -p%MYSQL_PASS% %DB_NAME% < database/02_tables.sql

echo 3. Agregando constraints...
%MYSQL_CMD% -u %MYSQL_USER% -p%MYSQL_PASS% %DB_NAME% < database/03_constraints.sql

echo 4. Insertando datos de prueba...
%MYSQL_CMD% -u %MYSQL_USER% -p%MYSQL_PASS% %DB_NAME% < database/06_seed_data.sql

echo Base de datos actualizada correctamente!
pause