# Efilo Backend
Program backend untuk kost efilo, sebagai tugas sim.
Semua kontrol program ada di cmd.

## Road Map
* ✅ Auth
* ✅ Post
* ❌ Bill
* ✅ Complaint
* ✅ Report
* ✅ Room
* ❌ User

## Tutorial
Beberapa tutorial yang bermanfaat

### Download semua dependensi yang dibutuhkan
> composer install

### Migrate database
Pastikan sudah setting database di .env
> php artisan migrate

### Membuat disk storage
> php artisan storage:link

### Membuat user admin
> php artisan efilo:admin
