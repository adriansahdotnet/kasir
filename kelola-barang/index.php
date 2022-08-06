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

if (isset($_POST['tombolAddKategori'])) {
  if (isset($_POST['addKategori'])) {
    $addKategori = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['addKategori'])));
    if (empty($addKategori)) {
      alert('gagal', 'Gagal menambahkan kategori baru', 'kelola-barang');
    } else {
      mysqli_query($konek, "INSERT INTO kategori VALUES ('','$addKategori')");
      alert('berhasil', 'Kategori baru berhasil di tambahkan', 'kelola-barang');
    }
  } else {
    alert('gagal', 'Gagal menambahkan kategori baru', 'kelola-barang');
  }
}

if (isset($_POST['saveBarang'])) {
  $kode_barang = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_barang'])));
  $nama_barang = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['nama_barang'])));
  $kategori = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kategori'])));
  $satuan = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['satuan'])));
  $harga_pokok = htmlspecialchars(trim(mysqli_real_escape_string($konek, sisa_angka($_POST['harga_pokok']))));
  $harga_eceran = htmlspecialchars(trim(mysqli_real_escape_string($konek, sisa_angka($_POST['harga_eceran']))));
  $jumlah_stok = htmlspecialchars(trim(mysqli_real_escape_string($konek, sisa_angka($_POST['jumlah_stok']))));

  if (empty($nama_barang) OR empty($kategori) OR empty($satuan) OR empty($harga_pokok) OR empty($harga_eceran) OR empty($jumlah_stok)) {
    alert('gagal', 'Data barang tidak boleh ada yang kosong', 'kelola-barang');
  } else {
    $update = mysqli_query($konek, "UPDATE barang SET nama_barang = '$nama_barang', kategori = '$kategori', jenis_satuan = '$satuan', harga_pokok = '$harga_pokok', harga_eceran = '$harga_eceran', jumlah_stok = '$jumlah_stok' WHERE kode_barang = '$kode_barang'");
    if ($update === true) {
      alert('berhasil', 'Barang berhasil di simpan', 'kelola-barang');
    } else {
      alert('gagal', 'Barang gagal di perbahrui', 'kelola-barang');
    }
  }
}

if (isset($_POST['hapusBarang'])) {
  if (!isset($_POST['kode_hapus'])) {
    alert('gagal', 'Barang gagal di hapus', 'kelola-barang');
  } else {
    $kode_hapus = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_hapus'])));
    mysqli_query($konek, "DELETE FROM barang WHERE kode_barang = '$kode_hapus'");
    alert('berhasil', 'Barang berhasil di hapus', 'kelola-barang');
  }
}

if (isset($_GET['kategori_hapus'])) {
  $idKategori_hapus = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_GET['kategori_hapus'])));
  $a = mysqli_query($konek, "DELETE FROM kategori WHERE id = '$idKategori_hapus'");
  alert('berhasil', 'Kategori berhasil dihapus', 'kelola-barang');
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Kelola Barang - <?= $judul; ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.css">
  <!-- Favicon -->
  <link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/select2/css/select2.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.css">
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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Kelola Barang</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= $link; ?>">Home</a></li>
              <li class="breadcrumb-item active">Kelola Barang</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Data Barang
                    <a class="btn btn-primary btn-sm" style="float: right;" href="tambah-barang.php">Tambah Barang</a>
                    <button class="btn btn-success btn-sm mr-2" style="float: right;" type="button" data-toggle="modal" data-target="#tambah-kategori">Tambah Kategori</button>
                    <button class="btn btn-success btn-sm mr-2" style="float: right;" type="button" data-toggle="modal" data-target="#daftar-kategori">Daftar Kategori</button>
                  </h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example1" class="table table-bordered table-striped">
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
                        <a href="javascript:;" onclick="edit_modal('<?= $rowBarang['kode_barang']; ?>')" class="badge badge-warning text-white"><i class="fa fa-pen p-1"></i> Edit</a>
                        <a href="javascript:;" onclick="hapus_barang('<?= $rowBarang['kode_barang']; ?>')" class="badge badge-danger"><i class="fa fa-trash p-1"></i> Hapus</a>
                      </td>
                    </tr>
                    <?php $no++; endwhile; ?>
                    <?php if (mysqli_num_rows($queryBarang) === 0 ): ?>
                    <tr>
                      <td colspan="9" align="center">Tidak ada barang</td>
                    </tr>
                    <?php endif ?>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
      </div>
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

<div class="modal fade" id="hapus-barang">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="" method="POST">
        <div class="modal-body">
          <p style="font-weight: bold;">Ingin menghapus barang?</p>
          <input type="hidden" name="kode_hapus" value="" id="kode_hapus">
          <div class="text-right">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger" name="hapusBarang">Hapus</button>
          </div>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="tambah-kategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Tambah Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Kategori" name="addKategori">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="submit" class="btn btn-primary" name="tombolAddKategori">Tambah Kategori</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="daftar-kategori">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Daftar Kategori</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="example1" class="table table-bordered table-striped">
          <tr>
            <th style="width: 10px;text-align: center;">No</th>
            <th>Kategori</th>
            <th style="width: 10px;text-align: center;">Aksi</th>
          </tr>
          <?php 
          $no = 1;
          $qDaftarKategori = mysqli_query($konek, "SELECT * FROM kategori ORDER BY kategori ASC");
          while($rDaftarKategori = mysqli_fetch_assoc($qDaftarKategori)) :
          ?>
          <tr>
            <td align="center"><?= $no; ?></td>  
            <td><?= $rDaftarKategori['kategori']; ?></td>
            <td>
              <a href="?kategori_hapus=<?= $rDaftarKategori['id']; ?>" class="badge badge-danger p-1">
                <i class="fas fa-trash"></i> Hapus
              </a>
            </td>
          </tr>
          <?php $no++; endwhile; ?>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary" onclick="tambah_kategori();">Tambah Kategori</button>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
  <div class="modal fade" id="edit-modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Edit Barang</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="POST">
          <div class="modal-body">
            <div id="data-edit"></div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            <button type="submit" name="saveBarang" class="btn btn-primary">Simpan Barang</button>
          </div>
        </form>
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
<!-- DataTables -->
<script src="<?= $link; ?>/assets/plugins/datatables/jquery.dataTables.js"></script>
<script src="<?= $link; ?>/assets/plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- FastClick -->
<!-- Select2 -->
<script src="<?= $link; ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="<?= $link; ?>/assets/plugins/fastclick/fastclick.js"></script>
<!-- SweetAlert2 -->
<script src="<?= $link; ?>/assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= $link; ?>/assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?= $link; ?>/assets/dist/js/demo.js"></script>
<!-- page script -->
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
    $('#example1').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": true,
    });
  });
</script>
<script>
  function tambah_kategori() {
    $('#daftar-kategori').modal('hide');
    $('#tambah-kategori').modal('show');
  }
</script>
<script type="text/javascript">
  function edit_modal(kode) {
    $('#edit-modal').modal('show');
    $.ajax({
      url: 'get-data.php',
      data: 'kode_barang=' + kode,
      type: 'POST',
      dataType: 'html',
      success: function(msg) {
        $("#data-edit").html(msg);
      }, error: function() {
        $('#data-edit').html('Terjadi kesalahan...');
      }, beforeSend: function() {
        $('#data-edit').html('Sedang memuat...');
      }
    });
  }
  function hapus_barang(kode) {
    $('#kode_hapus').attr('value', kode);
    $('#hapus-barang').modal('show');
  }
  </script>
</body>
</html>
