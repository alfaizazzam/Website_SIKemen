<?php
	include '../../database/Spesialisasi.php';

	$kode_spesialisasi = $_POST['kode_spesialisasi'];
	$nama_spesialisasi = $_POST['nama_spesialisasi'];
	$harga_spesialisasi = $_POST['harga_spesialisasi'];

	$spesialisasi = new Spesialisasi;
	$spesialisasi->tambahSpesialisasi($kode_spesialisasi,$nama_spesialisasi,$harga_spesialisasi);
	echo "<script>
						alert('Data Berhasil Ditambah !');
						window.location = '../../index.php?p=tabel_spesialis';
				</script>";

 ?>
