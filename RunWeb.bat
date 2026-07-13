@echo off

set GIT_BASH="C:\Program Files\Git\git-bash.exe"

:: Jendela 1: Menjalankan Node.js server (Vite/Mix)
start "" %GIT_BASH% -c "echo 'Menjalankan: npm run dev'; npm run dev; exec bash"

:: Jendela 2: Menjalankan Laravel Reverb (WebSocket)
start "" %GIT_BASH% -c "echo 'Menjalankan: php artisan reverb:start'; php artisan reverb:start; exec bash"

:: Jendela 3: Menjalankan Queue Worker
start "" %GIT_BASH% -c "echo 'Menjalankan: php artisan queue:work'; php artisan queue:work; exec bash"

:: Jendela 4: Menjalankan Schedule Worker
start "" %GIT_BASH% -c "echo 'Menjalankan: php artisan schedule:work'; php artisan schedule:work; exec bash"

:: Menambahkan jeda 4 detik agar server Laravel siap terlebih dahulu
timeout /t 5 /nobreak >nul

:: Jendela 5: Otomatis membuka browser ke URL poltree.test
start http://poltree.test

exit