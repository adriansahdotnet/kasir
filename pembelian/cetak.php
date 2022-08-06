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

if (!isset($_GET['kode'])) {
  header("location:../pembelian");
  exit();
}

$kodePembelian = $_GET['kode'];

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Cetak - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>
    @media print {
      * {
        background: white;
      }
      .print-hilang {
        display: none;
      }
    }
  </style>
</head>
<body class="hold-transition sidebar-mini">
  
<div class="wrapper">

  <?php require '../include/menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <section class="content" style="padding-top: 20px;">
      <div class="container-fluid">
        <div class="row justify-content-center">
          <div class="col-7">

            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                  <address style="text-transform: uppercase;">
                    <strong><i class="fas fa-shopping-cart"></i> &nbsp;<?= $judul; ?></strong><br>
                    <?= $d_jln; ?> <?= $d_kec; ?><br>
                    <?= $d_kot; ?>, <?= $d_kod; ?><br>
                    ID : <?= $_GET['kode']; ?><br>
                    <?= date("d M Y"); ?> <?= date("G:i"); ?>
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
                    <?php 
                    $queryBarang = mysqli_query($konek, "SELECT * FROM pembelian WHERE id_pembelian = '$kodePembelian'");
                    while($rowBarang = mysqli_fetch_assoc($queryBarang)) :
                    ?>
                    <tr>
                      <td align="center"><?= $rowBarang['jumlah']; ?></td>
                      <td><?= $rowBarang['nama_barang']; ?></td>
                      <td><?= number_format($rowBarang['harga_eceran'],0,',','.'); ?></td>
                      <td><?= number_format($rowBarang['total'],0,',','.'); ?></td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <div class="row">
                <!-- accepted payments column -->
                <div class="col-8"></div>
                <div class="col-4">
                  <div class="table-responsive">
                    <table class="table">
                      <?php 
                      $queryPembayaran = mysqli_query($konek, "SELECT * FROM pembayaran WHERE id_pembelian = '$kodePembelian'");
                      $fetchPembayaran = mysqli_fetch_assoc($queryPembayaran);
                      $kembalianNya = $fetchPembayaran['uang_tunai'] - $fetchPembayaran['total_bayar'];
                      ?>
                      <tr>
                        <th style="width:50%">Total:</th>
                        <td><?= number_format($fetchPembayaran['total_bayar'],0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>Uang Tunai</th>
                        <td><?= number_format($fetchPembayaran['uang_tunai'],0,',','.'); ?></td>
                      </tr>
                      <tr>
                        <th>Kembalian:</th>
                        <td><?= number_format($kembalianNya,0,',','.'); ?></td>
                      </tr>
                    </table>
                  </div>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->

              <!-- this row will not appear when printing -->
              <div class="row no-print">
                <div class="col-12">
                  <button type="button" class="btn btn-success float-right" onclick="window.print();"><i class="fas fa-print"></i> &nbsp;Cetak</button>
                  <a href="../pembelian" class="btn btn-default float-right" style="margin-right: 10px;"><i class="fas fa-arrow-circle-left"></i> &nbsp;Kembali</a>
                </div>
              </div>
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
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>
</body>
</html>
