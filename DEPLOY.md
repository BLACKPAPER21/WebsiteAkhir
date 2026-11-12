# Deploy: Neon Postgres + Vercel

Aplikasi: Laravel 12 (PHP 8.3), database PostgreSQL di Neon, hosting Vercel (serverless).

- Produksi: <https://demplane.vercel.app>
- Repo: <https://github.com/BLACKPAPER21/WebsiteAkhir>
- Database: Neon `ep-red-shadow-bdyza6iy` (us-east-2)

## Arsitektur

| Bagian | Lokasi |
|---|---|
| Entrypoint serverless | `api/index.php` |
| Konfigurasi Vercel | `vercel.json` |
| Asset statis | `public/` → di-build ke `dist/` saat deploy |
| Upload user | `storage/app/public` (lihat batasan di bawah) |

`api/index.php` memindahkan `storage_path()` ke `/tmp/demplane-storage` karena filesystem Lambda read-only.
Cache manifest Laravel (`APP_*_CACHE`) juga diarahkan ke `/tmp`; kalau tidak, Laravel gagal menulis
`bootstrap/cache/packages.php` dan seluruh request jadi HTTP 500.

## Koneksi database

Ambil connection string dari Neon Console (tombol **Connect**).

- Migrasi & seeding dijalankan lewat **endpoint direct** (`ep-...neon.tech`, tanpa `-pooler`),
  karena DDL di dalam transaksi sempat gagal di pooler.
- Runtime aplikasi memakai **pooler** (`ep-...-pooler...`), aman untuk koneksi serverless.

Variabel yang dipakai:

```
DB_CONNECTION=pgsql
DB_URL="postgresql://USER:PASSWORD@HOST/neondb?sslmode=require"
```

Perintah migrasi dari mesin lokal (butuh ekstensi `pdo_pgsql` di `php.ini`):

```bash
php artisan migrate --force
php artisan db:seed --force
```

## Variabel lingkungan di Vercel

Set di **Project → Settings → Environment Variables** (production, preview, development):

| Key | Nilai |
|---|---|
| `APP_NAME` | `Demplane` |
| `APP_ENV` | `production` |
| `APP_DEBUG` | `false` |
| `APP_KEY` | `php artisan key:generate --show` |
| `APP_URL` | `https://demplane.vercel.app` |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | connection string Neon (pooler) |
| `LOG_CHANNEL` | `stderr` |
| `LOG_LEVEL` | `error` |
| `SESSION_DRIVER` | `database` |
| `CACHE_STORE` | `database` |
| `QUEUE_CONNECTION` | `database` |
| `FILESYSTEM_DISK` | `local` |
| `APP_STORAGE_PATH` | `/tmp/demplane-storage` |
| `VIEW_COMPILED_PATH` | `/tmp/demplane-storage/framework/views` |
| `APP_CONFIG_CACHE` | `/tmp/demplane-storage/cache/config.php` |
| `APP_EVENTS_CACHE` | `/tmp/demplane-storage/cache/events.php` |
| `APP_PACKAGES_CACHE` | `/tmp/demplane-storage/cache/packages.php` |
| `APP_ROUTES_CACHE` | `/tmp/demplane-storage/cache/routes.php` |
| `APP_SERVICES_CACHE` | `/tmp/demplane-storage/cache/services.php` |

Deploy manual:

```bash
vercel deploy --prod
```

## Akun seed

| Email | Password | Role |
|---|---|---|
| `admin@demplane.com` | `password` | admin |
| `seller@example.com` | `password` | user |
| `buyer@example.com` | `password` | user |

Ganti password ini sebelum dipakai publik.

## Batasan Vercel (serverless)

1. **Upload file hilang.** `storage/` diarahkan ke `/tmp` yang bersifat sementara dan per-instance.
   Foto produk / dokumen KTP yang diunggah lewat `/admin/products` dan `/partner/register`
   tidak bertahan. Untuk produksi, pindahkan disk ke object storage (S3/R2/Vercel Blob) lalu set
   `FILESYSTEM_DISK=s3` + kredensialnya.
2. **Tanpa queue worker.** `QUEUE_CONNECTION=database` hanya menyimpan job; jalankan worker
   di host terpisah kalau butuh antrian.
3. **Log ke stderr** (`LOG_CHANNEL=stderr`) — lihat di Vercel → Deployment → Logs.
4. Request dengan ekstensi file (mis. `/composer.json`) dilayani route fallback Laravel,
   bukan sebagai file statis. File di luar `public/` tidak pernah bisa diakses langsung.
