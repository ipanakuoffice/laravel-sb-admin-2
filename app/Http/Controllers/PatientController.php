<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('menu_patient.index');
    }

    public function getData(Request $request)
    {
        $patients = DB::table('patients')
            ->orderBy('updated_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->whereNull('deleted_at')
            ->get();
        return response()->json($patients);
    }

    public function addPatient(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'gender' => 'required|string|max:10',
        ]);

        DB::beginTransaction();

        try {
            DB::table('patients')->insert([
                'name' => $request->input('name'),
                'date_of_birth' => $request->input('date_of_birth'),
                'height' => $request->input('height'),
                'weight' => $request->input('weight'),
                'gender' => $request->input('gender'),
                'created_at' => now(),
                'updated_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Patient added successfully',
                'status_code' => 200,
                'error_code' => 0

            ]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status' => 'failed ',
                'message' => 'Add Patient Failed',
                'status_code' => 500,
                'error_code' => 1,
                'error_message' => $e->getMessage(),
            ]);
        };
    }

    public function editPatient(Request $request, $patientId)
    {
        $patient = DB::table('patients')->where('id', $patientId)->first();

        if ($patient) {
            return response()->json($patient);
        }

        return response()->json(['message' => 'Patient not found'], 404);
    }

    public function updatePatient(Request $request, $patientId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'gender' => 'required|string|max:10',
        ]);

        $patient = Patients::findOrFail($patientId);
        $patient->update($request->all());
        return response()->json(['status' => 'success', 'message' => 'Patient updated successfully']);
    }

    public function deletePatient($patientId)
    {
        $patient = Patients::find($patientId);
        if ($patient) {
            $patient->delete();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error'], 404);
    }
}
