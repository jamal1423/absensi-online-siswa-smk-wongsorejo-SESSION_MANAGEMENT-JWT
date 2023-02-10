<?php

class Session
{
    public function __construct($username,$nama,$kelas,$nis,$lokasi)
    {
        $this->username = $username;
        $this->nama = $nama;
        $this->kelas = $kelas;
        $this->nis = $nis;
        $this->lokasi = $lokasi;
    }
}

class SessionManager
{

    public static string $SECRET_KEY = "fjnljaicnuwe8nuwvo8nfulvieufksvfukenkfnelvnuf";
    public static function login(string $username, string $password):bool
    {
        date_default_timezone_set("Asia/Jakarta");
        $issuedAt = time();
        // $expire = $issuedAt + 120; //2 menit
        // $expire = $issuedAt + 54000; //1.5 jam
        $expire = $issuedAt + 28800; //8 jam
        $token= md5(openssl_random_pseudo_bytes(32));
        
        $koneksi = mysqli_connect("localhost","root","","db_absensi");

        $sql = mysqli_query($koneksi,"SELECT * FROM tbl_siswa where username='$username'");
        $row = mysqli_fetch_array($sql);
        $uSiswa = $row['username'];
        $uNama = $row['nama'];
        $pSiswa = $row['password'];
        $kSiswa = $row['kelas'];
        $nSiswa = $row['nis'];
        $nLokasi = $row['lokasi'];

        //"csrf_token" => $token,

        if ($username == $uSiswa && md5($password) == $pSiswa) {
            $payload = [
                "username" => $uSiswa,
                "nama" => $uNama,
                "kelas" => $kSiswa,
                "nis" => $nSiswa,
                "lokasi" => $nLokasi,
                "iat" => $issuedAt,
                "exp" => $expire
            ];

            $jwt = \Firebase\JWT\JWT::encode($payload, SessionManager::$SECRET_KEY, 'HS256');
            setcookie("X-INOT-SESSION", $jwt);

            return true;
        } else {
            return false;
        }
    }

    public static function getCurrentSession(): Session
    {
        if($_COOKIE['X-INOT-SESSION']){
            $jwt = $_COOKIE['X-INOT-SESSION'];
            try {
                $payload = \Firebase\JWT\JWT::decode($jwt, SessionManager::$SECRET_KEY, ['HS256']);
                return new Session($payload->username,$payload->nama,$payload->kelas,$payload->nis,$payload->lokasi);
            }
            catch (Exception $exception){
                throw new Exception("User is not login");
            }
        }else{
            throw new Exception("User is not login");
        }
    }
}
