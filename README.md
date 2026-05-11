# Project CLO 2: Pengamanan Aplikasi Web 🔒

Repositori ini berisi dokumentasi dan kode program untuk Project CLO 2 Mata Kuliah Keamanan Sistem.

- **Nama:** Yuhsinu Syahbani Putra
- **NIM:** 101032300174
- **Kelas:** TK-47-01

## 🛠️ Fitur Keamanan yang Diterapkan:
1. **Infrastruktur:** Peladen lokal menggunakan VM Ubuntu Linux dengan IP Statis (`192.168.88.174`).
2. **Jalur Komunikasi:** Enkripsi protokol HTTPS menggunakan sertifikat OpenSSL *Self-Signed* (RSA 2048-bit).
3. **Keamanan Basis Data:** Kriptografi kata sandi menggunakan kombinasi **SHA-256** dan **Salting Dinamis** (teks `'jujusplik'`).
4. **Mitigasi Serangan:**
   - **SQL Injection:** Menerapkan *Prepared Statements* (`bind_param`) pada ekstensi `mysqli`.
   - **Buffer Overflow:** Pertahanan ganda menggunakan validasi `maxlength` di sisi peramban dan `strlen()` di sisi peladen.
   - **Spam Resubmit:** Menerapkan pola *Post/Redirect/Get* (PRG) untuk mencegah pengiriman data ganda saat halaman dimuat ulang.
