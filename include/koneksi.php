<?php 
/* 
	Aplication Web POS (Kasir)
	Copyright : 2019
	Web : http://frendysantoso.blogspot.com
	Web Panel : http://borneo-panel.com
	Created by Frendy Santoso

	// Don't Remove Copyright
*/

	/* Definisi Database */
	$konek = mysqli_connect('localhost', 'root', '', 'ukom');

	/* Definisi Tanggal */
	date_default_timezone_set('Asia/Jakarta');
	$tanggal = date('d M Y');
	$waktu = date('G:i:s');

	/* Utility */
	require 'data-aplikasi.php';
	$link = "http://".$_SERVER['SERVER_NAME']."/ukom-pos";

	/* Kumpulan Function Function */
	function alert($tipe, $isi, $lokasi) {
		setcookie($tipe, $isi, time()+2, '/');
		header("location:../" . $lokasi);
		exit();
	}

	function total_query($qu) {
		$q = mysqli_query($konek, $qu);
		return mysqli_num_rows($q);
	}

	function sisa_angka($string) {
		$string = preg_replace('/([^0-9\+]+)/', '', $string);
		return $string;
	}

	function cari_kasir($id_pembelian) {
	  global $konek;
	  $q = mysqli_query($konek, "SELECT * FROM pembayaran WHERE id_pembelian = '$id_pembelian'");
	  $f = mysqli_fetch_assoc($q);
	  return $f['kasir'];
	}

?>