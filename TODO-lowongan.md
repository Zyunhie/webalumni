# TODO: Implementasi Modul Lowongan Kerja (Job Vacancy)

## Status: Planning Phase (Awaiting Approval)

### PART 1: DATABASE & MODEL [COMPLETED] ✅

### PART 2: ADMIN PANEL [COMPLETED] ✅

### PART 3: HALAMAN PUBLIK & ALUMNI [COMPLETED] ✅

### PART 1: DATABASE & MODEL [COMPLETED] ✅
### PART 2: ADMIN PANEL [COMPLETED] ✅
### PART 3: HALAMAN PUBLIK & ALUMNI [COMPLETED] ✅
### PART 4: EMAIL & JOBS [COMPLETED] ✅

**Modul Lowongan Kerja FULLY IMPLEMENTED!**

**Final Setup**:
```
php artisan storage:link
php artisan queue:table && php artisan migrate
php artisan queue:work  # for email notifications
php artisan serve
```

**Test Flow**:
1. Admin create lowongan → approve → notify (email queue to alumni target prodi)
2. Alumni see `/lowongan` (prodi filter/rekomendasi) → detail → lamar (CV upload)
3. Admin `/admin/lowongan/{id}` see lamaran list
4. Dashboard alumni `/dashboard/lowongan` rekomendasi

**Policy**: Add LowonganPolicy if needed for production.

**Complete! 🎉**


- [x] Update migration 2025_11_06_014528_create_lowongans_table.php
- [x] Rewrite app/Models/Lowongan.php
- [x] Create migration create_lamarans_table.php
- [x] Create app/Models/Lamaran.php
- [x] Update app/Models/Alumni.php
- [x] Run `php artisan migrate`
- [x] Test models/scopes/relasi

**Note:** DB sync requires manual rollback/migrate for lowongans schema change. Run:
php artisan migrate:rollback --path=database/migrations/2025_11_06_014528_create_lowongans_table.php
php artisan migrate

### PART 2: ADMIN PANEL [PENDING]
### PART 3: HALAMAN PUBLIK & ALUMNI [PENDING]
### PART 4: EMAIL & JOBS [PENDING]

**Next:** User approval → Execute PART 1 step-by-step
