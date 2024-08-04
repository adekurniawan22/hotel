<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kamar</h1>
        <a href="<?= base_url('/kamar/create') ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fa-solid fa-plus fa-sm text-white-50"></i> Tambah Kamar</a>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama Kamar</th>
                            <th>Jumlah Kamar</th>
                            <th>Deskripsi</th>
                            <th>Tipe Kamar</th>
                            <th>Harga</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kamar as $item) : ?>
                            <tr>
                                <td><?= esc($item['nama_kamar']) ?></td>
                                <td><?= esc($item['jumlah_kamar']) ?></td>
                                <td><?= esc($item['deskripsi']) ?></td>
                                <td><?= esc($item['tipe_kamar']) ?></td>
                                <td><?= esc($item['harga']) ?></td>
                                <td>
                                    <a href="<?= site_url('kamar/edit/' . $item['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal" data-url="<?= site_url('kamar/delete/' . $item['id']) ?>">Hapus</button>
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