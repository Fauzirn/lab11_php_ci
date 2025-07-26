<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table = 'kategori';
    protected $primaryKey = 'id_kategori'; 
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    
    // Sesuaikan dengan kolom yang ada di database
    protected $allowedFields = ['nama_kategori', 'slug_kategori'];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Custom methods
    public function getKategoriBySlug($slug)
    {
        return $this->where('slug_kategori', $slug)->first();
    }

    public function getAllKategoriWithCount()
    {
        return $this->select('kategori.*, COUNT(artikel.id) as jumlah_artikel')
                    ->join('artikel', 'artikel.id_kategori = kategori.id_kategori', 'left')
                    ->groupBy('kategori.id_kategori')
                    ->findAll();
    }
}
