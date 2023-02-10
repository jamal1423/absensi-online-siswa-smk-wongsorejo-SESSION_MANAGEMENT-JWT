<?php
error_reporting(0);

$koneksi = mysqli_connect("localhost","root","","db_absensi") or die(mysqli_error());;


if(mysqli_connect_errno())
{
	echo"Koneksi database gagal...!!".mysqli_connect_error();
}

include("library.php");
?>