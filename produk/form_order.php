<?php
// Ambil data dari URL
$id_produk = $_GET['id_produk'];
$nama_produk = $_GET['nama_produk'];
$harga = $_GET['harga'];
$stok = $_GET['stok'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .order-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .order-form {
            margin-top: 20px;
        }

        .order-form label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #495057;
        }

        .order-form input[type="text"],
        .order-form input[type="number"],
        .order-form input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .order-form input[type="text"]:focus,
        .order-form input[type="number"]:focus,
        .order-form input[type="date"]:focus {
            border-color: #28a745;
            outline: none;
        }

        .order-form button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .order-form button:hover {
            background-color: #218838;
        }

        .order-form button:active {
            background-color: #1e7e34;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
    </style>
</head>
<body>

<div class="order-container">
    <h2>Form Order Produk</h2>
    <form method="POST" action="proses_order.php" class="order-form">

        <!-- Nama Produk -->
        <label for="nama_produk">Nama Produk</label>
        <input type="text" id="nama_produk" name="nama_produk" value="<?= htmlspecialchars($nama_produk); ?>" readonly>

        <!-- Tanggal Pemesanan -->
        <label for="tanggal_pemesanan">Tanggal Pemesanan</label>
        <input type="date" id="tanggal_pemesanan" name="tanggal_pemesanan" required>

        <!-- Jumlah Produk -->
        <label for="jumlah">Jumlah</label>
        <input type="number" id="jumlah" name="jumlah" min="1" max="<?= $stok; ?>" required>

        <!-- Tombol Pesan -->
        <button type="submit">Pesan Sekarang</button>
    </form>
    <div class="footer">
        <p>&copy; <?php echo date("Y"); ?> Warung Online</p>
    </div>
</div>

</body>
</html>
