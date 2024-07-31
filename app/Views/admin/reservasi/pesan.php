<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Kamar - Hotel Iksal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Formulir Pemesanan Kamar</h2>
        <form action="<?= site_url('kamar/pesan/' . $id_kamar) ?>" method="post" class="mx-5">
            <div class="mb-3">
                <label for="kamar_info" class="form-label">Informasi Kamar</label>
                <textarea id="kamar_info" class="form-control" rows="7" disabled style="line-height: 1.5; font-weight:bold">
<?= htmlspecialchars($kamar['nama_kamar']) ?>


Deskripsi: <?= htmlspecialchars($kamar['deskripsi']) ?>

Tipe Kamar: <?= htmlspecialchars($kamar['tipe_kamar']) ?>

Jumlah Kamar: <?= htmlspecialchars($kamar['jumlah_kamar']) ?>

Harga: Rp. <?= number_format($kamar['harga'], 0, ',', '.') ?> per/malam
                </textarea>

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
                <label for="no_hp" class="form-label">No. HP</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_check_in" class="form-label">Tanggal Check-In</label>
                <input type="date" class="form-control" id="tanggal_check_in" name="tanggal_check_in" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_check_out" class="form-label">Tanggal Check-Out</label>
                <input type="date" class="form-control" id="tanggal_check_out" name="tanggal_check_out" required>
            </div>
            <div class="text-end mt-5">
                <a href="<?= site_url('') ?>" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>