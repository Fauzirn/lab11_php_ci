
<?= $this->include('template/admin_header'); ?>

<div class="page-title">
    <h2><?= $title; ?></h2>
</div>

<div class="ajax-container">
    <div class="row mb-3">
        <div class="col-md-12">
            <button id="btnTambah" class="btn btn-primary">Tambah Artikel Baru</button>
        </div>
    </div>

    <!-- Alert untuk menampilkan pesan -->
    <div id="alert" class="alert" style="display: none;"></div>

    <table class="table table-striped" id="artikelTable">
        <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<!-- Modal Form -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModalLabel">Form Artikel</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formArtikel">
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="judul" class="form-label">Judul</label>
                        <input type="text" class="form-control" id="judul" name="judul" required>
                    </div>
                    <div class="form-group">
                        <label for="isi" class="form-label">Isi</label>
                        <textarea class="form-control" id="isi" name="isi" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="id_kategori" class="form-label">Kategori</label>
                        <select class="form-control" id="id_kategori" name="id_kategori" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $k): ?>
                                <option value="<?= $k['id_kategori']; ?>"><?= $k['nama_kategori']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="btnSimpan">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        // Setup CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Function untuk menampilkan pesan loading
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="5" class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div> Loading data...</td></tr>');
        }

        // Function untuk menampilkan pesan alert
        function showAlert(message, type) {
            $('#alert').removeClass().addClass('alert alert-' + type).html(message).show();
            setTimeout(function () {
                $('#alert').hide();
            }, 3000);
        }

        // Function untuk memuat data artikel
        function loadData() {
            showLoadingMessage();

            $.ajax({
                url: "<?= base_url('ajax/getData') ?>",
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var tableBody = "";
                    if (data.length > 0) {
                        for (var i = 0; i < data.length; i++) {
                            var row = data[i];
                            tableBody += '<tr>';
                            tableBody += '<td>' + row.id + '</td>';
                            tableBody += '<td>' + row.judul + '</td>';
                            tableBody += '<td><span class="badge badge-info">' + (row.nama_kategori || 'Tidak ada kategori') + '</span></td>';
                            tableBody += '<td><span class="badge badge-success">' + row.status + '</span></td>';
                            tableBody += '<td class="table-actions">';
                            tableBody += '<button class="btn btn-sm btn-info btn-edit" data-id="' + row.id + '">Edit</button> ';
                            tableBody += '<button class="btn btn-sm btn-danger btn-delete" data-id="' + row.id + '">Hapus</button>';
                            tableBody += '</td>';
                            tableBody += '</tr>';
                        }
                    } else {
                        tableBody = '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
                    }
                    $('#artikelTable tbody').html(tableBody);
                },
                error: function (xhr, status, error) {
                    $('#artikelTable tbody').html('<tr><td colspan="5" class="text-center text-danger">Error: ' + error + '</td></tr>');
                    console.error(xhr.responseText);
                }
            });
        }

        // Load data saat halaman dimuat
        loadData();

        // Event handler untuk tombol Tambah
        $('#btnTambah').click(function () {
            $('#formArtikel')[0].reset();
            $('#id').val('');
            $('#formModalLabel').text('Tambah Artikel Baru');
            $('#formModal').modal('show');
        });

        // Event handler untuk tombol Edit
        $(document).on('click', '.btn-edit', function () {
            var id = $(this).data('id');

            $.ajax({
                url: "<?= base_url('ajax/getById/') ?>" + id,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    $('#id').val(data.id);
                    $('#judul').val(data.judul);
                    $('#isi').val(data.isi);
                    $('#id_kategori').val(data.id_kategori);

                    $('#formModalLabel').text('Edit Artikel');
                    $('#formModal').modal('show');
                },
                error: function (xhr, status, error) {
                    showAlert('Gagal mengambil data: ' + error, 'danger');
                }
            });
        });

        // Event handler untuk tombol Simpan
        $('#btnSimpan').click(function () {
            if ($('#judul').val() == '' || $('#isi').val() == '' || $('#id_kategori').val() == '') {
                showAlert('Semua field harus diisi!', 'warning');
                return;
            }

            var formData = $('#formArtikel').serialize();

            $.ajax({
                url: "<?= base_url('ajax/save') ?>",
                method: "POST",
                data: formData,
                dataType: "json",
                success: function (response) {
                    if (response.status == 'success') {
                        $('#formModal').modal('hide');
                        showAlert(response.message, 'success');
                        loadData();
                    } else {
                        showAlert(response.message, 'danger');
                    }
                },
                error: function (xhr, status, error) {
                    showAlert('Terjadi kesalahan: ' + error, 'danger');
                    console.error(xhr.responseText);
                }
            });
        });

        // Event handler untuk tombol Hapus
        $(document).on('click', '.btn-delete', function () {
            var id = $(this).data('id');

            if (confirm('Apakah Anda yakin ingin menghapus artikel ini?')) {
                $.ajax({
                    url: "<?= base_url('ajax/delete/') ?>" + id,
                    method: "DELETE",
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 'success') {
                            showAlert(response.message, 'success');
                            loadData();
                        } else {
                            showAlert(response.message, 'danger');
                        }
                    },
                    error: function (xhr, status, error) {
                        showAlert('Terjadi kesalahan: ' + error, 'danger');
                        console.error(xhr.responseText);
                    }
                });
            }
        });
    });
</script>

<?= $this->include('template/admin_footer'); ?>
