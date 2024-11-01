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
            echo "<div class='message success'>Pemesanan berhasil!</div>";
        } else {
            echo "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='message error'>Jumlah pemesanan melebihi stok atau tidak valid.</div>";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        h2 {
            color: #343a40;
            text-align: center;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            margin: auto;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="number"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Tambah Pemesanan</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" required>
        </div>
        <div class="form-group">
            <label for="id_produk">Produk:</label>
            <select name="id_produk" required>
                <?php while ($row = mysqli_fetch_assoc($produk_query)): ?>
                    <option value="<?php echo $row['id_produk']; ?>"><?php echo $row['nama_produk']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="tanggal_pemesanan">Tanggal Pemesanan:</label>
            <input type="date" name="tanggal_pemesanan" required>
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" min="1" required>
        </div>
        <input type="submit" value="Pesan">
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
