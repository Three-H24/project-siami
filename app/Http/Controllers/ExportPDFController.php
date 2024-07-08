<?php

namespace App\Http\Controllers;

use App\Models\StandarsModel;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportPDFController extends Controller
{
    protected $standars;
    public function __construct()
    {
        $this->standars = new StandarsModel();
    }
    public function exportPDF($namaStandar, $standarID)
    {
        $standar = $this->standars->getIndikatorByStandarId($standarID);

        if (count($standar) === 0) {
            return redirect(route('standar.index'))->with('message-fail-get-indktr', 'Standar ini belum memiliki indikator!');
        }

        $startYear = \request('tahun_awal');
        $endYear = \request('tahun_akhir');

        $standars = $this->standars::with(['indikator' => function ($query) use ($startYear, $endYear) {
            $query->with(['target_waktu' => function ($query) use ($startYear, $endYear) {
                $query->whereBetween('tahun_target', [$startYear, $endYear]);
            }, 'dokumen_pendukung_indikator' => function ($query) use ($startYear, $endYear) {
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

        $pdf = Pdf::loadView('content/exportPdf/export_pdf', $data)->setPaper('A4', 'landscape');

        return $pdf->download(date('d-m-y') . '_' . $namaStandar . '.pdf');
    }
}
