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
    $nama_pelanggan = mysqli_real_escape_string($conn, $_POST['nama_pelanggan']);
    $id_produk = mysqli_real_escape_string($conn, $_POST['id_produk']);
    $tanggal_pemesanan = mysqli_real_escape_string($conn, $_POST['tanggal_pemesanan']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Update data pemesanan
    $sql = "UPDATE Pemesanan SET 
            id_produk = '$id_produk', 
            nama_pelanggan = '$nama_pelanggan', 
            tanggal_pemesanan = '$tanggal_pemesanan', 
            jumlah = '$jumlah', 
            status = '$status' 
            WHERE id_pemesanan = '$id'";

    if (mysqli_query($conn, $sql)) {
        header('Location: index_pemesanan.php'); // Redirect ke halaman daftar pemesanan
        exit();
    } else {
        echo "<div class='error-message'>Error updating record: " . mysqli_error($conn) . "</div>";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2 {
            text-align: center;
            color: #4CAF50;
        }
        .form-container {
            max-width: 500px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Pemesanan</h2>
    <?php if (isset($error_message)) { echo "<div class='error-message'>$error_message</div>"; } ?>
    <form method="POST">
        <label for="nama_pelanggan">Nama Pelanggan:</label>
        <input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($data['nama_pelanggan']); ?>" required>

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
        </select>

        <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
        <input type="date" name="tanggal_pemesanan" value="<?php echo $data['tanggal_pemesanan']; ?>" required>

        <label for="jumlah">Jumlah:</label>
        <input type="number" name="jumlah" value="<?php echo $data['jumlah']; ?>" required min="1">

        <label for="status">Status:</label>
        <select name="status" required>
            <option value="Disiapkan" <?php echo ($data['status'] == 'Disiapkan') ? 'selected' : ''; ?>>Disiapkan</option>
            <option value="Dikirim" <?php echo ($data['status'] == 'Dikirim') ? 'selected' : ''; ?>>Dikirim</option>
            <option value="Diterima" <?php echo ($data['status'] == 'Diterima') ? 'selected' : ''; ?>>Diterima</option>
        </select>

        <input type="submit" value="Update">
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
