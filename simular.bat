@echo off
:loop
php artisan tren:simular-movimiento
timeout /t 2 >nul
goto loop
