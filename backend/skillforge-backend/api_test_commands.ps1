# SkillForge API Test Script
# Használat: PowerShell-ben futtatható cURL parancsok

# Base URL
$BASE_URL = "http://localhost:8000/api"

Write-Host "=== SkillForge API Testing Script ===" -ForegroundColor Green
Write-Host "Base URL: $BASE_URL" -ForegroundColor Yellow
Write-Host ""

# 1. Dashboard Statistics
Write-Host "1. Dashboard Statistics" -ForegroundColor Cyan
$dashboardCmd = "curl -X GET `"$BASE_URL/dashboard/stats`" -H `"Accept: application/json`""
Write-Host $dashboardCmd -ForegroundColor Gray
Write-Host ""

# 2. Get All Courses
Write-Host "2. Get All Courses" -ForegroundColor Cyan
$coursesCmd = "curl -X GET `"$BASE_URL/courses`" -H `"Accept: application/json`""
Write-Host $coursesCmd -ForegroundColor Gray
Write-Host ""

# 3. Create New Course
Write-Host "3. Create New Course" -ForegroundColor Cyan
$createCourseCmd = @"
curl -X POST "$BASE_URL/courses" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Laravel Alapok",
    "description": "Tanuld meg a Laravel keretrendszert a nulláról",
    "status": "planned",
    "difficulty": "beginner",
    "instructor_id": 1
  }'
"@
Write-Host $createCourseCmd -ForegroundColor Gray
Write-Host ""

# 4. Get All Students
Write-Host "4. Get All Students" -ForegroundColor Cyan
$studentsCmd = "curl -X GET `"$BASE_URL/students`" -H `"Accept: application/json`""
Write-Host $studentsCmd -ForegroundColor Gray
Write-Host ""

# 5. Create New Student
Write-Host "5. Create New Student" -ForegroundColor Cyan
$createStudentCmd = @"
curl -X POST "$BASE_URL/students" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Nagy Péter",
    "email": "nagy.peter@example.com"
  }'
"@
Write-Host $createStudentCmd -ForegroundColor Gray
Write-Host ""

# 6. Get All Instructors
Write-Host "6. Get All Instructors" -ForegroundColor Cyan
$instructorsCmd = "curl -X GET `"$BASE_URL/instructors`" -H `"Accept: application/json`""
Write-Host $instructorsCmd -ForegroundColor Gray
Write-Host ""

# 7. Create New Instructor
Write-Host "7. Create New Instructor" -ForegroundColor Cyan
$createInstructorCmd = @"
curl -X POST "$BASE_URL/instructors" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Dr. Kovács Anna",
    "email": "kovacs.anna@skillforge.com"
  }'
"@
Write-Host $createInstructorCmd -ForegroundColor Gray
Write-Host ""

# 8. Send Contact Message
Write-Host "8. Send Contact Message" -ForegroundColor Cyan
$contactCmd = @"
curl -X POST "$BASE_URL/contact" \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Teszt Felhasználó",
    "email": "teszt@example.com",
    "message": "Kérdésem van a Laravel kurzussal kapcsolatban."
  }'
"@
Write-Host $contactCmd -ForegroundColor Gray
Write-Host ""

# 9. Search Courses
Write-Host "9. Search Courses by Title" -ForegroundColor Cyan
$searchCmd = "curl -X GET `"$BASE_URL/courses?search=Laravel&sort=title&dir=asc`" -H `"Accept: application/json`""
Write-Host $searchCmd -ForegroundColor Gray
Write-Host ""

# 10. Filter Active Courses
Write-Host "10. Filter Active Courses" -ForegroundColor Cyan
$filterCmd = "curl -X GET `"$BASE_URL/courses?status=active&difficulty=intermediate`" -H `"Accept: application/json`""
Write-Host $filterCmd -ForegroundColor Gray
Write-Host ""

Write-Host "=== Használati utasítások ===" -ForegroundColor Green
Write-Host "1. Indítsa el a Laravel szervert: php artisan serve" -ForegroundColor Yellow
Write-Host "2. Futtassa a migrációkat: php artisan migrate" -ForegroundColor Yellow
Write-Host "3. Másolja és futtassa a fenti cURL parancsokat" -ForegroundColor Yellow
Write-Host "4. Vagy importálja a Postman Collection-t a mellékelt JSON fájlból" -ForegroundColor Yellow
Write-Host ""

Write-Host "=== Postman fájlok ===" -ForegroundColor Green
Write-Host "Collection: SkillForge_API_Collection.postman_collection.json" -ForegroundColor Yellow
Write-Host "Environment: SkillForge_Environment.postman_environment.json" -ForegroundColor Yellow
