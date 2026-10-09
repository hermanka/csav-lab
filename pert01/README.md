# Airport Cybersecurity Lab

Virtual Airport Cybersecurity Laboratory untuk Praktikum Cybersecurity in Aviation.

## Teknologi

- Docker Compose
- PHP 8.3 + Apache
- MariaDB 11
- HTML/CSS flat design
- PHP cURL untuk komunikasi antar-service
- PDO MySQL untuk akses database

## Menjalankan Lab

```bash
docker compose up -d --build
docker compose ps
```

Buka:

- http://localhost:8080 — Airport Portal
- http://localhost:8081 — Flight Information Display System
- http://localhost:8082 — Check-in System

## Data latihan

| Booking | Passenger | Flight | Seat |
|---|---|---|---|
| ABC123 | Ahmad | GA-102 | 12A |
| DEF456 | Siti | QZ-701 | 18C |
| GHI789 | Budi | ID-650 | 07B |
| JKL012 | Rina | GA-215 | 21A |

## Eksplorasi Docker

```bash
docker compose ps
docker network ls
docker compose logs
docker inspect airport-portal
docker inspect airport-api
docker exec -it airport-db mariadb -u airport -pairport airport
```

## Reset database

```bash
docker compose down -v
docker compose up -d --build
```

`down -v` menghapus data volume. Pada lab ini database menggunakan init script sehingga database akan dibuat ulang saat container MariaDB dibuat kembali.

## Catatan pembelajaran

Pada Pertemuan 1 mahasiswa belum diminta menemukan kerentanan atau melakukan eksploitasi.

Fokus:
1. mengenali sistem digital bandara,
2. memahami hubungan antar sistem,
3. melihat bahwa aplikasi memiliki backend dan database,
4. memahami bahwa gangguan pada satu komponen dapat memengaruhi layanan lain.
