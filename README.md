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
Buka XAMPP, lalu pada bagian Apache klik **Config**, pilih **PHP.ini**. Untuk mengaktifkan konfigurasi hilangkan tanda ";' pada setiap eksitensi yang diaktifkan.

![Screenshot Konfigurasi PHP.ini](praktikum1/Screenshoot/ci19.png)

#### B. Instal CodeIgniter4
![Screenshot Instalisasi CI4](praktikum1/Screenshoot/ci21.png)

#### C. Menjalankan CLI (Command Line Interface)
Buka cmd/terminal, lalu arahkan pada direktori projek yang dibuat. Jalankan perintah untuk memanggil CLI Codeigniter:
    **php spark**
![Screenshot CLI Codeigniter](praktikum1/Screenshoot/ci2.png)

#### D. Mengaktifkan Mode Debugging
Mengubah nama file **env** menjadi **.env**, selanjutnya buka file tersebut dan ubah nilai **CI_ENVIRONTMENT** menjadi **development**, dan hilangkan tanda **#**.
![Screenshot Mode Debbuging](praktikum1/Screenshoot/ci5.png)

Berikut setelah mengaktifkan Mode Debugging, maka akan menampilkan pesan error.
![Screenshot Parse Error](praktikum1/Screenshoot/ci4.png)

#### E. Membuat Route Baru
Menambahkan kode berikut ini di file **Routes.php**
    $routes->get('/', 'Home::index');
    $routes->get('/about', 'Page::about');
    $routes->get('/contact', 'Page::contact');
    $routes->get('/faqs', 'Page::faqs');

Cek Route yang ditambahkan, dan jalankan perintah berikut :
    php spark routes
![Screenshot Route Baru](praktikum1/Screenshoot/ci8.png)

Untuk dapat mengakses, aktifkan dulu **localhost:8080** dengan menjalankan perintah berikut:
    php spark serve
![Screenshot Localhost](praktikum1/Screenshoot/ci22.png)

Lakukan akses route yang telah dibuat dengan mengakses alamat url
**http://localhost:8080/about**
![Screenshot Route About](praktikum1/Screenshoot/ci9.png)

#### F. Membuat Controller
Buat file baru dengan nama **page.php** pada
direktori Controller kemudian isi kodenya seperti berikut.
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

Maka akan menampilkan hasil halaman yang sudah dapat diakses.
![Screenshot Controller](praktikum1/Screenshoot/ci11.png)

#### G. Auto Routing
Untuk mengubah status autoroute
dapat mengubah nilai variabelnya. Untuk menonaktifkan ubah nilai **true** menjadi **false**.
   $routes->setAutoRoute(true);

Tambahkan method baru pada Controller Page seperti berikut. 
    public function tos()
    {
        echo "ini halaman Term of Services";
    }
Method ini belum ada pada **routing**, sehingga cara mengaksesnya dengan menggunakan
alamat: **http://localhost:8080/page/tos**
![Screenshot Autoroute](praktikum1/Screenshoot/ci14.png)

#### H. Membuat View

- **Praktikum 2:** Praktikum 2: Framework Lanjutan (CRUD)
- **Praktikum 3:** Praktikum 3: View Layout dan View Cell
...
