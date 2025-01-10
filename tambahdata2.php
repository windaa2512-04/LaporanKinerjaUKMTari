<?php
$cnn = mysqli_connect('localhost', 'root', '');

if (!$cnn) {
    echo "Koneksi Gagal";
    exit;
} 

echo "Koneksi Berhasil<br/>";
mysqli_select_db($cnn, "laporankinerja");

// Data pengurus dalam array
$informasipengurus = [
    ["Aisha Laksmitaputri N", "S1 Fisika", "Divisi Seni Tari Modern", "Ketua Bidang", "Aktif"],
    ["Salsa Anindiana Putri", "S1 Pendidikan Kimia", "Divisi Seni Tari", "Bendahara", "Aktif"],
    ["Winda Ardyani", "S1 Matematika", "Divisi Seni Tari Modern", "Staff 1", "Tidak Aktif"],
    ["Widigda Tri Pratiwi","S1 Pendidikan Matematika", "Divisi Seni Tari Modern", "Staff 2", " Tidak Aktif"],
    ["Retno Ayu Saraswati", "S1 Pendidikan Biologi", "Divisi Seni Tari Modern", "Staff 3", "Aktif"],
    ["Yasmine Putri Sakinah", "S1 Pendidikan Fisika", "Divisi Seni Tari", "Staff 4", "Tidak Aktif"]
];

// Iterasi untuk menyimpan setiap data mahasiswa
foreach ($informasipengurus as $data) {
    $Nama = $data[0];
    $Jurusan = $data[1];
    $Divisi = $data[2];
    $Role = $data[3];
    $Status = $data[4];

    $sql = "INSERT INTO data (Nama, Jurusan, Divisi, Role) VALUES ('$Nama', '$Jurusan', '$Divisi', '$Role', 'Status')";

    if (mysqli_query($cnn, $sql)) {
        echo "Data BERHASIL Disimpan: $Nama - $Jurusan - $Divisi - $Role - $Status<br/>";
    } else {
        echo "Data GAGAL Disimpan: $Nama - $Jurusan - $Divisi - $Role - $Status<br/>" . mysqli_error($cnn) . "<br/>";
    }
}
?>
