<?php

namespace App\Controllers;

use App\Models\ArtikelModel;
use App\Models\KategoriModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Artikel extends BaseController
{
    protected $helpers = ['url', 'form'];
     public function index()
    {
        $title = 'Daftar Artikel';
        $model = new ArtikelModel();
        
        try {
            $artikel = $model->getArtikelDenganKategori();
            return view('artikel/index', compact('artikel', 'title'));
        } catch (\Exception $e) {
            log_message('error', 'Error di Artikel::index: ' . $e->getMessage());
            $artikel = [];
            return view('artikel/index', compact('artikel', 'title'));
        }
    }
    public function admin_index()
    {
        $title = 'Daftar Artikel (Admin)';
        $model = new ArtikelModel();

        $q = $this->request->getVar('q') ?? '';
        $kategori_id = $this->request->getVar('kategori_id') ?? '';
        $page = $this->request->getVar('page') ?? 1;
        $sort = $this->request->getVar('sort') ?? 'id';
        $order = $this->request->getVar('order') ?? 'DESC';

        $builder = $model->table('artikel')
                        ->select('artikel.*, kategori.nama_kategori')
                        ->join('kategori', 'kategori.id_kategori = artikel.id_kategori', 'left');

        if ($q != '') {
            $builder->like('artikel.judul', $q);
        }

        if ($kategori_id != '') {
            $builder->where('artikel.id_kategori', $kategori_id);
        }

        // Apply sorting
        $builder->orderBy('artikel.' . $sort, $order);

        // Apply pagination
        $artikel = $builder->paginate(5, 'default', $page); 
        $pager = $model->pager;

        $data = [
            'title' => $title,
            'q' => $q,
            'kategori_id' => $kategori_id,
            'artikel' => $artikel,
            'pager' => $pager,
            'sort' => $sort,
            'order' => $order
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
        // Cek login admin
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
        
        $kategoriModel = new KategoriModel();
        $data = [
            'title' => "Tambah Artikel",
            'kategori' => $kategoriModel->findAll(),
            'validation' => null
        ];

        // Handle POST request
        if ($this->request->getMethod() === 'POST') {

            $rules = [
                'judul' => [
                    'label' => 'Judul',
                    'rules' => 'required|min_length[3]|max_length[200]',
                    'errors' => [
                        'required' => 'Judul harus diisi',
                        'min_length' => 'Judul minimal 3 karakter',
                        'max_length' => 'Judul maksimal 200 karakter'
                    ]
                ],
                'isi' => [
                    'label' => 'Isi',
                    'rules' => 'required|min_length[10]',
                    'errors' => [
                        'required' => 'Isi artikel harus diisi',
                        'min_length' => 'Isi artikel minimal 10 karakter'
                    ]
                ],
                'id_kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Kategori harus dipilih',
                        'integer' => 'Kategori tidak valid'
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                
                $model = new ArtikelModel();
                
                try {
                    $file = $this->request->getFile('gambar');
                    $gambar = '';
                    
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        
                        // Validasi file
                        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                        if (!in_array($file->getMimeType(), $allowedTypes)) {
                            session()->setFlashdata('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                            return redirect()->back()->withInput();
                        }
                        
                        if ($file->getSize() > 2048000) { // 2MB
                            session()->setFlashdata('error', 'Ukuran file terlalu besar. Maksimal 2MB.');
                            return redirect()->back()->withInput();
                        }
                        
                        $gambar = $file->getRandomName();
                        
                        // Pastikan direktori gambar ada
                        $uploadPath = ROOTPATH . 'public/gambar';
                        if (!is_dir($uploadPath)) {
                            if (!mkdir($uploadPath, 0755, true)) {
                                session()->setFlashdata('error', 'Gagal membuat direktori upload.');
                                return redirect()->back()->withInput();
                            }
                        }
                        
                        if (!$file->move($uploadPath, $gambar)) {
                            session()->setFlashdata('error', 'Gagal mengupload file.');
                            return redirect()->back()->withInput();
                        }
                    }
            
                    $insertData = [
                        'judul' => trim($this->request->getPost('judul')),
                        'isi' => trim($this->request->getPost('isi')),
                        'slug' => url_title($this->request->getPost('judul'), '-', true),
                        'id_kategori' => (int)$this->request->getPost('id_kategori'),
                        'gambar' => $gambar,
                        'status' => 'published'
                    ];
                    
                    // Insert data
                    $result = $model->insert($insertData);
                    
                    if ($result) {
                        session()->setFlashdata('success', 'Artikel berhasil ditambahkan!');
                        return redirect()->to('/admin/artikel');
                    } else {
                        $errors = $model->errors();
                        $errorMessage = 'Gagal menambahkan artikel';
                        if (!empty($errors)) {
                            $errorMessage .= ': ' . implode(', ', $errors);
                        }
                        session()->setFlashdata('error', $errorMessage);
                        return redirect()->back()->withInput();
                    }
                    
                } catch (\Exception $e) {
                    log_message('error', 'Exception in add artikel: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Gagal menambahkan artikel: ' . $e->getMessage());
                    return redirect()->back()->withInput();
                }
            } else {
                $data['validation'] = $this->validator;
                session()->setFlashdata('error', 'Data tidak valid. Periksa kembali form Anda.');
            }
        }
        return view('artikel/form_add', $data);
    }

    public function edit($id = null)
    {
        // Cek login admin
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
        
        if (!$id || !is_numeric($id)) {
            throw new PageNotFoundException('Artikel tidak ditemukan.');
        }
        
        $model = new ArtikelModel();
      
        $artikel = $model->find($id);
        if (!$artikel) {
            throw new PageNotFoundException('Artikel tidak ditemukan.');
        }

        $kategoriModel = new KategoriModel();
        $data = [
            'title' => "Edit Artikel",
            'artikel' => $artikel,
            'kategori' => $kategoriModel->findAll(),
            'validation' => null
        ];

        // Handle POST request
        if ($this->request->getMethod() === 'POST') {

            $rules = [
                'judul' => [
                    'label' => 'Judul',
                    'rules' => 'required|min_length[3]|max_length[200]',
                    'errors' => [
                        'required' => 'Judul harus diisi',
                        'min_length' => 'Judul minimal 3 karakter',
                        'max_length' => 'Judul maksimal 200 karakter'
                    ]
                ],
                'isi' => [
                    'label' => 'Isi',
                    'rules' => 'required|min_length[10]',
                    'errors' => [
                        'required' => 'Isi artikel harus diisi',
                        'min_length' => 'Isi artikel minimal 10 karakter'
                    ]
                ],
                'id_kategori' => [
                    'label' => 'Kategori',
                    'rules' => 'required|integer',
                    'errors' => [
                        'required' => 'Kategori harus dipilih',
                        'integer' => 'Kategori tidak valid'
                    ]
                ]
            ];

            if ($this->validate($rules)) {
                try {
                    // Prepare update data
                    $updateData = [
                        'judul' => trim($this->request->getPost('judul')),
                        'isi' => trim($this->request->getPost('isi')),
                        'slug' => url_title($this->request->getPost('judul'), '-', true),
                        'id_kategori' => (int)$this->request->getPost('id_kategori')
                    ];
                    
                    // Handle file upload
                    $file = $this->request->getFile('gambar');
                    if ($file && $file->isValid() && !$file->hasMoved()) {
                        // Validasi file
                        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                        if (!in_array($file->getMimeType(), $allowedTypes)) {
                            session()->setFlashdata('error', 'Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                            return redirect()->back()->withInput();
                        }
                        
                        if ($file->getSize() > 2048000) { // 2MB
                            session()->setFlashdata('error', 'Ukuran file terlalu besar. Maksimal 2MB.');
                            return redirect()->back()->withInput();
                        }
                        
                        // Delete old image if exists
                        if (!empty($artikel['gambar']) && file_exists(ROOTPATH . 'public/gambar/' . $artikel['gambar'])) {
                            unlink(ROOTPATH . 'public/gambar/' . $artikel['gambar']);
                        }
                        
                        $gambar = $file->getRandomName();
                        
                        // Pastikan direktori gambar ada
                        $uploadPath = ROOTPATH . 'public/gambar';
                        if (!is_dir($uploadPath)) {
                            if (!mkdir($uploadPath, 0755, true)) {
                                session()->setFlashdata('error', 'Gagal membuat direktori upload.');
                                return redirect()->back()->withInput();
                            }
                        }
                        
                        if (!$file->move($uploadPath, $gambar)) {
                            session()->setFlashdata('error', 'Gagal mengupload file.');
                            return redirect()->back()->withInput();
                        }
                        
                        $updateData['gambar'] = $gambar;
                    }
                    
                    $result = $model->update($id, $updateData);
                    
                    if ($result !== false) {
                        session()->setFlashdata('success', 'Artikel berhasil diupdate!');
                        return redirect()->to('/admin/artikel');
                    } else {
                        $errors = $model->errors();
                        $errorMessage = 'Gagal mengupdate artikel';
                        if (!empty($errors)) {
                            $errorMessage .= ': ' . implode(', ', $errors);
                        }
                        session()->setFlashdata('error', $errorMessage);
                        return redirect()->back()->withInput();
                    }
                    
                } catch (\Exception $e) {
                    log_message('error', 'Exception in edit artikel: ' . $e->getMessage());
                    session()->setFlashdata('error', 'Gagal mengupdate artikel: ' . $e->getMessage());
                    return redirect()->back()->withInput();
                }
            } else {
                $data['validation'] = $this->validator;
                session()->setFlashdata('error', 'Data tidak valid. Periksa kembali form Anda.');
            }
        }

        // GET request - show form
        return view('artikel/form_edit', $data);
    }

    public function delete($id)
    {
        // Cek login admin
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }
        
        if (!$id || !is_numeric($id)) {
            session()->setFlashdata('error', 'ID artikel tidak valid.');
            return redirect()->to('/admin/artikel');
        }
        
        $model = new ArtikelModel();
        
        try {
            $artikel = $model->find($id);
            
            if ($artikel) {
                // Hapus gambar jika ada
                if (isset($artikel['gambar']) && $artikel['gambar'] && file_exists(ROOTPATH . 'public/gambar/' . $artikel['gambar'])) {
                    unlink(ROOTPATH . 'public/gambar/' . $artikel['gambar']);
                }
                
                $result = $model->delete($id);
                
                if ($result) {
                    session()->setFlashdata('success', 'Artikel berhasil dihapus!');
                } else {
                    session()->setFlashdata('error', 'Gagal menghapus artikel.');
                }
            } else {
                session()->setFlashdata('error', 'Artikel tidak ditemukan.');
            }
        } catch (\Exception $e) {
            log_message('error', 'Error di delete artikel: ' . $e->getMessage());
            session()->setFlashdata('error', 'Gagal menghapus artikel: ' . $e->getMessage());
        }
        
        return redirect()->to('/admin/artikel');
    }

    public function view($slug)
    {
        $model = new ArtikelModel();
        
        try {
            $data['artikel'] = $model->getArtikelBySlugDenganKategori($slug);
            
            if (empty($data['artikel'])) {
                throw new PageNotFoundException('Artikel tidak ditemukan.');
            }
            
            $data['title'] = $data['artikel']['judul'];
            return view('artikel/detail', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error di view artikel: ' . $e->getMessage());
            throw new PageNotFoundException('Artikel tidak ditemukan.');
        }
    }
    
    public function kategori($slug_kategori)
    {
        $kategoriModel = new KategoriModel();
        
        try {
            $kategori = $kategoriModel->getKategoriBySlug($slug_kategori);
            
            if (!$kategori) {
                throw new PageNotFoundException('Kategori tidak ditemukan.');
            }
            
            $model = new ArtikelModel();
            $artikel = $model->getArtikelByKategori($kategori['id_kategori']);
            
            $data = [
                'title' => 'Artikel Kategori: ' . $kategori['nama_kategori'],
                'artikel' => $artikel,
                'kategori' => $kategori
            ];
            
            return view('artikel/kategori', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'Error di kategori: ' . $e->getMessage());
            throw new PageNotFoundException('Kategori tidak ditemukan.');
        }
    }

    
}