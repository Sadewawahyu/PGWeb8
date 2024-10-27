<?php
// Mengambil data dari form
$kecamatan = $_POST['kecamatan'];
$longitude = $_POST['longitude'];
$latitude = $_POST['latitude'];
$luas = $_POST['luas'];
$jumlah_penduduk = $_POST['jumlah_penduduk'];

// Konfigurasi koneksi MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acara8";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Menggunakan prepared statement untuk keamanan
$sql = "INSERT INTO jumlah_penduduk (kecamatan, longitude, latitude, luas, jumlah_penduduk) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sdddi", $kecamatan, $longitude, $latitude, $luas, $jumlah_penduduk);

// Menjalankan query dan memeriksa hasil
if ($stmt->execute()) {
    // Redirect ke index.php setelah berhasil menambah data
    header("Location: index.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

// Menutup statement dan koneksi
$stmt->close();
$conn->close();
?>
