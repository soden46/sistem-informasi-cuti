<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    public function index()
    {
        App::setLocale('id');
        if (Auth::check()) {
            return redirect('dashboard');
        } else {
            return view('login.index', [
                'judul' => 'Login',
                'active' => 'login'
            ]);
        }
    }

    public function authenticate(Request $request)
    {
        App::setLocale('id');
        $this->validate($request, [
            'nama_emp' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('nama_emp', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            // dd($user);
            Log::info('User logged in: ', ['nama_emp' => $user->nama_emp, 'hak_akses' => $user->hak_akses]);
            Session::regenerate();
            if ($user->hak_akses == 'manajer') {
                return redirect()->route('manajer.index');
            } elseif ($user->hak_akses == 'hrd') {
                return redirect()->route('hrd.index');
            } elseif ($user->hak_akses == 'karyawan') {
                return redirect()->route('karyawan.index');
            }
        } else {
            Log::warning('Failed login attempt: ', ['nama_emp' => $request->input('nama_emp')]);
            return redirect()->route('login')
                ->with('error', 'Nama atau Password salah.');
        }
    }

    public function logout(Request $request)
    {
        App::setLocale('id');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
