<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Reservasi</h1>
    </div>

    <!-- Form Example -->
    <div class="card shadow mb-4">
        <div class="card-body">
            <form action="<?= site_url('reservasi/update/' . $reservasi['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="id_kamar" class="form-label">Nama Kamar</label>
                    <select class="form-control" id="id_kamar" name="id_kamar" required>
                        <?php foreach ($kamar as $item) : ?>
                            <option value="<?= $item['id'] ?>" <?= $item['id'] == $reservasi['id_kamar'] ? 'selected' : '' ?>>
                                <?= esc($item['nama_kamar']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="nama_pemesan" class="form-label">Nama Pemesan</label>
                    <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" value="<?= esc($reservasi['nama_pemesan']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= esc($reservasi['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= esc($reservasi['no_hp']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_check_in" class="form-label">Tanggal Check-In</label>
                    <input type="date" class="form-control" id="tanggal_check_in" name="tanggal_check_in" value="<?= esc($reservasi['tanggal_check_in']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="tanggal_check_out" class="form-label">Tanggal Check-Out</label>
                    <input type="date" class="form-control" id="tanggal_check_out" name="tanggal_check_out" value="<?= esc($reservasi['tanggal_check_out']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" <?= $reservasi['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                        <option value="selesai" <?= $reservasi['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                        <option value="diproses" <?= $reservasi['status'] == 'diproses' ? 'selected' : '' ?>>Diproses</option>
                        <option value="gagal" <?= $reservasi['status'] == 'gagal' ? 'selected' : '' ?>>Gagal</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="<?= site_url('reservasi') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>