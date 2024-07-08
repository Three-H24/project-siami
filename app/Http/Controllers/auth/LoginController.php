<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\AuthModel;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function index()
    {
        return view('layout.login');
    }

    public function verifyLogin()
    {
        //dd(request()->all());
        $email = request('email');
        $password = request('password');
        $user = AuthModel::loginVerify($email, $password);
        if ($user === false) {
//            Session::flash('error', 'Username dan Password Tidak Sesuai!');
            return redirect(route('login.index'))->with('error', 'Email dan Password Tidak Sesuai!');

        }

        //kondisi ketika user tidak null
        $token = AuthModel::createToken($user->id);
        session(
            [
                'token' => $token,
                'iduserlogin' => $user->id,
                'namaUserLogin' => $user->nama,
                'emailUserLogin' => $user->email,
                'jabatanUserLogin' => $user->jabatan,
                'telpUserLogin' => $user->telp,
                'roleUserLogin' => $user->role,
                'fotoUserLogin' => $user->foto,
                'jamLogin' => date('H:i:s'),
                'password' => $user->password,
            ]
        );

        return redirect(route('dashboard.index'))->with('message', 'Anda sudah berhasil login!');
    }

    public function logout()
    {
        Session::flush();
        return redirect(route('login.index'));
    }
}
