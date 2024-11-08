<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $examinationHistory  = DB::table('examinations as e')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->select('e.id', 'p.id as patientId', 'm.id as modalitasId', 'p.name', 'p.nip', 'm.modalitas_name', 'e.created_at', 'e.updated_at')
            ->selectRaw('(SELECT COUNT(*) FROM examinations e2 WHERE e2.patient_id = e.patient_id AND e2.modalitas_id = e.modalitas_id) as total_pemeriksaan')
            ->distinct('e.patient_id', 'e.modalitas_id')  // Menentukan kolom untuk distinct
            ->get();




        return view('menu_riwayat_pemeriksaan.index', compact('examinationHistory'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $patientId = $request->input('patient_id');
        $modalitasId = $request->input('modalitas_id');

        $detailExaminationHistory = DB::table('examinations as e')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->select('p.name', 'm.modalitas_name', 'di.dose_indicator_name as dose_indicators', 'e.*')
            ->where('p.id', 1)
            ->where('m.id', 1)
            ->get();

        dd($detailExaminationHistory);
        return ($detailExaminationHistory);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showChart()
    {
        $tegangan = [220, 230, 240, 250, 260]; // Contoh data tegangan
        $dosis = [10, 15, 20, 25, 30]; // Contoh data dosis

        return view('chart', compact('tegangan', 'dosis'));
    }
}
