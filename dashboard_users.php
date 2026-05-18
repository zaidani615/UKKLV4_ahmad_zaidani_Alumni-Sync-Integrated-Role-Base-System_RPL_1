<?php
session_start();
include 'koneksi.php'; 
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit; 
}
$username_sekarang = $_SESSION['username'];
$nama_user         = $_SESSION['username']; 

if ($username_sekarang == 'superuser') {
    $data = mysqli_query($koneksi, "SELECT * FROM alumni ORDER BY nama ASC");
    $judul_kartu = "Semua Data Alumni";
} else {
    $data = mysqli_query($koneksi, "SELECT * FROM alumni WHERE nama = '$username_sekarang'");
    $judul_kartu = "Data Alumni Saya";
}

$total_alumni = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Data Alumni - User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="./style/dashboard.css"> 
</head>
<body>

<div class="main-wrapper">
    <header>
        <div class="nav-container">
            <div class="nav-left">
                <div class="role-badge">USER</div>
                <div class="school-name">TELKOM SCHOOL</div>
            </div>
            <div class="nav-center">
                <h2>MANAJEMEN DATA ALUMNI</h2>
            </div>
            <div class="nav-right">
                <div class="user-info">
                    <span>Selamat Datang,</span>
                    <strong><?= htmlspecialchars($nama_user) ?></strong>
                </div>
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div>
                    <h3><?= htmlspecialchars($judul_kartu); ?></h3>
                    <p>Jumlah Data: <strong><?= $total_alumni; ?></strong></p>
                </div>
            </div>

            <div class="table-responsive">
                <?php
                $no = 1;
                
                if (mysqli_num_rows($data) > 0) {
                    $data_array = [];
                    while ($d = mysqli_fetch_array($data)) {
                        $data_array[] = $d; 
                    }

                    if ($username_sekarang != 'superuser' && count($data_array) == 1) {
                        $user_data = $data_array[0]; 
                ?>
                        <div class="profile-card-highlight">
                            <div class="card-content-full"> 
                                <div class="avatar-large">
                                    <?= strtoupper(substr($user_data['nama'], 0, 1)) ?>
                                </div>

                                <div class="detail-info">
                                    <div class="profile-header-flex">
                                        <h4><i class="fas fa-id-card"></i> Informasi Profil Lengkap</h4>
                                        <a href="edit_profil.php" class="btn-edit-user">
                                            <i class="fas fa-edit"></i> Edit Profil
                                        </a>
                                    </div>

                                    <hr class="line-separator">

                                    <div class="grid-profile-layout">
                                        <div class="info-group">
                                            <strong><i class="fab fa-whatsapp"></i> NOMOR WHATSAPP:</strong>
                                            <p>
                                                <?php if (!empty($user_data['telepon'])): ?>
                                                    <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $user_data['telepon']) ?>" target="_blank" class="wa-link">
                                                        <?= htmlspecialchars($user_data['telepon']) ?>
                                                    </a>
                                                <?php else: ?> - <?php endif; ?>
                                            </p>
                                        </div>

                                        <div class="info-group">
                                            <strong><i class="fas fa-briefcase"></i> STATUS & INSTANSI:</strong>
                                            <p><?= !empty($user_data['status_alumni']) ? htmlspecialchars($user_data['status_alumni']) : '-' ?></p>
                                            <small><?= !empty($user_data['tempat_kerja']) ? htmlspecialchars($user_data['tempat_kerja']) : '-' ?></small>
                                        </div>

                                        <div class="info-group">
                                            <strong><i class="fas fa-envelope"></i> ALAMAT EMAIL:</strong>
                                            <p><?= !empty($user_data['email']) ? htmlspecialchars($user_data['email']) : '-' ?></p>
                                        </div>

                                        <div class="info-group">
                                            <strong><i class="fas fa-map-marker-alt"></i> ALAMAT DOMISILI:</strong>
                                            <p><?= !empty($user_data['alamat']) ? htmlspecialchars($user_data['alamat']) : '-' ?></p>
                                        </div>

                                        <div class="info-group">
                                            <strong><i class="fab fa-instagram"></i> INSTAGRAM:</strong>
                                            <p>
                                                <?php if (!empty($user_data['instagram'])): ?>
                                                    <?= '@' . htmlspecialchars(ltrim($user_data['instagram'], '@')) ?>
                                                <?php else: ?> - <?php endif; ?>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="footer-note">
                                        *Data ini digunakan untuk kepentingan pendataan alumni sekolah*
                                    </div>
                                </div> </div> </div> <?php 
                    } else { 
                ?>
                        <table>
                            <thead>
                                <tr>
                                    <th width="50">No</th> 
                                    <th>Nama</th> 
                                    <th>Angkatan</th> 
                                    <th>Jurusan</th> 
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_array as $row): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td> 
                                    <td>
                                        <div class="name-column">
                                            <div class="avatar">
                                                <?= strtoupper(substr($row['nama'], 0, 1)) ?>
                                            </div>
                                            <span><?= htmlspecialchars($row['nama']) ?></span>
                                        </div>
                                    </td> 
                                    <td class="text-center"><?= htmlspecialchars($row['angkatan']) ?></td> 
                                    <td><?= htmlspecialchars($row['jurusan']) ?></td> 
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                <?php 
                    } 
                } else { 
                ?>
                    <p style="text-align:center; padding:20px;">Data tidak ditemukan di sistem.</p>
                <?php } ?>
            </div> </div> </div> <footer>
        &copy; <?= date('Y') ?> Ahmad Zaidani - All Rights Reserved
    </footer>
</div> </body>
</html>