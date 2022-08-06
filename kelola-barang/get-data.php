<?php
require_once("../include/koneksi.php");
$kode = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_barang'])));
$queryBarang = mysqli_query($konek, "SELECT * FROM barang WHERE kode_barang = '$kode'");
$rowBarang = mysqli_fetch_assoc($queryBarang);
if (mysqli_num_rows($queryBarang) === 0) : ?>
<div class="alert alert-danger">
	<i class="fas fa-times" style="margin-right: 10px;"></i> Data tidak di temukan
</div>
<?php else : ?>
<div class="form-group">
  <label for="nama_barang">Nama Barang</label>
  <input type="hidden" name="kode_barang" value="<?= $rowBarang['kode_barang']; ?>">
  <input type="text" class="form-control" name="nama_barang" id="nama_barang" value="<?= $rowBarang['nama_barang']; ?>">
</div>
<div class="form-group">
  <label for="kategori">Kategori</label>
  <select class="select2 form-control" style="width: 100%;" name="kategori" id="kategori">
    <option value="<?= $rowBarang['kategori']; ?>"><?= $rowBarang['kategori']; ?></option>
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
    <option value="<?= $rowBarang['jenis_satuan']; ?>"><?= $rowBarang['jenis_satuan']; ?></option>
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
<div class="form-group">
  <label for="harga_pokok">Harga Pokok</label>
  <input type="number" class="form-control" name="harga_pokok" id="harga_pokok" value="<?= $rowBarang['harga_pokok']; ?>">
</div>
<div class="form-group">
  <label for="harga_eceran">Harga Jual</label>
  <input type="number" class="form-control" name="harga_eceran" id="harga_eceran" value="<?= $rowBarang['harga_eceran']; ?>">
</div>
<div class="form-group">
  <label for="jumlah_stok">Jumlah Stok</label>
  <input type="number" class="form-control" name="jumlah_stok" id="jumlah_stok" value="<?= $rowBarang['jumlah_stok']; ?>">
</div>
<?php endif; ?>