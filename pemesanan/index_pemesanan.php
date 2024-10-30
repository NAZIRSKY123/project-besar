<?php
// Koneksi ke database
$host = 'localhost';
$pengguna = 'root'; // Ganti jika username Anda berbeda
$pass = ''; // Ganti jika password Anda berbeda
$dbname = 'db_warung1';

$conn = mysqli_connect($host, $pengguna, $pass, $dbname);
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Handle search query
$search = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';

$query = "
    SELECT p.id_pemesanan, p.nama_pelanggan, pr.nama_produk, p.tanggal_pemesanan, p.jumlah, p.status
    FROM Pemesanan p
    JOIN Produk pr ON p.id_produk = pr.id_produk
    WHERE p.nama_pelanggan LIKE '%$search%' OR pr.nama_produk LIKE '%$search%'
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query gagal: " . mysqli_error($conn));
}
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin: 0;
            font-size: 28px;
        }
        nav {
            margin-top: 10px;
        }
        nav a {
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            margin: 0 5px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        nav a:hover {
            background-color: #0056b3;
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
            background-color: #17a2b8;
            color: white;
            cursor: pointer;
            margin-left: 5px;
            transition: background-color 0.3s;
        }
        .search-container button:hover {
            background-color: #138496;
        }
        h2 {
            text-align: center;
            margin-top: 20px;
        }
        .button-add {
            display: inline-block;
            background-color: #007bff; /* Same blue as table header */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            margin: 20px auto;
            text-align: center;
            transition: background-color 0.3s;
        }
        .button-add:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        table {
            width: 95%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e6f7ff;
        }
        .button-edit, .button-delete, .button-order {
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
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
        footer {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 20px;
        }
        .footer-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .footer-links {
            margin-top: 10px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }
        .footer-links a {
            color: white;
            text-decoration: none;
            padding: 0 15px;
            transition: color 0.3s;
        }
        .footer-links a:hover {
            text-decoration: underline;
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
    <div class="search-container">
        <form method="POST" action="">
            <input type="text" name="search" placeholder="Cari Pemesanan..." value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>
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
    <p style="text-align: center;">Tidak ada pemesanan.</p>
<?php endif; ?>

<footer>
    <div class="footer-content">
        <p>&copy; <?php echo date("Y"); ?> Warung Online. Hak Cipta Ahmad Munazir</p>
        <div class="footer-links">
            <a href="https://github.com/NAZIRSKY123" target="_blank">Lihat di GitHub</a>
        </div>
    </div>
</footer>

<?php
mysqli_close($conn); // Menutup koneksi
?>
