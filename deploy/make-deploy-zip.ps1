# =====================================================================
#  Unikeyterra — Deploy ZIP üretici (laravel/ + public_html/ ayrık)
#  Kullanım:  proje kökünde →  powershell -ExecutionPolicy Bypass -File deploy\make-deploy-zip.ps1
#  ÖNCE:      npm run build   (asset'ler güncel olsun)
# =====================================================================
$ErrorActionPreference = 'Stop'
$root = Split-Path -Parent $PSScriptRoot   # proje kökü (deploy/'nin üstü)
Set-Location $root

$dist = Join-Path $root 'deploy\dist'
$zip  = Join-Path $root 'deploy\unikeyterra-deploy.zip'

Write-Host 'Eski çıktı temizleniyor...'
if (Test-Path $dist) { Remove-Item $dist -Recurse -Force }
if (Test-Path $zip)  { Remove-Item $zip -Force }
New-Item -ItemType Directory -Force -Path "$dist\laravel","$dist\public_html" | Out-Null

Write-Host 'Laravel dosyaları kopyalanıyor (vendor dahil)...'
foreach ($d in 'app','bootstrap','config','database','lang','resources','routes','storage','vendor') {
    Copy-Item $d "$dist\laravel\$d" -Recurse -Force
}
foreach ($f in 'artisan','composer.json','composer.lock') {
    Copy-Item $f "$dist\laravel\$f" -Force
}
Copy-Item '.env.production' "$dist\laravel\.env" -Force

Write-Host 'Public içeriği kopyalanıyor...'
Copy-Item 'public\*' "$dist\public_html\" -Recurse -Force
Copy-Item 'deploy\index.php' "$dist\public_html\index.php" -Force   # cPanel için düzenlenmiş

Write-Host 'Önbellek / geçici / dev artıkları temizleniyor...'
Get-ChildItem "$dist\laravel\bootstrap\cache" -Filter *.php -ErrorAction SilentlyContinue | Remove-Item -Force
foreach ($p in 'framework\cache\data','framework\sessions','framework\views') {
    $sp = "$dist\laravel\storage\$p"
    if (Test-Path $sp) { Get-ChildItem $sp -Recurse -Force -ErrorAction SilentlyContinue | Where-Object { $_.Name -ne '.gitignore' } | Remove-Item -Recurse -Force -ErrorAction SilentlyContinue }
}
Get-ChildItem "$dist\laravel\storage\logs" -Filter *.log -ErrorAction SilentlyContinue | Remove-Item -Force
if (Test-Path "$dist\public_html\storage") { Remove-Item "$dist\public_html\storage" -Recurse -Force }  # symlink sunucuda kurulacak
if (Test-Path "$dist\public_html\hot")     { Remove-Item "$dist\public_html\hot" -Force }

Write-Host 'ZIP oluşturuluyor (biraz sürebilir)...'
Compress-Archive -Path "$dist\laravel","$dist\public_html" -DestinationPath $zip -Force

$sizeMB = [math]::Round((Get-Item $zip).Length / 1MB, 1)
Write-Host "TAMAM -> deploy\unikeyterra-deploy.zip ($sizeMB MB)" -ForegroundColor Green
