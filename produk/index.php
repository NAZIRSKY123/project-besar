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
            background-color: rgba(255, 182, 193, 0.8); /* Warna pink transparan */
            color: black;
            padding: 15px 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2); /* Bayangan halus */
        }
        nav a {
            color: black;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #ff69b4; /* Pink lebih gelap saat hover */
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
            background-color: #ff69b4; /* Pink */
            color: black;
            cursor: pointer;
            margin-left: 5px;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #ff1493; /* Pink lebih gelap saat hover */
        }
        .btn-add-gradient {
            display: inline-block;
            background: linear-gradient(90deg, #ff69b4, #ff1493);
            color: black;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background 0.3s ease, transform 0.2s ease;
            margin: 20px auto;
            text-align: center;
        }
        .btn-add-gradient:hover {
            background: linear-gradient(90deg, #ff1493, #db5e81);
            transform: scale(1.05);
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Soft shadow */
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd; /* Subtle border for cells */
        }
        th {
            background-color: #ff69b4; /* Header background color */
            color: black;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9; /* Light background for even rows */
        }
        tr:hover {
            background-color: #ffe4e1; /* Highlight row on hover */
        }
        .btn-order, .button {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            font-size: 14px;
            color: white;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-order {
            background-color: #ff69b4; /* Pink for order button */
        }
        .btn-order:hover {
            background-color: #ff1493; /* Darker pink on hover */
        }
        .button {
            background-color: #db5e81; /* Darker pink for edit button */
        }
        .button:hover {
            background-color: #c15a77; /* Darker on hover */
        }
        .button.delete {
            background-color: #dc3545; /* Red for delete button */
        }
        .button.delete:hover {
            background-color: #c82333; /* Darker red on hover */
        }
        footer {
            background-color: rgba(255, 182, 193, 0.8); /* Warna pink transparan */
            color: black;
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
    <a href="../pemesanan/index_pemesanan.php" class="btn-add-gradient">Kembali ke Pemesanan</a> <!-- Kembali button added -->

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
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
        </tbody>
    </table>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Warung Online. Hak Cipta Ahmad Munazir</p>
        <p><a href="https://github.com/NAZIRSKY123" target="_blank" style="color: black; text-decoration: underline;">Lihat di GitHub</a></p>
    </footer>

    <?php mysqli_close($conn); // Menutup koneksi ?>
</body>
</html>
