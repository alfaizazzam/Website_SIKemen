<?php
// Include your database connection
include 'config/database.php';

// Fetch payment data from tpembayaran table
$sql = "SELECT tp.id, tu.nama_user, ts.harga_spesialisasi, tp.metode_pembayaran, tp.tanggal_pembayaran 
        FROM tpembayaran tp 
        JOIN tuser tu ON tp.id_user = tu.id_user
        JOIN tspesialisasi ts ON tp.id_spesialisasi = ts.id_spesialisasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Table of Payments</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Tabel Pemasukan</h2>
        <a href="generate_pdf.php" class="btn btn-primary mb-3">Generate PDF</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>ID Pembayaran</th>
                    <th>Nama User</th>
                    <th>Harga Spesialisasi</th>
                    <th>Metode Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_user']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['harga_spesialisasi']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['metode_pembayaran']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_pembayaran']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='text-center'>No records found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
