# Quick Setup & Run Script for Toko Bunga (PowerShell)
# Jalankan script ini dari root project: .\setup-and-run.ps1

# 1. Install Composer dependencies jika folder vendor belum ada
if (!(Test-Path -Path "vendor")) {
    Write-Host "[INFO] Menginstall Composer dependencies..." -ForegroundColor Cyan
    composer install
} else {
    Write-Host "[INFO] Composer dependencies sudah terinstall."
}

# 2. Install NPM dependencies jika folder node_modules belum ada
if (!(Test-Path -Path "node_modules")) {
    Write-Host "[INFO] Menginstall NPM dependencies..." -ForegroundColor Cyan
    npm install
} else {
    Write-Host "[INFO] NPM dependencies sudah terinstall."
}

# 3. Copy .env jika belum ada
if (!(Test-Path -Path ".env")) {
    Write-Host "[INFO] Membuat file .env dari .env.example..." -ForegroundColor Cyan
    Copy-Item .env.example .env
}

# 4. Generate key jika APP_KEY belum ada
if ((Get-Content .env | Select-String -Pattern "^APP_KEY=$").Count -gt 0) {
    Write-Host "[INFO] Generate APP_KEY..." -ForegroundColor Cyan
    php artisan key:generate
}

# 5. Jalankan migrate & seed jika database kosong
if (!(Test-Path -Path "database/database.sqlite")) {
    Write-Host "[INFO] Membuat database dan menjalankan migrate --seed..." -ForegroundColor Cyan
    php artisan migrate --seed
}

# 6. Jalankan npm run dev & php artisan serve secara paralel
Write-Host "[INFO] Menjalankan npm run dev & php artisan serve..." -ForegroundColor Green
Start-Process powershell -ArgumentList "npm run dev" -WindowStyle Hidden
Start-Process powershell -ArgumentList "php artisan serve" -WindowStyle Hidden

Write-Host "[INFO] Semua proses berjalan. Buka http://localhost:8000 di browser Anda." -ForegroundColor Green
