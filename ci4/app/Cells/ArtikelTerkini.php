<?php

namespace App\Cells;

use App\Models\ArtikelModel;

class ArtikelTerkini
{
    public function render($params = [])
    {
        try {
            $model = new ArtikelModel();
            
            // Query sederhana tanpa join untuk menghindari error
            $artikel = $model->select('id, judul, slug, created_at')
                           ->where('status', 'published')
                           ->orderBy('created_at', 'DESC')
                           ->limit(5)
                           ->findAll();
            
            // Pastikan artikel adalah array
            if (!is_array($artikel)) {
                $artikel = [];
            }
            
            return view('cells/artikel_terkini', ['artikel' => $artikel]);
            
        } catch (\Exception $e) {
            log_message('error', 'Error di ArtikelTerkini: ' . $e->getMessage());
            return '<div class="widget-box"><h3 class="title">Artikel Terkini</h3><div class="alert alert-info">Artikel sedang dimuat...</div></div>';
        }
    }
}
