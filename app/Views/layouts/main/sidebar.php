<?php
// Mendapatkan URL saat ini
$currentURL = current_url(); // Pastikan fungsi ini sesuai dengan framework atau metode yang Anda gunakan

// Mendapatkan role pengguna dari session
$session = session();
$userRole = $session->get('role');
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('/') ?>">
        <div class="sidebar-brand-icon">
            <i class="fa-solid fa-building" style="color: #ffffff;font-size:22px"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Hotel Iksal</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if ($userRole === 'admin') : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= strpos($currentURL, 'dashboard') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url('dashboard') ?>">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            Menu
        </div>

        <!-- Nav Item - User -->
        <li class="nav-item <?= strpos($currentURL, 'user') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url('user') ?>">
                <i class="fas fa-fw fa-users"></i>
                <span>User</span>
            </a>
        </li>

        <!-- Nav Item - Kamar -->
        <li class="nav-item <?= strpos($currentURL, 'kamar') !== false ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url('kamar') ?>">
                <i class="fas fa-fw fa-door-open"></i>
                <span>Kamar</span>
            </a>
        </li>

    <?php endif; ?>

    <!-- Nav Item - Reservasi -->
    <li class="nav-item <?= strpos($currentURL, 'reservasi') !== false ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('reservasi') ?>">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Reservasi</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->