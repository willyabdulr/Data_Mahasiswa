<?php
require_once 'config/database.php';

$database = new Database();
$db = $database->getConnection();

// Data dummy users
$users = [
    ['username' => 'admin', 'password' => password_hash('admin123', PASSWORD_BCRYPT), 'role' => 'admin'],
    ['username' => 'petugas1', 'password' => password_hash('petugas123', PASSWORD_BCRYPT), 'role' => 'petugas'],
    ['username' => 'petugas2', 'password' => password_hash('petugas123', PASSWORD_BCRYPT), 'role' => 'petugas'],
    ['username' => 'mhs1', 'password' => password_hash('mahasiswa123', PASSWORD_BCRYPT), 'role' => 'mahasiswa'],
    ['username' => 'mhs2', 'password' => password_hash('mahasiswa123', PASSWORD_BCRYPT), 'role' => 'mahasiswa'],
    ['username' => 'mhs3', 'password' => password_hash('mahasiswa123', PASSWORD_BCRYPT), 'role' => 'mahasiswa']
];

// Insert users
$user_ids = [];
foreach ($users as $user) {
    $stmt = $db->prepare("INSERT INTO users (username, password, role) VALUES (:username, :password, :role)");
    $stmt->execute($user);
    $user_ids[] = $db->lastInsertId();
}

// Data dummy admin
$stmt = $db->prepare("INSERT INTO admin (user_id, nama) VALUES (:user_id, :nama)");
$stmt->execute(['user_id' => $user_ids[0], 'nama' => 'Admin Utama']);

// Data dummy petugas
$petugas = [
    ['user_id' => $user_ids[1], 'nip' => '198001012000121001', 'nama' => 'Petugas Satu', 'jabatan' => 'Staff TU'],
    ['user_id' => $user_ids[2], 'nip' => '198102022000121002', 'nama' => 'Petugas Dua', 'jabatan' => 'Staff TU']
];

foreach ($petugas as $p) {
    $stmt = $db->prepare("INSERT INTO petugas (user_id, nip, nama, jabatan) VALUES (:user_id, :nip, :nama, :jabatan)");
    $stmt->execute($p);
}

// Data dummy mahasiswa
$mahasiswa = [
    ['user_id' => $user_ids[3], 'nim' => '200001', 'nama' => 'Mahasiswa Satu', 'jurusan' => 'Teknik Informatika', 'semester' => 5],
    ['user_id' => $user_ids[4], 'nim' => '200002', 'nama' => 'Mahasiswa Dua', 'jurusan' => 'Sistem Informasi', 'semester' => 5],
    ['user_id' => $user_ids[5], 'nim' => '200003', 'nama' => 'Mahasiswa Tiga', 'jurusan' => 'Teknik Komputer', 'semester' => 3]
];

foreach ($mahasiswa as $m) {
    $stmt = $db->prepare("INSERT INTO mahasiswa (user_id, nim, nama, jurusan, semester) VALUES (:user_id, :nim, :nama, :jurusan, :semester)");
    $stmt->execute($m);
}

// Data dummy dosen
$dosen = [
    ['nip' => '197501011987021001', 'nama' => 'Prof. Dr. Dosen Satu', 'jurusan' => 'Teknik Informatika'],
    ['nip' => '197602021987021002', 'nama' => 'Dr. Dosen Dua', 'jurusan' => 'Sistem Informasi'],
    ['nip' => '197803031987021003', 'nama' => 'Dosen Tiga, M.Kom', 'jurusan' => 'Teknik Komputer']
];

foreach ($dosen as $d) {
    $stmt = $db->prepare("INSERT INTO dosen (nip, nama, jurusan) VALUES (:nip, :nama, :jurusan)");
    $stmt->execute($d);
}

// Data dummy mata kuliah
$matkul = [
    ['kode_matkul' => 'IF101', 'nama_matkul' => 'Pemrograman Dasar', 'sks' => 3, 'semester' => 1],
    ['kode_matkul' => 'IF102', 'nama_matkul' => 'Algoritma dan Struktur Data', 'sks' => 4, 'semester' => 2],
    ['kode_matkul' => 'IF201', 'nama_matkul' => 'Basis Data', 'sks' => 3, 'semester' => 3],
    ['kode_matkul' => 'IF202', 'nama_matkul' => 'Pemrograman Web', 'sks' => 3, 'semester' => 4],
    ['kode_matkul' => 'IF301', 'nama_matkul' => 'Kecerdasan Buatan', 'sks' => 3, 'semester' => 5]
];

foreach ($matkul as $mk) {
    $stmt = $db->prepare("INSERT INTO mata_kuliah (kode_matkul, nama_matkul, sks, semester) VALUES (:kode_matkul, :nama_matkul, :sks, :semester)");
    $stmt->execute($mk);
}

// Data dummy absensi
$absensi = [
    ['mahasiswa_id' => 1, 'matkul_id' => 3, 'dosen_id' => 1, 'tanggal' => '2023-11-01', 'status' => 'hadir', 'keterangan' => 'Hadir tepat waktu', 'petugas_id' => 1],
    ['mahasiswa_id' => 2, 'matkul_id' => 3, 'dosen_id' => 1, 'tanggal' => '2023-11-01', 'status' => 'hadir', 'keterangan' => 'Hadir tepat waktu', 'petugas_id' => 1],
    ['mahasiswa_id' => 1, 'matkul_id' => 5, 'dosen_id' => 2, 'tanggal' => '2023-11-02', 'status' => 'izin', 'keterangan' => 'Ijin sakit', 'petugas_id' => 2],
    ['mahasiswa_id' => 3, 'matkul_id' => 2, 'dosen_id' => 3, 'tanggal' => '2023-11-03', 'status' => 'hadir', 'keterangan' => 'Hadir tepat waktu', 'petugas_id' => 1]
];

foreach ($absensi as $a) {
    $stmt = $db->prepare("INSERT INTO absensi (mahasiswa_id, matkul_id, dosen_id, tanggal, status, keterangan, petugas_id) VALUES (:mahasiswa_id, :matkul_id, :dosen_id, :tanggal, :status, :keterangan, :petugas_id)");
    $stmt->execute($a);
}

echo "Data dummy berhasil ditambahkan!\n";
?>