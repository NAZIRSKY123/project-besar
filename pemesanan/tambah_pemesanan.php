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

// Validasi saat form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $jumlah = $_POST['jumlah'];
    $status = 'Disiapkan'; // Status awal

    // Cek stok produk
    $query_stok = mysqli_query($conn, "SELECT stok FROM Produk WHERE id_produk = $id_produk");
    $row_stok = mysqli_fetch_assoc($query_stok);
    
    if ($row_stok['stok'] >= $jumlah && $jumlah > 0) {
        // Insert pemesanan ke database
        $query_insert = "INSERT INTO Pemesanan (id_produk, nama_pelanggan, tanggal_pemesanan, jumlah, status) 
                         VALUES ($id_produk, '$nama_pelanggan', '$tanggal_pemesanan', $jumlah, '$status')";
        
        if (mysqli_query($conn, $query_insert)) {
            // Update stok produk
            $stok_baru = $row_stok['stok'] - $jumlah;
            mysqli_query($conn, "UPDATE Produk SET stok = $stok_baru WHERE id_produk = $id_produk");
            echo "Pemesanan berhasil!";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Jumlah pemesanan melebihi stok atau tidak valid.";
    }
}

// Ambil data produk untuk dropdown
$produk_query = mysqli_query($conn, "SELECT * FROM Produk");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemesanan</title>
</head>
<body>

<h2>Tambah Pemesanan</h2>
<form method="POST" action="">
    Nama Pelanggan: <input type="text" name="nama_pelanggan" required><br>
    Produk:
    <select name="id_produk" required>
        <?php while ($row = mysqli_fetch_assoc($produk_query)): ?>
            <option value="<?php echo $row['id_produk']; ?>"><?php echo $row['nama_produk']; ?></option>
        <?php endwhile; ?>
    </select><br>
    Tanggal Pemesanan: <input type="date" name="tanggal_pemesanan" required><br>
    Jumlah: <input type="number" name="jumlah" min="1" required><br>
    <input type="submit" value="Pesan">
</form>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
