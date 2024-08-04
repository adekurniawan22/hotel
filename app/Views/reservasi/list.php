<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Reservasi</h1>
        <a href="<?= base_url('/reservasi/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-solid fa-plus fa-sm text-white-50"></i> Tambah Reservasi</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="reservasiDataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Pemesan</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 17%" data-sortable="false">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservasi as $item) : ?>
                            <tr data-id="<?= esc($item['id']) ?>">
                                <td><?= esc($item['id']) ?></td>
                                <td><?= esc($item['nama_pemesan']) ?></td>
                                <td><?= esc($item['email']) ?></td>
                                <td><?= esc($item['no_hp']) ?></td>
                                <td class="checkin-date"><?= esc($item['tanggal_checkin']) ?></td>
                                <td><?= esc($item['tanggal_checkout']) ?></td>
                                <td id="status-<?= esc($item['id']) ?>">
                                    <p class="mb-3">
                                        <?php
                                        $statusIcon = '';
                                        switch ($item['status']) {
                                            case 'pending':
                                                $statusIcon = '<i class="fas fa-hourglass-start text-warning"></i> ';
                                                break;
                                            case 'dikonfirmasi':
                                                $statusIcon = '<i class="fas fa-check-circle text-primary"></i> ';
                                                break;
                                            case 'check-in':
                                                $statusIcon = '<i class="fas fa-door-open text-info"></i> ';
                                                break;
                                            case 'selesai':
                                                $statusIcon = '<i class="fas fa-check-double text-success"></i> ';
                                                break;
                                            case 'gagal':
                                                $statusIcon = '<i class="fas fa-times-circle text-danger"></i> ';
                                                break;
                                        }
                                        ?>
                                        <?= $statusIcon . ucfirst(esc($item['status'])) ?>
                                    </p>
                                    <?php
                                    $userInfos = [];

                                    if ($item['status'] == 'selesai' || $item['status'] == 'dikonfirmasi') {
                                        if (!is_null($item['dikonfirmasi'])) {
                                            $userInfos[] = ['label' => 'Dikonfirmasi oleh', 'id' => $item['dikonfirmasi']];
                                        }
                                    }

                                    if (!empty($userInfos)) {
                                        $db = \Config\Database::connect();
                                        $builder = $db->table('user');
                                        foreach ($userInfos as $userInfo) {
                                            $builder->where('id', $userInfo['id']);
                                            $user = $builder->get()->getRow();
                                            $userName = $user ? esc($user->nama) : 'User not found';

                                            echo '<div style="margin-bottom: 5px; font-size: 0.9em;">';
                                            echo '<strong style="color: #333;">' . esc($userInfo['label']) . ':</strong> ';
                                            echo '<span style="color: #555;">' . $userName . '</span>';
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                                </td>

                                <td class="text-center">
                                    <button type="button" class="btn btn-info btn-sm mb-1 btn-detail" data-id="<?= esc($item['id']) ?>">Detail</button>
                                    <a href="<?= site_url('reservasi/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#deleteModal" data-url="<?= site_url('reservasi/delete/' . $item['id']) ?>">Hapus</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail Reservasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Konten modal akan dimuat di sini -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        var table = $('#reservasiDataTable').DataTable({
            order: [
                [0, "desc"]
            ], // Sorting by the first column in descending order
            columnDefs: [{
                    visible: false,
                    targets: 0
                }, // Hiding the first column (ID Reservasi)
            ],
        });

        // Fungsi untuk memeriksa tanggal check-in dan memperbarui status
        function updatePendingStatus() {
            // Mendapatkan tanggal saat ini dalam zona waktu Indonesia
            var currentDate = new Date().toISOString().split('T')[0];
            // Membuat objek Date dari tanggal saat ini
            var currentDateObj = new Date(currentDate);

            table.rows().every(function() {
                var row = this.node();
                var id = $(row).data('id');
                var statusCell = $('#status-' + id);
                var checkinDate = $(row).find('.checkin-date').text().trim();

                // Membuat objek Date dari tanggal check-in
                var checkinDateObj = new Date(checkinDate);
                console.log("Tanggal checkin : " + checkinDate)
                console.log("Tanggal saat ini : " + currentDate)

                // Menghitung selisih hari antara tanggal check-in dan tanggal saat ini
                var oneDay = 24 * 60 * 60 * 1000; // Jumlah milidetik dalam sehari
                var diffDays = Math.round((checkinDateObj - currentDateObj) / oneDay);

                // Jika status masih pending dan 1 hari sebelum tanggal check-in, lakukan AJAX
                if (statusCell.length && statusCell.text().includes('Pending') && diffDays <= 1) {
                    setTimeout(function() {
                        $.ajax({
                            url: '<?= site_url('reservasi/update_status') ?>',
                            type: 'POST',
                            data: {
                                id: id,
                                status: 'gagal'
                            },
                            success: function(response) {
                                console.log(response);
                                if (response.success) {
                                    statusCell.html('<i class="fas fa-times-circle text-danger"></i> Gagal');
                                } else {
                                    console.error('Gagal memperbarui status');
                                }
                            },
                            error: function() {
                                console.error('Terjadi kesalahan saat memperbarui status.');
                            }
                        });
                    }, 5000); // Tunggu 10 detik
                }
            });
        }

        updatePendingStatus();

        // Ketika tombol Detail diklik
        $('.btn-detail').on('click', function() {
            var id = $(this).data('id'); // Ambil ID dari atribut data-id
            $.ajax({
                url: '<?= site_url('reservasi/detail') ?>', // URL endpoint untuk mendapatkan detail
                type: 'POST', // Menggunakan POST
                data: {
                    id: id
                }, // Kirim ID sebagai parameter
                dataType: 'json',
                success: function(response) {
                    var totalHarga = 0;
                    var modalBody = `
                    <div style="line-height: 2;" class="mb-3">
                        <div><strong>Nama Pemesan:</strong> ${response.nama_pemesan}</div>
                        <div><strong>Email:</strong> ${response.email}</div>
                        <div><strong>No HP:</strong> ${response.no_hp}</div>
                        <div><strong>Tanggal Check-In:</strong> ${response.tanggal_checkin}</div>
                        <div><strong>Tanggal Check-Out:</strong> ${response.tanggal_checkout}</div>
                        <div><strong>Status:</strong> <span style="text-transform: capitalize;">${response.status}</span></div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Kamar</th>
                                <th style="text-align: center;">Harga</th>
                                <th style="text-align: center;">Jumlah Kamar</th>
                                <th style="text-align: center;">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                    // Iterasi melalui data detail dan buat baris tabel
                    $.each(response.details, function(index, item) {
                        var itemTotal = parseFloat(item.harga) * parseInt(item.jumlah_kamar);
                        totalHarga += itemTotal;

                        modalBody += `
                        <tr>
                            <td>${item.nama_kamar}</td>
                            <td style="text-align: center;">${formatRupiah(item.harga)}</td>
                            <td style="text-align: center;">x ${item.jumlah_kamar}</td>
                            <td style="text-align: center;">${formatRupiah(itemTotal.toFixed(0))}</td>
                        </tr>
                    `;
                    });

                    // Tambahkan baris total
                    modalBody += `
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-right">Total</th>
                                <th style="text-align: center;">${formatRupiah(totalHarga.toFixed(0))}</th>
                            </tr>
                        </tfoot>
                    </table>
                `;

                    $('#detailModal .modal-body').html(modalBody);
                    $('#detailModal').modal('show'); // Tampilkan modal
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat data.');
                }
            });
        });

        // Fungsi untuk format angka ke format Rupiah
        function formatRupiah(angka) {
            var number_string = angka.toString().replace(/[^,\d]/g, '');
            var split = number_string.split(',');
            var sisa = split[0].length % 3;
            var rupiah = split[0].substr(0, sisa);
            var ribuan = split[0].substr(sisa).match(/\d{3}/gi);
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return 'Rp. ' + rupiah;
        }
    });
</script>
<?= $this->endSection() ?>