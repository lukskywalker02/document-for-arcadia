@echo off
echo Cambiando a configuracion Local...
echo.

REM Crear .env.local si no existe
if not exist .env.local (
    echo Creando .env.local desde .env actual...
    copy .env .env.local >nul
)

REM Cambiar valores en .env
powershell -Command "(Get-Content .env) -replace 'DB_HOST=db', 'DB_HOST=localhost' -replace 'DB_USER=zoo_user', 'DB_USER=root' -replace 'DB_PASS=zoo_password', 'DB_PASS=root' | Set-Content .env"

echo ✅ Cambiado a configuracion Local
echo.
echo Variables cambiadas:
echo   DB_HOST: db → localhost
echo   DB_USER: zoo_user → root
echo   DB_PASS: zoo_password → root
echo.
pause

