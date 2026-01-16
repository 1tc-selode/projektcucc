@echo off
echo Starting SkillForge Backend Server...
cd /d "C:\Users\1tc-selode\projekt\backend\skillforge-backend"
echo Current directory: %CD%
echo.
echo Starting Laravel development server on http://localhost:8000
echo Press Ctrl+C to stop the server
echo.
php artisan serve
pause
