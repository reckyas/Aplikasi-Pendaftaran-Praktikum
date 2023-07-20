<?php
session_start(); // Mulai sesi
session_unset(); // Menghapus semua variabel sesi
session_destroy(); // Menghapus sesi

// Redirect ke halaman login atau halaman lain yang sesuai setelah logout
header("Location: login.php");
exit();
?>
