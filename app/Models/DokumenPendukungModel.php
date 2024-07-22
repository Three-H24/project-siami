<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DokumenPendukungModel extends Model
{
    protected $table = 'dokumen_pendukung';

    protected $primaryKey = 'id';

    protected $guarded = ['id'];

    protected $fillable = [
        'nama_dokumen',
        'dokumen_pendukung'
    ];
    
    public function target_waktu()
    {
        return $this->belongsTo(TargetWaktuModel::class);
    }
    
    public function indikator()
    {
        return $this->belongsTo(IndikatorsModel::class);
    }

    public function createDokumen($dokumen)
    {
        $query = DB::table('dokumen_pendukung')->insert($dokumen);

        return $query;
    }
}
