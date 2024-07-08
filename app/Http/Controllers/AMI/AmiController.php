<?php

namespace App\Http\Controllers\AMI;

use App\Http\Controllers\Controller;
use App\Models\AmiModel;
use App\Models\IndikatorsModel;
use App\Models\TargetWaktuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AmiController extends Controller
{
    protected $ami;

    public function __construct()
    {
        $this->ami = new AmiModel();
    }

    public function index(): View
    {
        $targetWaktu = new TargetWaktuModel();

        $data = [
            'title' => 'ami',
            'amies' => $this->ami->with('dokumen_pendukung_ami', 'target_waktu', 'standars')->get(),
            'target_waktu' => $targetWaktu->groupByTanggalTarget(),
            'standars' => DB::table('standars')->get(),
        ];

//        dd($data);
        return \view('App/ami/ami_index', $data);
    }

    public function amiFilter()
    {
        $tahunTarget = request('tahun_target');
        $standar = request('standar');

        $targetWaktu = new TargetWaktuModel();

        $tanggalTarget = $targetWaktu->getByTanggalTarget($tahunTarget);

        $query = $this->ami::query();

        if ($tahunTarget) {
            $targetWaktuID = $tanggalTarget->id;
            $query->where('target_waktu_id', '=', $targetWaktuID);
        }

        if ($standar) {
            $query->where('standar_id', '=', $standar);
        }

        $amies = $query->with(['dokumen_pendukung_ami', 'target_waktu', 'standar', 'capaian'])->get();

        return \view('App/ami/ami_index', compact($amies));
    }
    public function amiAddForm(): View
    {
        $targetWaktu = new TargetWaktuModel();
        $data = [
            'title' => 'Formulir tambah ami',
            'standars' => DB::table('standars')->get(),
            'target_waktu' => $targetWaktu->groupByTanggalTarget(),

//            $targetWaktu::select('tanggal_target')->distinct()->orderBy('tanggal_target', 'ASC')->get()
        ];

        return \view('App/ami/ami_add_form', $data);
    }

    public function createAmi()
    {
        request()->validate([
            'standar' => 'required',
            'target_waktu' => 'required'
        ], [
            'standar.required' => 'Standar wajib dipilih!',

            'target_waktu.required' => 'Target waktu wajib dipilih'
        ]);

        $targetWaktu = new TargetWaktuModel();
        $tanggalTarget = $targetWaktu->getByTanggalTarget(request('target_waktu'));

        $targetWaktuID = $tanggalTarget->id;

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');

        $this->ami->standar_id = request('standar');
        $this->ami->target_waktu_id = $targetWaktuID;
        $this->ami->created_at = $createdAT;

        $this->ami->save();

        return redirect(route('ami.add.form'))->with('message', 'Berhasil menambahkan ami!');
    }
}
