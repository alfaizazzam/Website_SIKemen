<?php
  include '../../database/Konsultasi.php';

  date_default_timezone_set('Asia/Jakarta');
  $id_pasien = $_POST['id_pasien'];
  $id_dokter = $_POST['id_dokter'];
  $topik = $_POST['topik'];
  $date = date("Y-m-d,h-i-s");




  $konsul = new Konsultasi;
  $konsul->tambahKonsultasi($id_dokter,$id_pasien,$topik,$date);

  echo "<script>
            alert('Pesan anda akan segera di respon oleh konsultan :} !');
            	window.location = '../../index.php?p=select_chat';
        </script>";




 ?>
