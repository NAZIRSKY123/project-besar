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

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $id_produk = $_POST['id_produk'];
    $tanggal_pemesanan = $_POST['tanggal_pemesanan'];
    $jumlah = $_POST['jumlah'];
    $status = $_POST['status'];

    // Update data pemesanan
    $sql = "UPDATE Pemesanan SET 
            id_produk = '$id_produk', 
            nama_pelanggan = '$nama_pelanggan', 
            tanggal_pemesanan = '$tanggal_pemesanan', 
            jumlah = '$jumlah', 
            status = '$status' 
            WHERE id_pemesanan = '$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Data pemesanan berhasil diupdate.";
        header('Location: index.php'); // Redirect ke halaman daftar pemesanan
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Ambil data yang akan diedit
    $result = mysqli_query($conn, "SELECT * FROM Pemesanan WHERE id_pemesanan = '$id'");
    $data = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan</title>
</head>
<body>

<h2>Edit Pemesanan</h2>
<form method="POST">
    <label for="nama_pelanggan">Nama Pelanggan:</label>
    <input type="text" name="nama_pelanggan" value="<?php echo $data['nama_pelanggan']; ?>" required><br>

    <label for="id_produk">Produk:</label>
    <select name="id_produk" required>
        <?php
        // Ambil semua produk untuk pilihan
        $produk_result = mysqli_query($conn, "SELECT * FROM Produk");
        while ($produk = mysqli_fetch_assoc($produk_result)) {
            $selected = ($produk['id_produk'] == $data['id_produk']) ? 'selected' : '';
            echo "<option value='{$produk['id_produk']}' $selected>{$produk['nama_produk']}</option>";
        }
        ?>
    </select><br>

    <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
    <input type="date" name="tanggal_pemesanan" value="<?php echo $data['tanggal_pemesanan']; ?>" required><br>

    <label for="jumlah">Jumlah:</label>
    <input type="number" name="jumlah" value="<?php echo $data['jumlah']; ?>" required><br>

    <label for="status">Status:</label>
    <select name="status" required>
        <option value="Disiapkan" <?php echo ($data['status'] == 'Disiapkan') ? 'selected' : ''; ?>>Disiapkan</option>
        <option value="Dikirim" <?php echo ($data['status'] == 'Dikirim') ? 'selected' : ''; ?>>Dikirim</option>
        <option value="Diterima" <?php echo ($data['status'] == 'Diterima') ? 'selected' : ''; ?>>Diterima</option>
    </select><br>

    <input type="submit" value="Update">
</form>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
