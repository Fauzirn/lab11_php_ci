<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<h1><?= $title; ?></h1>

<div class="content">
    <h2>Tentang Kami</h2>
    <p>Ini adalah halaman about dari website portal artikel kami.</p>
    <p>Website ini dibuat menggunakan CodeIgniter 4 untuk praktikum Pemrograman Web 2.</p>
</div>

<?= $this->endSection() ?>