# Database Schema & ER Diagram
## Real-Time Public Transport Tracking System

---

## 📊 ENTITY RELATIONSHIP DIAGRAM

```
┌─────────────────┐
│     ROLES       │
├─────────────────┤
│ id (PK)         │
│ name            │
│ description     │
│ created_at      │
│ updated_at      │
└────────┬────────┘
         │
         │ 1:N
         │
┌────────▼─────────────────┐          ┌──────────────────┐
│       USERS              │          │    ROUTES        │
├──────────────────────────┤          ├──────────────────┤
│ id (PK)                  │          │ id (PK)          │
│ name                     │          │ route_number     │
│ email (UNIQUE)           │          │ name             │
│ phone (UNIQUE)           │          │ start_point      │
│ password                 │          │ end_point        │
│ role_id (FK) ───────────┐│          │ distance         │
│ avatar                   ││          │ estimated_time   │
│ is_active                ││          │ color            │
│ email_verified_at        ││          │ is_active        │
│ created_at               ││          │ created_at       │
│ updated_at               ││          │ updated_at       │
│ deleted_at               ││          └────────┬─────────┘
└──────┬───────────────────┘│                   │
       │                    │                   │ 1:N
       │                    │                   │
       │ 1:N                │          ┌────────▼─────────┐
       │                    │          │   BUS_STOPS      │
┌──────▼────────────────┐   │          ├──────────────────┤
│  EMERGENCY_ALERTS     │   │          │ id (PK)          │
├───────────────────────┤   │          │ name             │
│ id (PK)               │   │          │ address          │
│ driver_id (FK)        │   │          │ latitude         │
│ bus_id (FK)           │   │          │ longitude        │
│ trip_id (FK)          │   │          │ route_id (FK)    │
│ latitude              │   │          │ stop_order       │
│ longitude             │   │          │ is_active        │
│ description           │   │          │ created_at       │
│ status                │   │          │ updated_at       │
│ acknowledged_at       │   │          └──────────────────┘
│ resolved_at           │   │                   │
│ created_at            │   │                   │
│ updated_at            │   │                   │
└───────────────────────┘   │                   │
       │                    │                   │
       │                    │                   │
       │                    │          ┌────────▼────────────┐
       │                    │          │      BUSES          │
       │                    │          ├─────────────────────┤
┌──────▼────────────────┐   │          │ id (PK)             │
│   NOTIFICATIONS       │   │          │ bus_number (UNIQUE) │
├───────────────────────┤   │          │ registration_number │
│ id (PK)               │   │          │ model               │
│ user_id (FK)          │   │          │ capacity            │
│ title                 │   │          │ route_id (FK)       │
│ message               │   │          │ driver_id (FK)      │
│ type                  │   │          │ status              │
│ is_read               │   │          │ year_of_manufacture │
│ read_at               │   │          │ created_at          │
│ created_at            │   │          │ updated_at          │
│ updated_at            │   │          └─────────┬───────────┘
└───────────────────────┘   │                    │
                            │                    │ 1:N
                            │                    │
┌──────────────────────┐    │          ┌─────────▼───────────┐
│     FEEDBACKS        │    │          │       TRIPS         │
├──────────────────────┤    │          ├─────────────────────┤
│ id (PK)              │    │          │ id (PK)             │
│ user_id (FK)         │    │          │ bus_id (FK)         │
│ trip_id (FK)         │    │          │ driver_id (FK)      │
│ bus_id (FK)          │    │          │ route_id (FK)       │
│ rating               │    │          │ started_at          │
│ comment              │    │          │ ended_at            │
│ category             │    │          │ distance_covered    │
│ created_at           │    │          │ duration            │
│ updated_at           │    │          │ status              │
└──────────────────────┘    │          │ notes               │
                            │          │ created_at          │
                            │          │ updated_at          │
                            │          └─────────┬───────────┘
                            │                    │
                            └────────────────────┤
                                                 │ 1:N
                                                 │
                                        ┌────────▼─────────┐
                                        │  GPS_LOCATIONS   │
                                        ├──────────────────┤
                                        │ id (PK)          │
                                        │ bus_id (FK)      │
                                        │ trip_id (FK)     │
                                        │ latitude         │
                                        │ longitude        │
                                        │ speed            │
                                        │ heading          │
                                        │ recorded_at      │
                                        │ created_at       │
                                        │ updated_at       │
                                        └──────────────────┘
```

---

## 🗂️ TABLE DETAILS

### 1. ROLES
**Purpose:** Define user roles in the system

| Column      | Type         | Constraints           |
|-------------|--------------|----------------------|
| id          | BIGINT       | PRIMARY KEY, AUTO_INCREMENT |
| name        | VARCHAR(255) | UNIQUE, NOT NULL     |
| description | VARCHAR(255) | NULLABLE             |
| created_at  | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP |
| updated_at  | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP |

**Sample Data:**
- Admin
- Driver
- Passenger

---

### 2. USERS
**Purpose:** Store all system users

| Column            | Type         | Constraints                    |
|-------------------|--------------|-------------------------------|
| id                | BIGINT       | PRIMARY KEY, AUTO_INCREMENT   |
| name              | VARCHAR(255) | NOT NULL                      |
| email             | VARCHAR(255) | UNIQUE, NOT NULL              |
| phone             | VARCHAR(255) | UNIQUE, NULLABLE              |
| password          | VARCHAR(255) | NOT NULL                      |
| role_id           | BIGINT       | FOREIGN KEY → roles(id)       |
| avatar            | VARCHAR(255) | NULLABLE                      |
| is_active         | BOOLEAN      | DEFAULT TRUE                  |
| email_verified_at | TIMESTAMP    | NULLABLE                      |
| remember_token    | VARCHAR(100) | NULLABLE                      |
| created_at        | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP     |
| updated_at        | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP     |
| deleted_at        | TIMESTAMP    | NULLABLE (Soft Delete)        |

**Indexes:**
- email (UNIQUE)
- phone (UNIQUE)
- role_id

---

### 3. ROUTES
**Purpose:** Define bus routes

| Column             | Type          | Constraints                 |
|--------------------|---------------|-----------------------------|
| id                 | BIGINT        | PRIMARY KEY, AUTO_INCREMENT |
| route_number       | VARCHAR(255)  | UNIQUE, NOT NULL            |
| name               | VARCHAR(255)  | NOT NULL                    |
| start_point        | VARCHAR(255)  | NOT NULL                    |
| end_point          | VARCHAR(255)  | NOT NULL                    |
| distance           | DECIMAL(8,2)  | NOT NULL                    |
| estimated_duration | INTEGER       | NOT NULL (in minutes)       |
| color              | VARCHAR(7)    | DEFAULT '#3B82F6'           |
| is_active          | BOOLEAN       | DEFAULT TRUE                |
| created_at         | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP   |
| updated_at         | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP   |

**Indexes:**
- route_number (UNIQUE)

---

### 4. BUS_STOPS
**Purpose:** Store bus stop information

| Column      | Type          | Constraints                    |
|-------------|---------------|--------------------------------|
| id          | BIGINT        | PRIMARY KEY, AUTO_INCREMENT    |
| name        | VARCHAR(255)  | NOT NULL                       |
| address     | VARCHAR(255)  | NOT NULL                       |
| latitude    | DECIMAL(10,7) | NOT NULL                       |
| longitude   | DECIMAL(10,7) | NOT NULL                       |
| route_id    | BIGINT        | FOREIGN KEY → routes(id)       |
| stop_order  | INTEGER       | NOT NULL                       |
| is_active   | BOOLEAN       | DEFAULT TRUE                   |
| created_at  | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |
| updated_at  | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- latitude, longitude (COMPOSITE INDEX)
- route_id

---

### 5. BUSES
**Purpose:** Store bus/vehicle information

| Column              | Type         | Constraints                    |
|---------------------|--------------|--------------------------------|
| id                  | BIGINT       | PRIMARY KEY, AUTO_INCREMENT    |
| bus_number          | VARCHAR(255) | UNIQUE, NOT NULL               |
| registration_number | VARCHAR(255) | UNIQUE, NOT NULL               |
| model               | VARCHAR(255) | NOT NULL                       |
| capacity            | INTEGER      | NOT NULL                       |
| route_id            | BIGINT       | FOREIGN KEY → routes(id)       |
| driver_id           | BIGINT       | FOREIGN KEY → users(id), NULL  |
| status              | ENUM         | active/maintenance/inactive    |
| year_of_manufacture | YEAR         | NULLABLE                       |
| created_at          | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP      |
| updated_at          | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- bus_number (UNIQUE)
- registration_number (UNIQUE)
- route_id
- driver_id

---

### 6. TRIPS
**Purpose:** Track individual bus trips

| Column           | Type          | Constraints                    |
|------------------|---------------|--------------------------------|
| id               | BIGINT        | PRIMARY KEY, AUTO_INCREMENT    |
| bus_id           | BIGINT        | FOREIGN KEY → buses(id)        |
| driver_id        | BIGINT        | FOREIGN KEY → users(id)        |
| route_id         | BIGINT        | FOREIGN KEY → routes(id)       |
| started_at       | TIMESTAMP     | NOT NULL                       |
| ended_at         | TIMESTAMP     | NULLABLE                       |
| distance_covered | DECIMAL(8,2)  | NULLABLE (in km)               |
| duration         | INTEGER       | NULLABLE (in minutes)          |
| status           | ENUM          | ongoing/completed/cancelled    |
| notes            | TEXT          | NULLABLE                       |
| created_at       | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |
| updated_at       | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- bus_id
- driver_id
- route_id
- started_at

---

### 7. GPS_LOCATIONS
**Purpose:** Store real-time GPS coordinates

| Column      | Type          | Constraints                    |
|-------------|---------------|--------------------------------|
| id          | BIGINT        | PRIMARY KEY, AUTO_INCREMENT    |
| bus_id      | BIGINT        | FOREIGN KEY → buses(id)        |
| trip_id     | BIGINT        | FOREIGN KEY → trips(id), NULL  |
| latitude    | DECIMAL(10,7) | NOT NULL                       |
| longitude   | DECIMAL(10,7) | NOT NULL                       |
| speed       | DECIMAL(5,2)  | DEFAULT 0 (in km/h)            |
| heading     | DECIMAL(5,2)  | NULLABLE (in degrees)          |
| recorded_at | TIMESTAMP     | NOT NULL                       |
| created_at  | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |
| updated_at  | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- bus_id, recorded_at (COMPOSITE INDEX)
- latitude, longitude (COMPOSITE INDEX)
- trip_id

---

### 8. NOTIFICATIONS
**Purpose:** Store user notifications

| Column     | Type         | Constraints                    |
|------------|--------------|--------------------------------|
| id         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT    |
| user_id    | BIGINT       | FOREIGN KEY → users(id)        |
| title      | VARCHAR(255) | NOT NULL                       |
| message    | TEXT         | NOT NULL                       |
| type       | ENUM         | info/warning/alert/success     |
| is_read    | BOOLEAN      | DEFAULT FALSE                  |
| read_at    | TIMESTAMP    | NULLABLE                       |
| created_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP      |
| updated_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- user_id, is_read (COMPOSITE INDEX)

---

### 9. EMERGENCY_ALERTS
**Purpose:** Track emergency situations

| Column          | Type          | Constraints                    |
|-----------------|---------------|--------------------------------|
| id              | BIGINT        | PRIMARY KEY, AUTO_INCREMENT    |
| driver_id       | BIGINT        | FOREIGN KEY → users(id)        |
| bus_id          | BIGINT        | FOREIGN KEY → buses(id)        |
| trip_id         | BIGINT        | FOREIGN KEY → trips(id), NULL  |
| latitude        | DECIMAL(10,7) | NOT NULL                       |
| longitude       | DECIMAL(10,7) | NOT NULL                       |
| description     | TEXT          | NULLABLE                       |
| status          | ENUM          | pending/acknowledged/resolved  |
| acknowledged_at | TIMESTAMP     | NULLABLE                       |
| resolved_at     | TIMESTAMP     | NULLABLE                       |
| created_at      | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |
| updated_at      | TIMESTAMP     | DEFAULT CURRENT_TIMESTAMP      |

**Indexes:**
- status
- driver_id
- bus_id

---

### 10. FEEDBACKS
**Purpose:** Collect user feedback

| Column     | Type         | Constraints                           |
|------------|--------------|---------------------------------------|
| id         | BIGINT       | PRIMARY KEY, AUTO_INCREMENT           |
| user_id    | BIGINT       | FOREIGN KEY → users(id)               |
| trip_id    | BIGINT       | FOREIGN KEY → trips(id), NULLABLE     |
| bus_id     | BIGINT       | FOREIGN KEY → buses(id), NULLABLE     |
| rating     | INTEGER      | UNSIGNED, NOT NULL (1-5)              |
| comment    | TEXT         | NULLABLE                              |
| category   | ENUM         | bus_condition/driver_behavior/etc     |
| created_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP             |
| updated_at | TIMESTAMP    | DEFAULT CURRENT_TIMESTAMP             |

**Indexes:**
- rating
- user_id

---

## 📈 RELATIONSHIPS SUMMARY

| Relationship | Type  | Description |
|--------------|-------|-------------|
| Role → User | 1:N | One role has many users |
| Route → BusStop | 1:N | One route has many stops |
| Route → Bus | 1:N | One route has many buses |
| User (Driver) → Bus | 1:N | One driver drives many buses |
| Bus → Trip | 1:N | One bus has many trips |
| Bus → GpsLocation | 1:N | One bus has many GPS records |
| Trip → GpsLocation | 1:N | One trip has many GPS records |
| User → Notification | 1:N | One user has many notifications |
| User (Driver) → EmergencyAlert | 1:N | One driver can trigger many alerts |
| User → Feedback | 1:N | One user can give many feedbacks |

---

## 🔍 SAMPLE QUERIES

### Get all active buses with their current location
```sql
SELECT 
    b.bus_number,
    b.model,
    r.name as route_name,
    gl.latitude,
    gl.longitude,
    gl.speed,
    gl.recorded_at
FROM buses b
JOIN routes r ON b.route_id = r.id
LEFT JOIN LATERAL (
    SELECT * FROM gps_locations 
    WHERE bus_id = b.id 
    ORDER BY recorded_at DESC 
    LIMIT 1
) gl ON true
WHERE b.status = 'active';
```

### Get route with all stops in order
```sql
SELECT 
    r.name,
    bs.name as stop_name,
    bs.stop_order,
    bs.latitude,
    bs.longitude
FROM routes r
JOIN bus_stops bs ON r.id = bs.route_id
WHERE r.id = 1
ORDER BY bs.stop_order;
```

### Get driver's trip history
```sql
SELECT 
    t.id,
    b.bus_number,
    r.name as route_name,
    t.started_at,
    t.ended_at,
    t.distance_covered,
    t.duration,
    t.status
FROM trips t
JOIN buses b ON t.bus_id = b.id
JOIN routes r ON t.route_id = r.id
WHERE t.driver_id = 1
ORDER BY t.started_at DESC;
```

---

*Complete database schema for the Real-Time Public Transport Tracking System*
