
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h1><?= $title; ?></h1>

<?php if ($artikel):
    foreach ($artikel as $row): ?>
        <article class="entry">
            <h2><a href="<?= base_url('/artikel/' . $row['slug']); ?>"><?= $row['judul']; ?></a></h2>
            <?php if ($row['gambar']): ?>
                <img src="<?= base_url('/gambar/' . $row['gambar']); ?>" alt="<?= $row['judul']; ?>" class="img-preview"
                    style="max-width: 300px;">
            <?php endif; ?>
            <p><?= substr($row['isi'], 0, 200); ?>...</p>
        </article>
        <hr class="divider" />
    <?php endforeach; else: ?>
    <article class="entry">
        <h2>Belum ada artikel dalam kategori ini.</h2>
    </article>
<?php endif; ?>

<?= $this->endSection() ?>
