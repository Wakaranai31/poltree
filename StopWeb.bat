@echo off
echo Menghentikan semua service Laravel dan Node.js...

:: 1. Menghentikan semua process PHP (Reverb, Queue, Schedule)
taskkill /f /im php.exe >nul 2>&1

:: 2. Menghentikan process Node.js (Vite)
taskkill /f /im node.exe >nul 2>&1

:: 3. Menutup semua jendela Git Bash yang terbuka
taskkill /f /im bash.exe >nul 2>&1

echo Semua service telah diberhentikan.
exit