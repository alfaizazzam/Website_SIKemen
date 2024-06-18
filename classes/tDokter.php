<?php
class tDokter {
    private $conn;

    public function __construct() {
        require_once 'config/database.php';
        $this->conn = $conn;
    }

    public function tampilDokter() {
        $query = "SELECT d.*, s.nama_spesialisasi, s.harga_spesialisasi FROM dokter d 
                  JOIN spesialisasi s ON d.kode_spesialisasi = s.kode_spesialisasi";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function tampilDokterBySpesialisasi($kode) {
        $query = "SELECT d.*, s.nama_spesialisasi, s.harga_spesialisasi FROM dokter d 
                  JOIN spesialisasi s ON d.kode_spesialisasi = s.kode_spesialisasi 
                  WHERE s.kode_spesialisasi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $kode);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function tampilJumlahDokter() {
        $query = "SELECT COUNT(*) as jumlah FROM dokter";
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['jumlah'];
    }

    public function tampilJumlahDokterByKode($kode) {
        $query = "SELECT COUNT(*) as jumlah FROM dokter WHERE kode_spesialisasi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $kode);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['jumlah'];
    }
}

?>