# SkillForge Backend

Egy modern Laravel alapú REST API a SkillForge tanfolyam- és tanuláskövető platform backend részéhez.

## Funkcionalitások

- **CRUD műveletek**: Kurzusok, hallgatók, oktatók és kapcsolati üzenetek kezelése
- **Keresés és szűrés**: Fejlett keresési és szűrési lehetőségek
- **Lapozás**: Hatékony lapozás minden listázó endpoint-on
- **WebSocket támogatás**: Valós idejű értesítések kurzus létrehozáskor
- **Validáció**: Részletes validációs szabályok minden input-ra
- **Adatkapcsolatok**: Kurzus-hallgató és oktató-kurzus kapcsolatok

## Technológiai Stack

- **Backend Framework**: Laravel 11
- **Database**: MySQL
- **WebSocket**: Pusher Protocol
- **Architecture**: Repository Pattern + Service Layer
- **Validation**: Form Request Classes
- **Broadcasting**: Laravel Broadcasting with Pusher

## Telepítési Útmutató

### Előfeltételek

- PHP 8.2+
- Composer
- MySQL 5.7+ vagy 8.0+
- Node.js (WebSocket szerver futtatásához)

### 1. Repository klónozása

```bash
git clone <repository-url>
cd skillforge-backend
```

### 2. Függőségek telepítése

```bash
composer install
```

### 3. Környezeti változók beállítása

```bash
cp .env.example .env
php artisan key:generate
```

Szerkessze a `.env` fájlt és állítsa be az adatbázis kapcsolódási adatokat:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skillforge
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Adatbázis létrehozása és migráció

```bash
# Adatbázis létrehozása (MySQL CLI-ben)
CREATE DATABASE skillforge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Migrációk futtatása
php artisan migrate

# Kezdeti adatok betöltése (opcionális)
php artisan db:seed
```

### 5. WebSocket szerver telepítése és konfigurálása

WebSocket kommunikációhoz telepítse a Laravel WebSocket csomagot:

```bash
composer require pusher/pusher-php-server
```

Ha helyi WebSocket szervert szeretne használni, telepítse a laravel-websockets csomagot:

```bash
composer require beyondcode/laravel-websockets
php artisan vendor:publish --provider="BeyondCode\\LaravelWebSockets\\WebSocketsServiceProvider" --tag="migrations"
php artisan migrate
php artisan vendor:publish --provider="BeyondCode\\LaravelWebSockets\\WebSocketsServiceProvider" --tag="config"
```

## Futtatási Útmutató

### 1. Laravel szerver indítása

```bash
php artisan serve
```

Az API elérhető lesz a `http://localhost:8000/api` címen.

### 2. WebSocket szerver indítása

Ha a laravel-websockets csomagot használja:

```bash
php artisan websockets:serve
```

WebSocket szerver elérhető: `ws://127.0.0.1:6001`

### 3. Queue worker indítása (opcionális)

A broadcasting eseményekhez indítsa el a queue worker-t:

```bash
php artisan queue:work
```

## API Dokumentáció

A teljes API dokumentáció elérhető az `API_DOCUMENTATION.md` fájlban.

### Főbb Endpoint-ok

- **Dashboard**: `GET /api/dashboard/stats`
- **Kurzusok**: `GET|POST|PUT|DELETE /api/courses`
- **Hallgatók**: `GET|POST|DELETE /api/students`
- **Oktatók**: `GET|POST /api/instructors`
- **Kapcsolat**: `GET|POST /api/contact`

### Példa API hívás

```bash
# Összes kurzus lekérése
curl -X GET "http://localhost:8000/api/courses"

# Új kurzus létrehozása
curl -X POST "http://localhost:8000/api/courses" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "New Course",
    "description": "Course description",
    "difficulty": "beginner",
    "instructor_id": 1
  }'
```

## Fejlesztési Parancsok

```bash
# Cache tisztítása
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Migráció visszavonása
php artisan migrate:rollback

# Adatbázis újraépítése seederekkel
php artisan migrate:fresh --seed

# Route lista megtekintése
php artisan route:list

# Teszt futtatása
php artisan test
```

## Projekt Struktúra

```
app/
├── Events/
│   └── CourseCreated.php          # WebSocket események
├── Http/
│   ├── Controllers/
│   │   ├── CourseController.php   # Kurzus CRUD
│   │   ├── StudentController.php  # Hallgató kezelés
│   │   ├── InstructorController.php # Oktató kezelés
│   │   ├── ContactController.php  # Kapcsolati üzenetek
│   │   └── DashboardController.php # Statisztikák
│   └── Requests/
│       ├── StoreCourseRequest.php # Validáció
│       ├── UpdateCourseRequest.php
│       ├── StoreStudentRequest.php
│       ├── StoreInstructorRequest.php
│       └── StoreContactRequest.php
├── Models/
│   ├── Course.php                 # Kurzus modell
│   ├── Student.php                # Hallgató modell
│   ├── Instructor.php             # Oktató modell
│   └── ContactMessage.php         # Kapcsolati üzenet modell
├── Repositories/
│   ├── CourseRepository.php       # Adatlekérési logika
│   ├── StudentRepository.php
│   └── InstructorRepository.php
└── Services/
    ├── CourseService.php          # Üzleti logika
    ├── StudentService.php
    └── InstructorService.php
```

## Adatbázis Séma

### Táblák

1. **courses** - Kurzusok adatai
2. **students** - Hallgatók adatai
3. **instructors** - Oktatók adatai
4. **contact_messages** - Kapcsolati üzenetek
5. **course_student** - Kurzus-hallgató kapcsolótábla

### Kapcsolatok

- Instructor **1:N** Course (egy oktató több kurzust tarthat)
- Course **N:M** Student (many-to-many kapcsolat)

## WebSocket Események

### course.created

Új kurzus létrehozásakor automatikusan kiküldött esemény:

```json
{
  "course": { ... },
  "message": "New course created: Course Title",
  "timestamp": "2026-01-16T08:00:00.000Z"
}
```

## Tesztelés

Frontend teszteléshez használja a mellékelt seeder adatokat:

```bash
php artisan db:seed
```

Ez létrehoz:
- 3 oktatót
- 4 hallgatót
- 5 kurzust
- Kapcsolódó student-course kapcsolatokat

## Hibaelhárítás

### Gyakori problémák

1. **Database connection error**
   - Ellenőrizze a `.env` fájlban az adatbázis beállításokat
   - Győződjön meg róla, hogy a MySQL szerver fut

2. **WebSocket connection failed**
   - Indítsa el a WebSocket szervert: `php artisan websockets:serve`
   - Ellenőrizze a `.env` broadcasting beállításokat

3. **Storage permission error**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

4. **Composer memory limit**
   ```bash
   php -d memory_limit=-1 composer install
   ```

## Kapcsolat és Támogatás

Ha kérdése van a projekt kapcsán, tekintse meg az API dokumentációt vagy hozzon létre egy issue-t a repository-ban.

---

**Fejlesztve a SkillForge csapat által Laravel 11 és modern web technológiák használatával.**

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
