<?php
$dbname='laporankinerja';
$host='localhost';
$password='';
$username='root';
//Koneksi Ke MySQL
$cnn = mysqli_connect($host,$username,$password,$dbname);
//Membuat Koneksi
if(!$cnn){
	die("Koneksi Failed : ".mysqli_connect_error()); }
//Membuat Tabel
$sql ="CREATE TABLE data (
	Nama VARCHAR(50) NULL,
    Jurusan VARCHAR (30) Null,
	Divisi VARCHAR(35) Null,
    Role VARCHAR (15) Null,
	Status VARCHAR(15) Null,
	 constraint pk_pengurus primary key(Nama)
)";
if (mysqli_query($cnn, $sql)){
	echo "Table Berhasil di Buat";
	} else {
	echo "Table Gagal di Buat :".mysqli_error($cnn); }
	mysqli_close($cnn);
?>