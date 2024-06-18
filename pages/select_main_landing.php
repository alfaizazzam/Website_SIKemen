<!-- Info panel -->



<?php
  include 'database/Artikel.php';

 ?>
   <?php
          $artikel = new Artikel;

          $data = $artikel->tampilArtikel2();
          $i = 1;
          foreach ($data as $row) :
        ?>

  <div class="row workingspace" id="berita">
    <div class="col-lg-6">
      <img src="<?= $row['foto'] ?>" alt="workingspace" class="img-fluid">
    </div>
    <div class="col-lg-6">
      <h3><?= $row['judul'] ?></h3>
      <p><?= $row['artikel'] ?></p>
      <a href="index.php?p=detail_berita&id=<?=$row['id']?>" class="btn btn-secondary tombol">Read More</a>
    </div>

  </div>
          <?php
              $i++;
        endforeach;

        ?>
  <!-- Akhir working space -->

  <!-- Berita -->
  <div class="row titleberita">
    <div class="col-12">
      <h1>Artikel Terbaru</h1>
    </div>
  </div>

  <div class="row berita">
     <?php
          $artikel = new Artikel;

          $data = $artikel->tampilArtikel();
          $i = 1;
          foreach ($data as $row) :
        ?>
    <div class="col-lg-6 maelee">
      <img src="<?= $row['foto'] ?>" alt="workingspace" class="float-left">
      <h3><?= $row['judul'] ?></h3>
      <p><?= $row['artikel'] ?></p>
       <small class="text-warning">
         <?php
            $harijam = $row['date'] ;
            $date = strtotime($harijam);
            echo date('M - H:I', $date);
          ?>
        </small>
      <a href="index.php?p=detail_berita&id=<?=$row['id']?>"><img src="img/next.png" alt="workingspace" class="float-right" style="width:30px; height: 30px;"></a>

    </div>
     <?php
              $i++;
        endforeach;

        ?>
  </div>

  <!-- Akhir berita -->

<!--   Informasi Dokter -->
  <div class="row titleberita" id="ourdoctor">
    <div class="col-10">
      <h1>Psikolog Kami</h1>
    </div>
    <!-- <div class="col-2">
      <a href="#"><img class="float-right nextdoc" src="img/next2.png"></a>
      <a href="#"><img class="float-right nextdoc" src="img/prev2.png"></a>
    </div> -->
  </div>


    <div class="row justify-content-center ashiapp">

      <?php
           $dtr = new Dokter;

           $data = $dtr->tampilDokterLimit();
           $i = 1;
           foreach ($data as $row) :
         ?>


        <!-- <a href="index.php"> -->
          <div class="col-lg ourdoctor maelee mb-3">
            <div class="ourdoctortempat">
              <img src="<?= $row['foto_user'] ?>" alt="Doctor Image">
            </div>
            <h4>Dr. <?= $row['nama_user'] ?></h4>
            <p>Spesialis <?= $row['nama_spesialisasi'] ?></p>
    
            <div class="popup-card" style="display: none;">
                <p><?= $row['deskripsi'] ?></p> <!-- Assuming there's a description field -->
            </div>
          </div>
        <!-- </a> -->


        <?php
                 $i++;
           endforeach;

           ?>

        <!-- <a href="index.php?id=2">
          <div class="col-lg ourdoctor maelee mb-3">
            <div class="ourdoctortempat">
              <img src="img/doctor2.jpg" alt="Security">
            </div>
            <h4>Location</h4>
            <p>Lorem ipsum dolor sit amet.</p>
          </div>
        </a>

        <a href="index.php?id=3">
          <div class="col-lg ourdoctor maelee mb-3">
            <div class="ourdoctortempat">
              <img src="img/doctor3.jpg" alt="Security">
            </div>
            <h4>Location</h4>
            <p>Lorem ipsum dolor sit amet.</p>
          </div>
        </a>

        <a href="#">
          <div class="col-lg ourdoctor maelee mb-3">
            <div class="ourdoctortempat">
              <img src="img/doctor4.jpg" alt="Security">
            </div>
            <h4>Location</h4>
            <p>Lorem ipsum dolor sit amet.</p>
          </div>
        </a> -->
    </div>
    <div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <div class="modal-body">
            <div class="modal-image">
                <img id="modal-img" src="" alt="Doctor Image">
            </div>
            <div class="modal-info">
                <h4 id="modal-name"></h4>
                <p id="modal-specialty"></p>
                <p id="modal-description"></p>
            </div>
        </div>
    </div>
</div>


  <!-- Akhir Informasi Dokter -->