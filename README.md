# Menjalankan aplikasi web

Clone repository ini, kemudian checkout ke branch yang diinginkan (check di github untuk melihat daftar branch).
Contoh:

Clone

```
git clone git@github.com:des-learning/21si2-pemrograman-web-2.git
```

Checkout ke branch yang diinginkan:

```
 git checkout 05-using-breeze-starter-kit # sesuaikan dengan nama branch yang diingikan
```

Kemudian jalankan langkah-langkah berikut:

1. Jika konfigurasi belum ada (file `.env`), copy file `.env.example` ke `.env`, lakukan perubahan jika diperlukan
   terutama untuk konfigurasi DB. Contoh untuk konfigurasi DB menggunakan sqlite.

```
DB_CONNECTION=sqlite
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=/tmp/21si2-pemrograman-web-2/database/db.sqlite # sesuaikan dengan lokasi file database (path absolute)
DB_USERNAME=root
DB_PASSWORD=
DB_FOREIGN_KEYS=true
```

2. Install dependency, `composer install` dan `npm install`

3. Jalankan migration, `php artisan migrate` pada step ini seharusnya database sudah selesai dikonfigurasi

4. Jalankan `php artisan key:generate` untuk mengenerate secret key aplikasi Laravel

5. Jalankan `php artisan serve` untuk menghidupkan server web untuk meng-serve aplikasi Laravel

6. Buka satu terminal baru, jalankan `npm run dev` untuk menjalankan tools npm untuk melakukan _post processing_ selama
   proses development (ini supaya CSS dan JS akan digenerate ulang setiap kita melakukan perubahan).

7. Dari browser buka `http://localhost:8000` atau `http://127.0.0.1:8000` untuk mengakses aplikasi Laravel

# Form Request Validation

Selain mendefinisikan rule validasi pada controller langsung, kita bisa membuat request Validation.

Request validation digunakan untuk melakukan validasi yang lebih kompleks supaya logic di controller
lebih rapi, singkat dan jelas. Ini membantu developer ketika membaca code controller.

Selain itu request validator juga dapat di-_reuse_ sehingga jika ada validasi yang sama yang perlu
dilakukan pada controller yang berbeda cukup dengan me-refer ke request validation yang telah dibuat.

Membuat request validation

```shell
php artisan make:request CreateBarangRequest
```

Laravel akan membuat file baru di `app/Http/Requests/CreateBarangRequest.php`.

Baca dokumentasi di `https://laravel.com/docs/10.x/validation#form-request-validation`.

# Breeze Starter Kit

Kita akan menggunakan [starter kit Laravel](https://laravel.com/docs/10.x/starter-kits) untuk mempercepat proses development.
Starter kit merupakan library/framework tambahan di atas Laravel yang berisikan template,
view, helper, model, migration, controller dan lain-lain yang dapat membantu proses development.

Starter kit yang akan kita gunakan adalah [Laravel Breeze](https://laravel.com/docs/10.x/starter-kits#laravel-breeze).
Breeze menyediakan fungsi authentication dan halaman profile tanpa harus diimplementasikan lagi secara manual.

Catatan ketika menginstall Breeze pada project Laravel existing seluruh changes pada routing akan di-_overwrite_ oleh Breeze.
Simpan dulu file routing ke lokasi lain atau salin code dari routing untuk kemudian di-_paste_ kembali setelah Breeze selesai
dipasang.

Ikuti langkah di `https://laravel.com/docs/10.x/starter-kits#laravel-breeze-installation` untuk menginstall Breeze.

Breeze menyediakan beberapa integrasi untuk mengembangkan aplikasi web khususnya untuk pengembangan di-sisi
_frontend_.

1. Blade with Alpine
   Menggunakan template engine Blade dan [Alpine.js](https://alpinejs.dev/) untuk frontend.

2. Livewire (Volt class API) with Alpine
   Menggunakan [Livewire](https://laravel-livewire.com/) dan [Alpine.js](https://alpinejs.dev/) untuk tampilan frontend.
   Integrasi ini menggunakan [Volt class API](https://livewire.laravel.com/docs/volt#class-based-volt-components)
   untuk implementasi component.

3. Livewire (Volt functional API) with Alpine
   Menggunakan [Livewire](https://laravel-livewire.com/) dan [Alpine.js](https://alpinejs.dev/) untuk tampilan frontend.
   Integrasi ini menggunakan [Volt functional API](https://livewire.laravel.com/docs/volt#class-based-volt-components)
   untuk implementasi component.

4. React with Inertia
   Menggunakan framework [React](https://react.dev/) dan [inertiajs](https://inertiajs.com/) untuk tampilan frontend.

5. Vue with Inertia
   Menggunakan framework [Vue](https://vuejs.org/) dan [inertiajs](https://inertiajs.com/) untuk tampilan frontend.

6. API only
   Hanya menyediakan endpoint API untuk digunakan oleh aplikasi web dari project terpisah.

Untuk aplikasi frontend biasanya dibutuhkan HTML, CSS dan Javascript. Ada beberapa framework yang dikhususkan untuk
pengembangan aplikasi frontend seperti React dan Vue. Dengan menggunakan framework ini kita akan membutuhkan code
PHP untuk logic di backend dan code Javascript untuk logic di frontend.

Untuk memudahkan pengembangan, Laravel menyediakan `Livewire` untuk development frontend dengan menggunakan code
Javascript seminimal mungkin. Kita akan gunakan Livewire dengan Volt class API (pilihan no. 2).

## Authentication routes

Breeze meng-registrasi beberapa route yang berhubungan dengan authentication:

```sh
php artisan route:list

  GET|HEAD   / ..........................................................................................................................................................................................................................................................................
  POST       _ignition/execute-solution ................................................................................................................................................................... ignition.executeSolution › Spatie\LaravelIgnition › ExecuteSolutionController
  GET|HEAD   _ignition/health-check ............................................................................................................................................................................... ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckController
  POST       _ignition/update-config ............................................................................................................................................................................ ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfigController
  GET|HEAD   api/user ...................................................................................................................................................................................................................................................................
  GET|HEAD   confirm-password .......................................................................................................................................................................................................................................... password.confirm
  GET|HEAD   dashboard ........................................................................................................................................................................................................................................................ dashboard
  GET|HEAD   forgot-password ........................................................................................................................................................................................................................................... password.request
  GET|HEAD   livewire/livewire.js ........................................................................................................................................................................................... Livewire\Mechanisms › FrontendAssets@returnJavaScriptAsFile
  GET|HEAD   livewire/preview-file/{filename} .................................................................................................................................................................. livewire.preview-file › Livewire\Features › FilePreviewController@handle
  POST       livewire/update ........................................................................................................................................................................................ livewire.update › Livewire\Mechanisms › HandleRequests@handleUpdate
  POST       livewire/upload-file ................................................................................................................................................................................ livewire.upload-file › Livewire\Features › FileUploadController@handle
  GET|HEAD   login ................................................................................................................................................................................................................................................................ login
  GET|HEAD   profile ............................................................................................................................................................................................................................................................ profile
  GET|HEAD   register .......................................................................................................................................................................................................................................................... register
  GET|HEAD   reset-password/{token} ...................................................................................................................................................................................................................................... password.reset
  GET|HEAD   sanctum/csrf-cookie ...................................................................................................................................................................................... sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show
  GET|HEAD   verify-email ........................................................................................................................................................................................................................................... verification.notice
  GET|HEAD   verify-email/{id}/{hash} .................................................................................................................................................................................................. verification.verify › Auth\VerifyEmailController
```

Halaman register, login, reset & forgot password, profile dan dashboard disediakan oleh package Breeze.

Perubahan pada routes:

1. `routes/api.php` - menambahkan api untuk integrasi dengan Laravel Sanctum untuk menyediakan API terkait user
2. `routes/web.php` - meng-register beberapa endpoint terkait dashboard dan profile, serta meng-registrasi route `auth.php`
3. `routes/auth.php` - berisikan routing untuk fitur-fitur terkait authentication seperti registrasi, login, dll.

Jika ingin men-_disable_ fitur terkait authentication, ubah pada `routes/auth.php`, misalnya untuk men-_disable_
register user.

# Frontend Application

Pengembangan pada sisi _frontend_ dilakukan dengan menggunakan HTML, CSS dan Javascript. Breeze menyediakan
beberapa tools yang digunakan untuk pengembangan _frontend_.

1. [Livewire](https://laravel-livewire.com/)
   Fullstack framework untuk menghubungkan logic di sisi backend dan logic di sisi frontend. Livewire mirip dengan React/Vue.

2. [AlpineJs](https://alpinejs.dev/)
   Framework Javascript untuk meng-compose logic langsung pada HTML markup. AlpineJs digunakan oleh Livewire untuk melakukan
   binding dan proses lainnya.

3. [Tailwind](https://tailwindcss.com/)
   Framework CSS untuk men-style tampilan web.

4. [Vite](https://vitejs.dev/)
   Frontend tooling, digunakan sebagai build tool memproses Javascript dan CSS untuk kemudian di serve oleh Laravel sebagai response.

Untuk bisa menjalankan tools frontend ini, kita membutuhkan:

1. [NodeJS](https://nodejs.org/en)
   Javascript environment untuk menjalankan script Javascript pada server (vs dijalankan di sisi client/browser).

2. [NPM](https://www.npmjs.com/)
   Package manager untuk NodeJS, digunakan untuk memasang dependency Javascript (mirip dengan Composer untuk PHP).

Menjalankan server frontend development: `npm run dev`.
Untuk mendeploy aplikasi frontend di-production, `run run build`.

# Component Based UI

Kita akan menggunakan component Blade untuk membangun dan me-reuse tampilan UI.
Baca `https://laravel.com/docs/10.x/blade#components` dan `https://laravel.com/docs/10.x/blade#building-layouts`.

Aplikasi web yang kita bangun akan dibungkus pada component `BaseApp` yang mendefinisikan Tag HTML, CSS dan Javascript
yang dibutuhkan oleh seluruh halaman web di aplikasi kita.

`php artisan make:component BaseApp`

Perintah ini akan membentuk 2 file, `app/View/Components/BaseApp.php` dan `resources/views/components/base-app.balde.php`.

`app/View/Component/BaseApp.php` adalah Component yang akan merender view dan `resources/views/components/base-app.php` adalah
template Blade yang akan dirender.

Ubah `resources/views/components/base-app.php` untuk mendefinisikan tampilan UI yang akan digunakan oleh seluruh halaman lain.

Laravel akan meng-load seluruh component di `app/View/` dan `resources/components`.
Komponen yang dibuat akan bisa digunakan menggunakan tag `<x-base-app>` sesuai dengan format `<x-{nama-komponen-kebab-case}>`

Edit view `resources/views/barang/index.blade.php`, bungkus view kita dengan `<x-base-app>`.
Jangan lupa untuk mengupdate `routes/web.php` yang telah di-_overwrite_ oleh Breeze.

Supaya script Javascript dan CSS dibuild setiap kita melukan perubahan di-view, jalankan `npm run dev`.

# Laravel Queue

Dokumentasi di [Laravel Queue](https://laravel.com/docs/10.x/queues). Digunakan untuk menjalankan proses yang membutuhkan waktu lama
untuk mengurangi waktu response (misalnya, mengirimkan email).

Laravel queue memiliki beberapa pilihan connection untuk menyimpan Job yang akan dijalankan:

1. database
2. Redis
3. Amazon SQS
4. Beanstalkd

## Database connection

Menggunakan database untuk menyimpan dan sebagai queue untuk menampung job yang akan dijalankan.

1. Lakukan migrasi database untuk membentuk struktur table job

```sh
php artisan make:queue-table
php artisan migrate
```

2. Buat class job untuk mendefinisikan payload dan handler untuk menjalankan job

```sh
php artisan make:job BarangProcessor
```

Akan terbentuk sebuah file di `/app/Jobs/BarangProcessor.php`. Isikan payload
sebagai parameter di `__construct` dan definisikan proses untuk meng-_consume_ Job
di method `handle`.

3. Publish job dengan menggunakan static method `dispatch`.

    ```php
    BarangProcessor::dispatch($barang->id);
    ```
