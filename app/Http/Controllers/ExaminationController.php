<?php

namespace App\Http\Controllers;

use App\Models\Examinations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExaminationController extends Controller
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
        $examinations = DB::table('examinations')
            ->orderBy('updated_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->whereNull('deleted_at')
            ->get();

        if ($examinations) {
            return response()->json($examinations);
        } else {
            return response()->json([
                'error' => 'Examinations not found'
            ], 404);
        }
    }

    public function addExamination(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|numeric',
            'modalitas_id' => 'required|numeric',
            'dose_indicator_id' => 'required|numeric',
            'tegangan' => 'required|numeric',
            'dosis' => 'required|numeric',
            'result' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            Examinations::create([
                'patient_id' => $request->input('patient_id'),
                'modalitas_id' => $request->input('modalitas_id'),
                'dose_indicator_id' => $request->input('dose_indicator_id'),
                'tegangan' => $request->input('tegangan'),
                'dosis' => $request->input('dosis'),
                'result' => $request->input('result'),
                'note' => $request->input('note'),
                'created_by' => Auth::id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Examination added successfully',
                'status_code' => 200,
                'error_code' => 0
            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            Log::error('Add Examination Failed: ' . $e->getMessage());

            return response()->json([
                'status' => 'failed ',
                'message' => 'Add Examination Failed',
                'status_code' => 500,
                'error_code' => 1,
                'error_message' => $e->getMessage(),
            ]);
        };
    }

    public function editExamination(Request $request, $examinationId)
    {
        return response()->json([]);
    }

    public function updateExamination(Request $request, $examinationId)
    {
        return response()->json([]);
    }

    public function deleteExamination(Request $request, $examinationId)
    {
        return response()->json([]);
    }
}
