<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Website Artikel'; ?></title>
    <link rel="stylesheet" href="<?= base_url('/style.css'); ?>">
</head>

<body>
    <div id="container">
        <header>
            <nav>
                <a href="<?= base_url('/'); ?>" class="active">Home</a>
                <a href="<?= base_url('/artikel'); ?>">Artikel</a>
                <a href="<?= base_url('/about'); ?>">About</a>
                <a href="<?= base_url('/contact'); ?>">Contact</a>
                <?php if (session()->get('logged_in')): ?>
                    <a href="<?= base_url('/admin/dashboard'); ?>">Dashboard</a>
                    <a href="<?= base_url('/user/logout'); ?>">Logout</a>
                <?php else: ?>
                    <a href="<?= base_url('/user/login'); ?>">Login</a>
                <?php endif; ?>
            </nav>
        </header>

        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content'); ?>
            </section>

            <aside id="sidebar">
                <div class="widget-box">
                    <h3 class="title">Kategori</h3>
                    <ul>
                        <?php
                        $kategoriModel = new \App\Models\KategoriModel();
                        $kategoris = $kategoriModel->findAll();
                        foreach ($kategoris as $k):
                            ?>
                            <li><a href="<?= base_url('/kategori/' . $k['slug_kategori']) ?>"><?= $k['nama_kategori'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php
                try {
                    echo view_cell('\\App\\Cells\\ArtikelTerkini::render', []);
                } catch (\Exception $e) {
                    log_message('error', 'Error loading ArtikelTerkini cell: ' . $e->getMessage());
                    echo '<div class="widget-box"><h3 class="title">Artikel Terkini</h3><div class="alert alert-warning">Widget sedang dalam perbaikan</div></div>';
                }
                ?>
            </aside>
        </section>

        <footer>
            <p>&copy; <?= date('Y') ?> - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>

</html>