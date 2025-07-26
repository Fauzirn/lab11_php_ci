
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h1><?= $title; ?></h1>
<hr>

<div class="dashboard-info">
    <div class="card">
        <h3>Selamat Datang, <?= $user_name; ?>!</h3>
        <p>Ini adalah halaman dashboard admin.</p>
    </div>
    
    <div class="stats">
        <div class="stat-card">
            <h4>Total Artikel</h4>
            <p class="stat-number"><?= $artikel_count; ?></p>
        </div>
        <div class="stat-card">
            <h4>Artikel Dipublikasikan</h4>
            <p class="stat-number"><?= $artikel_published; ?></p>
        </div>
    </div>
    
    <div class="quick-actions">
        <h3>Aksi Cepat</h3>
        <div class="action-buttons">
            <a href="<?= base_url('/admin/artikel/add'); ?>" class="btn btn-primary">Tambah Artikel Baru</a>
            <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Kelola Artikel</a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
