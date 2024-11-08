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
        $subquery = DB::table('examinations as e2')
            ->select('e2.patient_id', 'e2.modalitas_id', DB::raw('COUNT(*) as total_pemeriksaan'))
            ->groupBy('e2.patient_id', 'e2.modalitas_id');

        $query = DB::table('examinations as e')
            ->select([
                'm.id',
                'p.name',
                'p.nip',
                'm.modalitas_name',
                'e.created_at',
                'e.updated_at',
                'total_pemeriksaan'
            ])
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->joinSub($subquery, 'exam_counts', function ($join) {
                $join->on('e.patient_id', '=', 'exam_counts.patient_id')
                    ->on('e.modalitas_id', '=', 'exam_counts.modalitas_id');
            })
            ->groupBy('m.id', 'p.name', 'm.modalitas_name', 'p.id', 'p.nip', 'e.created_at', 'e.updated_at', 'exam_counts.total_pemeriksaan')
            ->distinct();

        $examinationHistory = $query->get();

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
    public function show(string $id)
    {
        //
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
}
