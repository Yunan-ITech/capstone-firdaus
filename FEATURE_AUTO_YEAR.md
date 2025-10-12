# Fitur Auto-Fill Tahun pada Tambah Unit Barang

## Deskripsi
Fitur ini mengimplementasikan pengisian otomatis kolom Tahun pada form Tambah Unit Barang. Kolom tahun akan secara otomatis mengikuti nilai tahun yang telah diinput saat proses Tambah Barang (barang induk). Hal ini bertujuan untuk menjaga konsistensi data dan memudahkan proses input.

## Implementasi

### 1. Controller (AssetController.php)
- **Method `detail()`**: Ditambahkan variabel `$tahunInduk` yang berisi data tahun dari barang induk
- **Method `addUnit()`**: 
  - Dihapus validasi `tahun_id` dari request
  - Menggunakan `$induk->tahun_id` secara otomatis untuk setiap unit baru

### 2. View (detail.blade.php)
- **Form Tambah Unit Barang**:
  - Select tahun dibuat `disabled` dan tidak memiliki `name` attribute
  - Ditambahkan text helper: "Tahun otomatis mengikuti tahun pengadaan barang induk"
  - Option tahun otomatis terpilih berdasarkan tahun barang induk

### 3. JavaScript
- **Visual Indicator**: Select tahun diberi background abu-abu dan cursor not-allowed
- **Prevent Interaction**: Mencegah klik dan keyboard input pada select tahun
- **Auto-selection**: Memastikan tahun yang benar terpilih secara otomatis

### 4. Layout (app.blade.php)
- Ditambahkan `@stack('styles')` dan `@stack('scripts')` untuk mendukung push directives

## Manfaat
1. **Konsistensi Data**: Setiap unit barang akan memiliki tahun yang sama dengan barang induk
2. **Efisiensi Input**: Pengguna tidak perlu mengisi tahun secara manual
3. **Minimalisir Kesalahan**: Menghindari kesalahan pengisian tahun yang tidak sesuai
4. **User Experience**: Interface yang lebih user-friendly dengan visual indicator yang jelas

## Cara Kerja
1. Saat mengakses halaman detail barang, sistem mengambil tahun dari barang induk
2. Form Tambah Unit Barang menampilkan tahun tersebut dalam select yang disabled
3. Saat form disubmit, controller menggunakan tahun dari barang induk secara otomatis
4. Setiap unit baru yang ditambahkan akan memiliki tahun yang sama dengan barang induk

## File yang Dimodifikasi
- `app/Http/Controllers/AssetController.php`
- `resources/views/assets/detail.blade.php`
- `resources/views/layouts/app.blade.php`

## Testing
Untuk menguji fitur ini:
1. Akses halaman detail barang yang sudah ada
2. Perhatikan kolom tahun pada form Tambah Unit Barang (akan terisi otomatis dan disabled)
3. Isi form dengan data lain (jumlah, ruangan, kondisi)
4. Submit form
5. Verifikasi bahwa unit baru yang ditambahkan memiliki tahun yang sama dengan barang induk 