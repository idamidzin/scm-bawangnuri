<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\DaftarRequest;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function daftarView()
    {
        return view('auth.daftar');
    }

    public function daftar(DaftarRequest $request)
    {

        $email = User::where('email', $request->email)->first();
        
        if ($email) {
            return back()->with('msg-daftar',['type'=>'danger','text'=>'Email sudah digunakan']);
        }

        $path_ktp = null;

        if ($request->hasFile('ktp')) {
            $image      = $request->file('ktp');
            $fileName   = 'ktp_'.uniqid().'.' . $image->getClientOriginalExtension();
            $request->file('ktp')->storeAs('/ktp',$fileName,'public');
            $path_ktp = $fileName;
        }

        $user = User::create([
            'role_id' => $request->role_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'nohp' => $request->nohp,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nama_rekening' => $request->nama_rekening,
            'no_rekening' => $request->no_rekening,
            'alamat' => $request->alamat,
            'ktp' => $path_ktp
        ]);
        
        return redirect()->route('login')->with('msg-daftar',['type'=>'success','text'=>'Berhasil mendaftar sebagai '.$user->Role->nama]);
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user != null) {
            if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])) 
            {
                return redirect()->route('dashboard');
            }
            return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
        }else{
            return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
        }
        
    }
}
