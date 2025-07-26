<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h3>Kategori</h3>
<ul>
    <?php foreach($kategori as $k): ?>
        <li><a href="<?= site_url('kategori/' . $k['id_kategori']); ?>">
            <?= $k['nama_kategori']; ?></a></li>
    <?php endforeach; ?>
</ul>


<?= $this->endSection() ?>