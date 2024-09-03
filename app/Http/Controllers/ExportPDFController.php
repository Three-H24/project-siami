<?php

namespace App\Http\Controllers;

use App\Models\AmiModel;
use App\Models\StandarsModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportPDFController extends Controller
{
    protected $standars;

    public function __construct()
    {
        $this->standars = new StandarsModel();
    }

    public function exportStandarPDF($namaStandar, $standarID)
    {
        $standar = $this->standars->getIndikatorByStandarId($standarID);

        if (count($standar) === 0) {
            return redirect(route('standar.index'))->with('message-fail-get-indktr', 'Standar ini belum memiliki indikator!');
        }

        $startYear = \request('tahun_awal');
        $endYear = \request('tahun_akhir');

        # Batalkan export jika tahun akhir lebih kecil dari tahun awal
        if ($endYear < $startYear) {
            return redirect(route('standar.index'))->with('message-fail-export', 'Tahun akhir tidak boleh lebih kecil dari tahun awal!');
        }

        $standars = $this->standars::with(['indikator' => function ($query) use ($startYear, $endYear) {
            $query->with(['target_waktu' => function ($query) use ($startYear, $endYear) {
                $query->whereBetween('tahun_target', [$startYear, $endYear]);
            }, 'dokumen_pendukung' => function ($query) use ($startYear, $endYear) {
                $query->whereHas('target_waktu', function ($q) use ($startYear, $endYear) {
                    $q->whereBetween('tahun_target', [$startYear, $endYear]);
                });
            }]);
        }])->findOrFail($standarID);

        $totalYear = $endYear - $startYear + 1;

        $data = [
            'title' => $namaStandar,
            'standars' => $standars,
            'startYear' => $startYear,
            'endYear' => $endYear,
            'totalYear' => $totalYear,
        ];

        $pdf = Pdf::loadView('content/exportPdf/exportStandar_pdf', $data)->setPaper('A4', 'landscape');

        return $pdf->download(date('d-m-y') . '_' . $namaStandar . '.pdf');
    }

    public function exportAMIPdf(Request $request)
    {
        $request->validate([
            'standars' => 'required',
            'tahun_target' => 'required',
            'kolom' => 'required|array',
        ]);

        $standarID = $request->input('standars');
        $tahunTarget = $request->input('tahun_target');
        $selectedColumns = $request->input('kolom');

        // Ambil standar berdasarkan ID yang dipilih
        $standar = StandarsModel::findOrFail($standarID);
        $standarName = $standar->nama_standar;

        $amies = AmiModel::with(['indikator.standar', 'target_waktu'])
            ->whereHas('target_waktu', function ($query) use ($tahunTarget) {
                $query->where('tahun_target', $tahunTarget);
            })
            ->whereHas('indikator.standar', function ($query) use ($standarID) {
                $query->where('id', $standarID);
            })->get();

        $data = [
            'title' => $standarName,
            'selectedColumns' => $selectedColumns,
            'tahunTarget' => $tahunTarget,
            'amies' => $amies
        ];

        $pdf = Pdf::loadView('content/exportPdf/exportAMI_pdf', $data)->setPaper('A4', 'landscape');

        return $pdf->download('Hasil AMI Tahun/Target Waktu_' . $tahunTarget . '_' . date('d-m-y') . '.pdf');
    }
}
