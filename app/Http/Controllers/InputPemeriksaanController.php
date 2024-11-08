<?php

namespace App\Http\Controllers;

use App\Models\DoseIndicators;
use App\Models\Modalitas;
use App\Models\Examinations;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables; 

class InputPemeriksaanController extends Controller
{
    public function index(Request $request)
    {
        $patients = Patients::all();
        $modalities = Modalitas::all(); 
        $doseIndicators = DoseIndicators::all(); 

        if ($request->ajax()) {
            $examinations = DB::table('examinations as e')
                ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
                ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
                ->join('patients as p', 'e.patient_id', '=', 'p.id')
                ->join('users as u', 'u.id', '=', 'e.created_by')
                ->select('p.name','p.nip', 'm.modalitas_name', 'di.dose_indicator_name', 'e.created_at', 'u.name as creator', 'e.id', 'e.dosis', 'e.tegangan' )
                ->whereNull('e.deleted_at');
            
            return DataTables::of($examinations)
            ->addIndexColumn()
            ->addColumn('modalitas_name', function ($row) {
                return  '<strong>' . $row->modalitas_name . '</strong><br>' .
                        'Indikator: '. $row->dose_indicator_name . '<br>' .
                        'Tegangan: ' . $row->tegangan . '<br>' .
                        'Dosis: ' . $row->dosis;
            })
            ->addColumn('created', function ($row) {
                return '<strong>Creator</strong>: ' . $row->creator . '<br>' .
                       '<strong>Created at</strong>: ' . $row->created_at;
            })
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-primary btn-sm editBtn" data-id="' . $row->id . '">Edit</button> 
                        <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row->id . '">Delete</button>';
            })
            ->rawColumns(['modalitas_name', 'created', 'action'])
            ->make(true);
            
        }
        
    
        return view('menu_input_pemeriksaan.index', compact('patients', 'modalities', 'doseIndicators'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
                        'patient_id' => 'required|numeric',
                        'modalitas_id' => 'required|numeric',
                        'dose_indicator_id' => 'required|numeric',
                        'tegangan' => 'required|numeric',
                        'dosis' => 'required|numeric',
                        // 'result' => 'nullable|string',
                        // 'note' => 'nullable|string',
                    ]);

        DB::beginTransaction();

        try {
            Examinations::create([
                'patient_id' => $validated['patient_id'],
                'modalitas_id' => $validated['modalitas_id'],
                'dose_indicator_id' => $validated['dose_indicator_id'],
                'tegangan' => $validated['tegangan'],
                'dosis' => $validated['dosis'],
                'created_by' => Auth::id(),
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

    public function edit(string $id)
    {
        $examination = Examinations::findOrFail($id);
        return response()->json($examination);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'modalitas_id' => 'required|exists:modalitas,id',
            'dose_indicator_id' => 'required|exists:dose_indicators,id',
            'tegangan' => 'required|numeric',
            'dosis' => 'required|numeric',
        ]);

        try {
            $examination = Examinations::findOrFail($id);
            $examination->update($validated);

            return response()->json(['message' => 'Data pemeriksaan berhasil diperbarui']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memperbarui data pemeriksaan'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $examination = Examinations::findOrFail($id);
            $examination->delete();

            return response()->json(['message' => 'Data pemeriksaan berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus data pemeriksaan'], 500);
        }
    }
}