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

// Query untuk menampilkan semua produk
$result = mysqli_query($conn, "SELECT * FROM Produk");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        nav {
            margin: 10px 0;
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
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        footer {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: relative;
            bottom: 0;
            width: 100%;
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
</header>

<h2>Daftar Produk</h2>
<a href="tambah_produk.php">Tambah Produk</a>

<?php if (mysqli_num_rows($result) > 0): ?>
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
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo $row['kategori']; ?></td>
                <td><?php echo number_format($row['harga'], 2, ',', '.'); ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>">Edit</a> | 
                    <a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Tidak ada produk.</p>
<?php endif; ?>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Warung Online. All Rights Reserved.</p>
    <p><a href="https://github.com/username/repository" target="_blank" style="color: white; text-decoration: underline;">Lihat di GitHub</a></p>
</footer>

<?php
mysqli_close($conn); // Menutup koneksi
?>
