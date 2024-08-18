# Website Hotel dengan CodeIgniter 4 dan Bootstrap

Selamat datang di proyek Website Hotel ini! Proyek ini dibangun menggunakan CodeIgniter 4 dan Bootstrap untuk memberikan pengalaman yang responsif dan modern. Website ini memungkinkan tamu untuk memesan kamar secara online tanpa perlu membuat akun dan menyediakan berbagai fitur untuk admin dan resepsionis. Link Demo dari aplikasi dapat dilihat [di sini](https://codebyade.com/hotel/).

- Admin (username: admin, password: password) 
- Resepsionis (username: resepsionis, password: password)

## Fitur Utama

### Untuk Tamu
- **Landing Page**: Menampilkan daftar kamar yang tersedia.
- **Pemesanan Online**: Tamu dapat memesan satu atau banyak kamar tanpa harus membuat akun.
- **Konfirmasi Pemesanan**: Setelah pemesanan, tamu akan menerima informasi pemesanan melalui email.

### Menu Admin
- **Dashboard**: Menampilkan statistik seperti jumlah user, jumlah kamar, jumlah laporan reservasi yang masuk bulan ini, dan uang yang masuk bulan ini.
- **CRUD User**: Mengelola data user.
- **CRUD Kamar**: Mengelola data kamar.
- **CRUD Reservasi**: Mengelola data reservasi.

### Menu Resepsionis
- **Dashboard**: Menampilkan jumlah laporan reservasi yang masuk bulan ini dan uang yang masuk bulan ini.
- **CRUD Reservasi**: Mengelola data reservasi.

### Fitur Umum
- **Profil**: Setiap pengguna dapat mengedit profil mereka yang sedang login.
- **Logout**: Fitur untuk keluar dari sistem.

## Instalasi

1. **Clone repositori ini**:
   ```bash
   git clone https://github.com/adekurniawan22/hotel.git
   ```
   
2. **Masuk ke direktori proyek**:
   ```bash
    cd hotel
   ```

3. **Install dependensi**:
   ```bash
    composer install
   ```

4. **Jalankan migrasi database (konfigurasikan database di .env)**:
   ```bash
    php spark migrate
   ```

5. **Jalankan seeder (opsional)**:
   ```bash
    php spark db:seed DatabaseSeeder
   ```
   
5. **Jalankan servel lokal (ubah alamat baseURL di .env)**:
   ```bash
    php spark serve
   ```
   
## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan fork repository ini, buat branch baru, dan buat pull request dengan deskripsi perubahan yang Anda buat. Terimakasih😊
