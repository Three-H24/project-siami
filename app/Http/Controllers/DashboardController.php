<?php

namespace App\Http\Controllers;

use App\Models\AmiModel;
use App\Models\StandarsModel;
use App\Models\TargetWaktuModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $standars = StandarsModel::with(['indikator', 'indikator.dokumen_pendukung'])->get();

        $dataChart = [];
        foreach ($standars as $standar) {
            $dataIndikator = [];
            foreach ($standar->indikator as $index => $indikator) {
                $dataIndikator[] = [
                    'butir_indikator' => $index + 1, // Butir indikator dimulai dari 1
                    'jumlah_dokumen' => $indikator->dokumen_pendukung->count()
                ];
            }
            $dataChart[] = [
                'nama_standar' => $standar->nama_standar,
                'indikatorData' => $dataIndikator
            ];
        }

        $data = [
            'title' => 'Dashboard',
            'users' => DB::table('users')->count(),
            'standars' => DB::table('standars')->count(),
            'indikators' => $dataChart,
            'dokumen_pendukung' => DB::table('dokumen_pendukung')->count(),
        ];

        return view('content/dashboard', $data);
    }

    public function amiDashboardindex()
    {
        $targets =  TargetWaktuModel::select('tahun_target')->distinct()->get();
        $standars = StandarsModel::all();

        $data = [
            'title' => 'Dashboard AMI',
            'targets' => $targets,
            'standars' => $standars
        ];

        return view('content/dashboard_ami', $data);
    }

    public function amiDashboardFilter()
    {
        $tahunTarget = request()->input('tahun_target');
        $standarId = request()->input('standar');

        $amiModel = new AmiModel();

        $targets =  TargetWaktuModel::select('tahun_target')->distinct()->get();
        $standars = StandarsModel::all();

        $amis = $amiModel::with('indikator.standar')
            ->whereHas('target_waktu', function ($query) use ($tahunTarget) {
                $query->where('tahun_target', $tahunTarget);
            })
            ->whereHas('indikator.standar', function ($query) use ($standarId) {
                $query->where('id', $standarId);
            })->get();

        $dataChart = ['total_tercapai' => 0, 'total_tidak_tercapai' => 0];
        foreach ($amis as $ami) {
            if ($ami->capaian == 'Tercapai') {
                $dataChart['total_tercapai'] += 1;
            } else {
                $dataChart['total_tidak_tercapai'] += 1;
            }
        }

        $data = [
            'title' => 'Dashboard AMI',
            'dataChart' => $dataChart,
            'tahunTarget' => $tahunTarget,
            'standarId' => $standarId,
            'targets' => $targets,
            'standars' => $standars,
        ];

        return view('content/dashboard_ami', $data);
    }
}
