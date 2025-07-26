<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<article class="entry">
    <h2><?= $artikel['judul']; ?></h2>
    <p><strong>Kategori:</strong>
        <?php if (isset($artikel['nama_kategori'])): ?>
            <span class="badge badge-info"><?= $artikel['nama_kategori'] ?></span>
        <?php else: ?>
            <span class="badge">Tidak ada kategori</span>
        <?php endif; ?>
    </p>
    <?php if ($artikel['gambar']): ?>
        <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="<?= $artikel['judul']; ?>" class="img-preview">
    <?php endif; ?>
    <p><?= $artikel['isi']; ?></p>
</article>

<?= $this->endSection() ?>