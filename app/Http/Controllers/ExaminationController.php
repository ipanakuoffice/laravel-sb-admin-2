<?php

namespace App\Http\Controllers;

use App\Models\DoseIndicators;
use App\Models\Examinations;
use App\Models\Modalitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;

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
        $examinations = DB::table('examinations as e')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->select('p.name', 'p.height', 'p.weight', 'm.modalitas_name', 'di.dose_indicator_name', 'e.*')
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
        $examination = DB::table('examinations as e')
            ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
            ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
            ->join('patients as p', 'e.patient_id', '=', 'p.id')
            ->select('p.name', 'p.height', 'p.weight', 'm.modalitas_name', 'di.dose_indicator_name', 'e.*')
            ->whereNull('e.deleted_at')
            ->where('e.id', $examinationId)
            ->get();

        if ($examination) {
            return response()->json($examination);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'data not found',
                'status_code' => 404,
            ]);
        }
    }

    public function updateExamination(Request $request, $examinationId)
    {
        $request->validate([
            'modalitas_id' => 'required|numeric',
            'dose_indicator_id' => 'required|numeric',
            'tegangan' => 'required|numeric',
            'dosis' => 'required|numeric',
            'result' => 'nullable|string',
            'note' => 'nullable|string',
        ]);

        $examination = Examinations::findOrFail($examinationId);
        if ($examination) {
            $examination->update($request->all());
            return response()->json([
                'status' => 'success',
                'message' => 'update examination success',
                'status_code' => 200
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed update examination',
                'status_code' => 500
            ]);
        }
    }

    public function deleteExamination(Request $request, $examinationId)
    {
        $examination = Examinations::findOrFail($examinationId);
        if ($examination) {
            $examination->delete();
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'success deleting examination data',
                    'status_code' => 200
                ]
            );
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed deleting examination data',
                'status_code' => 500
            ]);
        }
    }

    public function getDataModalitas(Request $request)
    {
        $modalitas = Modalitas::all();
        if ($modalitas) {
            return response()->json($modalitas);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed fetching data',
                'status_code' => 500
            ]);
        }
    }

    public function getDataDoseIndicators(Request $request)
    {
        $doseIndicators = DoseIndicators::all();
        if ($doseIndicators) {
            return response()->json($doseIndicators);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'failed fetching data',
                'status_code' => 500
            ]);
        }
    }
}
