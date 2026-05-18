<?php
$host     = "localhost";   
$user     = "root";        // Username default MySQL (XAMPP)
$password = "";            // Password default MySQL (kosong pada XAMPP)
$database = "db_alumni";   // Nama database utama yang digunakan
// Membuat koneksi dari PHP ke database MySQL
$koneksi = mysqli_connect($host, $user, $password, $database);
// Validasi koneksi: Jika gagal, hentikan sistem dan tampilkan error
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>