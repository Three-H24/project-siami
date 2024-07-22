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
        return $this->belongsTo(StandarsModel::class, 'standar_id');
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorsModel::class, 'indikator_id');
    }

    public function target_waktu()
    {
        return $this->belongsTo(TargetWaktuModel::class, 'target_waktu_id');
    }

    public function updateCapainAmi($amiId, $capaian)
    {
        $query = DB::table('ami')
            ->where('id', '=', $amiId)
            ->update($capaian);

        return $query;
    }

    public function updateAmi($amiId, $updatedAMI)
    {
        $query = DB::table('ami')
            ->where('id', '=', $amiId)
            ->update($updatedAMI);

        return $query;
    }
}
