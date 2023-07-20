<?php
session_start(); // Mulai sesi
include_once("config.php");

if (!isset($_SESSION['id_mahasiswa'])) {
    // Redirect ke halaman login jika tidak ada sesi
    header("Location: login.php");
    exit();
}

$id_mahasiswa = $_SESSION['id_mahasiswa'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['praktikum']) && !empty($_POST['praktikum'])) {
        $id_praktikum = $_POST['praktikum'];

        // Hapus data praktikum yang diikuti oleh mahasiswa
        $sql = "DELETE FROM praktikum_mahasiswa WHERE id_mahasiswa = '$id_mahasiswa' AND id_praktikum = '$id_praktikum'";
        mysqli_query($mysqli, $sql);

        // Set pesan sukses ke dalam flash session
        $_SESSION['success_message'] = "Praktikum berhasil dihapus.";

        // Redirect kembali ke halaman index.php
        header("Location: index.php");
        exit();
    } else {
        // Jika tidak ada praktikum yang dipilih, redirect kembali ke halaman index.php
        header("Location: index.php");
        exit();
    }
} else {
    // Jika akses langsung ke halaman ini tanpa melalui POST request, redirect kembali ke halaman index.php
    header("Location: index.php");
    exit();
}
