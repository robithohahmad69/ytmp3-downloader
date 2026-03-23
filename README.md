# 🎵 YouTube MP3 Downloader (Laravel + yt-dlp)

Aplikasi web sederhana untuk:

* 🔍 Mencari lagu dari YouTube
* 🎧 Menampilkan hasil pencarian (seperti YouTube)
* ⬇️ Download 1 lagu (MP3) dari video
* 📝 Auto rename sesuai judul video

---

## 🚀 Fitur Utama

* Search video YouTube (relevan seperti YouTube)
* Download hanya **1 lagu (no playlist)**
* Convert otomatis ke **MP3**
* Nama file sesuai **judul video**
* Anti error:

  * ❌ HTTP 429 (Too Many Requests)
  * ❌ Bot detection
  * ❌ Format tidak tersedia

---

## 🛠️ Teknologi

* Laravel 10 / 11 / 12 / 13
* PHP 8+
* yt-dlp
* FFmpeg
* Node.js (untuk bypass proteksi YouTube)

---

## ⚙️ Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/username/repo-name.git
cd repo-name
```

---

### 2. Install Dependency Laravel

```bash
composer install
cp .env.example .env
php artisan key:generate
```

---

### 3. Install yt-dlp

Download:
https://github.com/yt-dlp/yt-dlp/releases

Contoh path:

```
C:\Program Files (x86)\yt-dlp\yt-dlp.exe
```

---

### 4. Install FFmpeg

Download:
https://ffmpeg.org/download.html

Contoh path:

```
C:\Program Files (x86)\ffmpeg\bin\ffmpeg.exe
```

---

### 5. Install Node.js (WAJIB)

Download:
https://nodejs.org

Cek:

```bash
node -v
```

---

## 📁 Struktur Folder Download

File hasil download akan disimpan di:

```
storage/app/public/downloads
```

---

## 🔥 Konfigurasi Controller

Pastikan path sesuai di controller:

```php
$ytDlpPath  = '"C:\Program Files (x86)\yt-dlp\yt-dlp.exe"';
$ffmpegPath = '"C:\Program Files (x86)\ffmpeg\bin"';
```

---

## ⚡ Command yt-dlp yang Digunakan

```bash
yt-dlp --no-playlist -x --audio-format mp3 \
--audio-quality 192K \
--ffmpeg-location "C:\Program Files (x86)\ffmpeg\bin" \
--js-runtimes node \
--extractor-args "youtube:player_client=web" \
--sleep-interval 3 \
--max-sleep-interval 6 \
--user-agent "Mozilla/5.0" \
-o "%(title)s.%(ext)s" \
<URL>
```

---

## 🧪 Testing (WAJIB)

Test dulu di CMD:

```bash
"C:\Program Files (x86)\yt-dlp\yt-dlp.exe" -x --audio-format mp3 https://www.youtube.com/watch?v=xxxx
```

Kalau ini berhasil → Laravel pasti berhasil ✅

---

## ❗ Troubleshooting

### ⚠️ 1. Error 429 (Too Many Requests)

Solusi:

* Gunakan `--sleep-interval`
* Tambahkan `--user-agent`
* Tunggu beberapa menit

---

### ⚠️ 2. Tidak bisa download

Cek:

* path yt-dlp benar
* path ffmpeg benar
* `exec()` tidak di-disable di php.ini

---

### ⚠️ 3. Nama file jadi `(title)s`

Solusi:

* jangan pakai `escapeshellarg()` di output

---

### ⚠️ 4. Download banyak file

Solusi:

* gunakan:

```
--no-playlist
```

---

## 📌 Catatan Penting

* Aplikasi ini hanya untuk **pembelajaran**
* Jangan gunakan untuk pelanggaran hak cipta
* Gunakan secara bijak

---

## 💡 Roadmap (Next Feature)

* Progress bar download
* Queue system (anti 429)
* Multi download
* UI seperti YouTube converter

---




---

## ⭐ Support

Kalau project ini membantu:

* ⭐ Star repo
* 🍴 Fork
* 🧠 Improve

---

🔥 Selamat ngoding & semoga lancar download tanpa error!
