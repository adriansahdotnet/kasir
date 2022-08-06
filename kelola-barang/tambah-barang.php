<?php 
session_start();
require '../include/koneksi.php';

if (!isset($_SESSION['username'])) {
    header("location:../logout");
    exit();
}

$username = $_SESSION['username'];
$queryUser = mysqli_query($konek, "SELECT * FROM akun WHERE username = '$username'");
$dataUser = mysqli_fetch_assoc($queryUser);

if ($dataUser['level'] !== "admin") {
  header("location:../logout");
  exit();
}

if (isset($_POST['addBarang'])) {
  $kode_barang = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_barang'])));
  $nama_barang = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['nama_barang'])));
  $kategori = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kategori'])));
  $satuan = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['satuan'])));
  $harga_pokok = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['harga_pokok'])));
  $harga_pokok = str_replace('.', '', $harga_pokok);

  if (empty($nama_barang) OR empty($kategori) OR empty($satuan) OR empty($harga_pokok) OR empty($kode_barang)) {
    alert('gagal', 'Data barang masih ada yang kosong', 'kelola-barang/tambah-barang');
  } else {
    $harga_jual = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['harga_jual'])));
    $harga_jual = str_replace('.', '', $harga_jual);

    $jumlah_stok = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['jumlah_stok'])));
    $jumlah_stok = str_replace('.', '', $jumlah_stok);


    if (empty($nama_barang) OR empty($kategori) OR empty($satuan) OR empty($harga_pokok) OR empty($harga_jual) OR empty($jumlah_stok)) {
      alert('gagal', 'Data barang tidak boleh ada yang kosong', 'kelola-barang/tambah-barang.php');
    } else {
      mysqli_query($konek, "INSERT INTO barang VALUES ('','$kode_barang','$nama_barang','$kategori','$satuan','$harga_pokok','$harga_jual','$jumlah_stok')");
      alert('berhasil', 'Barang baru berhasil di tambahkan dengan kode : ' . $kode_barang, 'kelola-barang/tambah-barang.php');
    }
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Tambah Barang - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/select2/css/select2.min.css">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="<?= $link; ?>/assets/plugins/quagga/quagga.min.js"></script>
  <script src="<?= $link; ?>/assets/plugins/instascan-qr/instascan-qr.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">

  <div id="suara"></div>

  <div class="wrapper">
  
  <?php require '../include/menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" style="padding-top: 20px;">
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Tambah Barang</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" action="" method="POST">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Kode Barang" readonly="" id="kode_barang" name="kode_barang">
                        <div class="input-group-prepend">
                          <button type="button" onclick="scan_modal();" class="btn btn-info">Scan QR</button>
                          <button type="button" onclick="scan_barcode();" class="btn btn-primary" style="border-radius: 0 5px 5px 0;">Scan Barcode</button>
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" id="nama_barang" autocomplete="off" name="nama_barang">
                      </div>
                      <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="select2 form-control" style="width: 100%;" name="kategori" id="kategori">
                          <option>Pilih salah satu</option>
                          <?php 
                          $queryModalKategori = mysqli_query($konek, "SELECT * FROM kategori ORDER BY kategori ASC");
                          while($rowModalKategori = mysqli_fetch_assoc($queryModalKategori)) :
                          ?>
                          <option value="<?= $rowModalKategori['kategori']; ?>"><?= $rowModalKategori['kategori']; ?></option>
                          <?php endwhile; ?>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="satuan">Jenis Satuan </label>
                        <select class="select2 form-control" style="width: 100%;" name="satuan" id="satuan">
                          <option>Pilih salah satu</option>
                          <option value="Unit">Unit</option>
                          <option value="Kotak">Kotak</option>
                          <option value="Botol">Botol</option>
                          <option value="Butir">Butir</option>
                          <option value="Buah">Buah</option>
                          <option value="Biji">Biji</option>
                          <option value="Sachet">Sachet</option>
                          <option value="Bks">Bks</option>
                          <option value="Roll">Roll</option>
                          <option value="PCS">PCS</option>
                          <option value="Box">Box</option>
                          <option value="Meter">Meter</option>
                          <option value="Centimeter">Centimeter</option>
                          <option value="Liter">Liter</option>
                          <option value="CC">CC</option>
                          <option value="Mililiter">Mililiter</option>
                          <option value="Lusin">Lusin</option>
                          <option value="Gross">Gross</option>
                          <option value="Kodi">Kodi</option>
                          <option value="Rim">Rim</option>
                          <option value="Dozen">Dozen</option>
                          <option value="Kaleng">Kaleng</option>
                          <option value="Lembar">Lembar</option>
                          <option value="Helai">Helai</option>
                          <option value="Gram">Gram</option>
                          <option value="Kilogram">Kilogram</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <label for="harga_pokok">Harga Pokok</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" class="form-control" id="harga_pokok" name="harga_pokok">
                      </div>
                      <label for="harga_jual">Harga Jual</label>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Rp.</span>
                        </div>
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual">
                      </div>
                      <div class="form-group">
                        <label for="jumlah_stok">Jumlah Stok</label>
                        <input type="text" class="form-control" id="jumlah_stok" name="jumlah_stok">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer text-right">
                  <a href="../kelola-barang" class="btn btn-default">Kembali</a>
                  <button type="submit" class="btn btn-primary" name="addBarang">Tambah Barang</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
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

<div class="modal fade" id="scan_qr">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Scan QR</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <video id="preview"></video>
      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="scan_barcode">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Scan Barcode</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <div id="scanner-container"></div>
      </div>
      <div class="modal-footer text-right">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?= $link; ?>/assets/plugins/select2/js/select2.full.min.js"></script>
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
<script>
  $(function () {
    $('.select2').select2()
  })
</script>
<script type="text/javascript">

  var harga_pokok = document.getElementById('harga_pokok');
  harga_pokok.addEventListener('keyup', function(e)
  {
    harga_pokok.value = formatRupiah(this.value);
  });
  
  harga_pokok.addEventListener('keydown', function(event)
  {
    limitCharacter(event);
  });

  var harga_jual = document.getElementById('harga_jual');
  harga_jual.addEventListener('keyup', function(e)
  {
    harga_jual.value = formatRupiah(this.value);
  });
  
  harga_jual.addEventListener('keydown', function(event)
  {
    limitCharacter(event);
  });

  var jumlah_stok = document.getElementById('jumlah_stok');
  jumlah_stok.addEventListener('keyup', function(e)
  {
    jumlah_stok.value = formatRupiah(this.value);
  });
  
  jumlah_stok.addEventListener('keydown', function(event)
  {
    limitCharacter(event);
  });

  /* Fungsi */
  function formatRupiah(bilangan, prefix)
  {
    var number_string = bilangan.replace(/[^,\d]/g, '').toString(),
      split = number_string.split(','),
      sisa  = split[0].length % 3,
      rupiah  = split[0].substr(0, sisa),
      ribuan  = split[0].substr(sisa).match(/\d{1,3}/gi);
      
    if (ribuan) {
      separator = sisa ? '.' : '';
      rupiah += separator + ribuan.join('.');
    }
    
    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
  }
  
  function limitCharacter(event)
  {
    key = event.which || event.keyCode;
    if ( key != 188 // Comma
       && key != 8 // Backspace
       && key != 17 && key != 86 & key != 67 // Ctrl c, ctrl v
       && (key < 48 || key > 57) // Non digit
       // Dan masih banyak lagi seperti tombol del, panah kiri dan kanan, tombol tab, dll
      ) 
    {
      event.preventDefault();
      return false;
    }
  }
</script>
<script>
  function scan_modal() {
    $("#scan_qr").modal('show');
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
      // getData_Barang(content)
      document.getElementById('kode_barang').value = content;
      var audioNa = '<audio src="<?= $link; ?>/assets/sound/sound.mp3" autoplay="autoplay"></audio>';
      document.getElementById('suara').innerHTML = audioNa;
      $("#scan_qr").modal('hide');
    });
    Instascan.Camera.getCameras().then(function (cameras) {
      if (cameras.length > 0) {
        scanner.start(cameras[0]);
      } else {
        console.error('No cameras found.');
      }
    }).catch(function (e) {
      console.error(e);
    });
  }
  function scan_barcode() {
    $("#scan_barcode").modal("show");
    Quagga.init({
        inputStream: {
            name: "Live",
            type: "LiveStream",
            target: document.querySelector('#scanner-container'),
            constraints: {
                width: 480,
                height: 320,
                facingMode: "environment"
            },
        },
        decoder: {
            readers: [
                "code_128_reader",
                "ean_reader",
                "ean_8_reader",
                "code_39_reader",
                "code_39_vin_reader",
                "codabar_reader",
                "upc_reader",
                "upc_e_reader",
                "i2of5_reader"
            ],
            debug: {
                showCanvas: true,
                showPatches: true,
                showFoundPatches: true,
                showSkeleton: true,
                showLabels: true,
                showPatchLabels: true,
                showRemainingPatchLabels: true,
                boxFromPatches: {
                    showTransformed: true,
                    showTransformedBox: true,
                    showBB: true
                }
            }
        },

    }, function (err) {
        if (err) {
            console.log(err);
            return
        }

        console.log("Initialization finished. Ready to start");
        Quagga.start();

        // Set flag to is running
        _scannerIsRunning = true;
    });

    Quagga.onProcessed(function (result) {
        var drawingCtx = Quagga.canvas.ctx.overlay,
        drawingCanvas = Quagga.canvas.dom.overlay;

        if (result) {
            if (result.boxes) {
                drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
                result.boxes.filter(function (box) {
                    return box !== result.box;
                }).forEach(function (box) {
                    Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                });
            }

            if (result.box) {
                Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
            }

            if (result.codeResult && result.codeResult.code) {
                Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
            }
        }
    });


    Quagga.onDetected(function (result) {
        // getData_Barang(result.codeResult.code)
        document.getElementById('kode_barang').value = result.codeResult.code;
        var audioNa = '<audio src="<?= $link; ?>/assets/sound/sound.mp3" autoplay="autoplay"></audio>';
        document.getElementById('suara').innerHTML = audioNa;
        $("#scan_barcode").modal("hide");
        // alert(result.codeResult.code);
        // console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
    });
}
</script>
</body>
</html>
