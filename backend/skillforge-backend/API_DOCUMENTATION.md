# SkillForge Backend API Documentation

## Overview
SkillForge backend REST API Laravel alapokon, amely támogatja a teljes CRUD műveletek végrehajtását kurzusokkal, hallgatókkal, oktatókkal és kapcsolati üzenetekkel. Az API WebSocket események küldésével valós idejű frissítéseket biztosít.

## Base URL
```
http://localhost:8000/api
```

## API Endpoints

### Dashboard Statistics
#### GET /dashboard/stats
Visszaadja a dashboard statisztikákat.

**Response:**
```json
{
  "total_courses": 10,
  "active_courses": 5,
  "completed_courses": 3,
  "planned_courses": 2,
  "statistics": {
    "total": 10,
    "by_status": {
      "active": 5,
      "completed": 3,
      "planned": 2
    }
  }
}
```

---

## Courses (Kurzusok)

### GET /courses
Lista az összes kurzust lapozással, kereséssel és rendezéssel.

**Query Parameters:**
- `search` (string): Keresés cím vagy leírás alapján
- `status` (string): Szűrés státusz szerint (planned|active|completed)
- `difficulty` (string): Szűrés nehézség szerint (beginner|intermediate|advanced)
- `sort` (string): Rendezési mező (created_at, title, status, difficulty)
- `dir` (string): Rendezési irány (asc|desc)
- `per_page` (int): Elemek száma oldalanként (alapértelmezett: 10)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "title": "Laravel Basics",
      "description": "Learn Laravel from scratch",
      "status": "active",
      "difficulty": "beginner",
      "instructor_id": 1,
      "created_at": "2026-01-16T08:00:00Z",
      "updated_at": "2026-01-16T08:00:00Z",
      "instructor": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
      }
    }
  ],
  "current_page": 1,
  "last_page": 1,
  "per_page": 10,
  "total": 1
}
```

### POST /courses
Új kurzus létrehozása.

**Request Body:**
```json
{
  "title": "Laravel Basics",
  "description": "Learn Laravel from scratch",
  "status": "planned",
  "difficulty": "beginner",
  "instructor_id": 1
}
```

**Validation Rules:**
- `title`: required, string, max:255
- `description`: required, string
- `status`: optional, in:planned,active,completed (default: planned)
- `difficulty`: required, in:beginner,intermediate,advanced
- `instructor_id`: required, exists:instructors,id

**Response:**
```json
{
  "id": 1,
  "title": "Laravel Basics",
  "description": "Learn Laravel from scratch",
  "status": "planned",
  "difficulty": "beginner",
  "instructor_id": 1,
  "created_at": "2026-01-16T08:00:00Z",
  "updated_at": "2026-01-16T08:00:00Z"
}
```

**WebSocket Event:**
Kurzus létrehozásakor `course.created` esemény kerül kiküldésre a `courses` csatornán.

### GET /courses/{id}
Egy adott kurzus részletes adatainak lekérése.

**Response:**
```json
{
  "id": 1,
  "title": "Laravel Basics",
  "description": "Learn Laravel from scratch",
  "status": "active",
  "difficulty": "beginner",
  "instructor_id": 1,
  "created_at": "2026-01-16T08:00:00Z",
  "updated_at": "2026-01-16T08:00:00Z",
  "instructor": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com"
  },
  "students": [
    {
      "id": 1,
      "name": "Jane Smith",
      "email": "jane@example.com",
      "pivot": {
        "course_id": 1,
        "student_id": 1
      }
    }
  ]
}
```

### PUT /courses/{id}
Kurzus módosítása.

**Request Body:**
```json
{
  "title": "Advanced Laravel",
  "status": "active"
}
```

**Validation Rules:** (ugyanaz mint POST-nál, de `sometimes` előtaggal)
- `title`: sometimes, required, string, max:255
- `description`: sometimes, required, string
- `status`: sometimes, in:planned,active,completed
- `difficulty`: sometimes, required, in:beginner,intermediate,advanced
- `instructor_id`: sometimes, required, exists:instructors,id

### DELETE /courses/{id}
Kurzus törlése.

**Response:** 204 No Content

### POST /courses/{course}/students/{student}
Hallgató hozzárendelése kurzushoz.

**Response:**
```json
{
  "message": "Student successfully attached to course",
  "course": {
    "id": 1,
    "title": "Laravel Basics",
    "instructor": {...},
    "students": [...]
  }
}
```

### DELETE /courses/{course}/students/{student}
Hallgató eltávolítása kurzusból.

---

## Students (Hallgatók)

### GET /students
Lista az összes hallgatót lapozással, kereséssel és rendezéssel.

**Query Parameters:**
- `search` (string): Keresés név vagy email alapján
- `sort` (string): Rendezési mező (name, email, created_at)
- `dir` (string): Rendezési irány (asc|desc)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Jane Smith",
      "email": "jane@example.com",
      "created_at": "2026-01-16T08:00:00Z",
      "updated_at": "2026-01-16T08:00:00Z",
      "courses_count": 2
    }
  ]
}
```

### POST /students
Új hallgató létrehozása.

**Request Body:**
```json
{
  "name": "Jane Smith",
  "email": "jane@example.com"
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, email, unique:students,email, max:255

### DELETE /students/{id}
Hallgató törlése.

**Response:** 204 No Content

---

## Instructors (Oktatók)

### GET /instructors
Lista az összes oktatót lapozással, kereséssel és rendezéssel.

**Query Parameters:**
- `search` (string): Keresés név vagy email alapján
- `sort` (string): Rendezési mező (name, email, created_at)
- `dir` (string): Rendezési irány (asc|desc)

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com",
      "created_at": "2026-01-16T08:00:00Z",
      "updated_at": "2026-01-16T08:00:00Z",
      "courses_count": 3
    }
  ]
}
```

### POST /instructors
Új oktató létrehozása.

**Request Body:**
```json
{
  "name": "John Doe",
  "email": "john@example.com"
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, email, unique:instructors,email, max:255

---

## Contact Messages (Kapcsolati üzenetek)

### GET /contact
Lista az összes kapcsolati üzenetet.

**Response:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "John Smith",
      "email": "johnsmith@example.com",
      "message": "Hello, I have a question about the courses.",
      "created_at": "2026-01-16T08:00:00Z",
      "updated_at": "2026-01-16T08:00:00Z"
    }
  ]
}
```

### POST /contact
Új kapcsolati üzenet küldése.

**Request Body:**
```json
{
  "name": "John Smith",
  "email": "johnsmith@example.com",
  "message": "Hello, I have a question about the courses."
}
```

**Validation Rules:**
- `name`: required, string, max:255
- `email`: required, email, max:255
- `message`: required, string, min:10, max:1000

**Response:**
```json
{
  "message": "Üzenet sikeresen elküldve!",
  "data": {
    "id": 1,
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "message": "Hello, I have a question about the courses.",
    "created_at": "2026-01-16T08:00:00Z",
    "updated_at": "2026-01-16T08:00:00Z"
  }
}
```

---

## WebSocket Events

### Course Events
**Channel:** `courses`

#### course.created
Új kurzus létrehozásakor küldött esemény.

**Event Data:**
```json
{
  "course": {
    "id": 1,
    "title": "Laravel Basics",
    "description": "Learn Laravel from scratch",
    "status": "planned",
    "difficulty": "beginner",
    "instructor": {
      "id": 1,
      "name": "John Doe",
      "email": "john@example.com"
    }
  },
  "message": "New course created: Laravel Basics",
  "timestamp": "2026-01-16T08:00:00.000Z"
}
```

---

## Error Responses

### Validation Errors (422)
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "title": ["A kurzus címe kötelező."],
    "email": ["Ez az email cím már foglalt."]
  }
}
```

### Not Found (404)
```json
{
  "message": "No query results for model [App\\Models\\Course] 999"
}
```

### Server Error (500)
```json
{
  "message": "Server Error"
}
```

---

## Authentication
Jelenleg az API nem használ autentikációt, minden endpoint nyilvánosan elérhető.

## Database Models

### Course
- id (int, primary key)
- title (string, 255)
- description (text)
- status (enum: planned, active, completed)
- difficulty (enum: beginner, intermediate, advanced)
- instructor_id (int, foreign key)
- created_at (timestamp)
- updated_at (timestamp)

### Student
- id (int, primary key)
- name (string, 255)
- email (string, 255, unique)
- created_at (timestamp)
- updated_at (timestamp)

### Instructor
- id (int, primary key)
- name (string, 255)
- email (string, 255, unique)
- created_at (timestamp)
- updated_at (timestamp)

### ContactMessage
- id (int, primary key)
- name (string, 255)
- email (string, 255)
- message (text)
- created_at (timestamp)
- updated_at (timestamp)

### course_student (pivot table)
- course_id (int, foreign key)
- student_id (int, foreign key)

## Broadcasting Configuration

WebSocket kommunikáció Pusher protokollon keresztül történik:
- **Host:** 127.0.0.1:6001
- **Scheme:** http
- **App Key:** local
- **Channels:** courses (public channel)
