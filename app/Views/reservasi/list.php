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
                            <th>Nama Kamar</th>
                            <th>Nama Pemesan</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Tanggal Check-In</th>
                            <th>Tanggal Check-Out</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reservasi as $item) : ?>
                            <tr>
                                <td><?= esc($item['id_reservasi']) ?></td>
                                <td><?= esc($item['nama_kamar']) ?></td>
                                <td><?= esc($item['nama_pemesan']) ?></td>
                                <td><?= esc($item['email']) ?></td>
                                <td><?= esc($item['no_hp']) ?></td>
                                <td><?= esc($item['tanggal_check_in']) ?></td>
                                <td><?= esc($item['tanggal_check_out']) ?></td>
                                <td>
                                    <p class="mb-3"><?= ucfirst(esc($item['status'])) ?></p>

                                    <?php
                                    // Menyiapkan array untuk menyimpan informasi pengguna yang akan ditampilkan
                                    $userInfos = [];

                                    if ($item['status'] == 'selesai') {
                                        // Jika status selesai, tampilkan nama dari diproses_oleh dan diselesaikan_oleh
                                        if (!is_null($item['diproses_oleh'])) {
                                            $userInfos[] = ['label' => 'Diproses oleh', 'id' => $item['diproses_oleh']];
                                        }
                                        if (!is_null($item['diselesaikan_oleh'])) {
                                            $userInfos[] = ['label' => 'Diselesaikan oleh', 'id' => $item['diselesaikan_oleh']];
                                        }
                                    } elseif ($item['status'] == 'diproses') {
                                        // Jika status diproses, tampilkan nama dari diproses_oleh
                                        if (!is_null($item['diproses_oleh'])) {
                                            $userInfos[] = ['label' => 'Diproses oleh', 'id' => $item['diproses_oleh']];
                                        }
                                    }

                                    // Mengambil dan menampilkan nama pengguna
                                    if (!empty($userInfos)) {
                                        $db = \Config\Database::connect();
                                        $builder = $db->table('user'); // Ganti 'user' dengan tabel pengguna Anda

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


                                <td>
                                    <a href="<?= site_url('reservasi/edit/' . $item['id_reservasi']) ?>" class="btn btn-warning btn-sm mb-1">Edit</a>
                                    <a href="<?= site_url('reservasi/delete/' . $item['id_reservasi']) ?>" class="btn btn-danger btn-sm mb-1">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= $this->endSection() ?>