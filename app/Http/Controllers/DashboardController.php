<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Models\Absen;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $cekSession;
    
    public function __construct(SessionController $sessionController)
    {
        $this->cekSession = $sessionController;
    }

    public function data_dashboard(){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            $dataUsername = $data['us2'];
            // $today = date("Y-m-d");
            $today = Carbon::now()->format("Y-m-d");
            $dataAbsen = Absen::where('userlog','=',$dataUsername->username)
            ->whereDate('tgl_clock_in','=',$today)
            ->get();

            $cekAbsen = Absen::where('userlog','=',$dataUsername->username)
            ->whereDate('tgl_clock_in','=',$today)
            ->count();
            return view('pages.dashboard',[
                'dataAbsen' => $dataAbsen,
                'cekAbsen' => $cekAbsen,
            ]);
        }else{
            return view('pages.login');
        }
    }

    public function get_data_dashboard(){
        $data = $this->cekSession->cek_session();
        $dataUsername = $data['us2'];
        if(isset($data['us1']) > 0){
            $dataUser = User::where('username','=',$dataUsername->username)->first();
            return response()->json([
                'dataUser' => $dataUser,
            ]);
        }else{
            return false;
        }
    }

    public function cek_map(){
        $data = $this->cekSession->cek_session();
        $dataUsername = $data['us2'];
        if(isset($data['us1']) > 0){
            $dataUser = User::where('username','=',$dataUsername->username)->first();

            $cekLokasi = User::select('siswa.nama','siswa.username','siswa.lokasi','lokasi.latitude','lokasi.longitude','lokasi.radius','lokasi.nama as nama_lokasi')
            ->join('lokasi','lokasi.nama','=','siswa.lokasi')
            ->where('siswa.username','=',$dataUsername->username)
            ->first();
            return response()->json([
                'dataUser' => $dataUser,
                'cekLokasi' => $cekLokasi,
            ]);
        }else{
            return false;
        }
    }
}
