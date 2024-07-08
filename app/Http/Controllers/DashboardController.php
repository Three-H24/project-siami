<?php

namespace App\Http\Controllers;

use App\Models\StandarsModel;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $standars = new StandarsModel();

        $indikators = $standars->with(['indikator' => function ($query) {
            $query->withCount('dokumen_pendukung_indikator');
        }])->get();

        $data = [
            'title' => 'Dashboard',
            'users' => DB::table('users')->count(),
            'standars' => DB::table('standars')->count(),
            'indikators' => $indikators,
            'dokumen_pendukung_standar' => DB::table('dokumen_pendukung_indikator')->count(),
        ];

        return view('content/dashboard', $data);
    }
}
