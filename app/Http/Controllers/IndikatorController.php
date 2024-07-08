<?php

namespace App\Http\Controllers;

use App\Models\DokumenPendukungModel;
use App\Models\IndikatorsModel;
use App\Models\StandarsModel;
use App\Models\TargetWaktuModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class IndikatorController extends Controller
{
    protected $indikator;

    public function __construct()
    {
        $this->indikator = new IndikatorsModel();
    }

    public function index(): View
    {
        $standarId = \request()->input('standar_id');

        $indikators = $this->indikator::query();

        if ($standarId === null) {
            $targetWaktu = new TargetWaktuModel();
            $data = [
                'title' => 'Indikator',
                'indikators' => $this->indikator->with(['standar', 'dokumen_pendukung_indikator', 'target_waktu'])->get(),
                'target_waktu' => $targetWaktu->groupByTanggalTarget(),
                'allStandar' => StandarsModel::all(),
            ];
        } else {
            if ($standarId !== 0) {
                $indikators->where('standar_id', $standarId);
            }

            $targetWaktu = new TargetWaktuModel();
            $data = [
                'title' => 'Indikator',
                'indikators' => $indikators->with(['standar', 'dokumen_pendukung_indikator', 'target_waktu'])->get(),
                'target_waktu' => $targetWaktu->groupByTanggalTarget(),
                'allStandar' => StandarsModel::all(),
            ];
        }

        return view('content/indikator/indikator_index', $data);
    }

    public function indikatorAddForm(): View
    {
        $data = [
            'title' => 'Formulir tambah indikator',
            'standars' => DB::table('standars')->get(),
        ];

        return \view('content/indikator/indikator_add_form', $data);
    }

    public function createIndikator()
    {
        request()->validate([
            'standar' => 'required',
            'butir_indikator' => 'required',
            'satuan' => 'required',
        ]);

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');
        $updatedAT = $createdAT;

        $this->indikator->butir_indikator = request('butir_indikator');
        $this->indikator->satuan = request('satuan');
        $this->indikator->standar_id = request('standar');
        $this->indikator->created_at = $createdAT;
        $this->indikator->updated_at = $updatedAT;

        $this->indikator->save();

        return redirect(route('indikator.add.form'))->with('message', 'Indikator berhasil ditambahkan!');
    }

    public function editIndikator($id, Request $request)
    {
        $indikator = $this->indikator->getById($id);

        if ($indikator === null) {
            return redirect(route('indikator.index'))->with('fail-edit', 'Indikator tidak ditemukan!');
        }

        $dt = new \DateTime();
        $updatedAT = $dt->format('Y-m-d H:i:s');

        $updateItems = [
            'butir_indikator' => request('butir_indikator'),
            'satuan' => request('satuan'),
            'updated_at' => $updatedAT
        ];

        $this->indikator->updateIndikator($id, $updateItems);

        return redirect(route('indikator.index'))->with('message', 'Indikator berhasil di edit!');
    }

    public function addTargetIndikator($id)
    {
        $indikator = $this->indikator->getById($id);

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');
        $updatedAT = $createdAT;

        // Simpan indikator ID ke $indikatorID
        $indikatorID = $indikator->id;

        $targetWaktu = new TargetWaktuModel();

        // Ambil target waktu berdasarkan Indikator ID
        $targetWaktuByIndikatorID = $targetWaktu->getTanggalTargetByIndikatorId($indikatorID);

        $inputTarget = \request('tanggal_target');
        $tanggalTargetExist = $targetWaktu->getTahunTargetByIndikatorId($indikatorID, $inputTarget);

        // Jika target waktu dengan indikator ID tertentu bernilai 0 atau belum ada
        if (count($targetWaktuByIndikatorID) === 0) {
            $targetWaktu->tahun_target = \request('tanggal_target');
            $targetWaktu->keterangan_target = \request('keterangan_target');
            $targetWaktu->indikator_id = $indikatorID;
            $targetWaktu->created_at = $createdAT;
            $targetWaktu->updated_at = $updatedAT;

            $targetWaktu->save();
        } else {
            // Jika tanggal yang di input sudah terkait dengan Indikator ID
            if ($tanggalTargetExist !== null) {

                return redirect(route('indikator.index'))->with('message-fail-add-target', 'Target/waktu yang diinput sudah ada!');

            } else {

                $targetWaktu->tahun_target = \request('tanggal_target');
                $targetWaktu->keterangan_target = \request('keterangan_target');
                $targetWaktu->indikator_id = $indikatorID;
                $targetWaktu->created_at = $createdAT;
                $targetWaktu->updated_at = $updatedAT;

                $targetWaktu->save();
            }

        }
        return redirect(route('indikator.index'))->with('message-target', 'Berhasil menambahkan target/waktu');
    }

    public function addDokumenPendukung($indikatorId)
    {
        //Simpan indikator ID ke $indikatorID
        $indikator = $this->indikator->getById($indikatorId);
//        dd($indikator);

        $indikatorID = $indikator->id;
        $targetWaktuId = \request('target_id');

        \request()->validate([
            'dokumen_pendukung.*' => 'required|mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png|max:2048'
        ]);

        if ($targetWaktuId === null) {
            return redirect()->back()->with('message-fail', 'Gagal menambahkan dokumen pendukung, tahun target belum ada!');
        }

        if (\request()->hasFile('dokumen_pendukung')) {
            foreach (\request()->file('dokumen_pendukung') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->move('dokumen_indikator', $fileName);

                $dokumen = new DokumenPendukungModel();

                $files = [
                    'nama_dokumen' => $fileName,
                    'dokumen_pendukung' => $filePath,
                    'target_waktu_id' => $targetWaktuId,
                    'indikator_id' => $indikatorID
                ];

                $dokumen->createDokumen($files);
            }
        }

        return redirect()->back()->with('message', 'Berhasil menambahkan dokumen pendukung!');
    }

    public function editTahunTargetIndikator($id)
    {
        $dt = new \DateTime();
        $updatedAT = $dt->format('Y-m-d H:i:s');

        $targetWaktu = new TargetWaktuModel();

        $targetWaktuId = \request()->post('target_waktu');

        $newTargetWaktu = [
            'keterangan_target' => \request()->post('keterangan_target'),
            'updated_at' => $updatedAT
        ];

        $targetWaktu->updateTargetWaktu($targetWaktuId, $newTargetWaktu);

        return redirect(route('indikator.index'))->with('message-edit-tahun', 'Tahun Target Indikator berhasil di edit!');
    }
}
