<?php
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

// Fungsi untuk menghapus data jika ada request
if (isset($_POST['delete_kecamatan'])) {
    $kecamatan = $_POST['delete_kecamatan'];
    $delete_sql = "DELETE FROM jumlah_penduduk WHERE kecamatan =?"; 
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $kecamatan);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>Data kecamatan '$kecamatan' berhasil dihapus.</p>";
    } else {
        echo "<p style='color: red;'>Gagal menghapus data kecamatan '$kecamatan'.</p>";
    }
}

// Query untuk mengambil data dari tabel 'jumlah_penduduk'
$sql = "SELECT kecamatan, longitude, latitude, luas, jumlah_penduduk FROM jumlah_penduduk";
$result = $conn->query($sql);

// Memeriksa apakah ada hasil yang dikembalikan
if ($result->num_rows > 0) {
    // Membuat header tabel dengan styling
    echo "<table style='border-collapse: collapse; width: 100%; font-family: Arial, sans-serif;'>
            <thead>
                <tr style='background-color: #f2f2f2; text-align: left;'>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Kecamatan</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Longitude</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Latitude</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Luas (km²)</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Jumlah Penduduk</th>
                    <th style='padding: 10px; border: 1px solid #ddd;'>Aksi</th>
                </tr>
            </thead>
            <tbody>";

    // Output data setiap baris dengan styling dan tombol hapus
    while ($row = $result->fetch_assoc()) {
        echo "<tr style='border-bottom: 1px solid #ddd;'>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($row["kecamatan"]) . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($row["longitude"]) . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($row["latitude"]) . "</td>
                <td style='padding: 10px; border: 1px solid #ddd;'>" . htmlspecialchars($row["luas"]) . "</td>
                <td style='padding: 10px; text-align: left; border: 1px solid #ddd;'>" . number_format(htmlspecialchars($row["jumlah_penduduk"])) . "</td>
                <td style='padding: 10px; text-align: center; border: 1px solid #ddd;'>
                    <form method='POST' action='' onsubmit='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>
                        <input type='hidden' name='delete_kecamatan' value='" . htmlspecialchars($row["kecamatan"]) . "'>
                        <input type='submit' value='Hapus' style='background-color: red; color: white; border: none; padding: 5px 10px; cursor: pointer;'>
                    </form>
                </td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    echo "<p style='font-family: Arial, sans-serif;'>Tidak ada hasil ditemukan</p>";
}

// Menutup koneksi
$conn->close();
?>
