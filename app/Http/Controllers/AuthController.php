<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SessionController;

class AuthController extends Controller
{
    private $cekSession;
    public function __construct(SessionController $sessionController)
    {
        $this->cekSession = $sessionController;
    }

    public function login_user(){
        $data = $this->cekSession->cek_session();
        // dd($data);
        if(isset($data['us1']) > 0){
            return view('pages.dashboard');
        }else{
            return view('pages.login');
        }
    }

    public function authenticate_user(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');

        $token = auth()->guard('web')->attempt($credentials);
        if (!$token) {
            return back()->with('loginError', 'Login gagal, ulangi lagi!');
        }

        if (auth()->guard('web')->check()) {
            $request->session()->regenerate();
            $request->session()->put('tokenJWT',$token);
            return redirect()->intended('/dashboard')->with(['statusLogin' => 'ok']);
        }else{
            return redirect()->intended('/login');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->put('tokenJWT','');
        return redirect('/login');
    }
}
