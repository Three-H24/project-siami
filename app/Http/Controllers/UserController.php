<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $users;

    public function __construct()
    {
        $this->users = new UserModel();
    }

    public function index(): View
    {
        $data = [
            'title' => 'Users',
            'users' => DB::table('users')->get(),
            'roles' => $this->users->getRoles()
        ];

        return view('content/users/user_index', $data);
    }

    public function addUserIndex(): View
    {
        $data = [
            'title' => 'Form Tambah User'
        ];

        return view('content/users/user_add', $data);
    }

    public function createUser(Request $request)
    {
        request()->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif,svg,JPG|max:2048',
            'email' => 'required|email|unique:users',
            'telp' => 'required|digits:12',
        ]);

        $imageName = time() . '_' . $request->file('foto')->getClientOriginalName();

        $path = $request->file('foto')->move('foto', $imageName);

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');

//        $users = new UserModel();

        $this->users->nama = $request->post('nama');
        $this->users->email =$request->post('email');
        $this->users->password = Hash::make($request->post('password'));
        $this->users->foto = $path;
        $this->users->jabatan = $request->post('jabatan');
        $this->users->telp = $request->post('telp');
        $this->users->role = $request->post('role');
        $this->users->created_at = $createdAT;

        $this->users->save();
        return redirect(route('user.add.index'))->with('message', 'User berhasil ditambahkan!');
    }

    public function resetPasswordUser($id)
    {

        $default_password = '12345678';
        $new_password = Hash::make($default_password);

        DB::table('users')
            ->where('id', '=', $id)
            ->update([
                'password' => $new_password
            ]);

        return redirect(route('user.index'))->with('message-reset', 'Password berhasil di atur ulang');
    }

    public function changeUser($id)
    {
        $imageName = time() . '_' . \request()->file('foto')->getClientOriginalName();

        $path = \request()->file('foto')->move('foto', $imageName);

        $dt = new \DateTime();
        $updatedAt = $dt->format('Y-m-d H:i:s');

        $updateUser = [
            'nama' => \request('nama'),
            'email' => \request('email'),
            'foto' => $path,
            'jabatan' => \request('jabatan'),
            'telp' => \request('telp'),
            'role' => \request('role'),
            'updated_at' => $updatedAt,
        ];

//        $user = DB::table('users')->where('id', '=', $id)->first();

        DB::table('users')
            ->where('id', '=', $id)
            ->update($updateUser);

        return redirect(route('user.index'))->with('message-change', 'Data user berhasil di ubah!');
    }

    public function ubahPassword()
    {
        $idUserLogin = session('iduserlogin');
        $passwordLama = \request('password-lama');
        $passwordSaatIni = session('password');

        $passwordBaru = \request('password-baru');
        $konfirmasiPassword = \request('konfirmasi-password');

        $checkPassword = Hash::check($passwordLama, $passwordSaatIni);

        if ($checkPassword === false) {
            return redirect(route('dashboard.index'))->with('Error-ubah-pass1', 'Password lama salah!');
        }

        if ($passwordBaru !== $konfirmasiPassword) {
            return redirect(route('dashboard.index'))->with('Error-ubah-pass2', 'Password baru dan konfirmasi password berbeda!');
        }

        DB::table('users')
            ->where('id', '=', $idUserLogin)
            ->update([
                'password' => Hash::make($passwordBaru)
            ]);

        Session::flush();
        return redirect(route('login.index'));
    }
}
