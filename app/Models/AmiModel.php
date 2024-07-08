<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AmiModel extends Model
{
    protected $table = 'ami';

    protected $primaryKey = 'id';

    protected $fillable = [
        'faktor_pendukung',
        'faktor_penghambat',
        'keterangan_ami',
        'status'
    ];

    public function standars()
    {
        return $this->belongsTo(StandarsModel::class);
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorsModel::class);
    }

    public function target_waktu()
    {
        return $this->belongsTo(TargetWaktuModel::class);
    }



    public function getByStandarId($standarID)
    {
        $query = DB::table('ami')
            ->join('standars', 'id', '=', 'ami.standar_id')
            ->where('ami.standar_id', '=', $standarID)
            ->first();

        return $query;
    }
}
