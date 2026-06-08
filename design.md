# Weekly Report System - Design Document

## 1. Overview

Sistem ini digunakan untuk mencatat aktivitas harian karyawan yang secara otomatis akan direkap menjadi laporan mingguan (Weekly Report).

Setiap user dapat mengisi aktivitas harian, dan admin dapat memonitor serta mengelola seluruh laporan.

---

## 2. Tech Stack

* Backend: Laravel 13
* Database: MySQL
* Frontend: Bootstrap 5
* Notification: WAHA (WhatsApp API)

---

## 3. User Roles

### 3.1 User

* Input aktivitas harian
* Melihat aktivitas pribadi
* Generate weekly report pribadi

### 3.2 Admin

* Melihat semua aktivitas user
* Filter berdasarkan user & tanggal
* Generate semua weekly report
* Mengirim reminder via WhatsApp

---

## 4. Core Features

### 4.1 Daily Activity Input

* User dapat menginput banyak aktivitas dalam 1 hari
* Field wajib:
  * tanggal
  * aktivitas
  * status

### 4.2 Weekly Report Generator

* Sistem otomatis menggabungkan aktivitas harian menjadi laporan mingguan
* Periode dapat ditentukan (misalnya Senin–Sabtu)

### 4.3 Summary Calculation

* Total Task
* Task Selesai
* Task Progress
* Task Kendala

### 4.4 WhatsApp Reminder

* Reminder harian untuk input aktivitas
* Reminder mingguan untuk finalisasi laporan

---

## 5. Database Design

### 5.1 Table: users

* id
* name
* email
* password
* role (admin/user)
* created_at
* updated_at

---

### 5.2 Table: daily_activities

* id
* user_id (foreign key)
* tanggal (DATE, wajib)
* aktivitas (TEXT, wajib)
* status (ENUM: selesai, progress, kendala)
* keterangan (TEXT, optional)
* created_at
* updated_at

---

## 6. Business Logic

### 6.1 Input Activity

* User dapat menambahkan lebih dari 1 aktivitas per hari
* Data disimpan berdasarkan tanggal

### 6.2 Weekly Aggregation

* Data diambil berdasarkan range tanggal
* Dikelompokkan per user

### 6.3 Summary Logic

* total_task = jumlah semua aktivitas
* selesai = count(status = selesai)
* progress = count(status = progress)
* kendala = count(status = kendala)

---

## 7. UI/UX Flow

### 7.1 User Flow

1. Login
2. Dashboard
3. Input aktivitas harian
4. Lihat list aktivitas
5. Generate weekly report

---

### 7.2 Admin Flow

1. Login
2. Dashboard
3. Lihat semua aktivitas
4. Filter data (user/tanggal)
5. Export weekly report

---

## 8. WhatsApp Notification Flow

### 8.1 Daily Reminder

* Waktu: setiap hari jam 16:00
* Target: user yang belum input aktivitas hari ini

Pesan:
"Jangan lupa isi aktivitas hari ini ya."

---

### 8.2 Weekly Reminder

* Waktu: Jumat atau Sabtu
* Target: semua user

Pesan:
"Segera lengkapi weekly report minggu ini."

---

## 9. API / Controller Logic

### 9.1 Get Weekly Data

* Filter berdasarkan:
  * user_id
  * start_date
  * end_date

---

### 9.2 Summary Calculation

* Hitung total dan status dari collection data

---

## 10. Future Improvements

* Export PDF laporan
* Grafik performa user
* KPI tracking
* Approval system dari atasan
* Integrasi email notification

---

## 11. Conclusion

Sistem ini dirancang untuk:

* Mempermudah pencatatan aktivitas harian
* Mengurangi pekerjaan manual dalam membuat weekly report
* Meningkatkan disiplin dan monitoring kinerja tim

---
