<?= $this->include('template/admin_header'); ?>

<div class="page-title">
    <h2><?= $title; ?></h2>
</div>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= session()->getFlashdata('success') ?>
    </div>
<?php endif; ?>

<?php if (isset($validation) && $validation): ?>
    <div class="alert alert-danger">
        <h5>Validation Errors:</h5>
        <?= $validation->listErrors() ?>
    </div>
<?php endif; ?>

<div class="form-container">
    <form action="<?= base_url('/admin/artikel/edit/' . $artikel['id']); ?>" method="POST"
        enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="judul" class="form-label">Judul *</label>
            <input type="text" name="judul" id="judul" value="<?= old('judul', $artikel['judul']); ?>"
                class="form-control" required>
            <?php if (isset($validation) && $validation->getError('judul')): ?>
                <div class="invalid-feedback"><?= $validation->getError('judul') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="isi" class="form-label">Isi Artikel *</label>
            <textarea name="isi" id="isi" cols="50" rows="10" class="form-control"
                required><?= old('isi', $artikel['isi']); ?></textarea>
            <?php if (isset($validation) && $validation->getError('isi')): ?>
                <div class="invalid-feedback"><?= $validation->getError('isi') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="id_kategori" class="form-label">Kategori *</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php if (isset($kategori) && is_array($kategori) && count($kategori) > 0): ?>
                    <?php foreach ($kategori as $k): ?>
                        <?php if (is_array($k) && isset($k['id_kategori']) && isset($k['nama_kategori'])): ?>
                            <?php
                            $selected = '';
                            $selectedValue = old('id_kategori', $artikel['id_kategori']);
                            if ($selectedValue == $k['id_kategori']) {
                                $selected = 'selected';
                            }
                            ?>
                            <option value="<?= $k['id_kategori']; ?>" <?= $selected ?>>
                                <?= esc($k['nama_kategori']); ?>
                            </option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="" disabled>Tidak ada kategori tersedia</option>
                <?php endif; ?>
            </select>
            <?php if (isset($validation) && $validation->getError('id_kategori')): ?>
                <div class="invalid-feedback"><?= $validation->getError('id_kategori') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="gambar" class="form-label">Gambar</label>
            <input type="file" name="gambar" id="gambar" accept="image/*" class="form-control">
            <small class="form-text text-muted">Format: JPG, PNG, GIF. Maksimal 2MB. Kosongkan jika tidak ingin mengubah
                gambar.</small>

            <?php if (isset($artikel['gambar']) && $artikel['gambar']): ?>
                <div class="current-image">
                    <small><strong>Gambar saat ini:</strong></small><br>
                    <img src="<?= base_url('/gambar/' . $artikel['gambar']); ?>" alt="Current image" class="img-preview">
                    <br><small class="text-muted">File: <?= $artikel['gambar']; ?></small>
                </div>
            <?php endif; ?>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Artikel</button>
            <a href="<?= base_url('/admin/artikel'); ?>" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<?= $this->include('template/admin_footer'); ?>