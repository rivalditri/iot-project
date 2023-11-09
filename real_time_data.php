<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensor";

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}

// Ambil data dari tabel real_time_data
$sql = "SELECT * FROM datasensor ORDER BY id DESC";
$result = $conn->query($sql);
$data = array();

// Memasukkan data ke dalam array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Mengirim data dalam format JSON
header('Content-Type: application/json');
echo json_encode(array_reverse($data));

// Menutup koneksi database
$conn->close();
?>
