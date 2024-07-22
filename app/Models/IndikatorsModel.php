<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class IndikatorsModel extends Model
{
    protected $table = 'indikator';

    protected $guarded = ['id'];

    public function standar()
    {
        return $this->belongsTo(StandarsModel::class);
    }

    public function dokumen_pendukung()
    {
        return $this->hasMany(DokumenPendukungModel::class, 'indikator_id');
    }

    public function target_waktu()
    {
        return $this->hasMany(TargetWaktuModel::class, 'indikator_id');
    }

    public function getById($id)
    {
        $query = DB::table('indikator')
            ->where('id', '=', $id)
            ->first();

        return $query;
    }

    public function updateIndikator($id, $updateItems)
    {
        $query = DB::table('indikator')
            ->where('id', '=', $id)
            ->update($updateItems);

        return $query;
    }
}
