<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>GIS SPBU | Registrasi</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@500;700&display=swap">
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('AdminLTE') ?>/dist/css/adminlte.min.css">

  <style>
    :root {
      --red: #E31B23; --red-dark: #A30F17; --blue: #0054A6;
      --ink: #1F2430; --muted: #6B7280; --surface: #F4F6F9; --border: #E7E9EE;
    }
    html, body { height: 100%; }
    body.login-page {
      font-family: 'Source Sans Pro', sans-serif;
      background: var(--surface);
      display: flex; align-items: center; justify-content: center;
    }
    .top-rail {
      position: fixed; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, #E31B23, #0054A6, #8DC63F); z-index: 5;
    }
    .login-box { position: relative; z-index: 2; width: 100%; max-width: 420px; }
    .login-logo { text-align: center; margin-bottom: 22px; }
    .login-logo a {
      font-family: 'Space Grotesk', sans-serif; font-weight: 700; font-size: 2rem;
      color: var(--ink); text-decoration: none;
    }
    .login-logo a .accent { color: var(--red); }
    .card.login-card-flat {
      border: none; border-radius: 16px; overflow: hidden; position: relative;
      box-shadow: 0 4px 24px rgba(31,36,48,0.08);
    }
    .card.login-card-flat::before {
      content: ""; position: absolute; top: 0; left: 0; right: 0; height: 4px;
      background: linear-gradient(90deg, var(--red), var(--blue));
    }
    .login-card-body { padding: 34px 32px 28px; }
    .login-box-msg { color: var(--muted); font-weight: 600; font-size: 0.92rem; margin-bottom: 22px; }
    .login-card-body .input-group { border-radius: 10px; overflow: hidden; margin-bottom: 16px; }
    .login-card-body .form-control {
      border: 1.5px solid var(--border); border-right: none; background: var(--surface);
      padding: 11px 14px; font-size: 0.95rem;
    }
    .login-card-body .input-group-text {
      border: 1.5px solid var(--border); border-left: none; background: var(--surface); color: var(--muted);
    }
    .login-card-body .form-control:focus { border-color: var(--blue); background: #fff; box-shadow: none; }
    .btn-register {
      background: var(--blue) !important; color: #fff !important;
      font-weight: 700; border: none; border-radius: 10px; padding: 11px 0;
    }
    .btn-register:hover { background: #003D7A !important; }
    .back-to-login {
      display: block; text-align: center; margin-top: 18px;
      font-size: 0.88rem; font-weight: 600; color: var(--muted); text-decoration: none;
    }
    .back-to-login:hover { color: var(--blue); }
    .alert-danger {
      background: rgba(227,27,35,0.06); border: 1px solid rgba(227,27,35,0.25);
      color: var(--red-dark); border-radius: 10px; font-size: 0.88rem; font-weight: 600;
    }
  </style>
</head>
<body class="hold-transition login-page">
<div class="top-rail"></div>

<div class="login-box">
  <div class="login-logo">
    <a href="<?= base_url('home') ?>"><span class="accent">GIS</span>&nbsp;SPBU</a>
  </div>

  <div class="card login-card-flat">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Buat Akun Baru</p>

      <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
          <?= session()->getFlashdata('errors') ?>
        </div>
      <?php endif; ?>

      <?php if (session()->has('_ci_validation_errors')): ?>
        <div class="alert alert-danger">
          <ul class="mb-0">
            <?php foreach (session('_ci_validation_errors') as $err): ?>
              <li><?= esc($err) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('auth/simpan_register') ?>" method="post">
        <?= csrf_field() ?>
        <div class="input-group">
          <input type="text" name="nama_user" class="form-control" placeholder="Nama Lengkap"
                 value="<?= old('nama_user') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-user"></span></div>
          </div>
        </div>
        <div class="input-group">
          <input type="email" name="email" class="form-control" placeholder="Email"
                 value="<?= old('email') ?>" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group">
          <input type="password" name="password" class="form-control" placeholder="Password (min 5 karakter)" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-register btn-block">Daftar</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <a href="<?= base_url('auth/login') ?>" class="back-to-login">
    <i class="fas fa-arrow-left"></i> Sudah punya akun? Log In
  </a>
</div>

<script src="<?= base_url('AdminLTE') ?>/plugins/jquery/jquery.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('AdminLTE') ?>/dist/js/adminlte.min.js"></script>
</body>
</html>
