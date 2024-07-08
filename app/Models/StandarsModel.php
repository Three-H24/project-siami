<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StandarsModel extends Model
{
    protected $table = 'standars';

    protected $guarded = ['id'];

    public function indikator()
    {
        return $this->hasMany(IndikatorsModel::class, 'standar_id');
    }

    public function getById($id)
    {
        $query = DB::table('standars')
            ->where('id', '=', $id)
            ->first();

        return $query;
    }

    public function getIndikatorByStandarId($standarId)
    {
        $query = DB::table('standars')
            ->join('indikator', 'standars.id', '=', 'standar_id')
            ->where('indikator.standar_id', '=', $standarId)
            ->get();

        return $query;
    }
}
