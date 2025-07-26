<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        $artikel = $model->getArtikelDenganKategori();
        return view('artikel/index', compact('artikel', 'title'));
    }
    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();

        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1; // Tambahkan ini untuk menangani pagination

        $builder = $model->table('artikel')
                         ->select('artikel.*, kategori.nama_kategori')
                         ->join('kategori', 'kategori.id_kategori = artikel.id_kategori');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        $data['artikel'] = $builder->paginate(10, 'default', $page);
        $data['pager'] = $model->pager;
        
        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
            'artikel' => $data['artikel'],
            'pager' => $data['pager'],
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON($data);
        } else {
            $kategoriModel = new KategoriModel();
            $data['kategori'] = $kategoriModel->findAll();
            return view('artikel/admin_index', $data);
        }

        
    }

    
    public function add()
    {
        // Validasi input form
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul'       => 'required',
            'id_kategori' => 'required|integer' // id_kategori wajib dan harus integer
        ])) {
            $model = new ArtikelModel();
            $model->insert([
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'slug'        => url_title($this->request->getPost('judul')),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            // Ambil data kategori untuk form
            $kategoriModel      = new KategoriModel();
            $data['kategori']   = $kategoriModel->findAll();
            $data['title']      = "Tambah Artikel";

            return view('artikel/form_add', $data);
        }
    }

    public function edit($id)
    {
        $model = new ArtikelModel();

        // Validasi input form
        if ($this->request->getMethod() == 'post' && $this->validate([
            'judul'       => 'required',
            'id_kategori' => 'required|integer'
        ])) {
            $model->update($id, [
                'judul'       => $this->request->getPost('judul'),
                'isi'         => $this->request->getPost('isi'),
                'id_kategori' => $this->request->getPost('id_kategori')
            ]);
            return redirect()->to('/admin/artikel');
        } else {
            $data['artikel']    = $model->find($id);
            $kategoriModel      = new KategoriModel();
            $data['kategori']   = $kategoriModel->findAll();
            $data['title']      = "Edit Artikel";

            return view('artikel/form_edit', $data);
        }
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $model->delete($id);

        return redirect()->to('/admin/artikel');
    }

        public function view($slug)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->select('artikel.*, kategori.nama_kategori')
                                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
                                ->where('slug', $slug)
                                ->first();

        if (!$data['artikel']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Artikel tidak ditemukan");
        }

        $data['title'] = $data['artikel']['judul'];
        return view('artikel/detail', $data);
    }

        public function byKategori($id_kategori)
    {
        $model = new ArtikelModel();
        $data['artikel'] = $model->select('artikel.*, kategori.nama_kategori')
                                ->join('kategori', 'kategori.id_kategori = artikel.id_kategori')
                                ->where('artikel.id_kategori', $id_kategori)
                                ->findAll();

        $kategoriModel = new KategoriModel();
        $kategori = $kategoriModel->find($id_kategori);
        $data['title'] = 'Artikel: ' . $kategori['nama_kategori'];

        return view('artikel/by_kategori', $data);
    }

}