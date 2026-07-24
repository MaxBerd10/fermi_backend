@echo off
set PHP=C:\xampp\php\php.exe
set ROOT=%~dp0

start "FJSTI Assets :8080" %PHP% -S localhost:8080 -t "%ROOT%frontend\web" "%ROOT%frontend\web\router.php"
start "FJSTI API :8081" %PHP% -S localhost:8081 -t "%ROOT%api\web" "%ROOT%api\web\router.php"
timeout /t 2 /nobreak >nul
cd /d "%ROOT%web"
npm run dev
