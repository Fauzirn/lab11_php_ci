<?php

namespace App\Controllers;

class Page extends BaseController
{
    public function about()
    {
        $data = [
            'title' => 'Halaman About',
            'content' => 'Ini adalah halaman About yang menjelaskan tentang halaman ini.'
        ];
        return view('content', $data);
    }

    public function artikel()
    {
        $data = [
            'title' => 'Halaman Artikel',
            'content' => 'Ini adalah halaman Artikel yang berisi kumpulan artikel menarik.'
        ];
        return view('content', $data);
    }

    public function kontak()
    {
        $data = [
            'title' => 'Halaman Kontak',
            'content' => 'Ini adalah halaman Kontak. Silakan hubungi kami di email@example.com.'
        ];
        return view('content', $data);
    }
}
