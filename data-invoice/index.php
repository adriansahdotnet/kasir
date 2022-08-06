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

if ($dataUser['level'] !== "admin") {
  header("location:../");
  exit();
}

if (isset($_POST['tombolSimpan'])) {

  $alamat_jln = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['alamat_jln'])));
  $kecamatan = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kecamatan'])));
  $kota = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kota'])));
  $kode_pos = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_pos'])));

  if (empty($alamat_jln) OR empty($kecamatan) OR empty($kota) OR empty($kode_pos)) {
    alert('gagal', 'Data Invoice masih belum lengkap 1', 'data-invoice');
  } else {
    $handle = fopen('../include/data-invoice.php', 'w');
    $isi = '<?php
$d_jln = "'.$alamat_jln.'";
$d_kec = "'.$kecamatan.'";
$d_kot = "'.$kota.'";
$d_kod = "'.$kode_pos.'";
?>';
    fwrite($handle, $isi);
    alert('berhasil', 'Data Invoice berhasil di simpan', 'data-invoice');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cetak - <?= $judul; ?></title>
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
        <div class="row">
          <div class="col-6">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Invoice</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="POST">
                <div class="card-body">
                  <div class="form-group">
                    <label for="alamat-jln">Alamat Jln</label>
                    <input type="text" class="form-control" id="alamat-jln" placeholder="Ex : Jln Sabrani" oninput="invoice_alamatjalan(this.value).value;" name="alamat_jln" value="<?= $d_jln; ?>">
                  </div>
                  <div class="form-group">
                    <label for="kecamatan">Kecamatan</label>
                    <input type="text" class="form-control" id="kecamatan" placeholder="Ex : Parenggean" oninput="invoice_alamatkecamatan(this.value).value;" name="kecamatan" value="<?= $d_kec; ?>">
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-8">
                        <label for="kota">Kota</label>
                        <input type="text" class="form-control" id="kota" placeholder="Ex : Sampit" oninput="invoice_alamatkota(this.value).value;" name="kota" value="<?= $d_kot; ?>">
                      </div>
                      <div class="col-md-4">
                        <label for="kode-pos">Kode Pos</label>
                        <input type="text" class="form-control" id="kode-pos" placeholder="Ex : 74355" oninput="invoice_alamatkodepos(this.value).value;" name="kode_pos" value="<?= $d_kod; ?>">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary" name="tombolSimpan">Simpan</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
          <div class="col-6">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <div class="row invoice-info">
                <div class="col-sm-6 invoice-col">
                  <address style="text-transform: uppercase;">
                    <strong><i class="fas fa-shopping-cart"></i> &nbsp;<?= $judul; ?></strong><br>
                    <span id="invoice-jln"><?= $d_jln; ?></span> <span id="invoice-kecamatan"><?= $d_kec; ?></span><br>
                    <span id="invoice-kota"><?= $d_kot; ?></span>, <span id="invoice-kodepos"><?= $d_kod; ?></span><br>
                    ID Pembelian<br>
                    Tanggal
                  </address>
                </div>
              </div>
              <!-- /.row -->

              <!-- Table row -->
              <div class="row">
                <div class="col-12 table-responsive">
                  <table class="table table-striped">
                    <thead>
                    <tr>
                      <th style="width: 10px;text-align: center;">Jumlah</th>
                      <th>Barang</th>
                      <th style="width: 120px;">Harga</th>
                      <th style="width: 120px;">Sub Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                      <td align="center">1</td>
                      <td>POP Mie</td>
                      <td>10.000</td>
                      <td>10.000</td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-7"></div>
                <div class="col-5">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th style="width:50%">Total:</th>
                        <td>10.000</td>
                      </tr>
                      <tr>
                        <th>Uang Tunai</th>
                        <td>10.000</td>
                      </tr>
                      <tr>
                        <th>Kembalian:</th>
                        <td>0</td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.invoice -->
          </div><!-- /.col -->
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
<script>
  function invoice_alamatjalan(jln) {
    $("#invoice-jln").html(jln);
  }
  function invoice_alamatkecamatan(kecamatan) {
    $("#invoice-kecamatan").html(kecamatan);
  }
  function invoice_alamatkota(kota) {
    $("#invoice-kota").html(kota);
  }
  function invoice_alamatkodepos(kode_pos) {
    $("#invoice-kodepos").html(kode_pos);
  }
</script>
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
