<?php
include '../config/database.php'; // Ensure this path is correct

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_REQUEST['id_user'];
    $id_spesialisasi = $_REQUEST['id_spesialisasi'];
    $metode_pembayaran = $_REQUEST['metode_pembayaran'];
    $tanggal_pembayaran = date('Y-m-d H:i:s');

    // Fetch nama_user from tuser table
    $sql_user = "SELECT nama_user FROM tuser WHERE id_user = ?";
    $stmt_user = $conn->prepare($sql_user);

    if ($stmt_user === false) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Prepare failed for user query: " . $conn->error]);
        exit;
    }

    $stmt_user->bind_param("i", $id_user);
    $stmt_user->execute();
    $stmt_user->bind_result($nama_user);
    $stmt_user->fetch();
    $stmt_user->close();

    if (!$nama_user) {
        echo json_encode(["status" => "error", "message" => "User not found"]);
        exit;
    }

    // Fetch harga_spesialisasi from tspesialisasi table
    $sql_spesialisasi = "SELECT harga_spesialisasi FROM tspesialisasi WHERE id_spesialisasi = ?";
    $stmt_spesialisasi = $conn->prepare($sql_spesialisasi);

    if ($stmt_spesialisasi === false) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Prepare failed for spesialisasi query: " . $conn->error]);
        exit;
    }

    $stmt_spesialisasi->bind_param("i", $id_spesialisasi);
    $stmt_spesialisasi->execute();
    $stmt_spesialisasi->bind_result($harga_spesialisasi);
    $stmt_spesialisasi->fetch();
    $stmt_spesialisasi->close();

    if (!$harga_spesialisasi) {
        echo json_encode(["status" => "error", "message" => "Specialization not found"]);
        exit;
    }

    // Prepare query to insert payment data
    $sql = "INSERT INTO tpembayaran (id_user, id_spesialisasi, metode_pembayaran, tanggal_pembayaran) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Prepare failed for insert query: " . $conn->error]);
        exit;
    }

    $stmt->bind_param("iiss", $id_user, $id_spesialisasi, $metode_pembayaran, $tanggal_pembayaran);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "No rows inserted"]);
        }
    } else {
        http_response_code(500);
        echo json_encode(["status" => "error", "message" => "Execute failed: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
} else {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
