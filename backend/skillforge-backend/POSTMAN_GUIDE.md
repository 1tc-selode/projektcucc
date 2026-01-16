# SkillForge API - Postman Tesztelési Útmutató

## 📁 Postman Fájlok

A backend API könnyű teszteléséhez készült Postman collection és environment fájlok:

### Fájlok:
- **`SkillForge_API_Collection.postman_collection.json`** - Teljes API gyűjtemény
- **`SkillForge_Environment.postman_environment.json`** - Környezeti változók
- **`api_test_commands.ps1`** - PowerShell cURL parancsok teszteléshez

## 🚀 Gyors Indítás

### 1. Laravel Szerver Indítása
```bash
# Backend mappából
cd backend/skillforge-backend
php artisan serve
```

### 2. Adatbázis Előkészítése
```bash
php artisan migrate
php artisan db:seed
```

### 3. Postman Import

1. **Nyissa meg a Postman alkalmazást**
2. **Import Collection:**
   - File → Import → `SkillForge_API_Collection.postman_collection.json`
3. **Import Environment:**
   - Environments → Import → `SkillForge_Environment.postman_environment.json`
4. **Válassza ki a "SkillForge Environment" környezetet**

## 📋 API Végpontok Áttekintése

### 🏠 Dashboard
- `GET /api/dashboard/stats` - Statisztikák (kurzusok száma státusz szerint)

### 📚 Courses (Kurzusok)
- `GET /api/courses` - Összes kurzus (keresés, szűrés, lapozás)
- `POST /api/courses` - Új kurzus létrehozása
- `GET /api/courses/{id}` - Kurzus részletei
- `PUT /api/courses/{id}` - Kurzus módosítása
- `DELETE /api/courses/{id}` - Kurzus törlése
- `POST /api/courses/{course}/students/{student}` - Hallgató hozzárendelése
- `DELETE /api/courses/{course}/students/{student}` - Hallgató eltávolítása

### 👥 Students (Hallgatók)
- `GET /api/students` - Összes hallgató
- `POST /api/students` - Új hallgató
- `DELETE /api/students/{id}` - Hallgató törlése

### 👨‍🏫 Instructors (Oktatók)
- `GET /api/instructors` - Összes oktató
- `POST /api/instructors` - Új oktató

### 💌 Contact Messages
- `GET /api/contact` - Összes üzenet
- `POST /api/contact` - Új üzenet küldése

## 🔧 Tesztelési Példák

### Új Kurzus Létrehozása
```json
POST /api/courses
{
    "title": "Laravel Haladó Technikák",
    "description": "Queues, Events, Broadcasting, API Resources",
    "status": "planned",
    "difficulty": "advanced",
    "instructor_id": 1
}
```

### Kurzus Keresése
```
GET /api/courses?search=Laravel&sort=title&dir=asc
```

### Aktív Kurzusok Szűrése
```
GET /api/courses?status=active&difficulty=intermediate
```

### Új Hallgató Létrehozása
```json
POST /api/students
{
    "name": "Nagy Péter",
    "email": "nagy.peter@example.com"
}
```

## 🎯 Teszt Szekvencia

### Alap Működés Tesztelése:

1. **Statisztikák lekérése** - `GET /dashboard/stats`
2. **Oktatók listája** - `GET /instructors`
3. **Új kurzus létrehozása** - `POST /courses`
4. **Kurzus részletek** - `GET /courses/1`
5. **Hallgatók listája** - `GET /students`
6. **Hallgató hozzárendelése kurzushoz** - `POST /courses/1/students/1`

### Keresés és Szűrés Tesztelése:

1. **Kurzus keresése** - `GET /courses?search=Laravel`
2. **Aktív kurzusok** - `GET /courses?status=active`
3. **Nehézségi szint szerinti szűrés** - `GET /courses?difficulty=beginner`
4. **Rendezés** - `GET /courses?sort=title&dir=asc`

## ⚡ PowerShell Tesztelés

Ha nincs Postman, használja a mellékelt PowerShell script-et:

```powershell
# Futtassa a script-et
.\api_test_commands.ps1
```

Ez kiírja az összes cURL parancsot, amit másolhat és futtathat.

## 🐛 Hibaelhárítás

### Gyakori Problémák:

1. **Connection refused**
   - Ellenőrizze, hogy a Laravel szerver fut: `php artisan serve`
   - Base URL: `http://localhost:8000`

2. **404 Not Found**
   - Ellenőrizze az API prefix-et: `/api/`
   - Route cache tisztítása: `php artisan route:clear`

3. **Validation errors**
   - Ellenőrizze a JSON formátumot
   - Kötelező mezők: `title`, `difficulty`, `instructor_id` (kurzusok)

4. **Foreign key constraint**
   - Futtassa a seeder-t: `php artisan db:seed`
   - Ellenőrizze, hogy léteznek oktatók az adatbázisban

## 📊 Válasz Példák

### Sikeres Kurzus Létrehozása:
```json
{
    "id": 6,
    "title": "Laravel Haladó Technikák",
    "description": "Queues, Events, Broadcasting",
    "status": "planned",
    "difficulty": "advanced",
    "instructor_id": 1,
    "created_at": "2026-01-16T10:30:00Z",
    "updated_at": "2026-01-16T10:30:00Z"
}
```

### Dashboard Statisztikák:
```json
{
    "total_courses": 5,
    "active_courses": 2,
    "completed_courses": 1,
    "planned_courses": 2,
    "statistics": {
        "total": 5,
        "by_status": {
            "active": 2,
            "completed": 1,
            "planned": 2
        }
    }
}
```

## 🔥 WebSocket Tesztelés

A kurzus létrehozása WebSocket eseményt küld. Teszteléhez:

1. Nyisson egy WebSocket klienst (pl. wscat)
2. Csatlakozzon: `ws://127.0.0.1:6001/app/local?protocol=7`
3. Hozzon létre új kurzust a Postman-ben
4. Figyelje az eseményt a WebSocket kliensnél

---

**Happy Testing! 🚀**
