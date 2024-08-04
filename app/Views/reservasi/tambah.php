<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Reservasi</h1>
    </div>

    <!-- Tabel Data Kamar -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kamar</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="kamarReservasiTable" class="table table-bordered" id="dataKamar" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;" class="text-center"></th>
                            <th>Nama Kamar</th>
                            <th>Tipe Kamar</th>
                            <th>Deskripsi</th>
                            <th>Kapasitas</th>
                            <th>Harga</th>
                            <th style="width: 15%;">Jumlah Kamar</th>
                            <th style="width: 15%;">Jumlah Pesan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kamar as $item) : ?>
                            <tr>
                                <td class="text-center">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" data-id-kamar="<?= $item['id'] ?>" data-nama-kamar="<?= $item['nama_kamar'] ?>">
                                    </div>
                                </td>
                                <td><?= esc($item['nama_kamar']) ?></td>
                                <td><?= esc($item['tipe_kamar']) ?></td>
                                <td><?= esc($item['deskripsi']) ?></td>
                                <td><?= esc($item['maksimal_kapasitas']) ?> Orang</td>
                                <td><?= "Rp. " . number_format($item['harga'], 0, ',', '.') ?></td>
                                <td><?= esc($item['jumlah_pesan']) ?>/<?= esc($item['jumlah_kamar']) ?> Kamar</td>
                                <td>
                                    <input type="number" min="1" value="1" class="form-control" data-jumlah-pesan="">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Form Reservasi -->
    <div class=" card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Pemesan</h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('reservasi/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="kamar" class="form-label">Kamar</label>
                    <textarea class="form-control" name="kamar" id="" rows="5" readonly></textarea>
                </div>

                <div class="mb-3">
                    <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                    <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_checkin" class="form-label">Tanggal Check-In</label>
                    <input type="date" class="form-control" id="tanggal_checkin" name="tanggal_checkin" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_checkout" class="form-label">Tanggal Check-Out</label>
                    <input type="date" class="form-control" id="tanggal_checkout" name="tanggal_checkout" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" data-icon="fas fa-hourglass-start">Pending</option>
                        <option value="dikonfirmasi" data-icon="fas fa-check-circle">Dikonfirmasi</option>
                        <option value="check-in" data-icon="fas fa-door-open">Check-In</option>
                        <option value="selesai" data-icon="fas fa-check-double">Selesai</option>
                        <option value="gagal" data-icon="fas fa-times-circle">Gagal</option>
                    </select>
                </div>

                <div class="text-right mb-2 mt-4">
                    <a href="<?= site_url('reservasi') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tambahkan script di akhir body atau di file JS terpisah -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Reset localStorage saat halaman dimuat
        localStorage.removeItem('checkedItems');

        // Menyembunyikan input number secara default
        $('#kamarReservasiTable tbody input[type="number"]').hide();

        // Mengambil status checklist dari localStorage jika ada
        const checkedItems = JSON.parse(localStorage.getItem('checkedItems')) || {};

        // Menandai checkbox dan input number yang sudah dicentang
        $('#kamarReservasiTable tbody input[type="checkbox"]').each(function() {
            const id = $(this).data('id-kamar');
            const inputNumber = $(this).closest('tr').find('input[type="number"]');

            if (checkedItems[id]) {
                $(this).prop('checked', true);
                inputNumber.val(checkedItems[id].jumlahPesan).show();
            } else {
                inputNumber.hide();
            }
        });

        // Event listener untuk checkbox
        $('#kamarReservasiTable tbody').on('change', 'input[type="checkbox"]', function() {
            const id = $(this).data('id-kamar');
            const namaKamar = $(this).data('nama-kamar');
            const inputNumber = $(this).closest('tr').find('input[type="number"]');

            if ($(this).is(':checked')) {
                inputNumber.show();
                checkedItems[id] = {
                    namaKamar: namaKamar || 'Nama Kamar Tidak Diketahui',
                    jumlahPesan: inputNumber.val() || '0'
                };
            } else {
                inputNumber.hide();
                delete checkedItems[id];
            }

            localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
            updateTextarea();
            toggleSubmitButton();
        });

        // Event listener untuk input number
        $('#kamarReservasiTable tbody').on('input', 'input[type="number"]', function() {
            const id = $(this).closest('tr').find('input[type="checkbox"]').data('id-kamar');
            const jumlahPesan = $(this).val();

            if (checkedItems[id]) {
                checkedItems[id].jumlahPesan = jumlahPesan || '0';
                localStorage.setItem('checkedItems', JSON.stringify(checkedItems));
                updateTextarea();
            }
        });

        // Update textarea dengan data dari localStorage
        function updateTextarea() {
            const textarea = $('textarea[name="kamar"]');
            let text = '';
            for (const id in checkedItems) {
                const item = checkedItems[id];
                text += `${item.namaKamar} dan ${item.jumlahPesan} pesan\n`;
            }
            textarea.val(text);
        }

        // Inisialisasi textarea dengan data yang ada di localStorage
        updateTextarea();

        // Menambahkan input tersembunyi ke form saat submit
        $('form').on('submit', function(e) {
            // Cek jika tidak ada item yang dicentang
            if (Object.keys(checkedItems).length === 0) {
                e.preventDefault(); // Mencegah pengiriman form
                alert('Harap pilih setidaknya satu kamar.');
                return;
            }

            // Menghapus input tersembunyi yang sudah ada
            $('form').find('input[name^="kamar"]').remove();

            // Menambahkan input tersembunyi untuk setiap item yang dicentang
            for (const id in checkedItems) {
                const item = checkedItems[id];
                $('<input>').attr({
                    type: 'hidden',
                    name: 'kamar_id[]',
                    value: id
                }).appendTo('form');
                $('<input>').attr({
                    type: 'hidden',
                    name: 'jumlah_pesan[]',
                    value: item.jumlahPesan
                }).appendTo('form');
            }
        });

        // Fungsi untuk menonaktifkan tombol submit jika tidak ada kamar yang dicentang
        function toggleSubmitButton() {
            const anyChecked = $('#kamarReservasiTable tbody input[type="checkbox"]:checked').length > 0;
            $('button[type="submit"]').prop('disabled', !anyChecked);
        }

        // Inisialisasi status tombol submit saat halaman dimuat
        toggleSubmitButton();
    });
</script>


<?= $this->endSection() ?>