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
            'title' => 'AMI',
            'amies' => $this->ami->with('indikator', 'target_waktu', 'standars')->get(),
            'target_waktu' => $targetWaktu->groupByTanggalTarget(),
            'standars' => DB::table('standars')->get(),
        ];

        return \view('App/ami/ami_index', $data);
    }

    public function amiFilter()
    {
        $tahunTarget = request()->input('tahun_target');
        $standarID = request()->input('standar');

        $targetWaktu = new TargetWaktuModel();
        $validated = request()->validate([
            'tahun_target' => 'required',
            'standar' => 'required',
        ]);

        $amies = $this->ami::with(['indikator', 'target_waktu', 'standars'])
            ->whereHas('target_waktu', function ($query) use ($validated) {
                $query->where('tahun_target', $validated['tahun_target']);
            })->whereHas('standars', function ($query) use ($validated) {
                $query->where('standar_id', $validated['standar']);
            })->get();

        $data = [
            'title' => 'AMI',
            'amies' => $amies,
            'target_waktu' => $targetWaktu->groupByTanggalTarget(),
            'standars' => DB::table('standars')->get(),
            'tahunTarget' => $tahunTarget,
            'standarId' => $standarID,
        ];

        return \view('App/ami/ami_index', $data);
    }

    public function prosesAuditAmi($standarId, $indikatorId)
    {
        $standar_id = $standarId;
        $indikator_id = $indikatorId;
        $target_waktu_id = request('target_id');
        $userAudit = session('namaUserLogin');

        $targetWaktuId = \request('target_id');

        if ($targetWaktuId === null) {
            return redirect()->back()->with('message-fail', 'Gagal memproses hasil audit, tahun target belum ada!');
        }

        $amiExists = $this->ami::with(['standars', 'indikator', 'target_waktu'])
            ->whereHas('standars', function ($query) use ($standar_id) {
                $query->where('standar_id', $standar_id);
            })->whereHas('indikator', function ($query) use ($indikator_id) {
                $query->where('indikator_id', $indikator_id);
            })->whereHas('target_waktu', function ($query) use ($target_waktu_id) {
                $query->where('target_waktu_id', $target_waktu_id);
            })->first();

        if ($amiExists !== null) {
            return redirect()->back()->with('message-fail-audit', 'Gagal memproses audit, capaian/hasil audit sudah diinput oleh ' . $amiExists->user_audit);
        }

        $dt = new \DateTime();
        $createdAT = $dt->format('Y-m-d H:i:s');

        $tanggal_audit = $createdAT;

        $this->ami->capaian = request('capaian');
        $this->ami->keterangan_capaian = request('keterangan_capaian');
        $this->ami->tanggal_audit = $tanggal_audit;
        $this->ami->user_audit = $userAudit;
        $this->ami->standar_id = $standar_id;
        $this->ami->indikator_id = $indikator_id;
        $this->ami->target_waktu_id = $target_waktu_id;
        $this->ami->created_at = $createdAT;
        $this->ami->save();

        return redirect()->back()->with('message-audit', 'Berhasil memproses hasil audit!');
    }

    public function prosesEditCapaianAuditAmi($amiId)
    {
        $capaian = [
            'capaian' => request('capaian'),
            'keterangan_capaian' => request('keterangan_capaian')
        ];

        $this->ami->updateCapainAmi($amiId, $capaian);

        return redirect()->back()->with('message-edit-capaian-audit', 'Berhasil mengubah keterangan capaian audit!');
    }

    public function editAMI($amiId)
    {
        $updatedAMI = [
            'faktor_pendukung' => request('faktor_pendukung'),
            'faktor_penghambat' => request('faktor_penghambat')
        ];

        $this->ami->updateAmi($amiId, $updatedAMI);

        return redirect(route('ami.index'))->with('message-edit-ami', 'Berhasil mengubah AMI!');
    }
}
