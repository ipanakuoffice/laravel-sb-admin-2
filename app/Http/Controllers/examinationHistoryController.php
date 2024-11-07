<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Laravel\Ui\Presets\React;

class examinationHistoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('menu_examination.index');
    }

    public function getData(Request $request)
    {
        $examinations = DB::table('examinations as e')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->select('p.name', 'p.height', 'p.weight', 'm.modalitas_name', 'di.dose_indicator_name', 'e.created_at', 'e.*')
            ->whereNull('e.deleted_at')
            ->get();

        if ($examinations) {
            return response()->json($examinations);
        } else {
            return response()->json([
                'error' => 'Examinations not found'
            ], 404);
        }
    }
}
