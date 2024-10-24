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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Proses order di sini (misalnya, update status pemesanan)
    $status = 'Dipesan'; // Contoh status baru
    $update_query = "UPDATE Pemesanan SET status = '$status' WHERE id_pemesanan = $id_pemesanan";

    if (mysqli_query($conn, $update_query)) {
        echo "<div class='message success'>Pemesanan berhasil diperbarui!</div>";
    } else {
        echo "<div class='message error'>Error: " . mysqli_error($conn) . "</div>";
    }
}
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
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
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
        input[type="number"] {
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
    <h2>Order Pemesanan</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" value="<?php echo $pemesanan['nama_pelanggan']; ?>" >
        </div>
        <div class="form-group">
            <label for="produk">Produk:</label>
            <input type="text" name="produk" value="<?php echo $pemesanan['id_produk']; ?>" >
        </div>
        <div class="form-group">
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" value="<?php echo $pemesanan['jumlah']; ?>">
        </div>
        <input type="submit" value="Konfirmasi Order">
    </form>
</div>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
