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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
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
    </style>
</head>
<body>

<h2>Daftar Pemesanan</h2>
<a href="tambah_pemesanan.php">Tambah Pemesanan</a>

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
                <td><?php echo $row['nama_pelanggan']; ?></td>
                <td><?php echo $row['nama_produk']; ?></td>
                <td><?php echo $row['tanggal_pemesanan']; ?></td>
                <td><?php echo $row['jumlah']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="edit_pemesanan.php?id=<?php echo $row['id_pemesanan']; ?>">Edit</a> | 
                    
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p>Tidak ada pemesanan.</p>
<?php endif; ?>

</body>
</html>

<?php
mysqli_close($conn); // Menutup koneksi
?>
