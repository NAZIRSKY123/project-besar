<?php
// Koneksi ke database
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'db_warung1';

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Handle search query
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

// Query untuk menampilkan semua produk dengan filter pencarian
$query = "SELECT * FROM Produk WHERE nama_produk LIKE '%$search%'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/background.jpg'); /* Path ke gambar latar belakang */
            background-size: cover; /* Menutupi seluruh latar belakang */
            background-position: center; /* Memusatkan gambar */
            background-repeat: no-repeat; /* Tidak mengulangi gambar */
            color: #333; /* Warna teks default */
        }
        header {
            background-color: rgba(76, 175, 80, 0.8); /* Warna hijau transparan */
            color: white;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Bayangan halus */
        }
        nav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #45a049; /* Warna hijau lebih gelap saat hover */
        }
        h1 {
            text-align: center;
            margin-top: 20px;
        }
        .search-container {
            margin: 15px auto;
            display: flex;
            justify-content: center;
        }
        .search-container input[type="text"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            width: 300px;
        }
        .search-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background-color: #28a745; /* Warna hijau */
            color: white;
            cursor: pointer;
            margin-left: 5px;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #218838; /* Warna hijau lebih gelap saat hover */
        }
        .btn-add-gradient {
            display: inline-block;
            background: linear-gradient(90deg, #4CAF50, #28a745);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
            margin: 20px auto;
            text-align: center;
        }
        .btn-add-gradient:hover {
            background: linear-gradient(90deg, #45a049, #218838);
            transform: scale(1.05);
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            background-color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e2e2e2;
        }
        .btn-order, .button {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            font-size: 14px;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-order {
            background-color: #28a745;
        }
        .btn-order:hover {
            background-color: #218838;
        }
        .button {
            background-color: #007BFF;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .button.delete {
            background-color: #dc3545;
        }
        .button.delete:hover {
            background-color: #c82333;
        }
        footer {
            background-color: rgba(76, 175, 80, 0.8); /* Warna hijau transparan */
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Warung Online</h1>
        <nav>
            <a href="index.php">Produk</a>
            <a href="../pemesanan/index_pemesanan.php">Pemesanan</a>
        </nav>
        <div class="search-container">
            <form method="POST" action="">
                <input type="text" name="search" placeholder="Cari Produk..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">Cari</button>
            </form>
        </div>
    </header>

    <h1>Daftar Produk</h1>
    <a href="tambah_produk.php" class="btn-add-gradient">Tambah Produk</a>

    <table>
        <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Aksi</th>
        </tr>
        
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                <td><?php echo htmlspecialchars($row['kategori']); ?></td>
                <td><?php echo number_format($row['harga'], 2, ',', '.'); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="form_order.php?id_produk=<?= $row['id_produk'] ?>&nama_produk=<?= urlencode($row['nama_produk']) ?>&harga=<?= $row['harga'] ?>&stok=<?= $row['stok'] ?>" class="btn-order">Order</a>
                    <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="button">Edit</a>
                    <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" class="button delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Warung Online. Hak Cipta Ahmad Munazir</p>
        <p><a href="https://github.com/NAZIRSKY123" target="_blank" style="color: white; text-decoration: underline;">Lihat di GitHub</a></p>
    </footer>

    <?php mysqli_close($conn); // Menutup koneksi ?>
</body>
</html>
