<?php

namespace App\Http\Controllers;

use App\Models\DokumenPendukungModel;
use App\Models\IndikatorsModel;
use App\Models\StandarsModel;
use App\Models\TargetWaktuModel;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class StandarController extends Controller
{

    protected $standars;

    public function __construct()
    {
        $this->standars = new StandarsModel();
    }

    public function index(): View
    {
        $targetWaktu = new TargetWaktuModel();

        $data = [
            'title' => 'Standars',
            'standars' => StandarsModel::with('indikator')->get(),
            'target_waktu' => $targetWaktu->groupByTanggalTarget(),
        ];

        return \view('content/standars/standars_index', $data);
    }

    public function standarAddForm(): View
    {
        $data = [
            'title' => 'Formulir tambah standar',
        ];

        return \view('content/standars/standar_add_form', $data);
    }

    public function createStandar()
    {
        request()->validate([
            'nama_standar' => 'required'
        ]);

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');
        $updatedAT = $createdAT;

        $this->standars->nama_standar = request('nama_standar');
        $this->standars->created_at = $createdAT;
        $this->standars->updated_at = $updatedAT;

        $this->standars->save();

        return redirect(route('standar.add.form'))->with('message', 'Standar berhasil ditambahkan');
    }

    public function editStandar($id)
    {
        $dt = new \DateTime();
        $updatedAT = $dt->format('Y-m-d H:i:s');

        $update_standar = [
            'nama_standar' => request('nama_standar'),
            'updated_at' => $updatedAT
        ];

        DB::table('standars')
            ->where('id', '=', $id)
            ->update($update_standar);

        return redirect(route('standar.index'))->with('message-edit', 'Standar berhasil di edit');
    }

    public function allStandarIndikator($nama_standar, $id)
    {
        $standar = $this->standars->getIndikatorByStandarId($id);

        if (count($standar) === 0) {
            return redirect(route('standar.index'))->with('message-fail-get-indktr', 'Standar ini belum memiliki indikator!');
        }

        $inputTahunTarget = request()->input('tahun_target');

        $standars = $this->standars::with(['indikator' => function ($query) use ($inputTahunTarget) {
            $query->with(['target_waktu' => function ($query) use ($inputTahunTarget) {
                $query->where('tahun_target', $inputTahunTarget);
            }, 'dokumen_pendukung_indikator' => function ($query) use ($inputTahunTarget) {
                $query->whereHas('target_waktu', function ($q) use ($inputTahunTarget) {
                    $q->where('tahun_target', $inputTahunTarget);
                });

            }]);
        }])->find($id);

        $data = [
            'title' => $nama_standar,
            'standars' => $standars,
            'tahunTarget' => $inputTahunTarget,
        ];

        return \view('content/standars/stnd_indkt', $data);
    }
}
