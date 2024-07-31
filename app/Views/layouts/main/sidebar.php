<?php
// Mendapatkan URL saat ini
$currentURL = current_url();

// Mendapatkan role pengguna dari session
$session = session();
$userRole = $session->get('role');
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= site_url('/') ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Hotel Iksal</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php if ($userRole === 'admin') : ?>
        <!-- Nav Item - Dashboard -->
        <li class="nav-item <?= $currentURL == site_url('dashboard') ? 'active' : '' ?>">
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
        <li class="nav-item <?= $currentURL == site_url('user') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url('user') ?>">
                <i class="fas fa-fw fa-solid fa-users"></i>
                <span>User</span>
            </a>
        </li>

        <!-- Nav Item - Kamar -->
        <li class="nav-item <?= $currentURL == site_url('kamar') ? 'active' : '' ?>">
            <a class="nav-link" href="<?= site_url('kamar') ?>">
                <i class="fas fa-fw fa-solid fa-door-open"></i>
                <span>Kamar</span>
            </a>
        </li>

    <?php endif; ?>

    <!-- Nav Item - Reservasi -->
    <li class="nav-item <?= $currentURL == site_url('reservasi') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= site_url('reservasi') ?>">
            <i class="fas fa-fw fa-solid fa-receipt"></i>
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