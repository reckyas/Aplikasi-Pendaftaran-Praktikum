<?php
session_start(); // Mulai sesi
include_once("config.php");

// Periksa apakah ada sesi yang aktif
if (!isset($_SESSION['id_mahasiswa'])) {
    // Redirect ke halaman login jika tidak ada sesi
    header("Location: login.php");
    exit();
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

// Periksa apakah ada pesan sukses dalam flash session
if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Hapus pesan sukses dari flash session setelah ditampilkan
}

// Query untuk mendapatkan data mahasiswa yang login
$queryMahasiswa = "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'";
$resultMahasiswa = mysqli_query($mysqli, $queryMahasiswa);
$mahasiswa = mysqli_fetch_assoc($resultMahasiswa);

// Query untuk mendapatkan data praktikum yang diikuti oleh mahasiswa
$queryPraktikum = "SELECT p.id_praktikum, p.nama_praktikum FROM praktikum p
                   INNER JOIN praktikum_mahasiswa pm ON p.id_praktikum = pm.id_praktikum
                   WHERE pm.id_mahasiswa = '$id_mahasiswa'";
$resultPraktikum = mysqli_query($mysqli, $queryPraktikum);
$praktikumArray = [];
while ($row = mysqli_fetch_assoc($resultPraktikum)) {
    $praktikumArray[] = $row;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Data Mahasiswa dan Praktikum</title>
    <link rel="stylesheet" href="home.css">
</head>

<body>
    <div class="container">
        <div class="menu">
            <h3>Menu</h3>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href="daftar_praktikum.php">Daftar Praktikum</a></li>
                <li>
                    <form action="logout.php">
                        <input type="submit" value="Keluar">
                    </form>
                </li>
            </ul>
        </div>
        <div class="content">
            <?php if (isset($successMessage)) { ?>
                <div class="flash-message">
                    <?php echo $successMessage; ?>
                </div>
            <?php } ?>

            <h1>Data Mahasiswa</h1>
            <table>
                <tr>
                    <th>Nama</th>
                    <td><?php echo $mahasiswa['nama_mahasiswa']; ?></td>
                </tr>
                <tr>
                    <th>NIM</th>
                    <td><?php echo $mahasiswa['nim']; ?></td>
                </tr>
            </table>

            <h2>Praktikum yang di ikuti</h2>
            <?php if (!empty($praktikumArray)) { ?>
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Praktikum</th>
                        <th>Aksi</th>
                    </tr>
                    <?php $no_urut = 1; ?>
                    <?php foreach ($praktikumArray as $praktikum) { ?>
                        <tr>
                            <td><?php echo $no_urut++; ?></td>
                            <td><?php echo $praktikum['nama_praktikum']; ?></td>
                            <td>
                                <form action="hapus_praktikum.php" method="POST">
                                    <input type="hidden" name="praktikum" value="<?php echo $praktikum['id_praktikum']; ?>">
                                    <input type="submit" value="Hapus">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <p>Tidak ada praktikum yang bisa diikuti.</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>
