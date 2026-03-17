@echo off
echo Cambiando a configuracion Docker...
copy .env.docker .env >nul
echo.
echo ✅ Cambiado a configuracion Docker
echo.
echo Variables cambiadas:
echo   DB_HOST: localhost → db
echo   DB_USER: root → zoo_user
echo   DB_PASS: root → zoo_password
echo.
pause

