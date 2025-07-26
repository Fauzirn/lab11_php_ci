<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\Request;
use CodeIgniter\HTTP\Response;
use App\Models\ArtikelModel;
use App\Models\KategoriModel;

class AjaxController extends Controller
{
    public function index()
    {
        $kategoriModel = new KategoriModel();
        $data['kategori'] = $kategoriModel->findAll();
        $data['title'] = 'Data Artikel (AJAX)';
        
        return view('ajax/index', $data);
    }

    public function getData()
    {
        $model = new ArtikelModel();
        
        // Gunakan Query Builder untuk mendapatkan data artikel dengan kategori
        $data = $model->db->table('artikel')
                    ->select('artikel.*, kategori.nama_kategori')
                    ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left')
                    ->get()
                    ->getResultArray();

        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function getById($id)
    {
        $model = new ArtikelModel();
        $data = $model->find($id);
        
        // Kirim data dalam format JSON
        return $this->response->setJSON($data);
    }

    public function save()
    {
        $model = new ArtikelModel();
        $data = [
            'judul' => $this->request->getPost('judul'),
            'isi' => $this->request->getPost('isi'),
            'id_kategori' => $this->request->getPost('id_kategori'),
            'slug' => url_title($this->request->getPost('judul'), '-', true),
            'status' => 'published'
        ];
        
        // Cek apakah ini update atau insert baru
        $id = $this->request->getPost('id');
        if (!empty($id)) {
            $model->update($id, $data);
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil diupdate'
            ];
        } else {
            $model->insert($data);
            $response = [
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan'
            ];
        }
        
        // Kirim response dalam format JSON
        return $this->response->setJSON($response);
    }

    public function delete($id)
    {
        $model = new ArtikelModel();
        $success = $model->delete($id);

        $response = [
            'status' => $success ? 'success' : 'error',
            'message' => $success ? 'Data berhasil dihapus' : 'Gagal menghapus data'
        ];

        // Kirim response dalam format JSON
        return $this->response->setJSON($response);
    }
}
