<?php
class tSpesialisasi {
    private $conn;

    public function __construct() {
        require_once 'config/database.php';
        $this->conn = $conn;
    }

    public function tampilSpesialisasi() {
        $query = "SELECT * FROM spesialisasi";
        $result = $this->conn->query($query);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function tampilSpesialisasiByKode($kode) {
        $query = "SELECT * FROM spesialisasi WHERE kode_spesialisasi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $kode);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
}
?>