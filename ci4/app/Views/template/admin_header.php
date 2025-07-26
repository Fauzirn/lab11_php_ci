<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <title><?= $title ?? 'Admin Panel' ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css') ?>">
</head>

<body>
    <div class="container">
        <header>
            <h1>Admin Portal Berita</h1>
        </header>
        <nav>
            <a href="<?= base_url('/admin/artikel'); ?>" class="active">Dashboard</a>
            <a href="<?= base_url('/admin/artikel/add'); ?>">Tambah Artikel</a>
            <a href="<?= base_url('/artikel'); ?>">Portal Berita</a>
            <a href="<?= base_url('/ajax'); ?>">AJAX Demo</a>
            <a href="<?= base_url('/user/logout'); ?>" style="float: right;">Logout</a>
        </nav>
        <main>