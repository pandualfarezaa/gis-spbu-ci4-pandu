<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GIS SPBU | Log In</title>

  <!-- Google Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">

  <!-- 🔴 CSS CUSTOM LOGIN — profesional / latar terang, konsisten dengan header -->
  <style>
    :root {
      --red: #E31B23;
      --red-dark: #A30F17;
      --blue: #0054A6;
      --blue-dark: #003D7A;
      --green: #8DC63F;
      --ink: #1F2430;
      --muted: #6B7280;
      --paper: #FFFFFF;
      --surface: #F4F6F9;
      --border: #E7E9EE;
    }

    @media (prefers-reduced-motion: reduce) {
      *, *::before, *::after { animation: none !important; transition: none !important; }
    }

    html, body { height: 100%; }

    body.login-page {
      font-family: 'Source Sans Pro', sans-serif;
      background: var(--surface);
      position: relative;
      overflow-x: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Latar: dot-grid halus + sedikit tint merah/biru di pojok, tetap terang */
    body.login-page::before {
      content: "";
      position: fixed;
      inset: 0;
      background-image: radial-gradient(rgba(31,36,48,0.05) 1px, transparent 1px);
      background-size: 22px 22px;
      pointer-events: none;
    }
    body.login-page::after {
      content: "";
      position: fixed;
      inset: 0;
      background:
        radial-gradient(520px circle at 10% 10%, rgba(227,27,35,0.06), transparent 60%),
        radial-gradient(560px circle at 90% 90%, rgba(0,84,166,0.07), transparent 60%);
      pointer-events: none;
    }

    /* Rel tiga-warna Pertamina, tipis dan tenang di puncak layar */
    .top-rail {
      position: fixed;
      top: 0; left: 0; right: 0;
      height: 4px;
      background: linear-gradient(90deg, var(--red), var(--blue), var(--green));
      z-index: 5;
    }

    .login-box {
      position: relative;
      z-index: 2;
      width: 100%;
      max-width: 400px;
    }

    /* Logo dengan ping halus, konsisten dengan navbar */
    .login-logo {
      text-align: center;
      margin-bottom: 22px;
    }
    .login-logo a {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 700;
      font-size: 2rem;
      color: var(--ink);
      letter-spacing: 0.01em;
      display: inline-flex;
      align-items: center;
      gap: 12px;
    }
    .login-logo a .accent { color: var(--red); }
    .ping-dot {
      position: relative;
      width: 13px;
      height: 13px;
      border-radius: 50%;
      background: var(--red);
      flex-shrink: 0;
    }
    .ping-dot::before {
      content: "";
      position: absolute;
      inset: 0;
      border-radius: 50%;
      border: 2px solid var(--red);
      opacity: 0;
      animation: ping-ring 3s cubic-bezier(0.2, 0.6, 0.4, 1) infinite;
    }
    @keyframes ping-ring {
      0%   { transform: scale(1); opacity: 0.5; }
      80%  { transform: scale(2.6); opacity: 0; }
      100% { transform: scale(2.6); opacity: 0; }
    }

    /* Kartu login: putih, rounded, rel aksen atas, shadow lembut */
    .card.login-card-flat {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
      box-shadow: 0 18px 40px rgba(20,22,28,0.10);
    }
    .card.login-card-flat::before {
      content: "";
      display: block;
      height: 4px;
      background: linear-gradient(90deg, var(--red), var(--blue), var(--green));
    }

    .login-card-body { padding: 34px 32px 28px; }

    .login-box-msg {
      color: var(--muted);
      font-weight: 600;
      font-size: 0.92rem;
      margin-bottom: 22px;
    }

    /* Input fields: flat terang, border biru menyala saat fokus */
    .login-card-body .input-group {
      border-radius: 10px;
      overflow: hidden;
      transition: box-shadow 0.2s ease;
    }
    .login-card-body .form-control {
      border: 1.5px solid var(--border);
      border-right: none;
      background: var(--surface);
      padding: 11px 14px;
      font-size: 0.95rem;
      transition: border-color 0.2s ease, background-color 0.2s ease;
    }
    .login-card-body .input-group-text {
      border: 1.5px solid var(--border);
      border-left: none;
      background: var(--surface);
      color: var(--muted);
      transition: color 0.2s ease, border-color 0.2s ease;
    }
    .login-card-body .form-control:focus {
      border-color: var(--blue);
      background: #fff;
      box-shadow: none;
    }
    .login-card-body .input-group:focus-within {
      box-shadow: 0 0 0 3px rgba(0,84,166,0.12);
      border-radius: 10px;
    }
    .login-card-body .input-group:focus-within .input-group-text {
      color: var(--blue);
      background: #fff;
    }
    .login-card-body .input-group:focus-within .form-control {
      background: #fff;
    }

    /* Tombol Log In: merah solid, flat & profesional, senada Portal Admin */
    .btn-login-flat {
      background: var(--red) !important;
      color: #fff !important;
      font-weight: 700;
      letter-spacing: 0.02em;
      border: none;
      border-radius: 10px;
      padding: 11px 0;
      transition: all 0.2s ease-in-out;
    }
    .btn-login-flat:hover {
      background: var(--red-dark) !important;
      box-shadow: 0 8px 20px rgba(163,15,23,0.25);
      transform: translateY(-1px);
    }
    .btn-login-flat:active { transform: translateY(0); }

    /* Alert gagal login */
    .login-card-body .alert-danger {
      background: rgba(227,27,35,0.06);
      border: 1px solid rgba(227,27,35,0.25);
      color: var(--red-dark);
      border-radius: 10px;
      font-size: 0.88rem;
      font-weight: 600;
    }
    .login-card-body .alert-danger .close {
      color: var(--red-dark);
      opacity: 0.6;
    }

    /* 🔵 Link kembali ke beranda / front-end */
    .back-to-home {
      display: block;
      text-align: center;
      margin-top: 18px;
      font-size: 0.88rem;
      font-weight: 600;
      color: var(--muted);
      text-decoration: none;
      transition: color 0.2s ease;
    }
    .back-to-home:hover {
      color: var(--blue);
      text-decoration: none;
    }
    .back-to-home i {
      margin-right: 6px;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="top-rail"></div>

<div class="login-box">
  <div class="login-logo">
    <a href="">
      <span class="ping-dot"></span>
      <span class="accent">GIS</span>&nbsp;SPBU
    </a>
  </div>
  <!-- /.login-logo -->
  <div class="card login-card-flat">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silakan Log In untuk Masuk Sistem</p>

      <!-- Notifikasi Jika Gagal Login -->
      <?php if (session()->getFlashdata('pesan')): ?>
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= session()->getFlashdata('pesan') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/cek_login') ?>" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-login-flat btn-block">Log In</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>

  <!-- 🔵 Tombol kembali ke halaman utama (front-end) -->
  <a href="<?= base_url('home') ?>" class="back-to-home">
    <i class="fas fa-arrow-left"></i> Kembali ke Beranda
  </a>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>
</body>
</html>