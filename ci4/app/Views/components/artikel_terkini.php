<div class="widget-box">
    <h3 class="title">Artikel Terkini <?= isset($kategori) && $kategori ? "- Kategori $kategori" : "" ?></h3>
    <ul>
        <?php if(empty($artikel)): ?>
            <li>Belum ada artikel terbaru<?= isset($kategori) && $kategori ? " dalam kategori $kategori" : "" ?>.</li>
        <?php else: ?>
            <?php foreach ($artikel as $row): ?>
            <li>
                <a href="<?= base_url('/artikel/' . $row['slug']) ?>"><?= $row['judul'] ?></a>
                <?php if(isset($row['kategori'])): ?>
                <small>(<?= $row['kategori'] ?>)</small>
                <?php endif; ?>
            </li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>
</div>