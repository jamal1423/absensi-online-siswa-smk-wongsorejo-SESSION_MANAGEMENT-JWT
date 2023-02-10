<?php
date_default_timezone_set('Asia/Jakarta');

$base_url = "https://".$_SERVER['SERVER_NAME']."/smkn1wongsorejo/";
$url_default = "https://".$_SERVER['SERVER_NAME']."/smkn1wongsorejo/adminpanel/";

debug_backtrace() || die (header("Location: {$base_url}error/401"));

$API_google = "AIzaSyAistE5xXU9MzuGP7TTBwqnEiZI3JLjO9A";

$sesi_login = "log";
$sesi_usr = "users";
$sesi_usr_nm = "nama_lengkap";
$sesi_kelas = "kelas";
$sesi_nis = "nis";
$sesi_token = "token";
$sesi_general = "_alt";
?>