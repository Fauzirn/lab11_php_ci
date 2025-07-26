<?php

namespace App\Controllers;
use App\Models\KategoriModel;

class Home extends BaseController
{
    public function index(): string
    {
    $kategoriModel = new KategoriModel();
    $data['kategori'] = $kategoriModel->findAll();
    return view('home', $data);
    }       
}
