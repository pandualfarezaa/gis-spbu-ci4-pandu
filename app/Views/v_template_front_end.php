<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GIS SPBU | <?= $judul ?></title>

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <!-- Tema custom (satu file, dipakai bersama backend) -->
  <link rel="stylesheet" href="<?= base_url('assets/css/theme-spbu.css') ?>">
</head>
<body class="hold-transition layout-top-nav site-public">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand-md navbar-dark bg-pertamina-red">
    <div class="container">
      <a href="<?= base_url('home') ?>" class="navbar-brand d-flex align-items-center">
        <span class="brand-ping-wrap">
          <img src="<?= base_url('AdminLTE') ?>/dist/img/AdminLTELogo.png" class="img-circle">
        </span>
      </a>
      <h5 class="brand-title mb-0 ml-2">
        MAPPING SPBU <span class="accent">PERTAMINA</span> <small class="d-none d-sm-inline">| Brebes &amp; Banyumas</small>
      </h5>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="<?= base_url('home') ?>" class="nav-link"><i class="fas fa-home mr-1"></i> Home</a>
          </li>

          <!-- DROPDOWN: WILAYAH -->
          <li class="nav-item dropdown">
            <a id="dropdownWilayah" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-map-marked-alt mr-1"></i> Wilayah</a>
            <ul aria-labelledby="dropdownWilayah" class="dropdown-menu" style="--accent: var(--blue);">
              <li><a href="<?= base_url('home') ?>" class="dropdown-item"><span class="item-icon"><i class="fas fa-globe"></i></span> Semua Wilayah</a></li>
              <li class="dropdown-divider"></li>
              <?php foreach ($wilayah as $key => $value) { ?>
                <li><a href="<?= base_url('home/wilayah/' . $value['id_wilayah']) ?>" class="dropdown-item"><span class="item-icon"><i class="fas fa-map-marker-alt"></i></span> <?= $value['nama_wilayah'] ?></a></li>
              <?php } ?>
            </ul>
          </li>

          <!-- DROPDOWN: JENIS SPBU -->
          <li class="nav-item dropdown">
            <a id="dropdownJenis" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-gas-pump mr-1"></i> Jenis SPBU</a>
            <ul aria-labelledby="dropdownJenis" class="dropdown-menu" style="--accent: var(--green);">
              <li><a href="<?= base_url('home') ?>" class="dropdown-item"><span class="item-icon"><i class="fas fa-list"></i></span> Semua Jenis</a></li>
              <li class="dropdown-divider"></li>
              <?php foreach ($jenis as $key => $value) { ?>
                <li><a href="<?= base_url('home/jenis/' . $value['id_jenis']) ?>" class="dropdown-item"><span class="item-icon"><i class="fas fa-filter"></i></span> <?= $value['jenis'] ?></a></li>
              <?php } ?>
            </ul>
          </li>

          <li class="nav-item ml-md-3 mt-2 mt-md-0">
            <a href="<?= base_url('auth/login') ?>" class="nav-link btn-portal-admin text-white text-center">
                <i class="fas fa-user-shield mr-1"></i> Portal Admin
            </a>
          </li>
        </ul>
      </div>

    </div>
  </nav>

  <!-- Content Wrapper -->
  <div class="content-wrapper">
    <div class="content">
        <div class="row pt-3">
          <?php
          if (isset($page) && $page) {
            echo view($page);
          }
          ?>
        </div>
    </div>
  </div>

  <!-- Main Footer -->
  <footer class="main-footer text-sm">
    <div class="float-right d-none d-sm-inline">
      <b>GIS Enterprise</b> Asset Management
    </div>
    <strong>Copyright &copy; <?= date('Y') ?> <a href="#">Pertamina Regional Jawa Tengah</a>.</strong> All rights reserved.
  </footer>
</div>

<!-- SCRIPTS -->
<script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>

<!-- Dropdown hover smooth di desktop -->
<script>
$(function () {
  if ($(window).width() > 767) {
    $('.nav-item.dropdown').hover(
      function () {
        $(this).addClass('show');
        $(this).find('.dropdown-menu').addClass('show');
      },
      function () {
        $(this).removeClass('show');
        $(this).find('.dropdown-menu').removeClass('show');
      }
    );
  }
});
</script>

</body>
</html>
