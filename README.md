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

## Praktikum 2: Praktikum 2: Framework Lanjutan (CRUD)


### Langkah - langkah Praktikum
#### A. Persiapan
Untuk memulai membuat aplikasi CRUD sederhana, yang perlu disiapkan adalah database server menggunakan MySQL. Pastikan MySQL Server sudah dapat dijalankan melalui XAMPP.

#### B. Membuat Database dan Tabel Artikel
```sql
    CREATE DATABASE ci4;
```

```sql
    CREATE TABLE artikel (
        id INT(11) auto_increment,
        judul VARCHAR(200) NOT NULL,
        isi TEXT,
        gambar VARCHAR(200),
        status TINYINT(1) DEFAULT 0,
        slug VARCHAR(200),
        PRIMARY KEY(id)
    );
```
![Screenshot hal](praktikum2/Screenshoot/a1.png)

#### C. Konfigurasi Koneksi Database
Membuat konfigurasi untuk menghubungkan dengan database server, menggunakan file **.env**. Pada praktikum ini kita gunakan konfigurasi pada file env.
![Screenshot hal](praktikum2/Screenshoot/a2.png)

#### D. Membuat Model
Membuat Model untuk memproses data Artikel. Buat file baru pada direktori **app/Models** dengan nama **ArtikelModel.php**.
![Screenshot hal](praktikum2/Screenshoot/a3.png)

#### E. Membuat Controller
Buat Controller baru dengan nama **Artikel.php** pada direktori **app/Controllers**.
![Screenshot hal](praktikum2/Screenshoot/a4.png)

#### F. Membuat View
Buat direktori baru dengan nama **artikel** pada direktori **app/views**, kemudian buat file baru dengan nama **index.php**.
![Screenshot hal](praktikum2/Screenshoot/a5.png)

Selanjutnya buka browser kembali, dengan mengakses url http://localhost:8080/artikel
![Screenshot hal](praktikum2/Screenshoot/a6.png)

Belum ada data yang diampilkan. Kemudian coba tambahkan beberapa data pada database agar dapat ditampilkan datanya.
```sql
    INSERT INTO artikel (judul, isi, slug) VALUE
    ('Artikel pertama', 'Lorem Ipsum adalah contoh teks atau dummy dalam industri percetakan dan penataan huruf atau typesetting. Lorem Ipsum telah menjadi standar contoh teks sejak tahun 1500an, saat seorang tukang cetak yang tidak dikenal mengambil sebuah kumpulan teks dan mengacaknya untuk menjadi sebuah buku contoh huruf.', 'artikel-pertama'), ('Artikel kedua', 'Tidak seperti anggapan banyak orang, Lorem Ipsum bukanlah teks-teks yang diacak. Ia berakar dari sebuah naskah sastra latin klasik dari era 45 sebelum masehi, hingga bisa dipastikan usianya telah mencapai lebih dari 2000 tahun.', 'artikel-kedua');
```
Refresh kembali browser, sehingga akan ditampilkan hasilnya.
![Screenshot hal](praktikum2/Screenshoot/a7.png)

#### G. Membuat Tampilan Detail Artikel
Tampilan pada saat judul berita di klik maka akan diarahkan ke halaman yang berbeda.
Tambahkan fungsi baru pada **Controller Artikel** dengan nama **view()**.
![Screenshot hal](praktikum2/Screenshoot/a9.png)

#### H. Membuat View Detail
Buat view baru untuk halaman detail dengan nama **app/views/artikel/detail.php**
![Screenshot hal](praktikum2/Screenshoot/a10.png)

#### I. Membuat Routing untuk artikel detail
Buka kembali file **app/config/Routes.php**, kemudian tambahkan routing untuk artikel detail.
```php
    $ruotes->get('/artikel/(:any)', 'Artikel::view/$1');
```
![Screenshot hal](praktikum2/Screenshoot/a8.png)

#### J. Membuat Menu Admin
Menu admin adalah untuk proses CRUD data artikel. Buat method baru pada **Controller Artikel** dengan nama **admin_index()**.
```php
    public function admin_index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->findAll();
        return view('artikel/admin_index', compact('artikel', 'title'));
    }
```
Selanjutnya buat view untuk tampilan admin dengan nama **admin_index.php**
![Screenshot hal](praktikum2/Screenshoot/a11.png)

Tambahkan Routing untuk menu admin seperti berikut:
![Screenshot hal](praktikum2/Screenshoot/a12.png)

Akses menu admin dengan URL http://localhost:8080/admin/artikel
![Screenshot hal](praktikum2/Screenshoot/a13.png)

#### K. Menambah Data Artikel
Tambahkan Fungsi/method baru pada **Controller Artikel** dengan nama **add()**.
![Screenshot hal](praktikum2/Screenshoot/a14.png)

Kemudian buat view untuk form tambah dengan nama **form_add.php**.
![Screenshot hal](praktikum2/Screenshoot/a15.png)

![Screenshot hal](praktikum2/Screenshoot/a16.png)

#### L. Mengubah Data
Tambahkan Fungsi/method baru pada **Controller Artikel** dengan nama **edit()**.
![Screenshot hal](praktikum2/Screenshoot/a17.png)

Kemudian buat view untuk form tambah dengan nama **form_edit.php**
![Screenshot hal](praktikum2/Screenshoot/a18.png)

![Screenshot hal](praktikum2/Screenshoot/a19.png)

#### M. Menghapus Data
Tambahkan Fungsi/method baru pada **Controller Artikel** dengan nama **delete()**.
```php
    public function delete($id)
    {
        $artikel = new ArtikelModel();
        $artikel->delete($id);
        return redirect('admin/artikel');
    }
```
## Praktikum 3: View Layout dan View Cell
### Tujuan
Setelah menyelesaikan praktikum ini, mahasiswa diharapkan dapat:
1. Memahami konsep View Layout di CodeIgniter 4.
2. Menggunakan View Layout untuk membuat template tampilan.
3. Memahami dan mengimplementasikan View Cell dalam CodeIgniter 4.
4. Menggunakan View Cell untuk memanggil komponen UI secara modular.
### Langkah-langkah Praktikum
Praktikum kali ini kita akan mengunakan konsep View Layout dan View Cell untuk memudahkan dalam penggunaan layout.
#### A. Membuat Layout Utama
Buat folder **layout** di dalam **app/Views/**
Buat file **main.php** di dalam folder **layout** dengan kode berikut:
![Screenshot hal](praktikum3/Screenshoot/3a.png)

#### B. Modifikasi File View
Ubah **app/Views/home.php** agar sesuai dengan layout baru, sesuaikan juga untuk halaman lainnya yang ingin menggunakan format layout baru.
![Screenshot hal](praktikum3/Screenshoot/3b.png)

#### C. Membuat Class View Cell
Buat folder **Cells** di dalam **app/**
Buat file **ArtikelTerkini.php** di dalam **app/Cells/** dengan kode berikut
![Screenshot hal](praktikum3/Screenshoot/3c.png)

#### D. Membuat View untuk View Cell
Buat folder **components** di dalam **app/Views/**
Buat file **artikel_terkini.php** di dalam **app/Views/components/** dengan kode berikut:
![Screenshot hal](praktikum3/Screenshoot/3d.png)

### Pertanyaan dan Tugas
#### 1. Apa manfaat utama dari penggunaan View Layout dalam pengembangan aplikasi?

Manfaat utama dari penggunaan View Layout dalam pengembangan aplikasi adalah:

1. **Konsistensi Tampilan**: View Layout memastikan semua halaman memiliki struktur dan tampilan yang konsisten.
2. **Pemisahan Konten dan Layout**: Memisahkan konten spesifik halaman dari struktur layout umum, sehingga kode lebih terorganisir.
3. **Penggunaan Kembali Kode (Reusability)**: Layout yang sama dapat digunakan oleh banyak halaman tanpa perlu menulis ulang kode.
4. **Pemeliharaan yang Lebih Mudah**: Perubahan pada layout cukup dilakukan di satu tempat dan akan berlaku untuk semua halaman yang menggunakannya.
5. **Pengembangan yang Lebih Cepat**: Pengembang dapat fokus pada konten halaman tanpa perlu mengulang-ulang kode layout.

#### 2. Jelaskan perbedaan antara View Cell dan View biasa.

Perbedaan antara View Cell dan View biasa:

1. **Fungsi dan Tujuan**:

- **View Biasa**: Digunakan untuk menampilkan halaman lengkap atau bagian dari halaman.
- **View Cell**: Digunakan untuk membuat komponen UI yang dapat digunakan ulang dan bersifat modular.

2. **Cara Pemanggilan**:

- **View Biasa**: Dipanggil dengan `return view('nama_view', $data)` atau `echo view('nama_view', $data)`.
- **View Cell**: Dipanggil dengan `<?= view_cell('Namespace\\Class::method', $params) ?>`.

3. **Logika Bisnis**:

- **View Biasa**: Biasanya tidak memiliki logika bisnis, hanya menerima data dari controller.
- **View Cell**: Dapat memiliki logika bisnis sendiri, seperti mengambil data dari database.
4. **Penggunaan Kembali**:

- **View Biasa**: Dapat digunakan kembali dengan include/extend, tetapi kurang fleksibel.
- **View Cell**: Dirancang khusus untuk komponen yang digunakan berulang kali di berbagai halaman.

5. **Isolasi**:

- **View Biasa**: Berbagi konteks dengan view yang memanggilnya.
- **View Cell**: Memiliki konteks tersendiri, terisolasi dari view yang memanggilnya.
#### 3. Ubah View Cell agar hanya menampilkan post dengan kategori tertentu.
Modifikasi pada method render() di class **ArtikelTerkini.php**
![Screenshot hal](praktikum3/Screenshoot/3e.png)

Memanggil View Cell dengan parameter kategori di layout
![Screenshot hal](praktikum3/Screenshoot/3f.png)

## Praktikum 4: Framework Lanjutan (Modul Login)
### Langkah-langkah Praktikum
Untuk memulai membuat modul Login, yang perlu disiapkan adalah database server menggunakan MySQL. Pastikan MySQL Server sudah dapat dijalankan melalui XAMPP.
#### A. Membuat Tabel User
```php
    CREATE TABLE user (
        id INT(11) auto_increment,
        username VARCHAR(200) NOT NULL,
        useremail VARCHAR(200),
        userpassword VARCHAR(200),
        PRIMARY KEY(id)
    );
```
![Screenshot hal](praktikum4/Screenshoot/4a.png)

#### B. Membuat Model User
Selanjutnya adalah membuat Model untuk memproses data Login. Buat file baru pada direktori **app/Models** dengan nama **UserModel.php**
![Screenshot hal](praktikum4/Screenshoot/4c.png)

#### C. Membuat Controller User
Buat Controller baru dengan nama **User.php** pada direktori **app/Controllers**. Kemudian tambahkan method **index()** untuk menampilkan daftar user, dan method **login()** untuk proses login.
![Screenshot hal](praktikum4/Screenshoot/4d.png)

#### D. Membuat View Login
Buat direktori baru dengan nama **user** pada direktori **app/views**, kemudian buat file baru dengan nama **login.php**.
![Screenshot hal](praktikum4/Screenshoot/4e.png)

#### E. Membuat Database Seeder
Database seeder digunakan untuk membuat data dummy. Untuk keperluan ujicoba modul login, kita perlu memasukkan data user dan password kedaalam database. Untuk itu buat database seeder untuk tabel user. Buka CLI,kemudian tulis perintah berikut:
```CLI
    php spark make:seeder UserSeeder
```
Selanjutnya, buka file **UserSeeder.php** yang berada di lokasi direktori **/app/Database/Seeds/UserSeeder.php** kemudian isi dengan kode berikut:
![Screenshot hal](praktikum4/Screenshoot/4g.png)
Selanjutnya buka kembali CLI dan ketik perintah berikut
```CLI
    php spark db:seed UserSeeder
```

#### F. Uji Coba Login
Selanjutnya buka url http://localhost:8080/user/login seperti berikut:
![Screenshot hal](praktikum4/Screenshoot/4i.png)

#### G. Membuat Auth Filter
Selanjutnya membuat filer untuk halaman admin. Buat file baru dengan nama **Auth.php** pada direktori **app/Filters**.
![Screenshot hal](praktikum4/Screenshoot/4j.png)

Selanjutnya buka file **app/Config/Filters.php** tambahkan kode berikut:
```php
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'auth'          => \App\Filters\Auth::class, 
    ];
```
Selanjutnya buka file **app/Config/Routes.php** dan sesuaikan kodenya.
![Screenshot hal](praktikum4/Screenshoot/4l.png)

#### H. Percobaan Akses Menu Admin
Buka url dengan alamat http://localhost:8080/admin/artikel ketika alamat tersebut diakses
maka, akan dimuculkan halaman login.
![Screenshot hal](praktikum4/Screenshoot/4m.png)

#### I. Fungsi Logout
Tambahkan method logout pada Controller User seperti berikut:
```php
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login');
    }
```
## Praktikum 5: Pagination dan Pencarian
### Langkah-langkah Praktikum
#### A. Membuat Pagination
Pagination merupakan proses yang digunakan untuk membatasi tampilan yang panjang dari data yang banyak pada sebuah website. Fungsi pagination adalah memecah tampilan menjadi beberapa halaman tergantung banyaknya data yang akan ditampilkan pada setiap halaman.
Untuk membuat pagination, buka Kembali **Controller Artikel**, kemudian modifikasi kode
pada method **admin_index** seperti berikut.
![Screenshot hal](praktikum5/Screenshoot/5a.png)

Kemudian buka file **views/artikel/admin_index.php** dan tambahkan kode berikut dibawah deklarasi tabel data.
```php
    <?= $pager->links(); ?>
```
Selanjutnya buka kembali menu daftar artikel, tambahkan data lagi untuk melihat
hasilnya.
![Screenshot hal](praktikum5/Screenshoot/5c.png)
#### B. Membuat Pencarian
Untuk membuat pencarian data, buka kembali **Controller Artikel**, pada method
**admin_index** ubah kodenya seperti berikut
![Screenshot hal](praktikum5/Screenshoot/5d.png)

Kemudian buka kembali file **views/artikel/admin_index.php** dan tambahkan form
pencarian sebelum deklarasi tabel seperti berikut:
![Screenshot hal](praktikum5/Screenshoot/5e.png)

Pada link pager ubah seperti ini:
```php
    <?= $pager->only(['q'])->links(); ?>
```
Selanjutnya ujicoba dengan membuka kembali halaman admin artikel, masukkan kata kunci tertentu pada form pencarian.
![Screenshot hal](praktikum5/Screenshoot/5f.png)

## Praktikum 6: Upload File Gambar
### Langkah-langkah Praktikum
#### A. Upload Gambar pada Artikel
Buka kembali **Controller Artikel** pada project sebelumnya, sesuaikan kode pada method **add** seperti berikut:
![Screenshot hal](praktikum6/Screenshoot/6a.png)

Kemudian pada file **views/artikel/form_add.php** tambahkan field input file seperti
berikut.
```php
    <p>
        <input type="file" name="gambar">
    </p>
```
Sesuaikan tag form dengan menambah encrypt type seperti berikut:
```php
    <form action="" method="post" enctype="multipart/form-data">
```
Ujicoba file upload dengan mengakses menu tambah artikel.
![Screenshot hal](praktikum6/Screenshoot/6d.png)
#### A.
#### A.
#### A.

## Praktikum 7: View Layout dan View Cell
### Langkah-langkah Praktikum
#### A.
#### A.
#### A.
#### A.

## Praktikum 8: View Layout dan View Cell
### Langkah-langkah Praktikum
#### A.
#### A.
#### A.
#### A.

## Praktikum 9: View Layout dan View Cell
### Langkah-langkah Praktikum
#### A.
#### A.
#### A.
#### A.

## Praktikum 10: View Layout dan View Cell
### Langkah-langkah Praktikum
#### A.
#### A.
#### A.
#### A.

