# Claude Instruction - Weekly Report System

## 1. Purpose

Dokumen ini berisi instruksi untuk AI (Claude / LLM / Assistant) dalam membantu pengembangan sistem Weekly Report berbasis Laravel.

AI harus memahami struktur sistem, aturan bisnis, dan standar coding yang digunakan dalam project ini.

---

## 2. System Context

Aplikasi ini adalah sistem pencatatan aktivitas harian yang akan direkap menjadi laporan mingguan.

Setiap user dapat:

* Menginput banyak aktivitas dalam 1 hari
* Wajib mengisi tanggal untuk setiap aktivitas
* Mengisi status aktivitas (selesai, progress, kendala)

---

## 3. Core Rules

### 3.1 Daily Activity Rules

* Satu user dapat memiliki banyak aktivitas dalam satu tanggal
* Field wajib:
  * tanggal
  * aktivitas
  * status
* Field opsional:
  * keterangan

---

### 3.2 Status Definition

* selesai → task sudah selesai
* progress → masih dikerjakan
* kendala → ada hambatan

---

### 3.3 Weekly Report Rules

* Data diambil berdasarkan range tanggal
* Biasanya periode: Senin – Sabtu
* Semua aktivitas dalam periode dihitung

---

## 4. Expected AI Behavior

AI harus:

### 4.1 Saat Generate Code

* Menggunakan standar Laravel (Controller, Model, Migration)
* Menggunakan clean code
* Menghindari duplikasi logic

---

### 4.2 Saat Generate Query

* Gunakan Eloquent ORM (default)
* Hindari query mentah kecuali diperlukan
* Gunakan whereBetween untuk filter tanggal

---

### 4.3 Saat Generate UI

* Gunakan Bootstrap 5
* Form harus simple dan jelas
* Gunakan validasi input

---

## 5. Database Understanding

### Table: daily_activities

Fields:

* id
* user_id
* tanggal (DATE, wajib)
* aktivitas (TEXT)
* status (ENUM: selesai, progress, kendala)
* keterangan (TEXT, optional)
* created_at
* updated_at

---

## 6. Business Logic Reference

### 6.1 Summary Calculation

AI harus mampu menghitung:

* total_task = jumlah semua aktivitas
* selesai = jumlah status selesai
* progress = jumlah status progress
* kendala = jumlah status kendala

---

### 6.2 Weekly Data Retrieval (Laravel Example)

Gunakan pendekatan:

* Filter berdasarkan user_id
* Filter tanggal dengan whereBetween

---

## 7. WhatsApp Reminder Logic

### Daily Reminder

* Kirim jika user belum input hari ini

### Weekly Reminder

* Kirim di akhir minggu

---

## 8. Coding Style Guidelines

* Gunakan penamaan variabel yang jelas
* Hindari nested logic berlebihan
* Pisahkan logic ke service jika kompleks
* Gunakan validation di controller

---

## 9. Constraints

AI tidak boleh:

* Menghapus field wajib (tanggal, aktivitas, status)
* Mengubah struktur database tanpa alasan jelas
* Menggunakan teknologi di luar stack tanpa diminta

---

## 10. Future Awareness

AI boleh menyarankan:

* Export PDF
* Dashboard analytics
* KPI system
* Approval workflow

Namun harus tetap sesuai konteks sistem utama.

---

## 11. Goal

Tujuan utama sistem:

* Mempermudah input aktivitas harian
* Menghasilkan laporan mingguan otomatis
* Meningkatkan monitoring kerja tim

---
