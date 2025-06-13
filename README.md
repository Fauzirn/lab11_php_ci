# Praktikum PHP CodeIgniter 4

## Praktikum 1: PHP Framework (Codeigniter)


### Langkah - langkah Praktikum
#### A. Persiapan
    Untuk memulai dengan CodeIgniter4 perlu konfigurasi beberapa ekstensi PHP seperti berikut:
    1. php-json ekstension untuk bekerja dengan JSON;
    2. php-mysqlnd native driver untuk MySQL;
    3. php-xml ekstension untuk bekerja dengan XML;
    4. php-intl ekstensi untuk membuat aplikasi multibahasa;
    5. libcurl (opsional), jika ingin pakai Curl.
Buka XAMPP, lalu pada bagian Apache klik **Config**, pilih **PHP.ini**. Untuk mengaktifkan konfigurasi hilangkan tanda **;** pada setiap eksitensi yang diaktifkan.

![Screenshot Konfigurasi PHP.ini](praktikum1/Screenshoot/ci19.png)

#### B. Instal CodeIgniter4
![Screenshot Instalisasi CI4](praktikum1/Screenshoot/ci21.png)

#### C. Menjalankan CLI (Command Line Interface)
Buka cmd/terminal, lalu arahkan pada direktori projek yang dibuat. Jalankan perintah untuk memanggil CLI Codeigniter:
```php
    php spark
```
![Screenshot CLI Codeigniter](praktikum1/Screenshoot/ci2.png)

#### D. Mengaktifkan Mode Debugging
Mengubah nama file **env** menjadi **.env**, selanjutnya buka file tersebut dan ubah nilai **CI_ENVIRONTMENT** menjadi **development**, dan hilangkan tanda **#**.
![Screenshot Mode Debbuging](praktikum1/Screenshoot/ci5.png)

Berikut setelah mengaktifkan Mode Debugging, maka akan menampilkan pesan error.
![Screenshot Parse Error](praktikum1/Screenshoot/ci4.png)

#### E. Membuat Route Baru
Menambahkan kode berikut ini di file **Routes.php**
```php
    $routes->get('/', 'Home::index');
    $routes->get('/about', 'Page::about');
    $routes->get('/contact', 'Page::contact');
    $routes->get('/faqs', 'Page::faqs');
```

Cek Route yang ditambahkan, dan jalankan perintah berikut :
```php
    php spark routes
```
![Screenshot Route Baru](praktikum1/Screenshoot/ci8.png)

Untuk dapat mengakses, aktifkan dulu **localhost:8080** dengan menjalankan perintah berikut:
```php
    php spark serve
```
![Screenshot Localhost](praktikum1/Screenshoot/ci22.png)

Lakukan akses route yang telah dibuat dengan mengakses alamat url
**http://localhost:8080/about**
![Screenshot Route About](praktikum1/Screenshoot/ci9.png)

#### F. Membuat Controller
Buat file baru dengan nama **page.php** pada
direktori Controller kemudian isi kodenya seperti berikut.
```php
    <?php
    namespace App\Controllers;
    class Page extends BaseController
    {
        public function about()

        {
            echo "Ini halaman About";
        }
            public function contact()
        {
            echo "Ini halaman Contact";
        }
            public function faqs()
        {
        echo "Ini halaman FAQ";
        }
    }
```

Maka akan menampilkan hasil halaman yang sudah dapat diakses.
![Screenshot Controller](praktikum1/Screenshoot/ci11.png)

#### G. Auto Routing
Untuk mengubah status autoroute
dapat mengubah nilai variabelnya. Untuk menonaktifkan ubah nilai **true** menjadi **false**.
```php
    $routes->setAutoRoute(true);
```

Tambahkan method baru pada Controller Page seperti berikut.
```php
    public function tos()
    {
        echo "ini halaman Term of Services";
    } 
```
    
Method ini belum ada pada **routing**, sehingga cara mengaksesnya dengan menggunakan
alamat: **http://localhost:8080/page/tos**
![Screenshot Autoroute](praktikum1/Screenshoot/ci14.png)

#### H. Membuat View
Buat file baru dengan nama **about.php** pada direktori view **(app/view/about.php)** kemudian isi kodenya seperti berikut.
    ```php
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $title; ?></title>
    </head>
    <body>
        <h1><?= $title; ?></h1>
        <hr>
        <p><?= $content; ?></p>
    </body>
    </html>
    ```
Ubah **method about** pada class **Controller Page** menjadi seperti berikut:
```php
public function about()
    {
        return view('about', [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman about yang menjelaskan tentang isi halaman ini.'
        ]);
    }
```
![Screenshot Halaman About](praktikum1/Screenshoot/ci17.png)

#### I. Membuat Layout Web dengan CSS
Pada Codeigniter 4 file yang menyimpan asset css dan javascript terletak pada direktori **public**.Buat file css pada direktori public dengan nama **style.css**
![Screenshot Style CSS](praktikum1/Screenshoot/ci23.png)
Kemudian buat folder template pada direktori view kemudian buat file **header.php** dan **footer.php**
File **app/view/template/header.php**
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Tambahkan di bagian head -->
<meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css');?>">
</head>
<body>
    <div id="container">
    <header>
        <h1>Layout Sederhana</h1>
    </header>
    <nav>
        <a href="<?= base_url('/');?>" class="active">Home</a>
        <a href="<?= base_url('/artikel');?>">Artikel</a>
        <a href="<?= base_url('/about');?>">About</a>
        <a href="<?= base_url('/contact');?>">Kontak</a>
    </nav>
    <section id="wrapper">
        <section id="main">
```
File **app/view/template/footer.php**
```php
</section>
        <aside id="sidebar">
            <div class="widget-box">
                <h3 class="title">Widget Header</h3>
                <ul>
                    <li><a href="#">Widget Link</a></li>
                    <li><a href="#">Widget Link</a></li>
                </ul>
            </div>
            <div class="widget-box">
                <h3 class="title">Widget Text</h3>
                <p>Vestibulum lorem elit, iaculis in nisl volutpat, malesuada tincidunt arcu. Proin in leo fringilla, vestibulum mi porta, faucibus felis. Integer pharetra est nunc, nec pretium nunc pretium ac.</p>
            </div>
        </aside>
    </section>
    <footer>
        <p>&copy; 2021 - Universitas Pelita Bangsa</p>
    </footer>
    </div>
</body>
</html>
```
Kemudian ubah file **app/view/about.php** seperti berikut.
```php
<?= $this->include('template/header'); ?>
<h1><?= $title; ?></h1>
<hr>
<p><?= $content; ?></p>
<?= $this->include('template/footer'); ?>
```
Selanjutnya refresh tampilan pada alamat **http://localhost:8080/about**
![Screenshot hal](praktikum1/Screenshoot/ci20.png)

- **Praktikum 2:** Praktikum 2: Framework Lanjutan (CRUD)
- **Praktikum 3:** Praktikum 3: View Layout dan View Cell
...
