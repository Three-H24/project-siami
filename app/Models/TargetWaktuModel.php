<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TargetWaktuModel extends Model
{
    protected $table = 'target_waktu';

    protected $guarded = ['id'];

    protected $primaryKey = 'id';

    protected $fillable = [
        'tanggal_target',
        'keterangan_target'
    ];

    public function indikator()
    {
        return $this->belongsTo(IndikatorsModel::class);
    }

    public function dokumen_pendukung()
    {
        return $this->hasMany(DokumenPendukungModel::class, 'target_waktu_id');
    }

    public function ami()
    {
        return $this->hasMany(AmiModel::class, 'target_waktu_id');
    }

    public function getTanggalTargetByIndikatorId($indikatorID)
    {
        $query = "select * from target_waktu join indikator i on i.id = target_waktu.indikator_id where target_waktu.indikator_id = ?";

        return DB::select($query, [$indikatorID]);
    }

    public function getTahunTargetByIndikatorId($indikatorID, $inputTarget)
    {
        $query = DB::table('target_waktu')
            ->select('tahun_target')
            ->join('indikator', 'indikator.id', '=', 'target_waktu.indikator_id')
            ->where('target_waktu.indikator_id', '=', $indikatorID)
            ->where('target_waktu.tahun_target', '=', $inputTarget)
            ->first();

        return $query;
    }

    public function updateTargetWaktu($id, $newTargetWaktu)
    {
        $query = DB::table('target_waktu')
            ->where('id', '=', $id)
            ->update($newTargetWaktu);

        return $query;
    }

    public function groupByTanggalTarget()
    {
        $query = DB::table('target_waktu')
            ->groupBy('tahun_target')
            ->get();

        return $query;
    }
}
