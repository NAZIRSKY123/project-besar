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

// Cek apakah id produk ada di URL
if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];

    // Ambil data produk berdasarkan id
    $query = "SELECT * FROM Produk WHERE id_produk = $id_produk";
    $result = mysqli_query($conn, $query);
    $produk = mysqli_fetch_assoc($result);

    // Proses saat form disubmit
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_produk = $_POST['nama_produk'];
        $kategori = $_POST['kategori'];
        $harga = $_POST['harga'];
        $stok = $_POST['stok'];

        // Query untuk memperbarui data produk
        $update_query = "UPDATE Produk SET nama_produk = '$nama_produk', kategori = '$kategori', harga = '$harga', stok = '$stok' WHERE id_produk = $id_produk";

        if (mysqli_query($conn, $update_query)) {
            echo "Produk berhasil diperbarui.";
            header("Location: index.php"); // Redirect ke halaman daftar produk
            exit();
        } else {
            echo "Error: " . $update_query . "<br>" . mysqli_error($conn);
        }
    }
} else {
    echo "ID produk tidak ditemukan.";
    exit();
}

mysqli_close($conn); // Menutup koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            width: 300px;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], input[type="decimal"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<h2>Edit Produk</h2>
<form method="POST" action="">
    <label for="nama_produk">Nama Produk:</label>
    <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $produk['nama_produk']; ?>" required>

    <label for="kategori">Kategori:</label>
    <input type="text" id="kategori" name="kategori" value="<?php echo $produk['kategori']; ?>" required>

    <label for="harga">Harga:</label>
    <input type="number" id="harga" name="harga" step="0.01" value="<?php echo $produk['harga']; ?>" required>

    <label for="stok">Stok:</label>
    <input type="number" id="stok" name="stok" value="<?php echo $produk['stok']; ?>" required>

    <input type="submit" value="Perbarui">
</form>

</body>
</html>
