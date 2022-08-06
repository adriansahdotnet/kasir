<?php
session_start();
require '../include/koneksi.php';

$kodePembelianShow = time() . rand(000,999);

if (!isset($_SESSION['username'])) {
  header('location:../logout');
  exit();
}

$username = $_SESSION['username'];
$queryUser = mysqli_query($konek, "SELECT * FROM akun WHERE username = '$username'");
$dataUser = mysqli_fetch_assoc($queryUser);

if (isset($_POST['tombolBeli'])) {
  if (!isset($_POST['post_kode'])) {
    alert('gagal', 'Tidak ada barang yang di beli', 'pembelian');
  } else if (!isset($_POST['uangTunai'])) {
    alert('gagal', 'Uang tunai tidak boleh kosong', 'pembelian');
  } else {
    $kode_pembelian = $_POST['kode_pembelian'];
    if ($_POST['uangTunai'] === 0 ) {
      alert('gagal', 'Uang tunai tidak boleh kosong', 'pembelian');
    }
    for ($i=0; $i < count($_POST['post_kode']); $i++) { 
      $post_kode = $_POST['post_kode'][$i];
      $post_jumlah = $_POST['post_jumlah'][$i];

      /* Ambil data data ke database */
      $queryBarangPost = mysqli_query($konek, "SELECT * FROM barang WHERE kode_barang = '$post_kode'");
      $fetchBarangPost = mysqli_fetch_assoc($queryBarangPost);

      /* Harga */
      $namaBarang = $fetchBarangPost['nama_barang'];
      $hargaEceran = $fetchBarangPost['harga_eceran'];

      $totalHarga = $hargaEceran * $post_jumlah;

      $priode = date('M Y');

      mysqli_query($konek, "INSERT INTO pembelian VALUES ('','$kode_pembelian','$post_kode','$namaBarang','$post_jumlah','$hargaEceran','$totalHarga','$tanggal $waktu','$priode')");
      if ($fetchBarangPost['jumlah_stok'] > 0 ) {
        mysqli_query($konek, "UPDATE barang SET jumlah_stok = jumlah_stok-$post_jumlah WHERE kode_barang = '$post_kode'");
      }
    }

    /* Ambil Semua Total Harga */
    $queryTotal = mysqli_query($konek, "SELECT * FROM pembelian WHERE id_pembelian = '$kode_pembelian'");
    $totalBayarNow = 0;
    while ($fetchTotal = mysqli_fetch_assoc($queryTotal)) {
      $totalBayarNow += $fetchTotal['total'];
    }

    $uangTunai = $_POST['uangTunai'];
    mysqli_query($konek, "INSERT INTO pembayaran VALUES ('','$kode_pembelian','$uangTunai','$totalBayarNow','$tanggal $waktu','$username')");

    setcookie('kode_pembelianHead', $kode_pembelian, time()+2, '/');
    alert('berhasil', 'Pembelian berhasil di simpan', 'pembelian');
  }
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pembelian - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/dist/css/adminlte.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <script src="<?= $link; ?>/assets/plugins/quagga/quagga.min.js"></script>
  <script src="<?= $link; ?>/assets/plugins/instascan-qr/instascan-qr.min.js"></script>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <div id="suara"></div>

  <?php require '../include/menu.php' ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content" style="padding-top: 20px;">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Pembelian</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table style="margin-bottom: 20px;">
                  <tr>
                    <th>Kasir</th>
                    <td style="padding: 0 20px;">:</td>
                    <td><?= $username; ?></td>
                  </tr>
                  <tr>
                    <th>ID Pembelian</th>
                    <td style="padding: 0 20px;">:</td>
                    <td><?= $kodePembelianShow; ?></td>
                  </tr>
                  <tr>
                    <th>Tanggal</th>
                    <td style="padding: 0 20px;">:</td>
                    <td><?= $tanggal; ?></td>
                  </tr>
                </table>

                <!-- Tambah Barang -->
                <div class="row">
                  <div class="col-md-3">
                    <div class="form-group">
                      <input type="text" class="form-control" id="kode_barang" oninput="getData_Barang(this.value).value;" placeholder="Kode Barang">
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" data-toggle="modal" type="button" data-target="#cari_data">Cari Data</button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="button" onclick="scan_modal();">Scan QR</button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-group">
                      <button class="btn btn-primary btn-block" type="button" onclick="scan_barcode();">Scan Barcode</button>
                    </div>
                  </div>
                </div>
                <hr>
                <div class="row">
                  <div class="col-md-6 data_barang hide">
                    <div class="form-group">
                      <label for="nama_barang">Nama Barang</label>
                      <input type="text" class="form-control" id="nama_barang" disabled="disabled">
                    </div>
                  </div>
                  <div class="col-md-1 data_barang hide">
                    <div class="form-group">
                      <label for="satuan">Satuan</label>
                      <input type="text" class="form-control" id="satuan" disabled="disabled">
                    </div>
                  </div>
                  <div class="col-md-3 data_barang hide">
                    <div class="form-group">
                      <label for="harga_eceran">Harga Eceran</label>
                      <input type="text" class="form-control" id="harga_eceran" disabled="disabled">
                    </div>
                  </div>
                  <div class="col-md-1 data_barang hide">
                    <div class="form-group">
                      <label for="jumlah">Jumlah</label>
                      <input type="number" class="form-control" id="jumlah">
                    </div>
                  </div>
                  <div class="col-md-1 data_barang hide">
                    <div class="form-group text-center">
                      <label>Tambah</label>
                      <button class="btn btn-primary" type="button" onclick="tambah_data();">
                        <i class="fas fa-check"></i>
                      </button>
                    </div>
                  </div>
                </div>

                <!-- Data Pembelian -->
                <form action="" method="POST">
                <table class="table table-bordered">
                  <tr>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                    <th>Sub Total</th>
                    <th style="width: 70px;">Aksi</th>
                  </tr>
                  <tbody id="data_barang"></tbody>
                  <tr>
                    <td colspan="4" align="right"><strong>Total</strong></td>
                    <td><input type="hidden" id="totalBayar" value="0"><p id="nowTotal"></p></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Uang Tunai</strong></td>
                    <td><input type="number" id="uangTunai" required="" name="uangTunai" class="form-control" oninput="total_kembalian(this.value).value;"></td>
                  </tr>
                  <tr>
                    <td colspan="4" align="right"><strong>Kembalian</strong></td>
                    <td><input type="hidden" id="kembalian" value="0"><p id="showKembalian"></p></td>
                  </tr>
                </table>
                <div class="row">
                  <div class="col-md-12" style="margin-top: 20px;text-align: right;">
                    <a href="../pembelian" class="btn btn-default">Reset</a>
                    <input type="hidden" value="<?= $kodePembelianShow; ?>" name="kode_pembelian">
                    <button class="btn btn-primary" type="submit" name="tombolBeli">Submit</button> 
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
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
<div class="modal fade" id="cari_data">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cari Data</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example2" class="table table-bordered table-hover">
         <thead>
          <tr>
            <th>No</th>
            <th>Kode Barang</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Harga Pokok</th>
            <th>Harga Jual</th>
            <th>Jumlah Stok</th>
            <th>Aksi</th>
          </tr>
          </thead>
          <tbody>
          <?php 
          $no = 1;
          $queryBarang = mysqli_query($konek, "SELECT * FROM barang ORDER BY id DESC");
          while($rowBarang = mysqli_fetch_assoc($queryBarang)) :
          ?>
          <tr>
            <td><?= $no; ?></td>
            <td><?= $rowBarang['kode_barang']; ?></td>
            <td><?= $rowBarang['nama_barang']; ?></td>
            <td><?= $rowBarang['kategori']; ?></td>
            <td>Rp <?= number_format($rowBarang['harga_pokok'],0,',','.'); ?></td>
            <td>Rp <?= number_format($rowBarang['harga_eceran'],0,',','.'); ?></td>
            <td><?= number_format($rowBarang['jumlah_stok'],0,',','.'); ?> <?= $rowBarang['jenis_satuan']; ?></td>
            <td>
              <a href="javascript:;" onclick="getData_Barang('<?= $rowBarang['kode_barang']; ?>')" class="badge badge-primary"><i class="fa fa-cart-plus p-1"></i> Tambah</a>
            </td>
          </tr>
          <?php $no++; endwhile; ?>
          <?php if (mysqli_num_rows($queryBarang) === 0 ): ?>
          <tr>
            <td colspan="9" align="center">Tidak ada barang</td>
          </tr>
          <?php endif ?>
        </tbody>
      </table>
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
<!-- /.modal -->
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
<script>
  function total_kembalian(uang_tun) {
    var total_pay = $("#totalBayar").val();
    var kembalian = parseInt(uang_tun) - total_pay;
    $("#kembalian").attr('value', kembalian);
    document.getElementById('showKembalian').innerHTML = kembalian;
  }
  function pemberitahuan(isi) {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    Toast.fire({
      type: 'error',
      title: isi
    });
  }
  function getData_Barang(kode_barang){
    var htmlobjek;
    $("#cari_data").modal('hide');
    $("#scan_qr").modal('hide');
    $("#scan_barcode").modal('hide');
    document.getElementById('kode_barang').value = kode_barang;
    $.ajax({
      url : 'get-data-barang.php',
      data  : 'search=nama_barang&kode_barang='+kode_barang,
      type  : 'POST',
      dataType: 'html',
      success : function(msg){
        $("#nama_barang").val(msg);
        $(".data_barang").removeClass('hide');
      }
    });
    $.ajax({
      url : 'get-data-barang.php',
      data  : 'search=jenis_satuan&kode_barang='+kode_barang,
      type  : 'POST',
      dataType: 'html',
      success : function(msg){
        $("#satuan").val(msg);
      }
    });
    $.ajax({
      url : 'get-data-barang.php',
      data  : 'search=harga_eceran&kode_barang='+kode_barang,
      type  : 'POST',
      dataType: 'html',
      success : function(msg){
        $("#harga_eceran").val(msg);
        $("#jumlah").attr('value', '1');
      }
    });
  }
  function scan_modal() {
    $("#scan_qr").modal('show');
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
    scanner.addListener('scan', function (content) {
      getData_Barang(content)
      var audioNa = '<audio src="<?= $link; ?>/assets/sound/sound.mp3" autoplay="autoplay"></audio>';
      document.getElementById('suara').innerHTML = audioNa;
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
</script>
<script>
  function hapus_data(id_data) {
    /* Ganti Manipuasi Harga */
    var totalOld = $("#totalBayar").val();
    var kodeBersih = id_data.replace("'", "");
    var hargaSub = $("#tot_"+kodeBersih).val();

    var updateHarga = parseInt(totalOld) - parseInt(hargaSub);
    $("#totalBayar").attr('value', updateHarga);
    document.getElementById('nowTotal').innerHTML = updateHarga;
    document.getElementById(id_data).innerHTML = "";

  }
  function tambah_data() {
    var kode_barang = $("#kode_barang").val();
    var nama_barang = $("#nama_barang").val();
    var satuan = $("#satuan").val();
    var harga_eceran = $("#harga_eceran").val();
    var jumlah = $("#jumlah").val();

    if (jumlah == 0) {
      pemberitahuan("Jumlah tidak boleh kosong");
    } else if (kode_barang === "") {
      pemberitahuan("Kode barang tidak boleh kosong");
    } else if (nama_barang === "None") {
      pemberitahuan("Barang tidak di temukan");
    } else {
      var angka_Random = Math.ceil(Math.random() * 300);
      var valclick = "'"+kode_barang+angka_Random+"'";
      var subtotal = harga_eceran * jumlah;
      var kodeTotal = valclick.replace("'", "");
      var hilangkanLagi = kodeTotal.replace("'", "");
      var baris_baru = '<tr id="'+kode_barang+angka_Random+'"><td><input type="hidden" value="'+kode_barang+'" name="post_kode[]">'+kode_barang+'</td><td>'+nama_barang+'</td><td><input type="hidden" value="'+jumlah+'" name="post_jumlah[]">'+jumlah+' '+satuan+'</td><td>'+harga_eceran+'</td><td><input type="hidden" value="'+subtotal+'" id="tot_'+hilangkanLagi+'" name="post_total[]">'+subtotal+'</td><td><a class="badge bg-warning" onclick="hapus_data('+valclick+')" href="javascript:;"><i class="fas fa-trash p-1"></i> Batal </a></td></tr>';
      $("#data_barang").append(baris_baru);
      $(".data_barang").addClass('hide');
      document.getElementById('kode_barang').value = "";

      // Ganti Total Bayar
      var totalNow = $("#totalBayar").val();
      var totalConfig = parseInt(totalNow) + parseInt(subtotal);
      $("#totalBayar").attr('value', totalConfig);
      document.getElementById('nowTotal').innerHTML = totalConfig;
      document.getElementById('jumlah').value = "1";
    }
  }
</script>

<!-- jQuery -->
<script src="<?= $link; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= $link; ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="<?= $link; ?>/assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- FastClick -->
<script src="<?= $link; ?>/assets/plugins/fastclick/fastclick.js"></script>
<!-- SweetAlert2 -->
<script src="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });
  });
</script>
<?php if (isset($_COOKIE['berhasil'])): ?>
<script>
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    Toast.fire({
      type: 'success',
      title: '<?= $_COOKIE['berhasil']; ?>&nbsp;<a href="cetak.php?kode=<?= $_COOKIE['kode_pembelianHead']; ?>"> Cetak</a>'
    });
  });
</script>
<?php endif ?>
<?php 
  if (isset($_COOKIE['gagal'])) {
    echo '<script>pemberitahuan("Tidak ada barang yang dibeli");</script>';
  }
?>
<script type="text/javascript">
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
  function format_rupiah(tanpa_rupiah) {
    tanpa_rupiah.addEventListener('keyup', function(e)
    {
      tanpa_rupiah.value = formatRupiah(this.value);
    });
    
    tanpa_rupiah.addEventListener('keydown', function(event)
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
  }
</script>
<script>
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
                getData_Barang(result.codeResult.code)
                var audioNa = '<audio src="<?= $link; ?>/assets/sound/sound.mp3" autoplay="autoplay"></audio>';
                document.getElementById('suara').innerHTML = audioNa;
                // alert(result.codeResult.code);
                // console.log("Barcode detected and processed : [" + result.codeResult.code + "]", result);
            });
        }
    </script>
</body>
</html>
