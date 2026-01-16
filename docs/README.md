# 📚 SkillForge - Course Management System

## 📖 Projekt leírás

A **SkillForge** egy valós idejű tanfolyam- és tanuláskövető platform, amely teljes körű CRUD funkcionalitást és WebSocket alapú kommunikációt biztosít. A projekt célja egy modern, full-stack kurzuskezelő rendszer létrehozása, amely lehetővé teszi kurzusok, hallgatók és oktatók hatékony kezelését valós idejű frissítésekkel.

Az alkalmazás Angular 19 és Laravel 11 technológiákra épül, ahol a frontend egy reaktív, komponensalapú felületet biztosít, míg a backend RESTful API-t és WebSocket broadcast funkciókat implementál.

### ✨ Főbb funkciók

- **Dashboard** - Valós idejű statisztikák (összes/aktív/lezárt kurzusok)
- **Kurzusok kezelése** - Teljes CRUD funkcionalitás, keresés, rendezés, lapozás, WebSocket frissítés
- **Hallgatók kezelése** - CRUD műveletek, hallgatók hozzárendelése kurzusokhoz
- **Oktatók kezelése** - CRUD műveletek, keresés és rendezés
- **Kapcsolati űrlap** - Reactive Forms validációval
- **About oldal** - Projekt bemutató és dokumentáció

---

## 🛠️ Használt technológiák

### Frontend
- **Angular 19** - Modern component-based framework standalone komponensekkel
- **TypeScript 5** - Type-safe fejlesztés
- **RxJS 7** - Reaktív programozás (BehaviorSubject, Observable, debounceTime)
- **Reactive Forms** - Form kezelés és validáció
- **Laravel Echo** - WebSocket kliens
- **Pusher** - WebSocket broadcaster protokoll
- **CSS Grid/Flexbox** - Responsive layout
- **CSS Custom Properties** - Dinamikus design system

### Backend
- **Laravel 11** - PHP framework MVC architektúrával
- **PHP 8.2+** - Backend programozási nyelv
- **MySQL** - Relációs adatbázis
- **RESTful API** - JSON alapú kommunikáció
- **Eloquent ORM** - Adatbázis műveletek
- **Form Request Validation** - Backend validációs szabályok
- **Laravel Events & Broadcasting** - WebSocket események

### WebSocket
- **Laravel Reverb / Soketi** - WebSocket szerver (Laravel broadcast driver)
- **Pusher Protocol** - Broadcast channel kommunikáció
- **Real-time Events** - CourseCreated esemény azonnali frissítéshez

### Egyéb eszközök
## 📦 Telepítési lépések

### 1. Előfeltételek

A következő szoftverek telepítése szükséges:
- **PHP 8.2+** (Composer-rel)
- **MySQL 8.0+** vagy kompatibilis adatbázis
- **Node.js 18+** és npm
- **Git**

### 2. Backend telepítése (Laravel)

```bash
# 1. Navigálj a backend mappába
cd backend/skillforge-backend

# 2. Telepítsd a PHP függőségeket Composer-rel
composer install

# 3. Hozd létre a környezeti fájlt
cp .env.example .env

# 4. Generálj alkalmazás kulcsot
php artisan key:generate

# 5. Állítsd be az adatbázis kapcsolatot a .env fájlban
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=skillforge
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Hozd létre az adatbázist
mysql -u root -p -e "CREATE DATABASE skillforge CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 7. Futtasd a migrációkat és seed-eket
php artisan migrate --seed

# 8. (Opcionális) Storage link létrehozása
php artisan storage:link
```

### 3. Frontend telepítése (Angular)

```bash
# 1. Navigálj a frontend mappába
cd frontend/frontend

# 2. Telepítsd a Node csomagokat
npm install

# 3. (Opcionális) Környezeti változók beállítása
# A src/environments/environment.ts fájlban állítsd be a backend API URL-t
# apiUrl: 'http://localhost:8000/api'
```

### 4. WebSocket broadcast indítása (Opcionális)

A WebSocket funkciók használatához szükséges egy broadcast szerver futtatása:

## 🚀 Build és futtatási parancsok

### Backend futtatása

**Fejlesztői mód (lokális szerver):**
```bash
cd backend/skillforge-backend
php artisan serve
```
A backend elérhető: `http://localhost:8000`

**Production szerverre telepítés:**
```bash
# 1. Optimalizált autoload
composer install --optimize-autoloader --no-dev

# 2. Konfiguráció cache
php artisan config:cache

# 3. Route cache
php artisan route:cache

# 4. View cache
php artisan view:cache

# 5. Állítsd be a .env fájlt production értékekkel:
# APP_ENV=production
# APP_DEBUG=false
```

### Frontend futtatása

**Fejlesztői mód:**
```bash
cd frontend/frontend
ng serve
```
A frontend elérhető: `http://localhost:4200`

**Production build:**
```bash
cd frontend/frontend

# Production build optimalizálással
ng build --configuration production

# Alternatíva (régebbi Angular verziók)
ng build --prod
```

A buildelt fájlok a `dist/frontend/` mappába kerülnek, amit egy web szerveren (Apache, Nginx) lehet futtatni.

### WebSocket szerver futtatása

```bash
cd backend/skillforge-backend

# Laravel Reverb
php artisan reverb:start

# Vagy Soketi
soketi start

# Vagy Laravel WebSockets
php artisan websockets:serve
```

### Teljes rendszer indítása (3 terminál)

**1. terminál - Backend:**
```bash
cd backend/skillforge-backend
php artisan serve
```

**2. terminál - Frontend:**
```bash
cd frontend/frontend
ng serve
```

**3. terminál - WebSocket (opcionális):**
```bash
cd backend/skillforge-backend
php artisan reverb:start
```

### Egyéb hasznos parancsok

**Backend:**
```bash
# Adatbázis frissítés
php artisan migrate:fresh --seed

# Cache törlés
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# API tesztelés
curl http://localhost:8000/api/courses -H "Accept: application/json"
curl http://localhost:8000/api/dashboard/stats -H "Accept: application/json"
```

**Frontend:**
```bash
# Fejlesztői build (gyors, nem optimalizált)
ng build

# Production build (optimalizált, minified)
ng build --configuration production

# Angular cache törlés
ng cache clean

# Linter futtatása
ng lint

# Unit tesztek futtatása
ng test
```
# WebSocket szerver indítása
php artisan websockets:serve
```

A WebSocket szerver alapértelmezetten a `ws://127.0.0.1:6001` címen fut.
# Laravel Reverb / Soketi indítása
php artisan reverb:start
# vagy
soketi start
```

WebSocket szerver: `ws://127.0.0.1:6001`

---

## 🚀 Build és futtatási parancsok

### Frontend build (production)
```bash
ng build --configuration production
```
Build kimenet: `dist/` mappa

### Backend API tesztelés
```bash
# Összes kurzus lekérése
curl http://localhost:8000/api/courses -H "Accept: application/json"

# Dashboard statisztikák
curl http://localhost:8000/api/dashboard/stats -H "Accept: application/json"
```

### Adatbázis frissítés
```bash
php artisan migrate:fresh --seed
```

---

## 📂 Projekt struktúra

```
projektcucc/
├── frontend/
│   └── frontend/
│       ├── src/
│       │   ├── app/
│       │   │   ├── components/
│       │   │   │   ├── dashboard/
│       │   │   │   ├── courses/
│       │   │   │   ├── students/
│       │   │   │   ├── instructors/
│       │   │   │   ├── contact/
│       │   │   │   └── about/
│       │   │   └── services/
│       │   │       ├── course.ts
│       │   │       ├── student.ts
│       │   │       ├── instructor.ts
│       │   │       └── websocket.ts
│       │   ├── styles.css
│       │   └── index.html
│       ├── angular.json
│       └── package.json
│
└── backend/
    └── skillforge-backend/
        ├── app/
        │   ├── Http/Controllers/
        │   ├── Models/
        │   ├── Events/
        │   └── Services/
        ├── routes/
        │   └── api.php
        └── database/
            └── migrations/
```

---

## 🔗 API Endpoints

### Dashboard
- `GET /api/dashboard/stats` - Statisztikák

### Courses
- `GET /api/courses` - Lista (keresés, szűrés, lapozás)
- `POST /api/courses` - Új kurzus
- `GET /api/courses/{id}` - Részletek
- `PUT /api/courses/{id}` - Módosítás
- `DELETE /api/courses/{id}` - Törlés

### Students
- `GET /api/students` - Lista
- `POST /api/students` - Új hallgató
- `DELETE /api/students/{id}` - Törlés
- `POST /api/students/{id}/courses` - Kurzus hozzárendelés
- `DELETE /api/students/{id}/courses/{courseId}` - Kurzus eltávolítás

### Instructors
- `GET /api/instructors` - Lista
- `POST /api/instructors` - Új oktató

### Contact
- `POST /api/contact` - Üzenet küldés

---

## 🎨 Design rendszer

### CSS változók
```css
--primary: #2563EB
--secondary: #1E293B
--bg: #F8FAFC
--surface: #FFFFFF
--success: #16A34A
--error: #DC2626
```

### Responsive breakpoints
- Mobile: `< 640px`
- Tablet: `640px - 1024px`
- Desktop: `> 1024px`

---

## ⚡ WebSocket események

### CourseCreated
```json
{
  "course": {
    "id": 1,
    "title": "Laravel Basics",
    "status": "planned",
    "difficulty": "beginner",
    "instructor": { "name": "John Doe" }
  }
}
```

Frontend kapcsolódás:
```typescript
ws.connect(course => this.cs.addLocal(course));
```

---

## 📊 Komponensek áttekintése

| Komponens | Útvonal | Funkciók |
|-----------|---------|----------|
| Dashboard | `/dashboard` | Statisztikák, recent courses |
| Courses | `/courses` | CRUD, search, sort, pagination |
| Students | `/students` | CRUD, course assignment |
| Instructors | `/instructors` | CRUD, search, sort |
| Contact | `/contact` | Reactive form, validation |
| About | `/about` | Static content |

---

## 🐛 Hibakeresés

### Backend nem fut
```bash
php artisan serve
```

### Frontend hibák
```bash
# Node modulok újratelepítése
rm -rf node_modules package-lock.json
npm install

# Angular cache törlése
ng cache clean
```

### WebSocket kapcsolódási hiba
Ellenőrizd:
1. Laravel Echo és Pusher betöltve az `index.html`-ben
2. WebSocket szerver fut (port 6001)
3. Böngésző konzol hibák

---

## 📝 Licensz

Ez egy oktatási projekt, amely a követelményrendszer alapján készült.

---

## 👥 Csapat

- **Frontend Developer** - Angular & RxJS
- **Backend Developer** - Laravel & API
- **Full Stack Developer** - Integration & WebSocket

---

## 📞 Kapcsolat

Ha kérdésed van a projekttel kapcsolatban, látogass el a `/contact` oldalra az alkalmazásban!

---

**Készítve ❤️-vel Angular 19 és Laravel 11 technológiákkal**
