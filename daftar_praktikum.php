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

// Ambil data mahasiswa
$data_mahasiswa = mysqli_query($mysqli, "SELECT * FROM mahasiswa WHERE id_mahasiswa = '$id_mahasiswa'");
$mahasiswa = mysqli_fetch_assoc($data_mahasiswa);

// Ambil data praktikum yang belum diikuti oleh mahasiswa
$data_praktikum = mysqli_query($mysqli, "SELECT * FROM praktikum WHERE id_praktikum NOT IN (SELECT id_praktikum FROM praktikum_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa')");
?>
<!DOCTYPE html>
<html>

<head>
    <title>Daftar Mahasiswa dan Pilihan Praktikum</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1>Daftar Mahasiswa</h1>
    <table>
        <tr>
            <th>Nama</th>
            <td><?php echo $mahasiswa['nama_mahasiswa'] ?></td>
        </tr>
        <tr>
            <th>NIM</th>
            <td><?php echo $mahasiswa['nim'] ?></td>
        </tr>
    </table>

    <h2>Pilih Praktikum</h2>
    <?php if (mysqli_num_rows($data_praktikum) > 0) { ?>
        <form action="process_daftar.php" method="POST">
            <?php
            while ($praktikum = mysqli_fetch_array($data_praktikum)) {
                echo "<div class='list_praktikum'>";
                echo "<input type='checkbox' id='" . $praktikum['id_praktikum'] . "' name='praktikum[]' value='" . $praktikum['id_praktikum'] . "'>";
                echo "<label for='" . $praktikum['id_praktikum'] . "'>" . $praktikum['nama_praktikum'] . "</label>";
                echo "<br>";
                echo "</div>";
            }
            ?>
            <input type="submit" value="DAFTAR">
        </form>
    <?php } else { ?>
        <p>Tidak ada praktikum yang bisa diikuti.</p>
        <div class="back">
            <a href="index.php">Kembali ke Beranda</a>
        </div>
    <?php } ?>
</body>

</html>
