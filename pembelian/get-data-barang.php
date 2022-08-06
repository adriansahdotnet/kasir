<?php
require_once("../include/koneksi.php");
$kode = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['kode_barang'])));
$search = htmlspecialchars(trim(mysqli_real_escape_string($konek, $_POST['search'])));
$queryBarang = mysqli_query($konek, "SELECT * FROM barang WHERE kode_barang = '$kode'");
$rowBarang = mysqli_fetch_assoc($queryBarang);
if (mysqli_num_rows($queryBarang) === 1) {
	echo $rowBarang[$search];
} else {
  echo "None";
}
?>