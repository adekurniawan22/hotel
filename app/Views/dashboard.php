<?= $this->extend('layouts/main/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <?php if (session()->get('role') === 'admin') : ?>
        <!-- Content Row for General Stats -->
        <div class="row mb-4">
            <!-- Jumlah User Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Jumlah User
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_user ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Jumlah Kamar Card Example -->
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Jumlah Kamar
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_kamar ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-door-open fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Content Row for Monthly Report -->
    <div class="row">
        <?php if (session()->get('role') === 'admin') : ?>
            <div class="col-12">
                <h2 class="h5 mb-4 text-gray-800">Laporan Bulan Ini</h2>
            </div>
        <?php endif; ?>
        <!-- Jumlah Reservasi (Bulan Ini) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jumlah Reservasi (Bulan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_reservasi ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Jumlah Uang Masuk (Bulan Ini) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Jumlah Uang Masuk (Bulan Ini)
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp <?= number_format($jumlah_uang_masuk, 2, ',', '.') ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-money-bill-wave fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>