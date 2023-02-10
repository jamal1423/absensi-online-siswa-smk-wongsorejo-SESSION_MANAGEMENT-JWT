<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function cek_session(){
        try{
            $token = session()->get('tokenJWT');
            if($token != ""){
                $tokenParts = explode(".", $token); 
                $tokenHeader = base64_decode($tokenParts[0]);
                $tokenPayload = base64_decode($tokenParts[1]);

                $jwtHeader = json_decode($tokenHeader);
                $jwtPayload = json_decode($tokenPayload);
                
                $username = base64_decode($jwtPayload->unm);
                $nis = base64_decode($jwtPayload->nis);
                $nama = base64_decode($jwtPayload->nm);
                
                $cekUser = User::where('username','=',$username)
                ->where('nis','=',$nis)->count();

                $cekSesiUser = User::select('username')
                ->where('username','=',$username)
                ->first();
                
                return ([
                    'us1' => $cekUser,
                    'us2' => $cekSesiUser
                ]);
            }else{
                return false;
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return false;
        }
    }
}
