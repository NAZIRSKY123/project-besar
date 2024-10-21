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

// Ambil data produk untuk dropdown
$produk_result = mysqli_query($conn, "SELECT * FROM Produk");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_produk = $_POST['id_produk'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];

    // Cek stok produk
    $stok_query = "SELECT stok FROM Produk WHERE id_produk = $id_produk";
    $stok_result = mysqli_query($conn, $stok_query);
    $stok_data = mysqli_fetch_assoc($stok_result);

    if ($stok_data['stok'] >= $jumlah) {
        // Query untuk menambahkan pemesanan
        $insert_query = "INSERT INTO Pemesanan (id_produk, nama_pelanggan, tanggal_pemesanan, jumlah, status) VALUES ('$id_produk', '$nama_pelanggan', '$tanggal_pemesanan', '$jumlah', '$status')";

        if (mysqli_query($conn, $insert_query)) {
            // Kurangi stok produk
            $new_stok = $stok_data['stok'] - $jumlah;
            mysqli_query($conn, "UPDATE Produk SET stok = $new_stok WHERE id_produk = $id_produk");
            echo "Pemesanan berhasil ditambahkan.";
            header("Location: index_pemesanan.php"); // Redirect ke daftar pemesanan
            exit();
        } else {
            echo "Error: " . $insert_query . "<br>" . mysqli_error($conn);
        }
    } else {
        echo "Stok tidak mencukupi untuk pemesanan.";
    }
}

mysqli_close($conn); // Menutup koneksi
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
    <label for="id_produk">Pilih Produk:</label>
    <select id="id_produk" name="id_produk" required>
        <?php while ($row = mysqli_fetch_assoc($produk_result)): ?>
            <option value="<?php echo $row['id_produk']; ?>"><?php echo $row['nama_produk']; ?></option>
        <?php endwhile; ?>
    </select>

    <label for="nama_pelanggan">Nama Pelanggan:</label>
    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>

    <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
    <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" required>

    <label for="jumlah">Jumlah:</label>
    <input type="number" id="jumlah" name="jumlah" min="1" required>

    <label for="status">Status:</label>
    <select id="status" name="status" required>
        <option value="Disiapkan">Disiapkan</option>
        <option value="Dikirim">Dikirim</option>
        <option value="Diterima">Diterima</option>
    </select>

    <input type="submit" value="Tambah Pemesanan">
</form>

</body>
</html>
