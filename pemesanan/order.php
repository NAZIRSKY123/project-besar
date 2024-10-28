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

// Ambil data pemesanan berdasarkan ID
$id_pemesanan = $_GET['id'];
$pemesanan_query = mysqli_query($conn, "SELECT * FROM Pemesanan WHERE id_pemesanan = $id_pemesanan");
$pemesanan = mysqli_fetch_assoc($pemesanan_query);

// Validasi saat form disubmit
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $status = 'Dipesan'; // Contoh status baru
    $update_query = "UPDATE Pemesanan SET status = '$status' WHERE id_pemesanan = $id_pemesanan";

    if (mysqli_query($conn, $update_query)) {
        $message = "<div class='message success'>Pemesanan berhasil diperbarui!</div>";
    } else {
        $message = "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
    }
}

mysqli_close($conn); // Menutup koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Pemesanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/background.jpg'); /* Gambar latar belakang */
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 20px;
        }
        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 500px;
            margin: auto;
        }
        h2 {
            text-align: center;
            color: #28a745;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #333;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus,
        input[type="number"]:focus {
            border-color: #28a745;
            outline: none;
        }
        input[type="submit"] {
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #218838;
            transform: scale(1.05);
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
    <h2>Order Pemesanan</h2>
    <?= $message; ?> <!-- Tampilkan pesan di sini -->
    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" value="<?php echo htmlspecialchars($pemesanan['nama_pelanggan']); ?>" required>
        </div>
        <div class="form-group">
            <label for="produk">Produk:</label>
            <input type="text" name="produk" value="<?php echo htmlspecialchars($pemesanan['id_produk']); ?>" readonly>
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" value="<?php echo htmlspecialchars($pemesanan['jumlah']); ?>" required min="1">
        </div>
        <input type="submit" value="Konfirmasi Order">
    </form>
</div>

</body>
</html>
