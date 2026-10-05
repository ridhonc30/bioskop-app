# 🎬 Aplikasi Bioskop

Aplikasi web pemesanan tiket bioskop berbasis **PHP native** dengan arsitektur **MVC (Model-View-Controller)**. Dibuat sebagai tugas kuliah kelompok (Agustus 2025).

## ✨ Fitur

**Untuk Admin:**
- Kelola data film (tambah, edit, hapus, upload poster)
- Kelola jadwal tayang
- Kelola data studio

**Untuk Penonton:**
- Lihat daftar film & jadwal tayang
- Pilih kursi (dengan validasi kursi yang sudah terpesan)
- Pemesanan tiket
- Riwayat pemesanan

## 🛠️ Tech Stack
- **Backend:** PHP (native, arsitektur MVC)
- **Database:** MySQL
- **Frontend:** HTML, CSS

## 🗂️ Struktur Project
```
bioskop-app/
├── controllers/   # Logic aplikasi (Auth, Film, Jadwal, Studio)
├── models/        # Interaksi dengan database
├── views/         # Tampilan halaman
├── db/            # Koneksi database
└── uploads/       # Poster film yang diupload
```

## 🚀 Cara Menjalankan
1. Nyalakan XAMPP (Apache & MySQL)
2. Import database yang ada di folder `db` ke phpMyAdmin
3. Clone/download repo ini ke folder `htdocs`
4. Buka browser, akses `localhost/bioskop-app`

## 👥 Kontributor
Dikerjakan secara berkelompok sebagai tugas kuliah.

---
*Project ini dibuat untuk tujuan pembelajaran arsitektur MVC dan pengembangan aplikasi web.*
