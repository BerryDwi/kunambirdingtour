# Backend Plan — Birdtour Asia (Kunam Birding Tour)

> **Status: DISETUJUI — implementasi berjalan.**
> **Batch 1A: SELESAI. Batch 1B: SELESAI. Batch 2A + 2A.1 + 2B: SELESAI. Batch 3: berikutnya.**
> Tanggal: 2 November 2026
> Stack: Laravel 13.35, PHP 8.4, Blade + Tailwind v4 (admin), Bootstrap 5 (publik), Vite 8, PHPUnit 12
> Database: SQLite (dev) / MySQL (produksi)

---

## 0. Ringkasan untuk Session Baru

Baca bagian ini dulu. Semua keputusan di bawah sudah final dan **tidak perlu ditanyakan lagi**.

**Yang sudah selesai (Batch 1A):**
- Fondasi panel admin Blade + Tailwind di `/admin`.
- Login/logout admin, middleware `admin`, rate limit 5 percobaan/menit.
- Migration `users.is_admin`, seeder admin, layout admin, dashboard placeholder.

**Yang sudah selesai (Batch 1B):**
- 10 migration, 10 model, 10 factory, 7 enum (37 file).
- Tabel: `settings`, `hero_slides`, `tours`, `leaders`, `tour_reports`, `custom_tours`, `terms_sections`, `products`, `bookings`, `contact_messages`.
- Relasi `Tour hasMany Booking`, scope `published/ordered/forYear`, cast enum, soft delete.
- Verifikasi: `migrate:fresh --seed` sukses, factory menghasilkan data valid, 21 test / 93 assertion hijau, Pint bersih.

**Yang sudah selesai (Batch 2A):**
- CRUD `tours` lengkap: list + filter (search/year/status/published), create, edit, soft delete.
- Upload gambar ke disk `public_uploads` (`public/uploads`), tanpa `storage:link`; dukung URL eksternal dan hapus gambar.
- Komponen admin reusable: page header, table, status badge, empty state, form field.
- `TourRequest` + konversi harga major → minor unit di controller.
- 10 test admin baru (guest redirect, non-admin 403, CRUD, upload, replacement, removal, soft delete, filter).

**Yang sudah selesai (Batch 2B):**
- CRUD `leaders`, `tour_reports`, `custom_tours`, `terms_sections`, `products` + upload/hapus gambar.
- Editor `settings` per grup + tambah/hapus setting.
- Inbox `bookings` + `contact_messages`: filter, detail, update status, soft delete booking, hapus pesan, export CSV.
- Form Request per resource, shared image trait, navigasi admin lengkap.
- 59 test admin baru + smoke test halaman admin.

**Yang sudah selesai (Batch 3A / 3A.1 / 3B):**
- Seeder konten: 57 settings, 30 hero slides, 16 tours, 15 leaders, 20+21 reports, 14 terms, 1 produk; demo inbox terpisah.
- Seluruh halaman publik, layout, booking, dan contact membaca DB/settings.
- `tours.status_label`, `terms_sections.nav_title`/`anchor`, `tour_reports.kind`, `leaders.badge_style`.

**Yang sudah selesai (Batch 4):**
- Form Request + action persist booking/contact, reference `BTA-YYYY-XXXXXX` unik dengan retry.
- Empat mailable (notifikasi admin + auto-reply), dikirim sinkron dengan fallback error aman.
- `terms_accepted_at`, IP, user agent tersimpan; honeypot + throttle 5/menit; admin inbox sudah lengkap.

**Yang sudah selesai (Batch 5 — SEO & QA):**
- Meta title/description per halaman dari settings grup `seo`, canonical, Open Graph, Twitter Card.
- `/sitemap.xml` dinamis (8 halaman publik) dan `/robots.txt` dinamis (`Disallow: /admin` + sitemap).
- Alias lama (`/customtours`, `/tourreports`, `/bookingform`, `/terms-and-conditions`, `/contactus` GET) menjadi **301** ke URL kanonik; POST `/contactus` tetap menerima submission.
- Full suite hijau, Pint bersih, view/build cache OK.

**Batch 6 (Kesiapan Deploy):**
- Di luar scope pekerjaan saat ini; checklist disimpan sebagai referensi bila nanti dibutuhkan.

**Penyempurnaan Batch 2A.1 (selesai):**
- Tabel tours diringkas jadi 6 kolom; detail lengkap lewat modal **View all** (native `<dialog>` + fetch partial).
- Form add/edit tours jadi wizard 5 langkah dengan validasi per langkah.
- Error server otomatis membuka langkah yang bermasalah + ringkasan error yang bisa diklik.
- Slug otomatis dibuat dari nama selama admin belum mengubah slug manual.

**Penyempurnaan admin R-03–R-06 (selesai, 15 Nov 2026):**
- Logo Birdtour Asia menggantikan placeholder "BA" lewat komponen `x-admin.brand-logo` (login, header mobile, sidebar).
- Dashboard berisi data nyata: 4 stat card, bar tour per tahun, line tren inbox 6 bulan, doughnut status tour, tabel 5 tour terdekat.
- Chart.js 4 (npm) dimuat lazy hanya di dashboard.
- Sidebar dikelompokkan menjadi Home / Content / Site / Inbox.
- Settings memakai sub-sidebar grup di dalam content (`?group=`), satu grup aktif per halaman; save/delete mempertahankan grup; tombol "Add setting" ada di header card grup aktif dan form-nya terkunci ke grup tersebut.
- Sidebar desktop scroll independen dari konten (nav scroll sendiri, logout menetap di bawah layar); header punya menu akun (Profile + Log out) dan halaman `/admin/profile` untuk lihat/edit nama, email, serta ganti password.

**Aturan kerja yang wajib dipatuhi:**
1. Minta persetujuan sebelum membuat/mengubah file (boleh batch).
2. Jangan commit kecuali diminta.
3. Jangan mengubah desain (warna, bentuk, layout, class visual) atau copy editorial frontend publik. Teks yang merepresentasikan data — mis. jumlah departure, tahun tour — wajib mengikuti database melalui perhitungan, dan perubahan teks tersebut **bukan** perubahan desain/copy.
4. 21 test lama harus tetap hijau.
5. Jangan menambah dependency baru tanpa persetujuan.
6. Panel admin memakai Blade + Tailwind, **bukan Filament**.
7. Urutan kerja: fondasi admin → tabel DB + model → CRUD admin → halaman publik dinamis → form → SEO/QA/deploy.
8. **Setiap batch yang selesai wajib dicatat di bagian 8 (Log Batch)**: tanggal, file, hasil verifikasi, dan catatan.

---

## 1. Tujuan

Memindahkan seluruh konten yang saat ini hardcoded di Blade ke database, menambahkan panel admin, dan membuat form booking & contact benar-benar menyimpan data serta mengirim email — **tanpa mengubah desain frontend** yang sudah selesai.

Definisi "dinamis":

- Admin dapat CRUD tours, leaders, tour reports, custom tours, home content, terms, dan settings.
- Halaman publik mengambil data dari Database, bukan hardcoded.
- Booking & contact tersimpan, tervalidasi, dan memicu notifikasi email.
- Layout, class CSS, dan copy frontend tetap sama.

---

## 2. Baseline Project

| Area | Status saat ini | Implikasi |
|---|---|---|
| Tours | Hardcoded 16 kartu (11×2027, 4×2028, 1×2029) | Perlu tabel `tours` + filter tahun |
| Booking form | Opsi tour hardcoded 19 item, tidak sinkron dengan halaman tours | Opsi harus diturunkan dari database |
| Leaders | 15 kartu hardcoded | Perlu tabel `leaders` |
| Tour reports | 20 kategori hardcoded (link eksternal) | Perlu tabel `tour_reports` |
| Home | Hero, about, featured reports, produk hardcoded | Sebagian menjadi settings/featured |
| Terms | 14 section hardcoded | Menjadi `terms_sections` |
| Booking/Contact | Hanya validasi; tidak persist, tidak kirim email | Prioritas utama backend |
| Layout | Kontak, bank, sosial, footer hardcoded | Pindah ke `settings` |
| Auth/Admin | Batch 1A selesai | CRUD menyusul |
| Database | SQLite dev, hanya tabel default + `users.is_admin` | Migration konten menyusul |
| Test | 21 test / 93 assertion, semua lulus | Harus tetap hijau selama refactor |

Konten existing wajib di-seed ulang agar tampilan tidak berubah dan test lama tetap valid.

---

## 3. Keputusan Final — Jangan Ditanyakan Lagi

| Topik | Keputusan | Catatan |
|---|---|---|
| Panel admin | **Custom Blade + Tailwind v4** | Tanpa Filament, tanpa dependency baru |
| Skill yang dipakai | `tailwindcss-development` + `laravel-best-practices` | Aktifkan saat menulis view/kode |
| Urutan kerja | **Admin + tabel DB dulu**, baru CRUD, baru halaman publik, baru form | Sesuai permintaan user |
| Auth admin | `users.is_admin` + middleware `auth` + alias `admin` | Tidak memakai tabel `admins` terpisah |
| Otorisasi | Middleware `admin` sebagai gerbang utama | Policy hanya bila muncul aturan granular |
| Path admin | `/admin` | Prefix dan name prefix `admin.` |
| Warna brand admin | Navy `#172b40`, green `#087d50` | Sudah menjadi `--color-brand-navy` / `--color-brand-green` |
| Database produksi | **MySQL** | Dev tetap SQLite |
| Email | **Default Laravel dulu** (`MAIL_MAILER=log`) | Provider dikonfigurasi hanya saat user mengirim detail |
| Kredensial admin | `ADMIN_EMAIL` / `ADMIN_PASSWORD` dari env | Fallback dev: `admin@birdtourasia.com` / `password` |
| Fallback dev | Hanya untuk environment non-production | Produksi wajib mengisi env |
| Rate limit login | 5 percobaan/menit per email + IP | Key: `admin-login|email|ip` |
| Tabel `products` | **Ikut dibuat di Batch 1B** | Untuk Leech Socks |
| Nilai uang | Integer minor unit (pence/cents) | Bukan float |
| Penyimpanan gambar | **`public/uploads`** via disk `public_uploads` | Tanpa `storage:link` (shared hosting) |
| URL publik lama | Dipertahankan | `/customtours`, `/tourreports`, `/contactus`, `/bookingform`, `/terms-and-conditions` |
| Copy & desain publik | **Dibekukan** | Tidak boleh berubah tanpa permintaan resmi |
| Commit | Hanya jika user meminta | Saat ini belum ada commit |
| Dependency baru | Butuh persetujuan eksplisit | Filament, Larastan, sitemap, dll. |

---

## 4. Default untuk Hal yang Belum Diputuskan

Bagian ini **tidak perlu ditanyakan sekarang**. Gunakan default berikut; tanyakan hanya jika pekerjaan sudah benar-benar menyentuh area tersebut.

| Topik | Default yang dipakai | Kapan boleh ditanya |
|---|---|---|
| Gambar | Dukung URL eksternal (CDN existing) **dan** upload ke `public/uploads` (disk `public_uploads`) | Sudah final |
| Provider email | Implementasi Mailable memakai konfigurasi `MAIL_*` standar | Saat mengaktifkan pengiriman nyata |
| Alamat pengirim | Ambil dari `MAIL_FROM_ADDRESS`, fallback ke setting `contact.email` | Saat membuat Mailable |
| Hosting | Tidak diputuskan; rencanakan deploy standar Laravel | Saat fase deploy |
| Pembayaran online | **Tidak ada**; tetap bank transfer | Hanya jika user meminta |
| Sitemap | Generate route XML manual tanpa package | Hanya jika user ingin package |
| 2FA admin | Tidak sekarang | Ditawarkan setelah CRUD stabil |
| Terms CMS | Termasuk dalam scope (bukan statis permanen) | — |

---

## 5. Rancangan Database

### 5.1 Tabel konten

#### `settings`

Menyimpan konfigurasi global yang dipakai layout dan halaman.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `key` | string, unique | contoh: `contact.email`, `bank.gbp.iban` |
| `value` | text, nullable | nilai |
| `type` | string | `string`, `text`, `boolean`, `json` |
| `group` | string | `contact`, `bank`, `social`, `seo`, `home` |
| timestamps | | |

Contoh key: `contact.email`, `contact.office_email`, `contact.whatsapp_1`, `contact.whatsapp_2`, `contact.address`, `bank.gbp.name`, `bank.gbp.sort`, `bank.gbp.account`, `bank.gbp.iban`, `bank.usd.*`, `social.facebook`, `home.map_embed`, `home.announcement`.

#### `hero_slides`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `page` | string, index | `home`, `tours`, `custom-tours`, `reports`, `leaders`, `booking`, `contact`, `terms` |
| `image` | string | path storage atau URL eksternal |
| `alt` | string | alt text |
| `title` | string, nullable | overlay title |
| `text` | text, nullable | overlay text |
| `sort_order` | integer | urutan |
| `is_active` | boolean | tampil/tidak |
| timestamps | | |

#### `tours`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `name` | string | nama tour |
| `slug` | string, unique | untuk URL/SEO |
| `year` | integer, index | 2027, 2028, dst. |
| `country` | string, nullable | negara/region |
| `summary` | string, nullable | deskripsi singkat di kartu |
| `description` | longText, nullable | deskripsi lengkap |
| `itinerary` | longText, nullable | markdown |
| `duration_days` | integer, nullable | durasi |
| `date_label` | string, nullable | teks tanggal fleksibel (mendukung 2 rentang) |
| `start_date` | date, nullable | untuk sorting/filter |
| `end_date` | date, nullable | |
| `price_gbp` | integer, nullable | pence |
| `price_usd` | integer, nullable | cents |
| `single_supplement_gbp` | integer, nullable | pence |
| `single_supplement_usd` | integer, nullable | cents |
| `status` | string, index | enum `TourStatus` |
| `image` | string, nullable | path/URL |
| `is_featured` | boolean | tampil di home |
| `is_published` | boolean, index | |
| `sort_order` | integer | |
| `meta_title` | string, nullable | SEO |
| `meta_description` | string, nullable | SEO |
| timestamps | | |
| softDeletes | | |

Index: `(year, is_published)`, `(status)`, `(sort_order)`.

#### `leaders`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `name` | string | |
| `slug` | string, unique | |
| `region` | string, nullable | badge, contoh `Throughout the region` |
| `bio` | longText, nullable | markdown |
| `photo` | string, nullable | path/URL |
| `email` | string, nullable | |
| `sort_order` | integer | |
| `is_published` | boolean | |
| timestamps | | |

#### `tour_reports`

Merepresentasikan kategori/laporan (sesuai UI 20 kartu), bukan tiap PDF.

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `title` | string | |
| `slug` | string, unique | |
| `region` | string, nullable | untuk grouping/filter |
| `summary` | string, nullable | |
| `cover_image` | string, nullable | |
| `report_url` | string, nullable | link eksternal/PDF |
| `published_at` | date, nullable | |
| `is_featured` | boolean | tampil di home |
| `sort_order` | integer | |
| `is_published` | boolean | |
| timestamps | | |

#### `custom_tours`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `title` | string | |
| `slug` | string, unique | |
| `destination` | string, nullable | |
| `date_label` | string, nullable | |
| `description` | longText, nullable | |
| `status` | string | contoh `open`, `confirmed` |
| `contact_email` | string, nullable | |
| `sort_order` | integer | |
| `is_published` | boolean | |
| timestamps | | |

#### `terms_sections`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `number` | integer | 1–14 |
| `title` | string | |
| `body` | longText | markdown |
| `sort_order` | integer | |
| timestamps | | |

#### `products` — **disetujui, ikut Batch 1B**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `name` | string | contoh Leech Socks |
| `slug` | string, unique | |
| `description` | longText, nullable | |
| `price` | integer, nullable | minor unit |
| `currency` | string, nullable | |
| `image` | string, nullable | |
| `purchase_url` | string, nullable | |
| `is_active` | boolean | |
| timestamps | | |

### 5.2 Tabel transaksi

#### `bookings`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `reference_code` | string, unique | format `BTA-YYYY-XXXXXX` |
| `tour_id` | foreignId, nullable | relasi ke tours |
| `tour_type` | string | enum `TourType` |
| `tour_name` | string | snapshot nama tour |
| `tour_year` | string, nullable | |
| `currency` | string | enum `Currency` |
| `room_preference` | string | enum `RoomPreference` |
| `full_name` | string | |
| `email` | string, index | |
| `phone` | string | |
| `country` | string | |
| `participants_count` | unsignedTinyInteger | 1–20 |
| `birding_experience` | string, nullable | |
| `dietary_medical` | text, nullable | |
| `special_notes` | text, nullable | |
| `terms_accepted_at` | timestamp | |
| `status` | string, index | enum `BookingStatus` |
| `payment_status` | string, index | enum `PaymentStatus` |
| `ip_address` | string, nullable | |
| `user_agent` | text, nullable | |
| timestamps | | |
| softDeletes | | |

#### `contact_messages`

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint | PK |
| `first_name` | string | |
| `last_name` | string | |
| `email` | string, index | |
| `phone` | string, nullable | |
| `message` | text | |
| `status` | string, index | enum `MessageStatus` |
| `ip_address` | string, nullable | |
| `user_agent` | text, nullable | |
| timestamps | | |

#### `users` (sudah dikerjakan Batch 1A)

`is_admin` boolean default `false`, index. Cast `boolean` di model. Tidak masuk `#[Fillable]`.

### 5.3 Enum (`app/Enums`)

- `TourStatus`: `Available`, `Full`, `Provisional`
- `TourType`: `Scheduled`, `Custom`
- `Currency`: `Gbp`, `Usd`
- `RoomPreference`: `TwinShare`, `SingleSupplement`
- `BookingStatus`: `Pending`, `Confirmed`, `Cancelled`, `Completed`
- `PaymentStatus`: `Unpaid`, `DepositPaid`, `Paid`, `Refunded`
- `MessageStatus`: `New`, `Read`, `Replied`, `Archived`

Gunakan TitleCase untuk key enum.

### 5.4 Catatan desain database

- `bookings.tour_name` disimpan sebagai snapshot agar histori tidak berubah saat tour diedit/dihapus.
- `tours.date_label` dipertahankan karena satu kartu bisa memuat dua rentang tanggal. `tour_departures` dapat ditambahkan nanti bila booking per-departure dibutuhkan.
- `tour_reports` awalnya merepresentasikan kategori/laporan, bukan tiap file PDF.
- Semua nilai uang disimpan sebagai integer minor unit (pence/cents), bukan float.
- Index tambahan: `bookings(reference_code)`, `bookings(email)`, `contact_messages(status)`.
- Urutan migration: `tours` harus dibuat sebelum `bookings` (foreign key).
- `products` sudah disetujui dan masuk Batch 1B.

---

## 6. Rancangan Aplikasi

### 6.1 Struktur folder (target)

```
app/
├── Actions/
│   ├── CreateBooking.php
│   ├── GenerateBookingReference.php
│   └── StoreContactMessage.php
├── Enums/                       # Batch 1B ✅
│   ├── BookingStatus.php
│   ├── Currency.php
│   ├── MessageStatus.php
│   ├── PaymentStatus.php
│   ├── RoomPreference.php
│   ├── TourStatus.php
│   └── TourType.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── Auth/LoginController.php      # Batch 1A ✅
│   │   │   ├── DashboardController.php       # Batch 1A ✅
│   │   │   ├── TourController.php            # Batch 2
│   │   │   ├── LeaderController.php          # Batch 2
│   │   │   ├── TourReportController.php      # Batch 2
│   │   │   ├── CustomTourController.php      # Batch 2
│   │   │   ├── BookingController.php         # Batch 2
│   │   │   ├── ContactMessageController.php  # Batch 2
│   │   │   ├── TermsSectionController.php    # Batch 2
│   │   │   └── SettingController.php         # Batch 2
│   │   └── LandingPage/ (existing, diubah query DB)
│   ├── Middleware/EnsureUserIsAdmin.php       # Batch 1A ✅
│   └── Requests/
│       ├── Admin/LoginRequest.php            # Batch 1A ✅
│       ├── StoreBookingRequest.php
│       ├── StoreContactRequest.php
│       ├── StoreTourRequest.php
│       ├── UpdateTourRequest.php
│       └── ...
├── Mail/
│   ├── BookingReceived.php
│   ├── BookingAdminNotification.php
│   ├── ContactAutoReply.php
│   └── ContactAdminNotification.php
├── Models/                      # Batch 1B ✅
│   ├── Booking.php
│   ├── ContactMessage.php
│   ├── CustomTour.php
│   ├── HeroSlide.php
│   ├── Leader.php
│   ├── Product.php
│   ├── Setting.php
│   ├── TermsSection.php
│   ├── Tour.php
│   └── TourReport.php
├── Policies/                    # hanya bila dibutuhkan
└── Support/helpers.php
config/
└── admin.php                                  # Batch 1A ✅
database/
├── factories/                   # Batch 1B ✅
├── migrations/                  # Batch 1A ✅ + Batch 1B ✅
└── seeders/
    ├── AdminUserSeeder.php                    # Batch 1A ✅
    ├── SettingSeeder.php                      # Batch 3
    ├── TourSeeder.php                         # Batch 3
    ├── LeaderSeeder.php                       # Batch 3
    ├── TourReportSeeder.php                   # Batch 3
    ├── CustomTourSeeder.php                   # Batch 3
    └── TermsSectionSeeder.php                 # Batch 3
routes/
├── web.php                                    # publik, tetap
└── admin.php                                  # Batch 1A ✅
resources/views/
├── admin/                                     # Batch 1A ✅ + Batch 2
│   ├── layouts/app.blade.php
│   ├── auth/login.blade.php
│   └── dashboard.blade.php
└── landing_page/ (loop menggantikan hardcode) # Batch 3
```

### 6.2 Pola kode

- Validasi di **Form Request**, bukan inline controller.
- Logika multi-langkah di **Action** (`CreateBooking`); controller tetap tipis.
- Query publik memakai scope: `Tour::published()->forYear($year)->ordered()->get()`.
- Authorization memakai middleware `admin`; policy hanya bila ada aturan granular.
- Booking creation + notifikasi dibungkus transaksi; email dikirim setelah commit (`DB::afterCommit`).
- Rate limit form: `throttle:forms` + honeypot + pencatatan IP/UA.
- `settings` dan query publik di-cache; invalidasi lewat model event.
- Upload gambar memakai disk `public_uploads` (root `public/uploads`), **tanpa `storage:link`**, agar kompatibel dengan shared hosting.
- Route admin dipisah di `routes/admin.php` dan didaftarkan melalui `withRouting(then: ...)` di `bootstrap/app.php`.
- Redirect guest memakai `Middleware::redirectGuestsTo(fn () => route('admin.login'))`.
- **Jangan memanggil `app()->environment()` di file config** — config dimuat sebelum `env` binding tersedia. Gunakan `env('APP_ENV', ...)`.

### 6.3 Route admin (Batch 1A)

```
GET  /admin/login     admin.login
POST /admin/login     admin.login.store
GET  /admin           admin.dashboard        (auth + admin)
POST /admin/logout    admin.logout           (auth + admin)
```

Route `/admin/login` memakai middleware `guest`. Sisanya memakai `auth` + `admin`.

### 6.4 Route admin (target Batch 2)

```
/admin                      dashboard
/admin/tours                CRUD tours
/admin/leaders              CRUD leaders
/admin/tour-reports         CRUD reports
/admin/custom-tours         CRUD custom tours
/admin/bookings             inbox + detail + update status + export CSV
/admin/contact-messages     inbox + detail + update status
/admin/terms                CRUD terms sections
/admin/settings             edit settings
```

Semua route admin dilindungi `auth` + `EnsureUserIsAdmin`.

---

## 7. Urutan Eksekusi per Batch

Urutan ini **final**: panel admin dan tabelnya dulu, bukan halaman publik.

| Batch | Fokus | Output | Status |
|---|---|---|---|
| **1A** | Fondasi admin | Login, logout, middleware, layout, dashboard, `users.is_admin` | ✅ **SELESAI** |
| **1B** | Skema DB + model + factory + enum | 10 tabel, 10 model, 10 factory, 7 enum | ✅ **SELESAI** |
| **2A** | CRUD admin: Tours | List + filter, form create/edit, upload gambar, soft delete, test | ✅ **SELESAI** |
| **2A.1** | Penyempurnaan UI Tours | Tabel ringkas + modal View all + wizard 5 langkah | ✅ **SELESAI** |
| **2B** | CRUD admin: resource lain | Leaders, reports, custom tours, terms, products, settings, inbox | ✅ **SELESAI** |
| **3A** | Seeder konten + admin hero slides | 9 seeder konten, `tour_reports.kind`, `leaders.badge_style`, CRUD hero slides, test seeder | ✅ **SELESAI** |
| **3B** | Halaman publik dinamis | Refactor tours, leaders, reports, custom tours, home, terms, layout + test publik | ✅ **SELESAI** |
| **4** | Form booking & contact | Persist, reference code, email, anti-spam, admin inbox | ✅ **SELESAI** |
| **5** | SEO & QA | Meta, sitemap, redirect alias, test lengkap, optimasi | ✅ **SELESAI** |
| **6** | Kesiapan deploy (referensi) | MySQL produksi, queue, `public/uploads` writable, backup, smoke test | ➖ **Di luar scope** |

Estimasi sisa MVP: **selesai** (Batch 1–5). Kesiapan deploy bersifat referensi dan dikerjakan terpisah.

### Batch 1A — Fondasi Admin (SELESAI)

- [x] Migration `users.is_admin` + index + `down()` yang benar.
- [x] `config/admin.php` dengan env + fallback dev.
- [x] `AdminUserSeeder` (langsung set properti, bukan mass assignment).
- [x] Login/logout admin + rate limit 5/menit + session regenerate.
- [x] Middleware `EnsureUserIsAdmin` (403 untuk non-admin).
- [x] Layout admin Tailwind responsif + login + dashboard.
- [x] Route admin + `withRouting(then:)` + alias middleware.
- [x] `database/seeders/DatabaseSeeder.php` memanggil `AdminUserSeeder`.
- [x] `resources/css/app.css`: `@source` view admin + brand colors.
- [x] `.env.example`: `ADMIN_NAME`, `ADMIN_EMAIL`, `ADMIN_PASSWORD`.
- [x] Verifikasi: migrate + seed, login E2E, 21 test hijau, Pint bersih, build sukses.

### Batch 1B — Skema DB, Model, Factory, Enum (37 file)

**10 migration** (urutan eksekusi):
1. `create_settings_table`
2. `create_hero_slides_table`
3. `create_tours_table`
4. `create_leaders_table`
5. `create_tour_reports_table`
6. `create_custom_tours_table`
7. `create_terms_sections_table`
8. `create_products_table`
9. `create_bookings_table` (FK ke `tours`, nullable)
10. `create_contact_messages_table`

**10 model:** `Setting`, `HeroSlide`, `Tour`, `Leader`, `TourReport`, `CustomTour`, `TermsSection`, `Product`, `Booking`, `ContactMessage`.

**10 factory** untuk model di atas.

**7 enum:** `TourStatus`, `TourType`, `Currency`, `RoomPreference`, `BookingStatus`, `PaymentStatus`, `MessageStatus`.

**Kriteria selesai:**
- [x] `php artisan migrate:fresh --seed` sukses di SQLite.
- [x] Semua relasi dan cast terdefinisi.
- [x] Scope `published()` / `ordered()` pada model konten.
- [x] Factory bisa membuat data valid.
- [x] 21 test lama tetap hijau.
- [x] Pint bersih.

### Batch 2A — CRUD Tours (SELESAI)

- [x] Layout admin: navigasi aktif, komponen tabel, pagination, empty state, flash.
- [x] CRUD `tours` (upload gambar, status, tahun, tanggal, external URL, publish).
- [x] Form Request `TourRequest` + validasi slug unik.
- [x] Test admin tours: guest redirect, non-admin 403, CRUD, upload (`Storage::fake`), replacement, removal, soft delete, filter.

### Batch 2B — CRUD Resource Lain (SELESAI)

- [x] CRUD `leaders`, `tour_reports`, `custom_tours`, `terms_sections`, `products`.
- [x] Setting editor (group contact/bank/social/home).
- [x] Inbox `bookings` + `contact_messages` (status, detail, export CSV).
- [x] Form Request per resource + validasi slug unik.
- [x] Test admin per resource.

### Batch 3A — Seeder Konten + Admin Hero Slides (SELESAI)

- [x] Tambah `tour_reports.kind` (`category` / `latest`) + scope `categories()` / `latestCards()`.
- [x] Tambah `leaders.badge_style` (`success` / `info` / `warning`) + validasi + form admin.
- [x] CRUD admin `hero_slides` + route + navigasi.
- [x] Seeder konten existing: 42 settings, 30 hero slides, 16 tours, 15 leaders, 20 kategori report + 21 latest report, 14 terms, 1 produk.
- [x] `CustomTourSeeder` mengisi 3 dummy custom tour (idempotent) untuk keperluan review halaman publik & admin.
- [x] `DemoInboxSeeder` terpisah, hanya manual/local, tidak dipanggil `DatabaseSeeder`.
- [x] `DatabaseSeeder` hanya memanggil seeder konten + `AdminUserSeeder` (user `test@example.com` dihapus).
- [x] Test seeder: jumlah, idempotensi, publish flag, badge/status mapping, isolasi demo inbox.

### Batch 3A.1 — Label Konten Persis (SELESAI)

- [x] Tambah `tours.status_label` (nullable) agar badge publik memakai copy persis, termasuk 7 label non-standar.
- [x] Tambah `terms_sections.nav_title` (nullable) agar sidebar memakai label navigasi persis.
- [x] Field admin + validasi + factory untuk kedua kolom baru.
- [x] Seeder mengisi label persis; `statusLabel()` / `navTitle()` fallback ke enum/title.

### Batch 3B — Halaman Publik Dinamis (SELESAI)

- [x] Refactor `tours.blade.php` menjadi loop + filter tahun + badge dari `status_label`.
- [x] Opsi `tour_name` di form booking diambil dari `tours` (optgroup per tahun).
- [x] Refactor `leaders.blade.php`, `tour_reports.blade.php`, `custom_tours.blade.php`.
- [x] Home: hero, announcement, featured reports, produk dari DB/settings.
- [x] Refactor `terms.blade.php` menjadi loop; sidebar memakai `nav_title` + `anchor` persis.
- [x] Layout publik: meta, kontak, sosial, footer dari `settings`.
- [x] Booking & contact: bank details, email, WhatsApp, Facebook dari `settings`.
- [x] Cache `Setting::values()` + invalidasi otomatis lewat model event.
- [x] Verifikasi visual (semua halaman 200) + test konten dinamis.
- [x] Hapus hardcode konten dari Blade setelah semua halaman dinamis.

### Batch 4 — Form Booking & Contact (SELESAI)

- [x] Form Request `StoreBookingRequest` dan `StoreContactRequest`.
- [x] Action `CreateBooking`, `GenerateBookingReference`, `StoreContactMessage`.
- [x] Reference code unik + retry bila bentrok.
- [x] Simpan `terms_accepted_at`, IP, user agent.
- [x] Mailable: admin notification + auto-reply untuk booking & contact.
- [x] Rate limiting + honeypot (Turnstile belum diaktifkan).
- [x] Admin inbox lengkap + update status + export CSV (sudah selesai sebelum Batch 4).
- [x] Test: validasi, persist, email fake, JSON, rate limit, honeypot.

### Batch 5 — SEO & QA (SELESAI)

- [x] Meta title/description halaman konten (settings grup `seo` + fallback).
- [x] `sitemap.xml`, `robots.txt`, Open Graph, Twitter Card, canonical.
- [x] Redirect permanen (301) alias lama.
- [x] Full test suite hijau + Pint.
- [x] Optimasi query (eager loading, index, hindari N+1) — tidak ditemukan N+1 pada halaman publik.
- [x] Cache config/route/view di produksi (langkah deploy, bukan kode).

### Batch 6 — Kesiapan Deploy (referensi, di luar scope)

> Batch ini tidak dikerjakan pada sesi ini. Checklist disimpan sebagai referensi.

- [ ] Konfigurasi MySQL produksi + migration `--force`.
- [ ] Queue worker + scheduler + `failed_jobs` monitoring (belum perlu selama email sinkron).
- [ ] Pastikan folder `public/uploads` writable (tanpa `storage:link`).
- [ ] Backup database & storage.
- [ ] Smoke test semua halaman + form.
- [ ] Deploy (gunakan skill `deploying-to-cloud` bila memakai Laravel Cloud).

---

## 8. Status Implementasi & Log Batch

> **Aturan:** setiap batch yang selesai **wajib** dicatat di sini sebelum batch berikutnya dimulai.

### Log Batch

| Batch | Tanggal | Status | Ringkasan | Verifikasi |
|---|---|---|---|---|
| 1A | 2 Nov 2026 | ✅ Selesai | Fondasi admin: auth, middleware, layout Tailwind, dashboard, `users.is_admin` | migrate+seed OK; E2E login OK; 21 test / 93 assertion; Pint bersih |
| 1B | 2 Nov 2026 | ✅ Selesai | 10 migration + 10 model + 10 factory + 7 enum | migrate:fresh --seed OK; factory OK; 21 test / 93 assertion; Pint bersih |
| 2A | 7 Nov 2026 | ✅ Selesai | CRUD Tours + upload `public/uploads` + komponen admin + test | 31 test / 131 assertion; E2E login/list/create/upload/update/delete OK; build OK; Pint bersih |
| 2A.1 | 7 Nov 2026 | ✅ Selesai | Tabel tours ringkas + modal View all + wizard 5 langkah | 34 test / 149 assertion; E2E modal + error step 5 OK; build OK; Pint bersih |
| 2B | 7 Nov 2026 | ✅ Selesai | CRUD leaders/reports/custom tours/terms/products, settings editor, inbox bookings & contact messages, export CSV | 95 test / 389 assertion; E2E 15 halaman admin 200; view:cache OK; build OK; Pint bersih |
| 3A | 13 Nov 2026 | ✅ Selesai | Seeder konten (settings, hero, tours, leaders, reports, terms, produk) + `kind`/`badge_style` + CRUD hero slides + demo inbox terpisah | migrate:fresh --seed OK; demo seeder manual OK; 115 test / 487 assertion; view:cache OK; build OK; Pint bersih |
| 3A.1 | 14 Nov 2026 | ✅ Selesai | `tours.status_label` + `terms_sections.nav_title` (admin + seeder) agar copy publik persis | Full suite hijau; Pint bersih; view:cache OK; build OK |
| 3B | 14 Nov 2026 | ✅ Selesai | Seluruh halaman publik, layout, booking, dan contact membaca DB/settings; cache settings + invalidasi | 125 test / 572 assertion; 8 halaman publik 200; anchors/badges/dropdown diverifikasi; Pint bersih; view:cache OK; build OK |
| 4 | 14 Nov 2026 | ✅ Selesai | Form Request, action persist booking/contact, reference unik + retry, 4 mailable, honeypot, throttle, test | 133 test / 650 assertion; persist + email + JSON + rate limit + honeypot terverifikasi; Pint bersih; view:cache OK; build OK |
| 5 | 14 Nov 2026 | ✅ Selesai | SEO per halaman dari settings, canonical/OG/Twitter, sitemap + robots dinamis, alias lama 301 | 139 test / 756 assertion; sitemap 8 URL; 5 alias 301; canonical/OG terverifikasi via Herd; Pint bersih; view:cache OK; build OK |
| R-03–R-06 | 15 Nov 2026 | ✅ Selesai | Logo admin, dashboard data + 3 chart, sidebar 4 kelompok + scroll independen + logout menetap, menu akun + halaman profile (edit nama/email/password), settings sub-sidebar per grup + Add setting per card | 168 test / 878 assertion; 4 halaman admin 200 via Herd; Pint bersih; view:cache OK; build OK |

### Detail Batch 1A

#### File baru (11)

| File | Fungsi |
|---|---|
| `config/admin.php` | Kredensial admin dari env + fallback dev |
| `routes/admin.php` | Login/logout (guest) + dashboard (auth + admin) |
| `app/Http/Controllers/Admin/Auth/LoginController.php` | Login, throttle, logout |
| `app/Http/Controllers/Admin/DashboardController.php` | Dashboard placeholder |
| `app/Http/Middleware/EnsureUserIsAdmin.php` | 403 untuk non-admin |
| `app/Http/Requests/Admin/LoginRequest.php` | Validasi login |
| `database/migrations/2026_11_02_090705_add_is_admin_to_users_table.php` | `is_admin` + index |
| `database/seeders/AdminUserSeeder.php` | Seed admin dari config |
| `resources/views/admin/layouts/app.blade.php` | Shell Tailwind admin |
| `resources/views/admin/auth/login.blade.php` | Halaman login |
| `resources/views/admin/dashboard.blade.php` | Dashboard |

### File diubah (5)

| File | Perubahan |
|---|---|
| `bootstrap/app.php` | Route admin via `then:`, alias `admin`, redirect guest |
| `app/Models/User.php` | Cast `is_admin` boolean |
| `database/seeders/DatabaseSeeder.php` | Memanggil `AdminUserSeeder` |
| `resources/css/app.css` | `@source` view admin + brand colors |
| `.env.example` | Variabel admin |

#### Hasil verifikasi

- Migrasi + seeding sukses.
- Admin user: `admin@birdtourasia.com`, `is_admin = 1`.
- Route terdaftar: 4 (`admin.dashboard`, `admin.login`, `admin.login.store`, `admin.logout`).
- Guest `/admin` → `302` ke `/admin/login`.
- Login benar → `302` ke `/admin`, dashboard `200`.
- Login akun non-admin → ditolak dengan pesan "does not have administrator access".
- 21 test / 93 assertion hijau.
- Pint bersih.
- `npm run build` sukses; utility brand ada di CSS hasil build.

#### Kredensial & URL dev

- URL: `http://localhost:8000/admin/login`
- Email: `admin@birdtourasia.com`
- Password: `password`
- Environment produksi **wajib** mengisi `ADMIN_EMAIL` dan `ADMIN_PASSWORD`.

#### Catatan teknis

- Layout publik tidak memakai Vite; layout admin memakai `@vite(['resources/css/app.css', 'resources/js/app.js'])`.
- Setelah mengubah view admin, jalankan `npm run build` (atau `npm run dev`).
- `config/admin.php` memakai `env('APP_ENV')`, bukan `app()->environment()`.

### Detail Batch 1B

#### Migration (10)

| Tabel | Catatan |
|---|---|
| `settings` | `key` unique, `group` index |
| `hero_slides` | `page` + `is_active` index |
| `tours` | soft delete, index `(year, is_published)`, `status`, `is_featured`, `sort_order` |
| `leaders` | `is_published` index |
| `tour_reports` | `region`, `is_featured`, `is_published` index |
| `custom_tours` | `is_published` index |
| `terms_sections` | `sort_order` index |
| `products` | `is_active` index |
| `bookings` | FK `tour_id` nullable `nullOnDelete`, soft delete, index email/status/payment |
| `contact_messages` | index email + status |

#### Model (10)

`Setting`, `HeroSlide`, `Tour`, `Leader`, `TourReport`, `CustomTour`, `TermsSection`, `Product`, `Booking`, `ContactMessage`.

- Fillable memakai atribut `#[Fillable]` (konvensi project).
- Cast enum: `Tour::status`, `Booking::tour_type/currency/room_preference/status/payment_status`, `Product::currency`, `ContactMessage::status`.
- `Tour hasMany Booking`; `Booking belongsTo Tour`.
- Soft delete: `Tour`, `Booking`.
- Scope: `published()`, `ordered()`, `forYear()`, `featured()`, `active()`, `forPage()`, `pending()`, `unread()`, `forStatus()`.

#### Factory (10)

Semua factory memakai `fake()` dan memiliki state berguna:

- `TourFactory`: `draft()`, `featured()`, `full()`
- `LeaderFactory`: `draft()`
- `TourReportFactory`: `featured()`, `draft()`
- `CustomTourFactory`: `draft()`
- `ProductFactory`: `inactive()`
- `BookingFactory`: `confirmed()`, `paid()`, `cancelled()`
- `ContactMessageFactory`: `replied()`, `archived()`
- `HeroSlideFactory`: `inactive()`
- `SettingFactory`, `TermsSectionFactory`: default

#### Enum (7)

`App\Enums\TourStatus`, `TourType`, `Currency`, `RoomPreference`, `BookingStatus`, `PaymentStatus`, `MessageStatus`.

- Semua backed string, key TitleCase.
- Setiap enum memiliki `label()`; `Currency` juga memiliki `symbol()`.

#### Hasil verifikasi Batch 1B

- `php artisan migrate:fresh --seed` sukses; 10 tabel baru terdaftar.
- Factory diuji dalam transaksi lalu di-rollback: `Tour`, `Booking`, `ContactMessage`, `Product`, `Setting`, `Leader`, `TourReport`, `CustomTour`, `TermsSection`, `HeroSlide` berhasil dibuat.
- Relasi `Booking->tour` dan enum cast berfungsi.
- Scope `Tour::published()` dan `ContactMessage::unread()` berfungsi.
- Admin user tetap ada setelah fresh seed.
- 21 test / 93 assertion hijau.
- Pint bersih.

#### Catatan teknis Batch 1B

- Enum di-generate ke `app/` oleh Artisan, lalu dipindahkan manual ke `app/Enums/` agar sesuai rencana.
- Timestamp migration dibuat berurutan (±1 detik) agar `tours` selalu dibuat sebelum `bookings`.
- `products` sudah ikut dibuat.
- Seeder konten **belum** dibuat; dijadwalkan Batch 3.

### Detail Batch 2A

#### File baru (13)

| File | Fungsi |
|---|---|
| `app/Http/Controllers/Admin/TourController.php` | List + filter, create, edit, update, soft delete, upload/hapus gambar |
| `app/Http/Requests/Admin/TourRequest.php` | Validasi tour, normalisasi slug, checkbox, slug unik |
| `resources/views/admin/tours/index.blade.php` | Tabel tour + filter + pagination |
| `resources/views/admin/tours/create.blade.php` | Form tambah tour |
| `resources/views/admin/tours/edit.blade.php` | Form edit tour |
| `resources/views/admin/tours/partials/form.blade.php` | Field form bersama create/edit |
| `resources/views/components/admin/page-header.blade.php` | Header halaman + slot actions |
| `resources/views/components/admin/table.blade.php` | Tabel admin reusable |
| `resources/views/components/admin/status-badge.blade.php` | Badge status tour/publish |
| `resources/views/components/admin/empty-state.blade.php` | Empty state + action |
| `resources/views/components/admin/form/field.blade.php` | Label, slot input, hint, error |
| `public/uploads/.gitignore` | Folder upload tanpa `storage:link` |
| `tests/Feature/Admin/TourManagementTest.php` | 10 test CRUD tours |

#### File diubah (5)

| File | Perubahan |
|---|---|
| `routes/admin.php` | `Route::resource('tours', TourController::class)` (show aktif) |
| `resources/views/admin/layouts/app.blade.php` | Menu Tours aktif; modul lain "coming soon" |
| `app/Models/Tour.php` | `imageUrl()` untuk URL eksternal / `uploads/...` |
| `config/filesystems.php` | Disk `public_uploads` → `public/uploads` (tanpa symlink) |
| `BACKEND_PLAN.md` | Strategi storage + log Batch 2A |

#### Hasil verifikasi Batch 2A

- `php artisan test --compact tests/Feature/Admin/TourManagementTest.php`: 10 test / 38 assertion hijau.
- Full suite: **31 test / 131 assertion** hijau (21 test lama tetap lulus).
- `npm run build` sukses.
- `vendor/bin/pint --dirty --format agent` bersih.
- E2E Herd `kunambirdingtour.test`:
  - Login admin → `302 /admin`.
  - `/admin/tours` → `200`, tombol "Add tour" dan navigasi tampil.
  - Create tour + upload JPG → `302 /admin/tours`; DB `price_gbp=123456`; gambar dapat diakses `200` di `/uploads/tours/...`.
  - Update tour + hapus gambar → `302`; nama/tahun/harga berubah, `image=NULL`, file lama terhapus.
  - Delete → `302`; `deleted_at` terisi (soft delete).

#### Catatan teknis Batch 2A

- Upload memakai disk `public_uploads` (root `public/uploads`), **tanpa `storage:link`**, agar cocok untuk shared hosting. Pastikan folder writable di produksi.
- Harga disimpan sebagai integer minor unit; form menerima desimal dan konversi dilakukan di controller agar `old()` tetap menampilkan input asli saat validasi gagal.
- Gambar eksternal (`http://`, `https://`, `//`) tidak dihapus saat replace/remove; hanya file lokal di disk `public_uploads` yang dihapus.
- `User::factory()->create(['is_admin' => true])` tidak bekerja karena `is_admin` tidak fillable; test memakai `forceFill(['is_admin' => true])->save()`.

### Detail Batch 2A.1

#### File baru (4)

| File | Fungsi |
|---|---|
| `resources/views/components/admin/modal.blade.php` | Komponen `<dialog>` reusable (header/body/footer) |
| `resources/views/admin/tours/partials/details.blade.php` | Isi modal detail tour |
| `resources/js/admin/detail-modal.js` | Fetch partial + buka/tutup modal + loading/error state |
| `resources/js/admin/tour-wizard.js` | Step wizard, validasi per langkah, error jump, auto-slug |

#### File diubah (7)

| File | Perubahan |
|---|---|
| `app/Http/Controllers/Admin/TourController.php` | Tambah `show()` untuk partial modal |
| `routes/admin.php` | Resource `tours` memakai route `show` |
| `resources/views/admin/tours/index.blade.php` | 9 → 6 kolom + tombol **View all** + modal |
| `resources/views/admin/tours/partials/form.blade.php` | 5 step wizard + ringkasan error + navigasi |
| `resources/views/admin/tours/create.blade.php`, `edit.blade.php` | `novalidate` + tombol pindah ke partial |
| `resources/js/app.js` | Import dan inisialisasi modal + wizard |
| `tests/Feature/Admin/TourManagementTest.php` | 3 test baru (detail modal, otorisasi, wizard) |

#### Hasil verifikasi Batch 2A.1

- Test Tours: **13 test / 56 assertion** hijau.
- Full suite: **34 test / 149 assertion** hijau.
- `npm run build` sukses; CSS memuat varian `data-[state=...]` dan `backdrop:`.
- Pint bersih.
- E2E Herd:
  - `/admin/tours` → `200`, 7 tombol **View all**, kolom Duration/From/Order sudah hilang.
  - `GET /admin/tours/{id}` → `200`, memuat itinerary, harga, dan tombol Edit.
  - Form create → 5 `data-wizard-step`, `data-initial-step=1`, `novalidate`.
  - Submit tanpa `status` → redirect kembali dengan `data-initial-step=5`, ringkasan error tampil, pesan `status field is required`.
  - Tidak ada tour baru yang tercipta dari submit invalid.

#### Catatan teknis Batch 2A.1

- Modal memakai `<dialog>` native, tanpa Alpine/React/dependency baru.
- Detail dimuat lazy via AJAX agar halaman list tetap ringan walau itinerary panjang.
- Wizard memakai `novalidate`; validasi client ditangani JS, validasi final tetap di server (`TourRequest`).
- Tekan Enter di step tengah diarahkan ke Next, bukan submit form.
- Saat edit, slug yang sudah terisi dianggap manual sehingga tidak berubah otomatis ketika nama diubah.

### Detail Batch 2B

#### File baru (52)

| Kelompok | File | Fungsi |
|---|---|---|
| Trait | `app/Http/Controllers/Admin/Concerns/ManagesImages.php` | Resolve upload/URL/remove + hapus file lokal |
| Controller | `LeaderController`, `TourReportController`, `CustomTourController`, `TermsSectionController`, `ProductController`, `SettingController`, `BookingController`, `ContactMessageController` | CRUD resource + settings bulk + inbox |
| Request | `LeaderRequest`, `TourReportRequest`, `CustomTourRequest`, `TermsSectionRequest`, `ProductRequest`, `SettingRequest`, `BookingRequest`, `ContactMessageRequest` | Validasi, normalisasi slug/checkbox, slug unik |
| View | `admin/leaders/{index,create,edit,partials/form}` | CRUD leader + upload foto |
| View | `admin/tour-reports/{index,create,edit,partials/form}` | CRUD report + cover image + featured |
| View | `admin/custom-tours/{index,create,edit,partials/form}` | CRUD custom tour |
| View | `admin/terms-sections/{index,create,edit,partials/form}` | CRUD terms bernomor |
| View | `admin/products/{index,create,edit,partials/form}` | CRUD produk + konversi harga |
| View | `admin/settings/{index,create}` | Editor per grup + form setting baru |
| View | `admin/bookings/{index,show}` | Inbox booking + detail + update status |
| View | `admin/contact-messages/{index,show}` | Inbox pesan + detail + update status |
| Test | `LeaderManagementTest`, `TourReportManagementTest`, `CustomTourManagementTest`, `TermsSectionManagementTest`, `ProductManagementTest`, `SettingManagementTest`, `InboxManagementTest` | 57 test CRUD/inbox |
| Test | `AdminPagesSmokeTest` | 2 test render semua halaman admin |

#### File diubah (7)

| File | Perubahan |
|---|---|
| `routes/admin.php` | Resource leaders, tour-reports, custom-tours, terms-sections, products; settings; bookings + export; contact-messages + export |
| `resources/views/admin/layouts/app.blade.php` | Navigasi lengkap + section Inbox (tanpa "coming soon") |
| `resources/views/components/admin/status-badge.blade.php` | Dukungan status booking/payment/message/product/open/featured |
| `app/Models/Leader.php` | `photoUrl()` (URL eksternal / `uploads/...`) |
| `app/Models/TourReport.php` | `coverImageUrl()` |
| `app/Models/Product.php` | `imageUrl()` |
| `BACKEND_PLAN.md` | Log + detail Batch 2B |

#### Hasil verifikasi Batch 2B

- Test Batch 2B: **59 test / 218 assertion** hijau.
- Smoke test halaman admin: **2 test / 22 assertion** hijau.
- Full suite: **95 test / 389 assertion** hijau (21 test lama tetap lulus).
- `php artisan view:cache` sukses (semua Blade terkompilasi).
- `npm run build` sukses.
- `vendor/bin/pint --dirty --format agent` bersih (1 unused import dihapus).
- 56 route admin terdaftar.
- E2E Herd `kunambirdingtour.test`: login admin sukses; 15 halaman admin (dashboard, index + create semua resource, settings, inbox) mengembalikan `200`.

#### Catatan teknis Batch 2B

- Resource route param memakai snake_case (`{tour_report}`, `{custom_tour}`, `{terms_section}`, `{contact_message}`); argumen camelCase controller di-resolve otomatis oleh Laravel via `Str::snake`.
- `settings` memakai editor bulk per grup (`PUT settings/group/{group}`), nilai dikirim sebagai `values[id] = value`. Tipe didukung: `string`, `text`, `boolean`, `number`.
- Produk menyimpan harga di minor unit; form menerima major unit dan controller mengalikan 100.
- Hapus gambar lokal memakai disk `public_uploads`; URL eksternal dibiarkan.
- `Booking` memakai soft delete; `ContactMessage` hard delete. Membuka pesan berstatus `new` otomatis mengubahnya menjadi `read`.
- Export CSV memakai `streamDownload` dan mengikuti filter aktif pada listing.
- Semua halaman admin memakai layout + komponen yang sama; tidak ada dependency baru.

### Detail Batch 3A

#### Skema tambahan

| Migration | Perubahan |
|---|---|
| `2026_11_08_231205_add_kind_to_tour_reports_table.php` | `tour_reports.kind` default `category` + index |
| `2026_11_08_231206_add_badge_style_to_leaders_table.php` | `leaders.badge_style` default `success` + index |

- `TourReport` mendapat scope `categories()` dan `latestCards()`. **Jangan** memberi nama scope `latest()` karena bertabrakan dengan `Builder::latest()` (scope diabaikan, query mengembalikan semua baris).
- `Leader.badge_style` memetakan warna badge publik: `success` (default), `info` (Bob Natural), `warning` (Frank Rheindt).

#### File baru

| Kelompok | File | Fungsi |
|---|---|---|
| Migration | 2 migration di atas | Kolom `kind` + `badge_style` |
| Request | `app/Http/Requests/Admin/HeroSlideRequest.php` | Validasi hero slide + upload |
| Controller | `app/Http/Controllers/Admin/HeroSlideController.php` | CRUD hero slide |
| View | `resources/views/admin/hero-slides/{index,create,edit,partials/form}.blade.php` | CRUD hero slide |
| Seeder | `SettingSeeder` | 42 setting (general/contact/bank/social/home/seo) |
| Seeder | `HeroSlideSeeder` | 30 slide untuk 8 halaman |
| Seeder | `TourSeeder` | 16 tour (11×2027, 4×2028, 1×2029) |
| Seeder | `LeaderSeeder` | 15 leader + badge style |
| Seeder | `TourReportSeeder` | 20 kategori + 21 latest report |
| Seeder | `CustomTourSeeder` | 3 dummy custom tour (Sulawesi, Western Himalaya, Taiwan) |
| Seeder | `TermsSectionSeeder` | 14 section dengan body HTML |
| Seeder | `ProductSeeder` | Leech Socks (£18, GBP) |
| Seeder | `DemoInboxSeeder` | 4 booking + 4 contact message demo (manual) |
| Test | `tests/Feature/DatabaseSeederTest.php` | 10 test seeder |
| Test | `tests/Feature/Admin/HeroSlideManagementTest.php` | CRUD hero slide |

#### File diubah

| File | Perubahan |
|---|---|
| `app/Models/TourReport.php` | `kind` fillable + scope `categories()` / `latestCards()` |
| `app/Models/Leader.php` | `badge_style` fillable |
| `app/Models/HeroSlide.php` | `imageUrl()` + scope `onPage()` (bukan `forPage`) |
| `app/Http/Requests/Admin/LeaderRequest.php` | Validasi `badge_style` |
| `app/Http/Requests/Admin/TourReportRequest.php` | Validasi `kind` |
| `resources/views/admin/leaders/partials/form.blade.php` | Select badge style |
| `resources/views/admin/tour-reports/{index,partials/form}.blade.php` | Kolom + select kind |
| `database/factories/{LeaderFactory,TourReportFactory}.php` | Field baru + state `latest()` |
| `routes/admin.php` | Resource `hero-slides` |
| `resources/views/admin/layouts/app.blade.php` | Navigasi Hero Slides |
| `database/seeders/DatabaseSeeder.php` | Panggil seeder konten; hapus user `test@example.com` |

#### Keputusan konten

- `tour_reports.kind`: `category` untuk 20 kartu halaman reports, `latest` untuk 21 kartu home. Kolom `summary` dipakai sebagai subtitle kartu; untuk kartu latest berisi label tanggal (mis. `July - August 2026`). `is_featured` = true untuk kind `latest`.
- `Settings` memakai key `snake_case` karena `SettingRequest` hanya mengizinkan `alpha_dash` (bukan titik).
- Body terms disimpan sebagai HTML persis dari halaman publik, termasuk highlight box, tabel pembatalan, dan alert.
- Judul section terms memakai heading kartu. Sidebar "Quick Navigation" pada Batch 3B akan memakai format `{number}. {title}`, sehingga 5 label navigasi sedikit berbeda dari versi statis (mis. "Payment & Currencies" menjadi "Payment & Currency Policy"). Tidak ada konten yang hilang.
- `CustomTourSeeder` mengisi 3 dummy custom tour yang published agar halaman publik dan admin list menampilkan kartu nyata; seeder bersifat idempotent (`updateOrCreate` per slug) dan datanya mudah diganti/dihapus dari admin.
- `DemoInboxSeeder` menolak berjalan di `production` dan tidak dipanggil `DatabaseSeeder`.

#### Hasil verifikasi Batch 3A

- `php artisan migrate:fresh --seed` sukses (SQLite) — 42 settings, 30 hero slides, 16 tours, 15 leaders, 41 reports, 14 terms, 1 produk.
- `php artisan db:seed --class=DemoInboxSeeder` sukses — 4 bookings, 4 contact messages.
- Full suite: **115 test / 487 assertion** hijau.
- `php artisan view:cache` sukses.
- `npm run build` sukses.
- `vendor/bin/pint --dirty --format agent` bersih.

### Detail Batch 3A.1

#### Skema tambahan

| Migration | Perubahan |
|---|---|
| `2026_11_13_170956_add_anchor_to_terms_sections_table.php` | `terms_sections.anchor` (nullable) untuk anchor sidebar publik |
| (batch 3A.1) | `tours.status_label` + `terms_sections.nav_title` (nullable) |

- `Tour::statusLabel()` mengembalikan `status_label` bila terisi, jika tidak fallback `TourStatus::label()`. `Tour::statusBadgeClass()` memetakan enum ke class `bta-badge-*`.
- `TermsSection::navTitle()` fallback ke `title`; `TermsSection::anchorId()` fallback ke `Str::slug(title)`.
- `TermsSectionSeeder` menyimpan `nav_title` dan `anchor` persis untuk 14 section (mis. `financial-security`, `passports-visas`).

### Detail Batch 3B

#### File baru

| File | Fungsi |
|---|---|
| `database/migrations/2026_11_13_170956_add_anchor_to_terms_sections_table.php` | Kolom `anchor` untuk sidebar terms |

#### File diubah

| File | Perubahan |
|---|---|
| `app/Models/Setting.php` | `values()` dengan `Cache::rememberForever` + invalidasi pada `saved`/`deleted` |
| `app/Providers/AppServiceProvider.php` | `View::composer` membagikan `$settings` ke `layouts.template` + `landing_page.*` |
| `app/Http/Controllers/LandingPage/TourController.php` | Home + tours dari `HeroSlide`, `Tour`, `TourReport`, `Product` |
| `app/Http/Controllers/LandingPage/LeaderController.php` | Leaders dari DB |
| `app/Http/Controllers/LandingPage/ReportController.php` | Kategori reports dari DB |
| `app/Http/Controllers/LandingPage/CustomTourController.php` | Custom tours dari DB |
| `app/Http/Controllers/LandingPage/TermsController.php` | 14 section dari DB |
| `app/Http/Controllers/LandingPage/BookingController.php` | `viewData()`: slides + optgroup tour per tahun |
| `app/Http/Controllers/LandingPage/ContactController.php` | Slides hero dari DB |
| `resources/views/landing_page/home.blade.php` | Hero loop, announcement/about/award/Facebook/reports settings, kartu report DB, produk kondisional |
| `resources/views/landing_page/tours.blade.php` | Loop 2027/2028/2029+, badge status DB, hero banner DB |
| `resources/views/landing_page/leaders.blade.php` | Hero loop + kartu leader DB + badge class |
| `resources/views/landing_page/tour_reports.blade.php` | Hero loop + kategori DB |
| `resources/views/landing_page/custom_tours.blade.php` | Hero loop + kartu participant DB dengan empty state |
| `resources/views/landing_page/terms.blade.php` | Hero loop, sidebar `anchorId()`/`navTitle()`, 14 kartu body HTML |
| `resources/views/landing_page/booking.blade.php` | Slides, dropdown tour DB, bank/PDF/email/WhatsApp dari settings |
| `resources/views/landing_page/contact.blade.php` | Slides + email/office/WhatsApp/Facebook/alamat dari settings |
| `resources/views/layouts/template.blade.php` | Meta description, footer kontak/sosial/copyright dari settings |
| `app/Models/Tour.php` | `statusBadgeClass()` |
| `app/Models/Leader.php` | `badgeClass()` |
| `app/Models/TermsSection.php` | `anchor` fillable + `anchorId()` |
| `app/Http/Requests/Admin/TermsSectionRequest.php` | Validasi `anchor` |
| `database/factories/TermsSectionFactory.php` | Default `anchor` null |
| `database/seeders/TermsSectionSeeder.php` | `anchors()` + pengisian anchor |
| `resources/views/admin/terms-sections/partials/form.blade.php` | Field anchor |
| `tests/Feature/{TourTest,LeaderTest,TourReportTest,CustomTourTest,TermsTest,BookingTest,ContactTest}.php` | `RefreshDatabase` + seed + assertion konten dinamis |
| `tests/Feature/DatabaseSeederTest.php` | Assertion anchor terms |

#### Keputusan implementasi

- Dropdown booking kini satu `<optgroup>` per tahun published; label opsi `"{name} ({year})"`. Opsi Custom/Tailormade tetap statis.
- Hitungan `29 Departures` / `26 Departures` awalnya literal agar copy visual identik. **Direvisi 15 Nov 2026 (R-02):** badge departure kini memakai jumlah tour published per tahun dari DB dengan `Str::plural`, sehingga angka mengikuti data (saat ini 11 dan 4).
- Kalimat harga/ukuran produk Leech Socks di home tetap statis; hanya nama, gambar, URL, dan paragraf deskripsi pertama dari DB.
- `$settings` dibagikan hanya ke view publik agar koleksi `$settings` milik admin tidak tertimpa.
- Halaman custom tours mempertahankan copy empty state persis; kartu hanya muncul bila ada custom tour published.
- Test publik memakai `setUp()` + `$this->seed(DatabaseSeeder::class)` karena `RefreshDatabase` hanya menjalankan seeder saat migrasi pertama dalam satu proses test.

#### Hasil verifikasi Batch 3B

- `php artisan migrate` + `php artisan db:seed` sukses; 14 anchor terms terisi.
- 8 halaman publik (`/`, `/tours`, `/leaders`, `/tour-reports`, `/custom-tours`, `/terms`, `/booking`, `/contact`) merespons **200** via Herd.
- Verifikasi konten: badge "One space available"/"Tour is provisionally full", 14 kartu terms + anchor `financial-security`, optgroup 2027 + opsi `China in winter (2027)`, IBAN bank, announcement home.
- Full suite: **125 test / 572 assertion** hijau.
- `php artisan view:cache` sukses; `npm run build` sukses (63.45 kB CSS); `vendor/bin/pint --dirty --format agent` bersih.

### Detail Batch 4

#### File baru

| File | Fungsi |
|---|---|
| `app/Http/Requests/StoreBookingRequest.php` | Validasi booking + normalisasi currency + honeypot `prohibited` |
| `app/Http/Requests/StoreContactRequest.php` | Validasi contact + honeypot `prohibited` |
| `app/Actions/Bookings/GenerateBookingReference.php` | Reference `BTA-YYYY-XXXXXX` unik + retry 5x (termasuk soft-deleted) |
| `app/Actions/Bookings/CreateBooking.php` | Persist booking, resolve `tour_id`, isi `terms_accepted_at`/IP/UA |
| `app/Actions/Bookings/SendBookingNotifications.php` | Kirim notifikasi admin + auto-reply; kegagalan mail tidak membatalkan booking |
| `app/Actions/Contact/StoreContactMessage.php` | Persist contact message + IP/UA |
| `app/Actions/Contact/SendContactMessageNotifications.php` | Kirim notifikasi admin + auto-reply contact |
| `app/Mail/Bookings/NewBookingReceived.php` | Mailable notifikasi booking ke office |
| `app/Mail/Bookings/BookingAutoReply.php` | Mailable auto-reply ke pemesan |
| `app/Mail/Contact/NewContactMessageReceived.php` | Mailable notifikasi pesan contact |
| `app/Mail/Contact/ContactAutoReply.php` | Mailable auto-reply ke pengirim |
| `resources/views/emails/bookings/notification.blade.php` | Template email admin booking |
| `resources/views/emails/bookings/auto-reply.blade.php` | Template email auto-reply booking (+ reference code) |
| `resources/views/emails/contact/notification.blade.php` | Template email admin contact |
| `resources/views/emails/contact/auto-reply.blade.php` | Template email auto-reply contact |

#### File diubah

| File | Perubahan |
|---|---|
| `app/Http/Controllers/LandingPage/BookingController.php` | `StoreBookingRequest` + action persist/kirim mail; flash memakai reference asli |
| `app/Http/Controllers/LandingPage/ContactController.php` | `StoreContactRequest` + action persist/kirim mail |
| `app/Models/Setting.php` | `officeEmail()`: `office_email` → `contact_email` → `config('admin.email')` → `mail.from.address` |
| `routes/web.php` | `throttle:5,1` pada POST booking/contact/contactus |
| `resources/views/landing_page/booking.blade.php` | Honeypot `website` tersembunyi (tanpa perubahan visual) |
| `resources/views/landing_page/contact.blade.php` | Honeypot `website` tersembunyi (tanpa perubahan visual) |
| `tests/Feature/BookingTest.php` | Persist, reference unik, enum/currency, IP/UA, mail, setting recipient, honeypot, rate limit |
| `tests/Feature/ContactTest.php` | Persist, status, IP/UA, mail, setting recipient, honeypot, rate limit |

#### Keputusan implementasi

- Reference memakai prefix `BTA-` (konsisten dengan `DemoInboxSeeder`/factory), bukan `BTR-`.
- Currency dinormalisasi ke lowercase di `prepareForValidation()` karena enum `Currency` menyimpan `gbp`/`usd` sedangkan form mengirim `GBP`/`USD`.
- `tour_id` di-resolve dari pola `"{name} ({year})"` hanya untuk `tour_type=scheduled`; custom tour tetap `null`.
- Mail dikirim sinkron (tanpa `ShouldQueue`) agar tidak butuh queue worker; exception mail di-`report()` supaya data booking/contact yang sudah tersimpan tidak hilang.
- Recipient admin dari settings `office_email`; auto-reply ke email pengirim.
- Honeypot memakai field `website` + rule `prohibited`; throttle 5 request/menit per IP.
- JSON response dipertahankan untuk kompatibilitas (`success`, `message`, `reference_code`/`data`).

#### Hasil verifikasi Batch 4

- Booking tersimpan dengan reference `BTA-YYYY-XXXXXX`, `terms_accepted_at`, IP, dan user agent; `tour_id` terhubung ke tour seeded.
- Contact message tersimpan dengan status `new` + IP/UA.
- `Mail::fake()` memverifikasi notifikasi admin dan auto-reply untuk kedua form.
- Honeypot menolak submission tanpa menyimpan data; request ke-6 dalam satu menit menghasilkan **429**.
- Full suite: **133 test / 650 assertion** hijau.
- `vendor/bin/pint --dirty --format agent` bersih; `php artisan view:cache` OK; `npm run build` OK.

### Detail Batch 5

#### File baru

| File | Fungsi |
|---|---|
| `app/Http/Controllers/SeoController.php` | Render `/sitemap.xml` dan `/robots.txt` dinamis |
| `resources/views/seo/sitemap.blade.php` | Template XML sitemap |
| `tests/Feature/SeoTest.php` | Test canonical/OG, meta settings, sitemap, robots, redirect alias |

#### File diubah

| File | Perubahan |
|---|---|
| `database/seeders/SettingSeeder.php` | 15 setting SEO baru (`meta_image` + title/description 7 halaman); total 57 |
| `resources/views/layouts/template.blade.php` | `<title>`, description, canonical, Open Graph, Twitter Card dari section + settings |
| `resources/views/landing_page/home.blade.php` | `meta_description` dari settings |
| `resources/views/landing_page/{tours,custom_tours,leaders,tour_reports,terms,booking,contact}.blade.php` | Title + meta description per halaman dari settings grup `seo` |
| `routes/web.php` | Route sitemap/robots + 301 alias lama; POST `/contactus` tetap aktif |
| `tests/Feature/{BookingTest,ContactTest,CustomTourTest,TourReportTest,TermsTest}.php` | Ekspektasi alias berubah menjadi 301 |
| `tests/Feature/DatabaseSeederTest.php` | Jumlah settings 42 → 57 |
| `public/robots.txt` | Dihapus; diganti route dinamis agar mengikuti domain produksi |

#### Keputusan implementasi

- Home tetap memakai `meta_title`/`meta_description`; halaman lain memakai `meta_title_{page}`/`meta_description_{page}` dengan fallback ke teks lama sehingga copy tidak berubah.
- Canonical memakai `url()->current()` (tanpa query string) dan diterapkan di semua halaman publik.
- Sitemap dibuat tanpa dependency baru: 8 URL kanonik, tanpa `lastmod` agar tidak menghasilkan diff tanggal palsu.
- `robots.txt` dibuat dinamis supaya baris `Sitemap:` selalu memakai domain yang benar.
- Alias GET memakai `Route::permanentRedirect` (301). Khusus `/contactus`, GET diarahkan 301 ke `/contact` tetapi POST tetap diteruskan ke controller agar form lama tidak kehilangan data.
- Gambar OG default memakai logo Birdtour Asia dan dapat diganti lewat setting `meta_image`.

#### Hasil verifikasi Batch 5

- Semua 8 halaman publik menampilkan canonical, `og:title`, `og:description`, `og:image`, `og:url`, dan `twitter:card`.
- Meta title/description mengikuti perubahan setting (diuji lewat update `meta_title_tours`/`meta_description_tours`).
- `/sitemap.xml` → **200**, `application/xml`, berisi 8 `<loc>` kanonik; `/robots.txt` → **200**, `Disallow: /admin` + URL sitemap.
- Lima alias lama merespons **301** ke URL kanonik (diverifikasi via curl/Herd).
- Full suite: **139 test / 756 assertion** hijau.
- `vendor/bin/pint --dirty --format agent` bersih; `php artisan view:cache` OK; `npm run build` OK.

---

## 9. Strategi Migrasi Konten

1. Inventaris semua konten dari Blade (jumlah di bagian 2).
2. Buat seeder saat Batch 3A (sudah selesai): `SettingSeeder`, `HeroSlideSeeder`, `TourSeeder`, `LeaderSeeder`, `TourReportSeeder`, `CustomTourSeeder`, `TermsSectionSeeder`, `ProductSeeder`, plus `DemoInboxSeeder` terpisah.
3. Isi seeder dengan konten existing (copy manual lebih aman; parser one-off tidak di-commit) — selesai di Batch 3A.
4. Jalankan `php artisan migrate:fresh --seed` di dev.
5. Bandingkan halaman lama vs baru (visual check + assertion test).
6. Setelah semua halaman dinamis, hapus hardcode dari Blade.
7. Copy, urutan, gambar, dan link harus identik sampai ada permintaan perubahan resmi.

**Catatan:** seeder konten tidak dibuat di Batch 1B. Batch 1B hanya skema, model, factory, dan enum. Seeder konten menyusul di Batch 3 agar bisa langsung diverifikasi terhadap tampilan publik.

---

## 10. Testing & Quality Gates

Setiap batch wajib:

```bash
vendor/bin/pint --dirty --format agent
php artisan test --compact
```

Test yang ditambahkan:

- **Publik:** status 200, konten dari seeder, filter tahun, hanya `is_published`, badge status.
- **Booking:** validasi, tersimpan, reference code unik, email terkirim (`Mail::fake()`), respons JSON, rate limit, honeypot.
- **Contact:** validasi, tersimpan, auto-reply, admin notification.
- **Admin:** guest redirect, non-admin 403, CRUD, upload gambar (`Storage::fake`), slug unik, soft delete.
- **Settings:** cache terisi dan ter-invalidasi saat update.

Gunakan `RefreshDatabase`, factory, `Mail::fake()`, `Queue::fake()`, dan `Storage::fake('public')`.

---

## 11. Risiko & Mitigasi

| Risiko | Mitigasi |
|---|---|
| Test lama gagal karena copy berubah | Loop harus menghasilkan output identik; update test hanya bila disengaja |
| Konten hilang saat migrasi | Seeder + verifikasi visual + backup DB |
| SQLite lock di produksi | MySQL untuk produksi |
| Email masuk spam / gagal | Provider + SPF/DKIM + queue worker + monitor `failed_jobs` |
| Spam form | Honeypot + throttle + opsional Turnstile |
| Gambar CDN mati | Dukung URL eksternal dan upload lokal; migrasi bertahap |
| Admin disalahgunakan | Password kuat, rate limit login, opsional 2FA |
| Legal terms berubah tanpa sengaja | Seed persis + versioning/effective date |
| Queue worker mati | Monitoring + retry + notifikasi admin |
| Format uang salah | Simpan minor unit + helper format terpusat |

---

## 12. Definition of Done

- [ ] Semua halaman publik mengambil data dari DB dan tampil identik.
- [ ] Admin dapat mengelola seluruh konten tanpa developer.
- [ ] Booking & contact tersimpan, tervalidasi, dan mengirim email.
- [ ] 21 test lama + test baru hijau; Pint bersih.
- [ ] Tidak ada hardcode konten di Blade (kecuali copy statis yang disepakati).
- [ ] Produksi memakai MySQL, queue worker, scheduler, `public/uploads` yang writable, dan backup.
- [ ] `.ai/rules` mencatat konvensi backend yang baru.

---

## 13. Peta Halaman → Sumber Data

| Halaman | Sumber data |
|---|---|
| Home — hero | `hero_slides` (page = home) |
| Home — about | settings / static |
| Home — announcement | settings |
| Home — featured reports | `tour_reports` (is_featured) |
| Home — produk | `products` |
| Tours | `tours` (published, group by year) |
| Custom Tours | `custom_tours` + settings (map embed) |
| Tour Reports | `tour_reports` (published) |
| Leaders | `leaders` (published) |
| Booking — opsi tour | `tours` |
| Booking — bank details | settings |
| Booking — flowchart | static |
| Contact — info | settings |
| Terms | `terms_sections` |
| Layout — nav/footer/kontak/sosial | settings |

---

## 14. Aturan Kerja untuk Session Baru

1. **Baca dokumen ini sebelum menulis kode.** Bagian 3 dan 4 bersifat final.
2. **Jangan mengulang pertanyaan yang sudah dijawab** di bagian 3.
3. **Minta persetujuan** sebelum membuat/mengubah file. Sebutkan daftar file dan tujuannya.
4. **Jangan commit** kecuali diminta eksplisit.
5. **Jangan menambah dependency** (Filament, Larastan, sitemap, dll.) tanpa persetujuan.
6. **Jangan mengubah** desain, class, atau copy frontend publik.
7. **Jalankan quality gates** setiap batch: Pint + test.
8. **Batch 1B belum dimulai** sampai user memberi perintah setelah review Batch 1A.
9. Gunakan `php artisan` untuk membuat file; ikuti konvensi project.
10. Jika ada konflik antara dokumen ini dan permintaan terbaru user, **permintaan terbaru user menang**, lalu perbarui dokumen ini.
11. **Setiap batch selesai wajib dicatat** di bagian 8 (Log Batch) sebelum melanjutkan batch berikutnya.

---

## 15. Referensi Cepat Perintah

```bash
# migration & model
php artisan make:model Tour -mf
php artisan make:model Booking -mf
php artisan make:request StoreBookingRequest
php artisan make:middleware EnsureUserIsAdmin
php artisan make:mail BookingReceived

# database
php artisan migrate
php artisan migrate:fresh --seed

# storage
# Tidak memakai storage:link (shared hosting).
# Pastikan folder public/uploads writable.

# test & format
php artisan test --compact
vendor/bin/pint --dirty --format agent

# frontend
npm run build

# boost
php artisan boost:update
```

---

*Dokumen ini adalah sumber kebenaran untuk eksekusi backend. Perbarui bagian 7 dan 8 setiap kali batch selesai.*
