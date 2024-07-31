<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Iksal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lobibox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lobibox@1.2.7/dist/css/lobibox.min.css">
    <style>
        .hero-section {
            background: url('https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center/cover;
            padding: 100px 0;
            color: #fff;
            position: relative;
            text-align: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 0;
        }

        .hero-section h1,
        .hero-section p,
        .hero-section a {
            position: relative;
            z-index: 1;
        }

        .room-card {
            cursor: pointer;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .room-card .room-type {
            top: 0;
            left: 0;
            width: 100%;
            height: 150px;
            background-color: #eee;
            color: #343a40;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            z-index: 1;
        }

        .room-card .card-body {
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        .room-card:hover .room-type {
            background-color: rgba(0, 123, 255, 1);
            color: #fff;
        }

        .footer {
            background-color: #343a40;
            padding: 20px 0;
            color: #f8f9fa;
        }

        .footer a {
            color: #007bff;
        }

        .footer a:hover {
            color: #0056b3;
            text-decoration: none;
        }

        .social-icons a {
            color: #f8f9fa;
            margin: 0 10px;
            font-size: 1.5rem;
        }
    </style>
</head>

<body>
    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <h1 class="display-4">Selamat Datang di Hotel Iksal</h1>
            <p class="lead">Nikmati pengalaman mewah dan kenyamanan bersama kami. Kami berkomitmen untuk memberikan pelayanan terbaik bagi Anda dengan fasilitas yang modern dan suasana yang nyaman. Apapun tujuan kunjungan Anda, baik untuk liburan atau bisnis, kami siap untuk membuat pengalaman Anda menginap menjadi tak terlupakan.</p>
            <a href="#rooms" class="btn btn-primary btn-lg">Lihat Kamar Kami</a>
        </div>
    </header>

    <!-- Rooms Section -->
    <section id="rooms" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Kamar Kami</h2>
            <div class="row">
                <?php foreach ($kamar as $item) : ?>
                    <div class="col-md-4 mb-3">
                        <div class="card room-card">
                            <div class="room-type"><?= htmlspecialchars($item['tipe_kamar'], ENT_QUOTES, 'UTF-8') ?></div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item['nama_kamar'], ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($item['jumlah_kamar'], ENT_QUOTES, 'UTF-8') ?> Kamar)</h5>
                                <p class="card-text"><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="card-text"><strong>Harga:</strong> Rp. <?= number_format($item['harga'], 0, ',', '.') ?> per/malam</p>
                                <a class="btn btn-primary w-100" href="<?= site_url('kamar/pesan/' . $item['id']) ?>">PESAN</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 Hotel Iksal.</p>
            <div class="social-icons">
                <a href="#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets') ?>/vendor/jquery/jquery.min.js"></script>
    <!-- Lobibox JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/lobibox@1.2.7/dist/js/lobibox.min.js"></script>

    <script>
        $(document).ready(function() {
            // Notification Success
            <?php if (session()->has('success')) : ?>

                function notifSuccess() {
                    Lobibox.notify('success', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'fa-regular fa-circle-check',
                        msg: '<?= session()->getFlashdata('success') ?>'
                    });
                }
                notifSuccess();
            <?php endif ?>

            // Notification Error
            <?php if (session()->has('error')) : ?>

                function notifError() {
                    Lobibox.notify('error', {
                        pauseDelayOnHover: true,
                        continueDelayOnInactiveTab: false,
                        position: 'top right',
                        icon: 'fa-regular fa-circle-xmark',
                        msg: '<?= session()->getFlashdata('error') ?>'
                    });
                }
                notifError();
            <?php endif ?>
        });
    </script>
</body>

</html>