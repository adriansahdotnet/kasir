<?php
session_start();
require '../include/koneksi.php';

if (isset($_SESSION['username'])) {
  header('location:../');
  exit();
}

if (isset($_POST['tombol'])) {
  if (isset($_POST['username']) AND isset($_POST['password'])) {
    $username = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['username'])));
    $password = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['password'])));

    if (empty($username) OR empty($password)) {
      alert('gagal', 'Username atau password tidak boleh kosong', 'login');
    } else {
      $queryUser = mysqli_query($konek, "SELECT * FROM akun WHERE username = '$username'");
      if (mysqli_num_rows($queryUser) !== 1) {
        alert('gagal', 'Username atau password salah', 'login');
      } else {
        $fetchUser = mysqli_fetch_assoc($queryUser);
        if ($username === $fetchUser['username']) {
          if (password_verify($password, $fetchUser['password'])) {
            $_SESSION['username'] = $fetchUser['username']; 
            header("location:../");
            exit();
          } else {
            alert('gagal', 'Username atau password salah', 'login');
          }
        } else {
          alert('gagal', 'Username atau password salah', 'login');
        }
      }
    }

  } else {
    alert('gagal', 'Username atau password tidak boleh kosong', 'login');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?= $link; ?>"><strong><?= $judul; ?></strong></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Silahkan masuk dengan akun Anda</p>

      <form action="" method="post">
        <?php if (isset($_COOKIE['gagal'])): ?>
        <div class="alert alert-danger">
          <?= $_COOKIE['gagal']; ?>
        </div>
        <?php endif ?>
        <?php if (isset($_COOKIE['berhasil'])): ?>
        <div class="alert alert-success">
          <?= $_COOKIE['berhasil']; ?>
        </div>
        <?php endif ?>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Username" name="username">
          <div class="input-group-append input-group-text">
              <span class="fas fa-envelope"></span>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append input-group-text">
              <span class="fas fa-lock"></span>
          </div>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat btn-block" name="tombol">Login</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
