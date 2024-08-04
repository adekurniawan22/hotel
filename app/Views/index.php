<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicon -->
    <link rel="icon" href="<?= base_url('assets/img/icon.svg') ?>" type="image/x-icon">
    <title>Hotel Iksal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Lobibox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lobibox@1.2.7/dist/css/lobibox.min.css">
    <style>
        .hero-section {
            background: url('https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D') no-repeat center center/cover;
            padding: 120px 0;
            color: #fff;
            text-align: center;
            position: relative;
            overflow: hidden;
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

        .hero-section h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .hero-section p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .hero-section a {
            font-size: 1.25rem;
        }

        .room-card {
            cursor: pointer;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .room-card:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .room-card .room-type {
            background-color: #007bff;
            color: #fff;
            font-size: 1.25rem;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        .room-card .card-body {
            padding: 20px;
        }

        .footer {
            background-color: #343a40;
            padding: 10px 0;
            color: #f8f9fa;
        }

        .footer p {
            margin-bottom: 10px;
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
            margin: 0 15px;
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .hero-section h1 {
                font-size: 2.5rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .room-card .room-type {
                font-size: 1rem;
                padding: 10px;
            }
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
                    <div class="col-md-4 mb-4">
                        <div class="card room-card">
                            <?php
                            $imageUrl = 'https://picsum.photos/500/300?random=' . rand(1, 9999);
                            ?>
                            <img src="<?= htmlspecialchars($imageUrl, ENT_QUOTES, 'UTF-8') ?>" class="card-img-top" alt="Gambar Hotel">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($item['nama_kamar'], ENT_QUOTES, 'UTF-8') ?></h5>
                                <p class="card-text"><?= htmlspecialchars($item['deskripsi'], ENT_QUOTES, 'UTF-8') ?></p>
                                <p class="card-text mb-0"><strong>Tersedia:</strong> <?= htmlspecialchars($item['jumlah_kamar'] - $item['jumlah_pesan'], ENT_QUOTES, 'UTF-8') ?> kamar</p>
                                <p class="card-text"><strong>Harga:</strong> Rp <?= number_format($item['harga'], 0, ',', '.') ?>/malam</p>
                                <a class="btn btn-primary w-100" href="<?= site_url('pemesanan/' . $item['id']) ?>">PESAN SEKARANG</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <!-- Bulk Booking Section -->
    <section id="bulk-booking" class="py-5 bg-light">
        <div class="container text-center">
            <h2 class="mb-4">Pesan Beberapa Kamar Sekaligus</h2>
            <p class="mb-4">Dengan fitur pemesanan kamar secara banyak, Anda dapat merencanakan kunjungan grup atau acara khusus dengan lebih praktis dan efisien. Apakah Anda memerlukan beberapa kamar untuk keluarga, teman, atau rekan bisnis, proses pemesanan kami dirancang untuk memudahkan Anda. Cukup klik tombol di bawah ini untuk melakukan pemesanan kamar secara langsung dan nikmati kemudahan mengatur akomodasi untuk seluruh grup Anda.</p>
            <a href="<?= site_url('/pemesanan') ?>" class="btn btn-primary btn-lg">Pesan Kamar Sekarang</a>
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