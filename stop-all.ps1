# Stop all background processes for Toko Bunga (PowerShell)
# Jalankan script ini dari root project: .\stop-all.ps1

Write-Host "[INFO] Menghentikan semua proses node (Vite) dan php (Artisan Serve)..." -ForegroundColor Yellow

# Stop all node (npm run dev) and php (artisan serve) processes
Get-Process -Name node,php -ErrorAction SilentlyContinue | Stop-Process -Force

Write-Host "[INFO] Semua proses berhasil dihentikan." -ForegroundColor Green
