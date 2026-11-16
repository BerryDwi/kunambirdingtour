# Frontend & Plan Perbaikan — Birdtour Asia

> **Dokumen:** Rencana Perbaikan Frontend & Halaman Publik  
> **Status:** 📋 Menunggu Persetujuan Pengguna  

---

## 1. Aturan Perbaikan

1. Jangan mengubah desain (warna, bentuk, layout, class visual) atau copy editorial frontend publik kecuali diminta. Teks yang merepresentasikan data — mis. jumlah departure, tahun tour — wajib mengikuti database melalui perhitungan, dan perubahan teks tersebut **bukan** perubahan desain/copy.
2. Perbaikan bersifat minimal dan terarah pada temuan.
3. Setiap perbaikan wajib disertai test bila menyentuh logika.
4. Full suite + Pint harus tetap hijau setelah perbaikan.
5. Tidak menambah dependency baru tanpa persetujuan.
6. Tidak commit kecuali diminta.

---

## 2. Daftar Rencana Perbaikan

| No | Halaman / Area | Ringkasan Perbaikan yang Diminta | Status |
|---|---|---|---|
| 1 | Halaman Booking (`/booking`) | Hapus bagian Scheduled Tours Flowchart, Custom Tours Flowchart, fitur online booking & reservation form, bank wire details official bank payment sheets, dan tampilan financial consumer protection. | ✅ Selesai |
| 2 | Halaman Tours (`/tours`) | Buatkan halaman detail tours per departure (`/tours/{slug}`). | ✅ Selesai |

---

## 3. Detail Rencana Kerja

### Item 1: Halaman Booking (`resources/views/landing_page/booking.blade.php`)
- **Tindakan**:
  - Hapus bagian **Scheduled Tours Flowchart** dan **Custom Tours Flowchart** (kontainer `#flowchart-section` beserta tab).
  - Hapus fitur **Online Booking & Reservation Form Wizard** (kontainer `#booking-form-section`).
  - Hapus bagian **Official Bank Wire Details & Payment Sheets** (kontainer `#payment-details-section`).
  - Hapus tampilan **Financial Consumer Protection** (IPP London).
  - Sesuaikan tautan tombol pada hero announcement overlay (`.bta-announcement-overlay`) dan teks pengantar agar tidak mengarah ke section yang telah dihapus.
  - Bersihkan CSS dan JavaScript internal di `booking.blade.php` yang khusus melayani elemen-elemen yang dihapus tersebut.
  - Sesuaikan `tests/Feature/BookingTest.php` agar selaras dengan isi halaman booking yang baru dan full suite tetap hijau.

### Item 2: Halaman Tours — Detail per Departure (`/tours/{slug}`)
- **Tindakan**:
  - Daftarkan rute publik `Route::get('/tours/{tour:slug}', [TourController::class, 'show'])->name('tours.show')` di `routes/web.php`.
  - Tambahkan method `show(Tour $tour)` di `App\Http\Controllers\LandingPage\TourController`:
    - Validasi hanya tour `is_published` yang dapat diakses (abort 404 jika draft).
    - Ambil data tur dan relasi tour terkait.
  - Buat view `resources/views/landing_page/tour_detail.blade.php` yang menampilkan:
    - Judul tur, foto hero, tanggal keberangkatan, negara, status ketersediaan.
    - Spesifikasi tur: durasi hari, harga (GBP & USD), single supplement, ukuran grup.
    - Deskripsi & ringkasan tur.
    - Itinerary harian / detail jadwal perjalanan.
    - Tombol kontak / enquiry langsung (WhatsApp & Email).
    - Tautan ke itinerary eksternal jika ada.
  - Perbarui `resources/views/landing_page/partials/tour-card.blade.php` agar judul dan tombol mengarah ke `route('tours.show', $tour)`.
  - Daftarkan URL tour detail ke `sitemap.xml` di `SeoController.php`.
  - Buat feature test `tests/Feature/TourDetailTest.php` untuk memastikan routing, status 200/404, dan konten detail tur berfungsi dengan baik.

---

## 4. Konfirmasi Eksekusi

Sesuai instruksi Anda:
- Perbaikan **belum dieksekusi**.
- Pengerjaan baru akan dimulai satu per satu setelah Anda mengonfirmasi dan menyatakan bahwa seluruh plan sudah selesai.
