<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Initialize objects for Spesialisasi and Dokter
$spesial = new Spesialisasi;
$dokter = new Dokter;

// Fetch all specializations and doctors
$tampilSpesial = $spesial->tampilSpesialisasi();
$tampilDokter = $dokter->tampilDokter();
$jumlahSemuaDokter = $dokter->tampilJumlahDokter();

// Check if a specialization code is received from URL ($_GET['kode'])
if (isset($_GET['kode'])) {
    $kode = $_GET['kode'];
    $tampilSpesialByKode = $spesial->tampilSpesialisasiByKode($kode);
    $tampilDokter = $dokter->tampilDokterBySpesialisasi($kode);
}
?>
<?php if ($_SESSION['role'] == 'user'): ?>
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-light bg-light justify-content-between">
                <h3>Hallo <?= htmlspecialchars($_SESSION['nama']) ?>!</h3>
                <form class="form-inline">
                    <input class="form-control mr-sm-2" type="search" placeholder="Cari Nama Dokter..." autofocus aria-label="Search" id="keyword">
                    <button class="btn hijau putih my-2 my-sm-0" type="submit" id="tombolCari">Search</button>
                </form>
            </nav>
        </div>
    </div><br />
    <div class="row">
        <div class="col-12 kategori">
            <a href="index.php?p=select_chat">
                <button type="button" class="btn btn-sm">
                    All <span class="badge badge-secondary hijau"><?= htmlspecialchars($jumlahSemuaDokter) ?></span>
                </button>
            </a>
            <?php if ($tampilSpesial): ?>
                <?php foreach ($tampilSpesial as $row): ?>
                    <a href="index.php?p=select_chat&kode=<?= htmlspecialchars($row['kode_spesialisasi']) ?>">
                        <button type="button" class="btn btn-sm">
                            <?= htmlspecialchars($row['nama_spesialisasi']) ?>
                            <?php
                            // Fetch the number of doctors by specialization
                            $jumlahDokter = $dokter->tampilJumlahDokterByKode($row['kode_spesialisasi']);
                            ?>
                            <span class="badge badge-secondary hijau"><?= htmlspecialchars($jumlahDokter) ?></span>
                        </button>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="row justify-content-center ashiapp" id="konten">
        <?php if ($tampilDokter): ?>
            <?php foreach ($tampilDokter as $row): ?>
                <div class="col-lg ourdoctor2 maelee mb-3 text-center">
                    <div class="ourdoctortempat">
                        <div class="kotaku">
                            <img src="<?= htmlspecialchars($row['foto_user']) ?>" alt="Foto Dokter" class="">
                            <div class="overlay">
                                <div class="text"><img class="" src="img/doctor.svg" style="font-size: 10px;"></div>
                            </div>
                        </div>
                    </div>
                    <h4>Dr. <?= htmlspecialchars($row['nama_user']) ?></h4>
                    <p><?= htmlspecialchars($row['nama_spesialisasi']) ?></p>
                    <button class="btn btn-secondary hijau tombol" onclick="showPaymentModal('<?= htmlspecialchars($row['id_user']) ?>')">Konsul</button>
                </div>

                <!-- Payment Modal -->
                <div class="modal fade" id="paymentModal_<?= htmlspecialchars($row['id_user']) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Pembayaran</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="POST" id="paymentForm_<?= htmlspecialchars($row['id_user']) ?>">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>Harga Konsultasi:</label>
                                        <p><?= htmlspecialchars($row['harga_spesialisasi']) ?> Konsultasi bersama <?= htmlspecialchars($row['nama_spesialisasi']) ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="metodePembayaran_<?= htmlspecialchars($row['id_user']) ?>">Pilih Metode Pembayaran:</label>
                                        <select class="form-control" name="metode_pembayaran" id="metodePembayaran_<?= htmlspecialchars($row['id_user']) ?>">
                                            <option value="ovo">OVO</option>
                                            <option value="gopay">GoPay</option>
                                            <option value="spay">SPay</option>
                                        </select>
                                    </div>
                                    <input type="hidden" name="id_user" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                                    <input type="hidden" name="id_spesialisasi" value="<?= htmlspecialchars($row['id_spesialisasi']) ?>">
                                    <input type="hidden" name="harga_spesialisasi" value="<?= htmlspecialchars($row['harga_spesialisasi']) ?>">
                                    <input type="hidden" name="nama_user" value="<?= htmlspecialchars($_SESSION['nama']) ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                    <button type="button" class="btn btn-primary bayar" data-user="<?= htmlspecialchars($row['id_user']) ?>">Bayar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Consultation Modal -->
                <div class="modal fade" id="form_konsul_<?= htmlspecialchars($row['id_user']) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Konsultasi dengan <?= htmlspecialchars($row['nama_user']) ?></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="process/konsul/tambahKonsul_proses.php">
                                    <div class="form-group text-center">
                                        <img src="<?= htmlspecialchars($row['foto_user']) ?>" alt="Foto Dokter" class="gambar-bulat">
                                        <h2>Dr. <?= htmlspecialchars($row['nama_user']) ?></h2>
                                        <p class="text-hijau"><?= htmlspecialchars($row['nama_spesialisasi']) ?></p>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Pertanyaan Anda:</label>
                                        <textarea class="form-control" rows="3" name="topik" maxlength="120" minlength="3" id="text_<?= htmlspecialchars($row['id_user']) ?>"></textarea>
                                        <span class="badge badge-secondary" id="count_message_<?= htmlspecialchars($row['id_user']) ?>">0 / 120</span>
                                    </div>
                                    <input type="hidden" name="id_pasien" value="<?= htmlspecialchars($_SESSION['id']) ?>">
                                    <input type="hidden" name="id_dokter" value="<?= htmlspecialchars($row['id_user']) ?>">
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="successModalLabel">Pembayaran Berhasil</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Pembayaran berhasil dengan <span id="paymentMethod"></span>. Silakan lanjutkan untuk konsultasi!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary consultation-btn" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        id_user = null;

        // Function to show payment modal
        window.showPaymentModal = function(id_user) {
            $('#paymentModal_' + id_user).modal('show');
        };
        // $('#successModal').modal('show');

        // Function to handle payment submission
        $('.bayar').on('click', function(e) {
            e.preventDefault();
            id_user = $(this).data('user');
            var metodePembayaran = $('#metodePembayaran_' + id_user).val();
            var id_spesialisasi = $('#paymentModal_' + id_user).find('input[name="id_spesialisasi"]').val();
            var harga_spesialisasi = $('#paymentModal_' + id_user).find('input[name="harga_spesialisasi"]').val();
            var nama_user = $('#paymentModal_' + id_user).find('input[name="nama_user"]').val();

            console.log(id_user, metodePembayaran, id_spesialisasi);

            $.ajax({
              type: "POST",
              url: "process/process_payment.php",
              data: {
                  id_user: id_user,
                  id_spesialisasi: id_spesialisasi,
                  harga_spesialisasi: harga_spesialisasi,
                  metode_pembayaran: metodePembayaran,
                  nama_user: nama_user
              },
              dataType: 'json',
              success: function(response) {
                  if (response.status === 'success') {
                      $('#paymentModal_' + id_user).modal('hide');
                      $('#paymentModal_' + id_user).on('hidden.bs.modal', function () {
                          $('#paymentMethod').text(metodePembayaran);
                          $('#successModal').modal('show');
                      });
                  } else {
                      alert('Pembayaran gagal. Silakan coba lagi atau hubungi admin.');
                  }
              },
              error: function(xhr, status, error) {
                  alert('Terjadi kesalahan saat memproses pembayaran: ' + xhr.responseText);
              }
          });

        });

        $('.consultation-btn').click(function(){
                          $('#successModal').modal('hide');
          $('#form_konsul_' + id_user).modal('show');
        });
    });
    </script>

<?php else: ?>
    <script type="text/javascript">
        alert('Anda harus login sebagai user');
        window.location = 'process/logout.php';
    </script>
<?php endif; ?>
