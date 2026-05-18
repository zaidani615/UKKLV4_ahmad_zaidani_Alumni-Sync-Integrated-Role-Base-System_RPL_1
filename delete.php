<?php
include 'koneksi.php'; 
$id = mysqli_real_escape_string($koneksi, $_GET['id']);
mysqli_query($koneksi, "DELETE FROM alumni WHERE id_alumni='$id'");
header("Location: dashboard_admin.php");
exit; 
?>