<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_warung1';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Cek apakah id produk ada di URL
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Proses penghapusan
    $delete_query = "DELETE FROM Produk WHERE id_produk = $id_produk";

    if (mysqli_query($conn, $delete_query)) {
        echo "Produk berhasil dihapus.";
        header("Location: index.php"); // Redirect ke halaman daftar produk
        exit();
    } else {
        echo "Error: " . $delete_query . "<br>" . mysqli_error($conn);
    }
} else {
    echo "ID produk tidak ditemukan.";
}

mysqli_close($conn); // Menutup koneksi
?>
