<?php
session_start();
require '../include/koneksi.php';
require '../include/data-invoice.php';

if (!isset($_SESSION['username'])) {
  header('location:../logout');
  exit();
}

$username = $_SESSION['username'];
$queryUser = mysqli_query($konek, "SELECT * FROM akun WHERE username = '$username'");
$dataUser = mysqli_fetch_assoc($queryUser);

if (isset($_POST['tombolSimpan'])) {
  $judulNew = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['judul'])));
  $handle = fopen('../include/data-aplikasi.php', 'w');
  $isi = '<?php
  $judul = "'.$judulNew.'";
  ?>';
  fwrite($handle, $isi);
  alert('berhasil', 'Judul baru berhasil di simpan', 'pengaturan-aplikasi');
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pengaturan Aplikasi - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
  
<div class="wrapper">

  <?php require '../include/menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content" style="padding-top: 20px;">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-6">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Aplikasi</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="alamat-jln">Judul</label>
                    <input type="text" class="form-control" id="alamat-jln" name="judul" autocomplete="off" value="<?= $judul; ?>">
                  </div>
                </div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary" name="tombolSimpan">Simpan</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php require '../include/footer.php' ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- FastClick -->
<script src="<?= $link; ?>/assets/plugins/fastclick/fastclick.js"></script>
<!-- SweetAlert2 -->
<script src="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>
<script type="text/javascript">
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    <?php if (isset($_COOKIE['berhasil'])): ?>
    Toast.fire({
      type: 'success',
      title: '<?= $_COOKIE['berhasil']; ?>'
    })
    <?php endif; ?>

    <?php if (isset($_COOKIE['gagal'])): ?>
    Toast.fire({
      type: 'error',
      title: '<?= $_COOKIE['gagal']; ?>'
    })
    <?php endif; ?>
  });
</script>
</body>
</html>
