<?php

namespace App\Http\Controllers;

use App\Models\DoseIndicators;
use App\Models\Modalitas;
use App\Models\User;
use App\Models\Examination; // Menambahkan model untuk Examination
use App\Models\Examinations;
use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables; 

class InputPemeriksaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Mendapatkan data pasien yang memiliki role 'patient'
        // $patients = User::role('patient')->get();
        $patients = Patients::all();
        // Mendapatkan semua modalitas dan dose indicators
        $modalities = Modalitas::all(); 
        $doseIndicators = DoseIndicators::all(); 

        if ($request->ajax()) {
            $examinations = DB::table('examinations as e')
                ->join('modalitas as m', 'e.modalitas_id', '=', 'm.id')
                ->join('dose_indicators as di', 'e.dose_indicator_id', '=', 'di.id')
                ->join('patients as p', 'e.patient_id', '=', 'p.id')
                ->join('users as u', 'u.id', '=', 'e.created_by')
                ->select('p.name', 'm.modalitas_name', 'di.dose_indicator_name', 'e.created_at', 'u.name as creator', 'e.id')
                ->whereNull('e.deleted_at');
            
            return DataTables::of($examinations)
                ->addIndexColumn() // Automatically add the row number column
                ->addColumn('action', function ($row) {
                    return '<button class="editBtn" data-id="' . $row->id . '">Edit</button> <button class="deleteBtn" data-id="' . $row->id . '">Delete</button>';
                })
                ->make(true);
        }
        
        // Mengirim data ke view
        return view('menu_input_pemeriksaan.index', compact('patients', 'modalities', 'doseIndicators'));
    }

    /**
     * Menyimpan data pemeriksaan baru.
     */
    public function store(Request $request)
    {
        // dd($request);
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

    /**
     * Mengambil data pemeriksaan untuk keperluan editing.
     */
    public function edit(string $id)
    {
        // Mengambil data pemeriksaan berdasarkan ID
        $examination = Examinations::findOrFail($id);
        
        // Mengembalikan data pemeriksaan dalam bentuk JSON
        return response()->json($examination);
    }

    /**
     * Memperbarui data pemeriksaan.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input
        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'modalitas_id' => 'required|exists:modalitas,id',
            'dose_indicator_id' => 'required|exists:dose_indicators,id',
            'tegangan' => 'required|numeric',
            'dosis' => 'required|numeric',
        ]);

        try {
            // Menemukan data pemeriksaan yang akan diupdate
            $examination = Examinations::findOrFail($id);

            // Memperbarui data pemeriksaan
            $examination->update($validated);

            return response()->json(['message' => 'Data pemeriksaan berhasil diperbarui']);
        } catch (\Exception $e) {
            // Menangani error dan mencatatnya ke log
            return response()->json(['error' => 'Gagal memperbarui data pemeriksaan'], 500);
        }
    }

    /**
     * Menghapus data pemeriksaan.
     */
    public function destroy(string $id)
    {
        try {
            // Menghapus data pemeriksaan berdasarkan ID
            $examination = Examinations::findOrFail($id);
            $examination->delete();

            return response()->json(['message' => 'Data pemeriksaan berhasil dihapus']);
        } catch (\Exception $e) {
            // Menangani error dan mencatatnya ke log
            return response()->json(['error' => 'Gagal menghapus data pemeriksaan'], 500);
        }
    }
}