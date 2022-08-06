<?php require '../include/koneksi.php' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Cetak - <?= $judul; ?></title>
	<style>
		* {
			font-family: arial,sans-serif;
			font-size: 11px;
			margin: auto;
		}
		p {
			text-align: center;
			font-weight: bold;
			font-size: 12px;
			margin-bottom: 10px;
		}
		th {
			background: #eaeaea;
		}
		.td-data {
			padding-left: 5px;
		}
		.td-no {
			text-align: center;
			margin-left: -5px;
		}
		@media print {
			table {
				width: 100%;
			}
		}
	</style>
	<!-- Favicon -->
  	<link rel="icon" href="<?= $link; ?>/assets/dist/img/logo.png">
</head>
<body onload="window.print();">
	<p>Laporan <?= $_GET['tipe']; ?></p>
	<?php if (isset($_GET['tipe']) AND isset($_GET['data'])): ?>

		<?php if ($_GET['tipe'] === "Data Barang"): ?>
		<table border="1" cellspacing="0" width="50%">
			<tr>
				<?php if ($_GET['data'] === "All"): ?>
					<td class="td-data" colspan="8">Semua Barang</td>
				<?php else : ?>
					<td class="td-data" colspan="8">Kategori : <?= $_GET['data']; ?></td>
				<?php endif; ?>
			</tr>
			<tr>
				<th width="30px;">No</th>
				<th>Kode Barang</th>
				<th>Nama Barang</th>
				<th>Kategori</th>
				<th>Jenis Satuan</th>
				<th>Harga Pokok</th>
				<th>Harga Jual</th>
				<th>Jumlah Stok</th>
			</tr>
			<?php 
			if ($_GET['data'] === "All") {
				$queryDataBarang = mysqli_query($konek, "SELECT * FROM barang ORDER BY nama_barang ASC");
			} else {
				$data = $_GET['data'];
				$queryDataBarang = mysqli_query($konek, "SELECT * FROM barang WHERE kategori = '$data' ORDER BY nama_barang ASC");
			}
			$no = 1;
			while($rowDataBarang = mysqli_fetch_assoc($queryDataBarang)) :
			?>
			<tr>
				<td class="td-no"><?= $no; ?></td>
                <td class="td-data"><?= $rowDataBarang['kode_barang']; ?></td>
                <td class="td-data"><?= $rowDataBarang['nama_barang']; ?></td>
                <td class="td-data"><?= $rowDataBarang['kategori']; ?></td>
                <td class="td-data"><?= $rowDataBarang['jenis_satuan']; ?></td>
                <td class="td-data"><?= number_format($rowDataBarang['harga_pokok'],0,',','.'); ?></td>
                <td class="td-data"><?= number_format($rowDataBarang['harga_eceran'],0,',','.'); ?></td>
                <td class="td-data"><?= number_format($rowDataBarang['jumlah_stok'],0,',','.'); ?></td>
			</tr>
			<?php $no++; endwhile; ?>
		</table>
		<?php endif ?>

		<?php if ($_GET['tipe'] === "Pembelian Bulanan" || $_GET['tipe'] === "Pembelian Semua"): ?>
		<table border="1" cellspacing="0" width="50%">
			<?php 
			$pisahPriode = explode(' ', $_GET['data']);

            if(preg_match("/Jan/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jan', 'Januari', $pisahPriode[0]);
            } else if(preg_match("/Feb/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Feb', 'Februari', $pisahPriode[0]);
            } else if(preg_match("/Mar/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Mar', 'Maret', $pisahPriode[0]);
            } else if(preg_match("/Apr/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Apr', 'April', $pisahPriode[0]);
            } else if(preg_match("/May/i", $pisahPriode[0])) {
              $bulanShow = str_replace('May', 'May', $pisahPriode[0]);
            } else if(preg_match("/Jun/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jun', 'Juni', $pisahPriode[0]);
            } else if(preg_match("/Jul/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Jul', 'Juli', $pisahPriode[0]);
            } else if(preg_match("/Aug/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Aug', 'Agustus', $pisahPriode[0]);
            } else if(preg_match("/Sep/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Sep', 'September', $pisahPriode[0]);
            } else if(preg_match("/Oct/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Oct', 'Oktober', $pisahPriode[0]);
            } else if(preg_match("/Nov/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Nov', 'November', $pisahPriode[0]);
            } else if(preg_match("/Dec/i", $pisahPriode[0])) {
              $bulanShow = str_replace('Dec', 'Desember', $pisahPriode[0]);
            }
			?>
			<tr>
				<?php if ($_GET['data'] === "All"): ?>
					<td class="td-data" colspan="8">Semua Pembelian</td>
				<?php else : ?>
					<td class="td-data" colspan="8">Priode Bulan : <?= $bulanShow; ?></td>
				<?php endif; ?>
			</tr>
			<tr>
	            <th>No</th>
	            <th>Kasir</th>
	            <th>ID Pembelian</th>
	            <th>Nama Barang</th>
	            <th>Jumlah</th>
	            <th>Harga Jual</th>
	            <th>Total Harga</th>
	          </tr>
	          </thead>
	          <tbody>
	          <?php 
	          if ($_GET['data'] === "All") {
	            $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian ORDER BY id ASC");
	          } else {
	            $data = $_GET['data'];
	            $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian WHERE priode = '$data' ORDER BY id ASC");
	          }
	          $no = 1;
	          while($rowPembelianBulanan = mysqli_fetch_assoc($queryPembelianBulanan)) :
	          ?>
	          <tr>
	            <td class="td-no"><?= $no; ?></td>
	            <td class="td-data"><?= cari_kasir($rowPembelianBulanan['id_pembelian']); ?></td>
	            <td class="td-data"><?= $rowPembelianBulanan['id_pembelian']; ?></td>
	            <td class="td-data"><?= $rowPembelianBulanan['nama_barang']; ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['jumlah'],0,',','.'); ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['harga_eceran'],0,',','.'); ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['total'],0,',','.'); ?></td>
	          </tr>
	          <?php $no++; endwhile; ?>
		</table>
		<?php endif ?>
		
		<?php if ($_GET['tipe'] === "Pembelian Tahunan"): ?>
		<table border="1" cellspacing="0" width="50%">
			<tr>
				<?php if ($_GET['data'] === "All"): ?>
					<td class="td-data" colspan="8">Semua Pembelian</td>
				<?php else : ?>
					<td class="td-data" colspan="8">Priode Tahun : <?= $_GET['data']; ?></td>
				<?php endif; ?>
			</tr>
			<tr>
	            <th>No</th>
	            <th>Kasir</th>
	            <th>ID Pembelian</th>
	            <th>Nama Barang</th>
	            <th>Jumlah</th>
	            <th>Harga Jual</th>
	            <th>Total Harga</th>
	          </tr>
	          </thead>
	          <tbody>
	          <?php 
	          if ($_GET['data'] === "All") {
	            $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian ORDER BY id ASC");
	          } else {
	            $data = $_GET['data'];
	            $queryPembelianBulanan = mysqli_query($konek, "SELECT * FROM pembelian WHERE priode LIKE '%$data%' ORDER BY id ASC");
	          }
	          $no = 1;
	          while($rowPembelianBulanan = mysqli_fetch_assoc($queryPembelianBulanan)) :
	          ?>
	          <tr>
	            <td class="td-no"><?= $no; ?></td>
	            <td class="td-data"><?= cari_kasir($rowPembelianBulanan['id_pembelian']); ?></td>
	            <td class="td-data"><?= $rowPembelianBulanan['id_pembelian']; ?></td>
	            <td class="td-data"><?= $rowPembelianBulanan['nama_barang']; ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['jumlah'],0,',','.'); ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['harga_eceran'],0,',','.'); ?></td>
	            <td class="td-data"><?= number_format($rowPembelianBulanan['total'],0,',','.'); ?></td>
	          </tr>
	          <?php $no++; endwhile; ?>
		</table>
		<?php endif ?>
	<?php endif ?>
</body>
</html>