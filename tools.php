<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Total</title>
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
</head>
<body onload="window.print();">
	<p>Laporan</p>
	<table border="1" cellspacing="0" width="50%">
		<tr>
			<td class="td-data" colspan="4">Kategori : Minuman</td>
		</tr>
		<tr>
			<th width="30px;">No</th>
			<th>Data</th>
			<th>Data</th>
			<th>Data</th>
		</tr>
		<?php for($i = 0; $i < 9; $i++) :?>
		<tr>
			<td class="td-no"><?= $i; ?></td>
			<td class="td-data">Data <?= $i; ?></td>
			<td class="td-data">Data <?= $i; ?></td>
			<td class="td-data">Data <?= $i; ?></td>
		</tr>
		<?php endfor; ?>
	</table>
</body>
</html>