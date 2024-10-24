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
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        .btn-order {
            background-color: #28a745;
            color: white;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        .btn-order:hover {
            background-color: #218838;
        }
    </style>
</head>
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
<header>
    <h1>Warung Online</h1>
    <nav>
        <a href="index.php">Produk</a>
        <a href="../pemesanan/index_pemesanan.php">Pemesanan</a>
    </nav>
</header>
<body>
    <h1>Daftar Produk</h1>
    <a href="tambah_produk.php" class="btn-add-gradient">Tambah Produk</a>

<style>
    .btn-add-gradient {
        background: linear-gradient(90deg, #4CAF50, #28a745); /* Gradien hijau */
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-add-gradient:hover {
        background: linear-gradient(90deg, #45a049, #218838); /* Gradien lebih gelap saat hover */
        transform: scale(1.05); /* Sedikit membesar saat hover */
    }

    /* Menghapus margin untuk tombol */
    .btn-add-gradient {
        margin: 0; /* Pastikan tidak ada jarak */
    }
</style>

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
                    <!-- Tombol Order mengarahkan ke form_order.php dengan parameter produk -->
                    <a href="form_order.php?id_produk=<?= $row['id_produk'] ?>&nama_produk=<?= $row['nama_produk'] ?>&harga=<?= $row['harga'] ?>&stok=<?= $row['stok'] ?>" class="btn-order">Order</a>
                    <style>
.button {
    display: inline-block;
    padding: 10px 15px;
    margin: 5px;
    font-size: 14px;
    color: white;
    background-color: #007BFF; /* Warna biru */
    border: none;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.button:hover {
    background-color: #0056b3; /* Warna biru lebih gelap saat hover */
}

.button.delete {
    background-color: #dc3545; /* Warna merah untuk hapus */
}

.button.delete:hover {
    background-color: #c82333; /* Warna merah lebih gelap saat hover */
}
</style>

<a href="edit_produk.php?id=<?php echo $row['id_produk']; ?>" class="button">Edit</a>
<a href="hapus_produk.php?id=<?php echo $row['id_produk']; ?>" class="button delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>

                </td>
                </td>
                
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<footer>
    <p>&copy; <?php echo date("Y"); ?> Warung Online. All Rights Reserved.</p>
    <p><a href="https://github.com/username/repository" target="_blank" style="color: white; text-decoration: underline;">Lihat di GitHub</a></p>
</footer>


<?php
mysqli_close($conn); // Menutup koneksi
?>
