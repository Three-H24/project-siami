<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DokumenPendukungModel extends Model
{
    protected $table = 'dokumen_pendukung_indikator';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_dokumen',
        'dokumen_pendukung'
    ];

    public function createDokumen($dokumen)
    {
        $query = DB::table('dokumen_pendukung_indikator')->insert($dokumen);

        return $query;
    }

    public function target_waktu()
    {
        return $this->belongsTo(TargetWaktuModel::class);
    }

    public function indikator()
    {
        return $this->belongsTo(IndikatorsModel::class);
    }

    public function getAllDocsByIndikatorAndTargetID($indikatorID, $tahunTargetId)
    {
        $query = DB::table('dokumen_pendukung_indikator')
            ->select(['nama_dokumen', 'dokumen_pendukung'])
            ->join('indikator', 'indikator.id', '=', 'indikator_id')
            ->join('target_waktu', 'target_waktu.id', '=', 'target_waktu_id')
            ->where('dokumen_pendukung_indikator.indikator_id', '=', $indikatorID)
            ->where('target_waktu.id', '=', $tahunTargetId)
            ->get();

        return $query;
    }
}
