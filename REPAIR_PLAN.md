# Repair & Testing Plan — Kunam Birding Tours

> **Status:** R-01 & R-02 selesai; R-03–R-06 menunggu persetujuan (plan disusun).
> **Update terakhir:** 15 November 2026
> **File terkait:** `BACKEND_PLAN.md` (riwayat implementasi Batch 1–5)

## 1. Tujuan

Dokumen ini mencatat temuan dari pengujian end-to-end, rencana perbaikan, dan bukti penyelesaian. Implementasi baru dilakukan setelah plan disetujui.

## 2. Ruang Lingkup

| Area | Cakupan |
|---|---|
| Publik | `/`, `/tours`, `/custom-tours`, `/tour-reports`, `/leaders`, `/booking`, `/contact`, `/terms` |
| Form | Booking + contact: validasi, persist, email, honeypot, throttle |
| Admin | Login, dashboard, CRUD konten, settings, inbox bookings/contact, export CSV |
| SEO | Meta title/description, canonical, Open Graph, sitemap, robots, alias 301 |
| Data | Seeder, upload `public/uploads`, soft delete, status enum |
| Responsif | Tampilan desktop & mobile halaman utama dan admin |

**Di luar scope:** deployment produksi/MySQL, konfigurasi server, dan hal-hal di Batch 6.

## 3. Aturan Perbaikan

1. Jangan mengubah desain (warna, bentuk, layout, class visual) atau copy editorial frontend publik kecuali diminta. Teks yang merepresentasikan data — mis. jumlah departure, tahun tour — wajib mengikuti database melalui perhitungan, dan perubahan teks tersebut **bukan** perubahan desain/copy.
2. Perbaikan bersifat minimal dan terarah pada temuan.
3. Setiap perbaikan wajib disertai test bila menyentuh logika.
4. Full suite + Pint harus tetap hijau setelah perbaikan.
5. Tidak menambah dependency baru tanpa persetujuan.
6. Tidak commit kecuali diminta.

## 4. Format Pencatatan Temuan

| ID | Area | Severity | Ringkasan | Status |
|---|---|---|---|---|
| R-01 | Publik / Tours | P1 | Tahun & tab tours masih hardcode | ✅ Selesai |
| R-02 | Publik / Tours | P2 | Badge departure masih angka statis | ✅ Selesai |
| R-03 | Admin / Branding | P2 | Logo admin panel masih placeholder "BA" | ✅ Selesai |
| R-04 | Admin / Dashboard | P1 | Dashboard masih placeholder, belum ada data/chart | ✅ Selesai |
| R-05 | Admin / Navigasi | P2 | Sidebar hanya 2 kelompok | ✅ Selesai |
| R-06 | Admin / Settings | P1 | Settings masih card per grup | ✅ Selesai |

**Severity:**
- **P0** — fitur inti rusak / data hilang / error 500
- **P1** — alur utama terganggu, ada workaround
- **P2** — masalah tampilan/konten minor
- **P3** — saran peningkatan

---

## 5. Detail Temuan & Rencana

### R-01 — Tahun tours masih hardcode di halaman `/tours`

**Severity:** P1 (fitur berjalan sekarang, tapi menuntut edit kode setiap ada tahun baru)
**Status:** ✅ Selesai — 15 November 2026

#### Kondisi saat ini

| Lokasi | Hardcode |
|---|---|
| `app/Http/Controllers/LandingPage/TourController.php:37-44` | Query dibagi manual ke `$tours2027`, `$tours2028`, `$toursFuture` (>= 2029) |
| `resources/views/landing_page/tours.blade.php:46-50` | Tombol navigasi `2027 tours`, `2028 tours`, `Future tours` |
| `resources/views/landing_page/tours.blade.php:57-111` | Blok section 2027 & 2028 diduplikasi, termasuk badge `29 Departures` / `26 Departures` |
| `resources/views/landing_page/tours.blade.php:113-138` | Blok "Future" memakai id `2029-tours` dan heading "Beyond 2028 (2029 available Dec 2026)" |

Dampak: menambah tour tahun 2030 (atau tahun lain) tidak otomatis menambah tombol/tab; anchor future juga menyesatkan karena selalu `#2029-tours`.

#### Perilaku yang diharapkan

1. Tombol navigasi dan section dibuat dari **distinct `year` tour published** di database, urut naik.
2. Tahun dalam window kalender terdekat tampil sebagai tab sendiri: `#{{ year }}-tours`.
3. Tahun di luar window dikelompokkan dalam satu tab **Future tours** dengan anchor stabil `#future-tours` (bukan lagi `#2029-tours`).
4. Tombol dan section Future otomatis hilang bila tidak ada tour future.
5. Tour draft/soft-deleted tetap tidak muncul.
6. Menambah tahun baru tidak perlu mengubah kode.

#### Rekomendasi teknis (default)

- **Window kalender:** `now()->year + 2`.
  - Hari ini (2026): 2027 & 2028 menjadi tab tahunan; 2029+ masuk Future — sama persis dengan tampilan sekarang.
  - Tahun 2027: 2029 otomatis naik menjadi tab tahunan; 2030+ tetap Future.
- **Controller** mengirim tiga variabel:
  - `$calendarGroups` — `Collection<int, Collection<Tour>>` per tahun dalam window.
  - `$futureTours` — tour tahun di luar window, sudah diurutkan.
  - `$lastCalendarYear` — untuk heading Future.
- **View** mengganti tiga blok duplikat dengan satu loop + partial kartu tour.
- **Badge jumlah departure:** copy `29 Departures`/`26 Departures` dipertahankan untuk 2027/2028 (mapping kecil), tahun lain tanpa badge — agar copy visual tidak berubah. Catatan: angka ini memang tidak sama dengan jumlah baris DB (keputusan Batch 3B). **Direvisi R-02 (15 Nov 2026):** badge kini memakai hitungan tour published per tahun dari DB — lihat R-02.
- **Heading Future:** `Beyond {{ $lastCalendarYear }}` (parenthetical "2029 available Dec 2026" dihapus karena tidak bisa diturunkan dari data). Jika copy itu wajib persis, alternatifnya jadikan setting `tours_future_heading`.
- **Partial baru:** `resources/views/landing_page/partials/tour-card.blade.php` untuk menghilangkan duplikasi markup kartu (class & tampilan identik).

#### Alternatif yang dipertimbangkan

- **Semua tahun jadi tab sendiri, tanpa grup Future.** Paling literal dan tanpa cutoff waktu, tetapi menghilangkan UX "Future tours" yang sekarang ada dan diminta untuk disesuaikan. Tidak dipilih sebagai default.
- **Cutoff dinamis dari data (mis. dua tahun terendah).** Lebih rapuh saat tour lama dihapus. Tidak dipilih.

#### Langkah implementasi

1. Ubah `TourController@tours` untuk membangun `$calendarGroups`, `$futureTours`, dan `$lastCalendarYear` dari satu query `published()->ordered()`.
2. Buat partial `tour-card.blade.php` dari markup kartu yang sekarang (tanpa perubahan class/style).
3. Ganti tombol navigasi hardcode dengan loop `$calendarGroups` + tombol Future kondisional.
4. Ganti tiga blok section dengan loop `$calendarGroups` + satu section `#future-tours` kondisional.
5. ~~Pertahankan badge 2027/2028 lewat mapping; tahun lain tidak menampilkan badge.~~ **Direvisi R-02:** badge memakai hitungan DB.
6. Tambah test dinamis (lihat di bawah).
7. Verifikasi visual desktop/mobile dan anchor `#2027-tours`, `#2028-tours`, `#future-tours`.

#### File yang akan diubah

| File | Perubahan |
|---|---|
| `app/Http/Controllers/LandingPage/TourController.php` | Grouping tahun + window Future |
| `resources/views/landing_page/tours.blade.php` | Nav & section dinamis, Future `#future-tours` |
| `resources/views/landing_page/partials/tour-card.blade.php` | **Baru** — partial kartu tour |
| `tests/Feature/TourTest.php` | Test tahun dinamis, Future, dan data draft |
| `REPAIR_PLAN.md` | Update status setelah implementasi |

#### Rencana test

- Tahun 2027/2028/2029 seeded tetap tampil pada tab yang benar (2029 masuk Future pada 2026).
- Tambah tour tahun `now()->year + 3` → muncul di section Future tanpa ubah kode.
- Tambah tour tahun `now()->year + 1` → otomatis muncul sebagai tombol/section tahun tersebut.
- Hapus semua tour future → tombol & section Future tidak dirender.
- Tour draft tahun baru tidak muncul di nav/section.
- Anchor `#future-tours` ada; `#2029-tours` tidak lagi dipakai untuk grup future.
- Test memakai tahun relatif terhadap `now()` agar tidak rusak saat tahun berganti.

#### Risiko & catatan

- **Copy:** heading Future berubah dari "Beyond 2028 (2029 available Dec 2026)" menjadi "Beyond 2028". Intro paragraf dan meta description masih menyebut "2027 - 2028" dan "2029 tours ... December 2027" — keduanya **tidak** diubah di R-01; akan dicatat sebagai temuan terpisah bila Anda ingin dibuat dinamis.
- **Badge:** ~~angka 29/26 tetap statis sesuai keputusan sebelumnya; bukan bug pada R-01.~~ **Direvisi R-02:** angka mengikuti jumlah tour published per tahun.
- **SEO:** anchor berubah untuk future; canonical halaman tetap `/tours`, tidak ada dampak.

#### Definition of done

- Tidak ada tahun yang di-hardcode untuk struktur nav/section.
- Menambah tour tahun baru hanya lewat admin, tanpa deploy/edit kode.
- Tampilan 2027/2028/Future saat ini tetap sama (kecuali heading Future).
- Full suite + Pint hijau; `view:cache` OK.

#### Hasil implementasi

- `TourController@tours` sekarang mengelompokkan tour published per tahun; cutoff `now()->year + 2`, sisanya masuk `$futureTours`.
- Nav dan section dirender dari `$calendarGroups`; section Future memakai anchor tetap `#future-tours` dan heading `Beyond {lastCalendarYear}`.
- Markup kartu dipindah ke `resources/views/landing_page/partials/tour-card.blade.php` (class tetap sama).
- ~~Badge `29 Departures`/`26 Departures` dipertahankan lewat mapping untuk 2027/2028.~~ **Direvisi R-02:** badge dihitung dari jumlah tour published per tahun.
- Verifikasi Herd (`/tours`): nav 2027/2028/Future, `#future-tours` aktif, `#2029-tours` tidak lagi dipakai.
- Test: 142 test / 777 assertion hijau (termasuk tahun baru dinamis, grup Future, dan Future kosong).
- Pint bersih; `view:cache` OK; `npm run build` OK.

### R-02 — Badge departure masih memakai angka statis

**Severity:** P2 (teks yang merepresentasikan data tidak mengikuti DB)
**Status:** ✅ Selesai — 15 November 2026

#### Kondisi saat ini

- `tours.blade.php` memakai mapping `$departureLabels = [2027 => '29 Departures', 2028 => '26 Departures']`.
- Angka tidak berubah saat tour ditambah/dihapus, dan tahun baru tidak mendapat badge.

#### Perilaku yang diharapkan

1. Badge per tahun = jumlah tour **published** pada tahun tersebut.
2. Pluralisasi otomatis: `1 Departure`, `11 Departures`.
3. Section Future tetap tanpa badge (tidak menambah elemen desain baru).
4. Tour draft/soft-deleted tidak ikut dihitung.

#### Implementasi

- Mapping `$departureLabels` dihapus.
- Badge memakai `$yearTours->count()` + `Str::plural('Departure', $departureCount)`; class `badge bg-success` dan struktur markup tidak berubah.
- File: `resources/views/landing_page/tours.blade.php`, `tests/Feature/TourTest.php`, `BACKEND_PLAN.md`, `REPAIR_PLAN.md`.

#### Test

- Badge 2027/2028 dibandingkan dengan `Tour::published()->where('year', ...)->count()`.
- Menambah 1 tour published 2027 menaikkan badge; tour draft tidak dihitung.
- Tahun dengan tepat 1 tour menampilkan `1 Departure` (bukan `1 Departures`).

#### Hasil verifikasi

- `/tours` menampilkan **11 Departures** (2027) dan **4 Departures** (2028); 2029 di Future tanpa badge.
- Full suite: **144 test / 782 assertion** hijau.
- Pint bersih; `view:cache` OK; `npm run build` OK.

### R-03 — Logo admin panel masih placeholder "BA"

**Severity:** P2 (branding, bukan fungsi)
**Status:** ✅ Selesai — 15 November 2026

#### Kondisi saat ini

- Halaman login **sudah** memakai logo landing (perubahan terakhir).
- `resources/views/admin/layouts/app.blade.php:34` (header mobile) dan `:44` (sidebar) masih memakai kotak hijau **"BA"**.
- URL logo diduplikasi di beberapa file.

#### Rencana

1. Buat komponen bersama `resources/views/components/admin/brand-logo.blade.php`:
   - Prop `class` untuk ukuran (default `h-9`).
   - Prop `framed` untuk menampilkan chip putih (dipakai di background navy).
   - URL logo CDN sama dengan landing page.
2. Pakai komponen di:
   - Login: `framed`, tinggi ±48px.
   - Header mobile admin: tanpa frame (background putih), tinggi ±32px.
   - Sidebar admin: `framed` (background navy), tinggi ±32–36px.
3. Sidebar: logo menggantikan ikon "BA", teks "Birdtour Asia" dihapus karena sudah ada di logo; subtitle "Admin Panel" dipertahankan.
4. Lebar sidebar, warna, dan struktur menu **tidak** diubah.

#### File

| File | Perubahan |
|---|---|
| `resources/views/components/admin/brand-logo.blade.php` | **Baru** — komponen logo |
| `resources/views/admin/layouts/app.blade.php` | Header mobile + sidebar memakai komponen |
| `resources/views/admin/auth/login.blade.php` | Memakai komponen (hapus URL duplikat) |
| `tests/Feature/Admin/AdminPagesSmokeTest.php` | Pastikan halaman admin tetap render |

#### Definition of done

- Tidak ada lagi teks/ikon "BA" di login maupun layout admin.
- Logo tampil jelas di background putih dan navy.
- Tidak ada perubahan layout navigasi.

#### Hasil implementasi

- Komponen `x-admin.brand-logo` dibuat dengan prop `size` (default `h-9`) dan `framed`; URL logo CDN sama dengan landing page.
- Login memakai `h-12` + `framed`; header mobile `h-8` tanpa frame; sidebar `h-9` + `framed` dengan subtitle "Admin Panel".
- Teks "Birdtour Asia" pada sidebar dihapus (sudah ada di logo); tidak ada lagi "BA".
- `tests/Feature/Admin/BrandingTest.php` baru: logo tampil di login & layout admin, "BA" tidak ada.
- Verifikasi Herd: `/admin/login` 200 dengan logo; `/admin` (authenticated) 200 dengan logo.

---

### R-04 — Dashboard masih placeholder

**Severity:** P1 (informasi operasional belum tersedia)
**Status:** ✅ Selesai — 15 November 2026

#### Kondisi saat ini

- `DashboardController` hanya `return view('admin.dashboard')`.
- View menampilkan kartu dengan nilai `—` dan section "Foundation status" yang sudah tidak relevan.

#### Data yang akan ditampilkan

**Stat cards (4):**

| Card | Nilai |
|---|---|
| Tours | jumlah published + total |
| Bookings | total + jumlah pending |
| Messages | total + jumlah status `new` |
| Tour Reports | total |

**Charts:**

| Chart | Tipe | Data |
|---|---|---|
| Tours per year | Bar | jumlah tour published per `year` (2027, 2028, 2029, dst.) |
| Tour status | Pie/donut | `Available` / `Full` / `Provisional` |

**Tabel "New tours" (maks 5):**

- 5 tour terbaru berdasarkan `created_at` (soft-deleted tidak ikut).
- Kolom: Name, Year, Status, Published, Added, aksi Edit.
- Empty state bila belum ada tour.

#### Implementasi

1. `DashboardController` menghitung agregat dengan Eloquent (tanpa N+1):
   - `$stats` — tour published/total, booking total/pending, message total/new, report total.
   - `$toursByYear` — `groupBy('year')` + count, urut tahun.
   - `$tourStatuses` — `groupBy('status')` + count, label dari `TourStatus`.
   - `$newTours` — `Tour::latest()->limit(5)->get()`.
2. `resources/views/admin/dashboard.blade.php`:
   - Page header + 4 stat cards.
   - Grid chart: bar (2/3) + pie (1/3); stack di mobile.
   - Tabel New tours memakai komponen `x-admin.table`.
   - Hapus section "Foundation status".
3. Chart library:
   - **Rekomendasi:** Chart.js 4 via CDN, dimuat hanya di dashboard.
   - Alternatif tanpa dependency: bar + pie dari CSS/SVG murni.
   - Butuh konfirmasi karena aturan proyek melarang dependency baru tanpa persetujuan.
4. Layout admin: tambahkan `@stack('scripts')` sebelum `</body>` agar script dashboard bisa di-push.
5. Data chart dikirim sebagai JSON (`@json`) dan dibaca script inline; tidak ada query tambahan di view.

#### File

| File | Perubahan |
|---|---|
| `app/Http/Controllers/Admin/DashboardController.php` | Agregasi data dashboard |
| `resources/views/admin/dashboard.blade.php` | Stat cards, chart, tabel new tours |
| `resources/views/admin/layouts/app.blade.php` | `@stack('scripts')` |
| `tests/Feature/Admin/DashboardTest.php` | **Baru** — test data & chart |
| `tests/Feature/Admin/AdminPagesSmokeTest.php` | Tambah route dashboard |

#### Rencana test

- Angka stat card sesuai data DB (pakai factory).
- Hanya 5 tour terbaru tampil; tour ke-6 tidak tampil.
- Payload chart memuat tahun dan status yang benar.
- Database kosong tidak menghasilkan error.
- Non-admin tidak bisa mengakses dashboard.

#### Definition of done

- Tidak ada teks "module pending" / nilai `—`.
- Semua angka berasal dari DB.
- Chart tampil di desktop dan mobile.
- Full suite + Pint + `view:cache` + `build` hijau.

#### Hasil implementasi

- `DashboardController@__invoke` menghitung: `stats` (tours published/total, bookings total/pending, messages total/new, tour reports), `toursByYear` (published, urut tahun), `tourStatus` (published, label dari `TourStatus`), `inboxTrend` (6 bulan terakhir, bookings + messages), `newTours`.
- `newTours` = 5 tour terdekat: `start_date` nulls last, lalu `year`, `sort_order`, `name`; kolom Departure memakai `start_date` atau `date_label` sebagai fallback.
- Chart.js 4 dipasang via npm (`chart.js/auto`) dan dimuat **lazy** lewat dynamic import di `resources/js/app.js` hanya saat `#tours-by-year-chart` ada. Chunk terpisah `dashboard-*.js` (±205 KB) tidak membebani halaman lain.
- View dashboard: 4 stat cards, bar "Tours per year", line "Inbox activity", doughnut "Tour status", tabel "New tours" (maks 5) dengan empty state; section "Foundation status" dihapus.
- `@stack('scripts')` ditambahkan ke layout admin.
- `tests/Feature/Admin/DashboardTest.php` baru (6 test): statistik & chart, grouping tahun, 5 tour terdekat, tren inbox, dashboard kosong, non-admin 403.
- Verifikasi Herd: payload chart 2027/2028/2029 = 11/4/1; status published 5/9/2; tabel New tours terisi.

---

### R-05 — Sidebar admin hanya 2 kelompok

**Severity:** P2 (navigasi makin panjang)
**Status:** ✅ Selesai — 15 November 2026

#### Struktur baru

| Kelompok | Menu |
|---|---|
| **Home** | Dashboard |
| **Content** | Tours, Leaders, Tour Reports, Custom Tours, Terms, Products |
| **Site** | Hero Slides, Settings |
| **Inbox** | Bookings, Contact Messages |

- Dashboard tetap paling atas dalam kelompok **Home**.
- Settings dan Hero Slides digabung dalam **Site**.
- Urutan dan label mengikuti tabel di atas.

#### Implementasi

1. Ganti `$navigation` + `$inbox` di layout dengan satu array `$navigationGroups` (label + items).
2. Render satu loop; heading kelompok memakai gaya uppercase yang sekarang.
3. Active state tetap memakai `request()->routeIs(...)`.
4. Mobile drawer, logout, dan layout sidebar tidak berubah.

#### File & test

| File | Perubahan |
|---|---|
| `resources/views/admin/layouts/app.blade.php` | Struktur grup navigasi |
| `tests/Feature/Admin/AdminPagesSmokeTest.php` | Pastikan semua halaman tetap render |
| `tests/Feature/Admin/NavigationGroupTest.php` | **Baru** — label grup + menu aktif |

#### Definition of done

- Empat kelompok tampil sesuai urutan.
- Tidak ada menu yang hilang/duplikat.
- Active state tetap benar di semua halaman.

#### Hasil implementasi

- `$navigation` + `$inbox` diganti satu array `$navigationGroups` (Home, Content, Site, Inbox) dan dirender dengan satu loop; heading memakai gaya uppercase yang sudah ada.
- Dashboard tetap item pertama di kelompok Home; urutan menu lain tidak berubah.
- `tests/Feature/Admin/NavigationGroupTest.php` baru memverifikasi urutan 4 kelompok beserta seluruh itemnya.
- Verifikasi Herd: sidebar `/admin` menampilkan Home/Content/Site/Inbox berurutan.
- **Revisi scroll & akun:** di desktop `body` dikunci (`lg:h-screen lg:overflow-hidden`); sidebar setinggi viewport dengan nav yang scroll sendiri (`min-h-0 overflow-y-auto overscroll-contain scrollbar-none`, scrollbar disembunyikan via utility `scrollbar-none` di `app.css` untuk sidebar maupun kolom konten) dan footer logout `shrink-0` yang tetap di bawah. Konten scroll di kolomnya sendiri (`lg:overflow-y-auto`) dengan header sticky, jadi scroll sidebar dan konten tidak saling memengaruhi.
- Header desktop: nama + avatar menjadi menu `<details data-user-menu>` berisi **Profile** dan **Log out**; `resources/js/admin/user-menu.js` menutup menu saat klik di luar/Escape. Halaman `/admin/profile` (`ProfileController`) mendukung lihat + edit nama/email dan ganti password (wajib password saat ini, konfirmasi, minimal 8 karakter) dengan `ProfileUpdateRequest`.
- Test baru `ProfileTest` (lihat, update nama/email, email unik, ganti password, password lama salah, password dikosongkan, non-admin) dan `HeaderUserMenuTest`; smoke test mencakup route profile.

---

### R-06 — Settings masih card per grup

**Severity:** P1 (halaman panjang, sulit dinavigasi)
**Status:** ✅ Selesai — 15 November 2026

#### Perilaku yang diharapkan

1. `/admin/settings` menampilkan **satu grup aktif** saja, bukan semua card.
2. Di dalam content ada **sub-sidebar** berisi daftar grup setting (bukan di header, bukan collapsible).
3. Setiap item menampilkan nama grup + jumlah setting; grup aktif di-highlight.
4. Default: grup pertama (`general`); grup dipilih lewat `?group=contact`.
5. Mobile: sub-sidebar menjadi daftar horizontal yang bisa di-scroll, tetap bukan collapsible.
6. Save dan delete mempertahankan grup aktif.
7. Tombol **Add setting** berada di header card grup aktif (bukan page header), dan form-nya terkunci ke grup tersebut.

#### Implementasi

**Controller** (`SettingController@index`):

- Terima `Request`, validasi `group` terhadap key yang tersedia.
- Fallback ke grup pertama bila kosong/tidak valid.
- Kirim `$groups` (key, label, count), `$activeGroup`, `$activeSettings`.
- Label map: `general => General`, `contact => Contact`, `bank => Bank Details`, `social => Social`, `home => Home Page`, `seo => SEO`.
- `destroy()` redirect kembali ke grup setting tersebut.

**View** (`admin/settings/index.blade.php`):

- Grid `lg:grid-cols-[220px_minmax(0,1fr)]`.
- Kiri: `<nav>` daftar grup (link + count + active style).
- Kanan: form grup aktif — markup field/textarea/checkbox/delete yang sekarang dipertahankan.
- Delete form hanya dirender untuk setting di grup aktif.
- Empty state bila tidak ada setting.

#### File & test

| File | Perubahan |
|---|---|
| `app/Http/Controllers/Admin/SettingController.php` | Group aktif + redirect |
| `resources/views/admin/settings/index.blade.php` | Sub-sidebar + satu form aktif |
| `tests/Feature/Admin/SettingManagementTest.php` | Test tab/group aktif |
| `tests/Feature/Admin/AdminPagesSmokeTest.php` | Tetap render |

#### Rencana test

- Default menampilkan `general`; setting grup lain tidak tampil.
- `?group=seo` menampilkan setting SEO dan tidak menampilkan general.
- Grup tidak valid fallback ke grup pertama.
- Bulk update redirect membawa `?group=`.
- Delete tetap berada di grup yang sama.
- Test lama `test_admin_can_see_settings_grouped_by_area` tetap lolos (satu-satunya grup → aktif).

#### Definition of done

- Tidak ada semua card tampil sekaligus.
- Sub-sidebar berada di dalam content, bukan header.
- Tidak ada JS collapsible; navigasi memakai link biasa.
- Full suite + Pint + `view:cache` + `build` hijau.

#### Hasil implementasi

- `SettingController@index(Request $request)` mengirim `$groups` (key, label, count), `$activeGroup`, `$activeLabel`, `$activeSettings`; grup tidak valid fallback ke grup pertama.
- View memakai grid `lg:grid-cols-[220px_minmax(0,1fr)]`: sub-sidebar kiri (link + count + active style, horizontal scroll di mobile) dan form grup aktif di kanan; label/field/checkbox/delete dipertahankan.
- `destroy()` mengembalikan ke `?group=` asal; bulk update sudah mengembalikan `?group=`. Delete form hanya dirender untuk grup aktif.
- **Revisi:** tombol "Add setting" dipindah dari page header ke header card grup aktif (`settings.create?group=...`); form create memakai input `group` tersembunyi sehingga key baru selalu masuk ke grup yang sedang dibuka, dan `store()` kembali ke tab grup tersebut. Grup tidak valid atau kosong fallback ke grup pertama.
- `tests/Feature/Admin/SettingManagementTest.php`: tambah test grup aktif (default general, `?group=seo`, fallback grup tidak valid), create form ter-scope grup, tombol add ter-scope grup, dan delete mempertahankan grup.
- Verifikasi Herd: `/admin/settings?group=seo` hanya menampilkan setting SEO (17) dengan sub-sidebar 6 grup; total setting tetap 57.

---

## 6. Temuan Lain

| Area | Catatan | Tindakan |
|---|---|---|
| Home | Menurut pengujian user masih aman | Tidak ada |
| Intro `/tours` | Masih menyebut "2027 - 2028" dan "Our 2029 tours ... December 2027" | Menunggu keputusan user |
| Meta `/tours` | Description menyebut 2027/2028 | Menunggu keputusan user |
| Custom tours | `CustomTourSeeder` diisi 3 dummy (Sulawesi, Western Himalaya, Taiwan) | ✅ Selesai |

## 7. Keputusan yang Perlu Dikonfirmasi

1. ✅ Cutoff Future memakai `now()->year + 2`.
2. ✅ Heading Future memakai "Beyond {tahun}".
3. ⏳ Intro paragraf & meta description `/tours` dibuat dinamis — ditunda atas permintaan user.

R-01 dan R-02 selesai. Poin 3 dapat dikerjakan sebagai temuan lanjutan bila diperlukan.

## 8. Keputusan R-03–R-06 (dikonfirmasi)

1. **Chart library (R-04):** ✅ **Chart.js 4 via npm** (disetujui user; dimuat lazy hanya di dashboard).
2. **Bar chart (R-04):** ✅ Gabungan — jumlah tour published per tahun **dan** tren booking/pesan 6 bulan terakhir.
3. **Pie chart (R-04):** ✅ Distribusi status tour (`Available` / `Full` / `Provisional`).
4. **New tours (R-04):** ✅ 5 tour terdekat berdasarkan `start_date` (nulls last, fallback tahun/urutan).
5. **Kelompok sidebar (R-05):** ✅ Home / Content / Site / Inbox.
6. **Tab default Settings (R-06):** ✅ Grup `general`, dipilih lewat `?group=`.

Urutan implementasi yang dijalankan: **R-03 → R-05 → R-06 → R-04**.

## 9. Verifikasi Akhir R-03–R-06

- Full suite: **168 test / 878 assertion** hijau.
- Pint bersih; `php artisan view:cache` OK; `npm run build` OK.
- Verifikasi Herd: `/admin/login`, `/admin`, `/admin/profile`, dan `/admin/settings?group=seo` merespons 200 dengan logo, 4 kelompok sidebar, chart payload, sub-sidebar settings, serta menu akun (Profile + Log out) yang benar.

