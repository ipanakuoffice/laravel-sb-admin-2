<?php

namespace App\Http\Controllers;

use App\Models\Examinations;
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
    public function show($patientId, Request $request)
    {
        $modalitasId = $request->query('modalitas_id');

        $detailExaminationHistory = DB::table('examinations as e')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->select('p.name', 'm.modalitas_name', 'di.dose_indicator_name', 'e.created_at', 'p.weight', 'p.height', 'p.nip', 'e.patient_id', 'e.*')  // Pastikan kolom ini sesuai
            ->where('p.id', $patientId)  // Filter berdasarkan patient_id
            ->where('m.id', $modalitasId)  // Filter berdasarkan modalitas_id
            ->get();

        return response()->json($detailExaminationHistory);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($patientId, Request $request)
    {
        //
        // Mengambil dua parameter dari request
        $modalitasId = $request->query('modalitas_id');

        // Query untuk mendapatkan detail pemeriksaan berdasarkan kedua parameter tersebut


        // Mengembalikan data sebagai respons JSON
        return response()->json($detailExaminationHistory);
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

    public function showChart(Request $request)
    {
        $patientId = $request->query('patientId');
        $modalitasId = $request->query('modalitasId');
        $doseIndicatorId = $request->query('doseIndicatorId');

        // Fetch data based on the patient, modalitas, and dose indicator
        $data = DB::table('examinations as e')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->where('p.id', $patientId)
            ->where('m.id', $modalitasId)
            ->where('di.id', $doseIndicatorId)
            ->select('e.dosis', 'e.tegangan')
            ->get();

        // Return as JSON for use in JavaScript
        return response()->json($data);
    }
}
