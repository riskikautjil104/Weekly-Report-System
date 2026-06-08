# Weekly Report System - Flow Diagram

## 1. Overview

Dokumen ini menjelaskan alur sistem (flow) dari input aktivitas harian hingga menjadi laporan mingguan.

Flow dibuat step-by-step agar mudah dipahami developer.

---

## 2. Daily Activity Flow

```
[Start]
   ↓
[User Login]
   ↓
[Masuk Dashboard]
   ↓
[Klik Input Aktivitas]
   ↓
[Isi Form]
   - Tanggal (wajib)
   - Aktivitas (wajib)
   - Status (wajib)
   - Keterangan (optional)
   ↓
[Validasi Input]
   ↓
 ┌───────────────┐
 │ Valid?        │
 └──────┬────────┘
        │
   Yes  │   No
        │
        ↓
   [Simpan Data]      [Tampilkan Error]
        ↓                     ↑
   [Data Masuk DB]───────────┘
        ↓
[User Bisa Tambah Aktivitas Lagi]
        ↓
[End]
```

---

## 3. Daily Reminder Flow (WAHA)

```
[Scheduler Jalan (16:00)]
        ↓
[Ambil Semua User]
        ↓
[Loop per User]
        ↓
[Cek Aktivitas Hari Ini]
        ↓
 ┌───────────────┐
 │ Sudah Isi?    │
 └──────┬────────┘
        │
   Yes  │   No
        │
        ↓
   [Skip]        [Kirim WhatsApp Reminder]
        ↓                     ↓
      [Next User] <───────────┘
        ↓
[End]
```

---

## 4. Weekly Report Generation Flow

```
[User/Admin Pilih Periode]
   ↓
[Input Tanggal Start & End]
   ↓
[Request ke Server]
   ↓
[Ambil Data dari DB]
   WHERE tanggal BETWEEN start AND end
   ↓
[Filter by user_id (optional)]
   ↓
[Proses Data]
   ↓
[Hitung Summary]
   - Total Task
   - Selesai
   - Progress
   - Kendala
   ↓
[Group Data (optional by tanggal)]
   ↓
[Generate Report]
   ↓
 ┌──────────────────────┐
 │ Format Output        │
 │ - Table             │
 │ - PDF (optional)    │
 └──────────┬───────────┘
            ↓
       [Tampilkan ke User]
            ↓
          [End]
```

---

## 5. Weekly Reminder Flow

```
[Scheduler (Jumat/Sabtu)]
        ↓
[Ambil Semua User]
        ↓
[Loop per User]
        ↓
[Kirim Reminder]
"Segera isi weekly report"
        ↓
[End]
```

---

## 6. Admin Monitoring Flow

```
[Admin Login]
     ↓
[Dashboard Admin]
     ↓
[Lihat Semua Aktivitas]
     ↓
[Filter]
 - User
 - Tanggal
     ↓
[Tampilkan Data]
     ↓
[Generate Report]
     ↓
[Export (PDF/Excel optional)]
     ↓
[End]
```

---

## 7. Error Handling Flow

```
[User Submit Form]
       ↓
[Validasi]
       ↓
 ┌───────────────┐
 │ Valid Data?   │
 └──────┬────────┘
        │
   Yes  │   No
        │
        ↓
   [Save]       [Return Error Message]
        ↓               ↓
     [Success]      [User Fix Input]
        ↓               ↓
       [End] <──────────┘
```

---

## 8. High-Level System Flow

```
        +-------------------+
        |     USER          |
        +-------------------+
                  ↓
        Input Daily Activity
                  ↓
        +-------------------+
        |   DATABASE        |
        +-------------------+
                  ↓
        Weekly Aggregation
                  ↓
        +-------------------+
        |  REPORT SYSTEM    |
        +-------------------+
                  ↓
        View / Export Report
```

---

## 9. Key Notes

* Satu hari bisa banyak aktivitas
* Tanggal adalah mandatory field
* Semua report berbasis range tanggal
* Reminder berjalan otomatis via scheduler
* Sistem scalable untuk banyak user

---

## 10. Conclusion

Flow ini memastikan:

* Input data tetap fleksibel
* Reporting tetap terstruktur
* Monitoring bisa dilakukan real-time

---
