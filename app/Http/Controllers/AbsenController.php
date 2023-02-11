<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Models\Absen;
use Carbon\Carbon;

class AbsenController extends Controller
{
    private $cekSession;
    
    public function __construct(SessionController $sessionController)
    {
        $this->cekSession = $sessionController;
    }

    public function riwayat_absensi(){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            $dataUsername = $data['us2'];
            $today = Carbon::now()->format("Y-m-d");
            $monthNow = Carbon::now()->format("m");
            $dataAbsen = Absen::where('userlog','=',$dataUsername->username)
            ->where('clock_in','=','YES')
            ->whereMonth('tgl_clock_in','=',$monthNow)
            ->orderBy('tgl_clock_in','DESC')
            ->get();

            return view('pages.riwayat-absensi',[
                'dataAbsen' => $dataAbsen
            ]);
        }else{
            return view('pages.login');
        }
    }
}
