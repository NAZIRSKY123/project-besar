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

// Query untuk menampilkan semua pemesanan
$result = mysqli_query($conn, "
    SELECT p.id_pemesanan, p.nama_pelanggan, pr.nama_produk, p.tanggal_pemesanan, p.jumlah, p.status
    FROM Pemesanan p
    JOIN Produk pr ON p.id_produk = pr.id_produk
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pemesanan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
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
        .button-add, .button-edit, .button-delete, .button-order {
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .button-add {
            background-color: #28a745;
        }
        .button-add:hover {
            background-color: #218838;
        }
        .button-edit {
            background-color: #ffc107;
        }
        .button-edit:hover {
            background-color: #e0a800;
        }
        .button-delete {
            background-color: #dc3545;
        }
        .button-delete:hover {
            background-color: #c82333;
        }
        .button-order {
            background-color: #007bff;
        }
        .button-order:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<header>
    <h1>Warung Online</h1>
    <nav>
        <a href="../produk/index.php">Produk</a>
        <a href="index_pemesanan.php">Pemesanan</a>
    </nav>
</header>

<h2>Daftar Pemesanan</h2>
<a href="tambah_pemesanan.php" class="button-add">Tambah Pemesanan</a>

<?php if (mysqli_num_rows($result) > 0): ?>
    <table>
        <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Produk</th>
            <th>Tanggal Pemesanan</th>
            <th>Jumlah</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php
        $no = 1;
        while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $no++; ?></td>
                <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                <td><?php echo htmlspecialchars($row['nama_produk']); ?></td>
                <td><?php echo htmlspecialchars($row['tanggal_pemesanan']); ?></td>
                <td><?php echo htmlspecialchars($row['jumlah']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <a href="order.php?id=<?php echo $row['id_pemesanan']; ?>" class="button-order">Order</a>
                    <a href="edit_pemesanan.php?id=<?php echo $row['id_pemesanan']; ?>" class="button-edit">Edit</a>
                    <a href="hapus_pemesanan.php?id=<?php echo $row['id_pemesanan']; ?>" class="button-delete" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Tidak ada pemesanan.</p>
<?php endif; ?>

<footer>
    <p>&copy; <?php echo date("Y"); ?> Warung Online. All Rights Reserved.</p>
    <p><a href="https://github.com/username/repository" target="_blank" style="color: white; text-decoration: underline;">Lihat di GitHub</a></p>
</footer>

<?php
mysqli_close($conn); // Menutup koneksi
?>
