<?php
session_start(); // Mulai sesi
include_once("config.php");

if (!isset($_SESSION['nim'])) {
    // Redirect ke halaman login jika tidak ada sesi
    header("Location: login.php");
    exit();
}

if (isset($_POST['praktikum']) && !empty($_POST['praktikum'])) {
    $praktikumArray = $_POST['praktikum'];
    $idMahasiswa = $_SESSION['id_mahasiswa'];

    // Proses penyimpanan data pilihan praktikum oleh mahasiswa
    foreach ($praktikumArray as $praktikum) {
        // Simpan data pendaftaran praktikum ke dalam tabel praktikum_mahasiswa
        $sql = "INSERT INTO praktikum_mahasiswa (id_mahasiswa, id_praktikum) VALUES ('$idMahasiswa', '$praktikum')";
        mysqli_query($mysqli, $sql);
    }

    // Set flash session untuk pemberitahuan sukses daftar praktikum
    $_SESSION['success_message'] = "Pendaftaran praktikum berhasil!";
    
    // Alihkan pengguna ke halaman index.php
    header("Location: index.php");
    exit();
} else {
    // Jika tidak ada pilihan praktikum yang dipilih, tambahkan pesan error atau redirect ke halaman lain
    echo "Anda belum memilih praktikum. Silakan pilih minimal satu praktikum.";
}
?>
