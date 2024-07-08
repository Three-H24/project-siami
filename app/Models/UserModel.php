<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

enum ROLES: string
{
    case ADMIN = 'admin';
    case AUDITOR = 'auditor';
    case AUDITEE = 'auditee';
}
class UserModel extends Model
{
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'foto',
        'jabatan',
        'telp',
        'role'
    ];

    public function getRoles()
    {
        return ROLES::cases();
    }
}
