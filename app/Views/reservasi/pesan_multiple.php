<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Kamar - Hotel Iksal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="<?= base_url('assets/img/icon.svg') ?>" type="image/x-icon">
    <style>
        .room-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .room-card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        #additional_rooms {
            transition: opacity 0.3s ease;
        }

        .input-jumlah {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Formulir Pemesanan Kamar</h2>
        <form action="<?= site_url('kamar/pesan') ?>" method="post" class="mx-5">
            <!-- Formulir Kamar Lain -->
            <div id="additional_rooms">
                <h4 class="mb-3">Pilih Kamar</h4>
                <div class="row">
                    <?php foreach ($kamar as $item) : ?>
                        <div class="col-md-4 mb-3">
                            <div class="card room-card" id="room-card-<?= $item['id'] ?>">
                                <?php
                                $imageUrl = 'https://picsum.photos/500/300?random=' . rand(1, 9999);
                                ?>
                                <img src="<?= $imageUrl ?>" alt="Gambar Kamar" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['nama_kamar'] ?></h5>
                                    <p class="card-text"><?= $item['deskripsi'] ?></p>
                                    <p class="card-text mb-0">Tersedia <strong><?= $item['jumlah_kamar'] - $item['jumlah_pesan'] ?> Kamar</strong></p>
                                    <p class="card-text"><strong>Harga:</strong> Rp. <?= number_format($item['harga'], 0, ',', '.') ?> per malam</p>
                                    <button type="button" class="btn btn-primary btn-order-room w-100 mb-3" data-room-id="<?= $item['id'] ?>" id="btn-order-<?= $item['id'] ?>">Pesan Kamar Ini</button>
                                    <div class="input-jumlah text-center" id="input-jumlah-<?= $item['id'] ?>" style="display: none;">
                                        <label for="jumlah_<?= $item['id'] ?>" class="form-label">Jumlah Kamar Yang Dipesan</label>
                                        <input type="hidden" value="<?= $item['id'] ?>" id="kamar_<?= $item['id'] ?>">
                                        <input type="number" class="form-control" id="jumlah_<?= $item['id'] ?>" min="1" max="<?= $item['jumlah_kamar'] - $item['jumlah_pesan'] ?>" placeholder="Masukkan jumlah pesan">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>

            <!-- Data Pemesan -->
            <div class="card">
                <div class="card-body">
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
                        <label for="tanggal_checkin" class="form-label">Tanggal Check-In</label>
                        <input type="date" class="form-control" id="tanggal_checkin" name="tanggal_checkin" required>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_checkout" class="form-label">Tanggal Check-Out</label>
                        <input type="date" class="form-control" id="tanggal_checkout" name="tanggal_checkout" required>
                    </div>
                </div>
            </div>

            <div class="text-end mt-4">
                <a href="<?= site_url('') ?>" class="btn btn-secondary me-2">Kembali</a>
                <button type="submit" class="btn btn-primary">Pesan Sekarang</button>
            </div>

        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.btn-order-room').forEach(function(button) {
            button.addEventListener('click', function() {
                var roomId = this.getAttribute('data-room-id');
                var inputJumlah = document.getElementById('input-jumlah-' + roomId);
                var inputJumlahValue = document.getElementById('jumlah_' + roomId);
                var inputKamarValue = document.getElementById('kamar_' + roomId);
                var button = this;

                // Toggle display of the input number
                if (inputJumlah.style.display === 'none' || inputJumlah.style.display === '') {
                    inputJumlah.style.display = 'block';
                    inputJumlahValue.value = 1; // Set default value to 1
                    inputJumlahValue.setAttribute('name', 'jumlah[]'); // Set name attribute
                    inputKamarValue.setAttribute('name', 'kamar[]'); // Set name attribute
                    button.textContent = 'Batalkan';
                    button.classList.remove('btn-primary');
                    button.classList.add('btn-danger');
                } else {
                    inputJumlah.style.display = 'none';
                    inputJumlahValue.value = ''; // Clear value when not displayed
                    inputJumlahValue.removeAttribute('name'); // Remove name attribute
                    button.textContent = 'Pesan Kamar Ini';
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');
                }
            });
        });
    </script>
</body>

</html>