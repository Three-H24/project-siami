<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AuthModel extends Model
{
    public static function loginVerify($email, $password)
    {

        $sql = "select * from users where email=?";
        $user = collect(DB::select($sql, [$email]))->first();

        if ($user != null) {
            if (password_verify($password, $user->password)) {
                return $user;
            }
        }
        return false;
    }

    public static function createToken($idUser)
    {
        $token = md5(date('Y-m-d H:i:s') . $idUser);
        DB::table('users')
            ->where('id', '=', $idUser)
            ->update(['token' => $token]);

        return $token;
    }
}
