<?php
require('library/fpdf.php');
include 'config/database.php';

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        // Add logo (if needed)
        // $this->Image('logo.png',10,6,30);
        // Add font
        $this->SetFont('Arial', 'B', 12);
        // Move to the right
        $this->Cell(80);
        // Title
        $this->Cell(30, 10, 'Tabel Pemasukan', 0, 1, 'C');
        // Line break
        $this->Ln(10);

        // Column headers
        $this->Cell(30, 10, 'ID Pembayaran', 1);
        $this->Cell(50, 10, 'Nama User', 1);
        $this->Cell(30, 10, 'Harga', 1);
        $this->Cell(40, 10, 'Metode Pembayaran', 1);
        $this->Cell(40, 10, 'Tanggal Pembayaran', 1);
        $this->Ln();
    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Create instance of the PDF class
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Fetch payment data from tpembayaran table
$sql = "SELECT tp.id, tu.nama_user, ts.harga_spesialisasi, tp.metode_pembayaran, tp.tanggal_pembayaran 
        FROM tpembayaran tp 
        JOIN tuser tu ON tp.id_user = tu.id_user
        JOIN tspesialisasi ts ON tp.id_spesialisasi = ts.id_spesialisasi";
$result = $conn->query($sql);

// Check for records and output them to the PDF
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(30, 10, htmlspecialchars($row['id']), 1);
        $pdf->Cell(50, 10, htmlspecialchars($row['nama_user']), 1);
        $pdf->Cell(30, 10, htmlspecialchars($row['harga_spesialisasi']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($row['metode_pembayaran']), 1);
        $pdf->Cell(40, 10, htmlspecialchars($row['tanggal_pembayaran']), 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(190, 10, 'No records found', 1, 1, 'C');
}

$conn->close();

// Output the PDF
$pdf->Output();
?>
