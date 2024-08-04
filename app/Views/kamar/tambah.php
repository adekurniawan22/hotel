<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kamar</h1>
    </div>

    <!-- Form Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= site_url('kamar/store') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="nama_kamar" class="form-label">Nama Kamar</label>
                    <input type="text" class="form-control" id="nama_kamar" name="nama_kamar" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
                    <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" required>
                </div>

                <div class="mb-3">
                    <label for="maksimal_kapasitas" class="form-label">Maksimal Kapasitas</label>
                    <input type="number" class="form-control" id="maksimal_kapasitas" name="maksimal_kapasitas" required>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" required>
                </div>

                <div class="mb-3">
                    <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
                    <input type="number" class="form-control" id="jumlah_kamar" name="jumlah_kamar" required>
                </div>

                <div class="text-right mb-2 mt-4">
                    <a href="<?= site_url('kamar') ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>