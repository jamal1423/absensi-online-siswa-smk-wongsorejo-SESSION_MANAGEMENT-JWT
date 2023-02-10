<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;
use App\Models\Absen;
use App\Models\Siswa;
use Carbon\Carbon;

class ScanController extends Controller
{
    private $cekSession;
    
    public function __construct(SessionController $sessionController)
    {
        $this->cekSession = $sessionController;
    }

    public function scan_data(){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            $dataUsername = $data['us2'];
            $today = Carbon::now()->format("Y-m-d");
            $dataAbsen = Absen::where('userlog','=',$dataUsername->username)
            ->whereDate('tgl_clock_in','=',$today)
            ->get();

            $cekAbsen = Absen::where('userlog','=',$dataUsername->username)
            ->whereDate('tgl_clock_in','=',$today)
            ->count();

            return view('pages.scan',[
                'dataAbsen' => $dataAbsen,
                'cekAbsen' => $cekAbsen,
            ]);
        }else{
            return view('pages.login');
        }
    }
    
    public function cari_data(Request $request){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            $dataUsername = $data['us2'];
            $code = $request->hasil;

            $dataSiswa = Siswa::where('kelas', $code)
            ->where('username',$dataUsername->username)
            ->first();
            return response()->json([
                'responData' => $code,
                'dataSiswa' => $dataSiswa,
            ]);
        }else{
            return view('pages.login');
        }
    }

    public function clock_in(Request $request){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            try {
                $validatedData = $request->validate([
                    'kelas' => '',
                    'nama' => '',
                    'userlog' => '',
                    'clock_in' => '',
                    'tgl_clock_in' => '',
                    'clock_out' => '',
                    'tgl_clock_out' => '',
                    'latitude' => 'required',
                    'longitude' => 'required',
                    'lokasi' => '',
                ]);

                $dataUsername = $data['us2'];
                $dataSiswa = Siswa::where('username',$dataUsername->username)
                ->first();

                $validatedData['kelas'] = $dataSiswa->kelas;
                $validatedData['nama'] = $dataSiswa->nama;
                $validatedData['userlog'] = $dataSiswa->username;
                $validatedData['clock_in'] = 'YES';
                $validatedData['tgl_clock_in'] = Carbon::now()->format("Y-m-d H:i:s");
                $validatedData['clock_out'] = '';
                $validatedData['tgl_clock_out'] = Carbon::now()->format("Y-m-d H:i:s");
                $validatedData['lokasi'] = $dataSiswa->lokasi;
                
                Absen::create($validatedData);
                $message = 'sukses';
                return response()->json($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = 'gagal';
                return response()->json($message);
            }
        }else{
            return view('pages.login');
        }
    }
    
    public function clock_out(){
        $data = $this->cekSession->cek_session();
        if(isset($data['us1']) > 0){
            try {
                $today = Carbon::now()->format("Y-m-d");
                $dataUsername = $data['us2'];
                $cekAbsenDay = Absen::where('userlog','=',$dataUsername->username)
                ->whereDate('tgl_clock_in','=',$today)
                ->first();
               
                Absen::where('id', $cekAbsenDay->id)
                ->update([
                    'clock_out' => 'YES',
                    'tgl_clock_out' => Carbon::now()->format("Y-m-d H:i:s")
                ]);
                $message = 'sukses';
                return response()->json($message);
            } catch (\Illuminate\Database\QueryException $e) {
                $message = 'gagal';
                return response()->json($message);
            }
        }else{
            return view('pages.login');
        }
    }
}
