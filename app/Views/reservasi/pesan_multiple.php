<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Kamar - Hotel Ade</title>
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
        <form action="<?= site_url('pemesanan') ?>" method="post" class="mx-5">
            <!-- Formulir Kamar Lain -->
            <div id="additional_rooms">
                <h4 class="mb-3">Pilih Kamar</h4>
                <div class="row" id="room-container">
                    <?php foreach ($kamar as $index => $item) : ?>
                        <div class="col-md-4 mb-3 room-item" <?php if ($index >= 6) echo 'style="display: none;"'; ?>>
                            <div class="card room-card" id="room-card-<?= $item['id'] ?>">
                                <?php
                                $urls = [
                                    "https://plus.unsplash.com/premium_photo-1678297269980-16f4be3a15a6?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1445991842772-097fea258e7b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://plus.unsplash.com/premium_photo-1661964071015-d97428970584?q=80&w=1920&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1495365200479-c4ed1d35e1aa?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://plus.unsplash.com/premium_photo-1687960116497-0dc41e1808a2?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1468824357306-a439d58ccb1c?q=80&w=1959&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1506059612708-99d6c258160e?q=80&w=2069&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://plus.unsplash.com/premium_photo-1675745329378-5573c360f69f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1590381105924-c72589b9ef3f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1527853787696-f7be74f2e39a?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1561501878-aabd62634533?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://plus.unsplash.com/premium_photo-1661881436846-5a0f53025711?q=80&w=1856&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1529290130-4ca3753253ae?q=80&w=1776&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1507038772120-7fff76f79d79?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
                                    "https://images.unsplash.com/photo-1512918728675-ed5a9ecdebfd?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                ];

                                $imageUrl = $urls[array_rand($urls)];
                                ?>
                                <img src="<?= $imageUrl ?>" alt="Gambar Kamar" class="card-img-top">
                                <div class="card-body">
                                    <h5 class="card-title"><?= $item['nama_kamar'] ?></h5>
                                    <p class="card-text"><?= $item['deskripsi'] ?></p>
                                    <p class="card-text mb-0">Tersedia <strong><?= $item['jumlah_kamar'] - $item['jumlah_pesan'] ?> Kamar</strong></p>
                                    <p class="card-text"><strong>Harga:</strong> Rp. <?= number_format($item['harga'], 0, ',', '.') ?> per malam</p>
                                    <button type="button" class="btn btn-primary btn-order-room w-100 mb-3" data-room-id="<?= $item['id'] ?>" id="btn-order-<?= $item['id'] ?>">Pilih Kamar Ini</button>
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
                <div class="text-center mb-5">
                    <button id="load-more" class="btn btn-primary">Lihat Lebih >></button>
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
                    button.textContent = 'Pilih Kamar Ini';
                    button.classList.remove('btn-danger');
                    button.classList.add('btn-primary');
                }
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            let roomsToShow = 6;
            let totalRooms = document.querySelectorAll('.room-item').length;

            // Hide all rooms initially
            document.querySelectorAll('.room-item').forEach(function(room, index) {
                if (index >= roomsToShow) {
                    room.style.display = 'none';
                }
            });

            document.getElementById('load-more').addEventListener('click', function() {
                roomsToShow += 3;
                document.querySelectorAll('.room-item').forEach(function(room, index) {
                    if (index < roomsToShow) {
                        room.style.display = 'block';
                    }
                });

                // Hide "Lihat Lebih" button if all rooms are shown
                if (roomsToShow >= totalRooms) {
                    document.getElementById('load-more').style.display = 'none';
                }
            });
        });
    </script>
</body>

</html>