<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
    public function getUniversitas(): JsonResponse
    {
        try {
            $universitas = Institution::select('institution_code', 'institution_name')
                ->where('status', 'aktif')
                ->orderBy('institution_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data universitas berhasil dimuat',
                'data' => $universitas
            ], 200);

        } catch (Exception $e) {
            Log::error('Error loading universitas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data universitas',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function getFakultas(Request $request): JsonResponse
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'institution_code' => 'required|string|max:10'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kode universitas tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $universitasCode = $request->input('institution_code');

            // Validasi universitas exists
            $universitas = Institution::where('institution_code', $universitasCode)
                ->where('status', 'aktif')
                ->first();

            if (!$universitas) {
                return response()->json([
                    'success' => false,
                    'message' => 'Universitas tidak ditemukan atau tidak aktif'
                ], 404);
            }

            $fakultas = Faculty::select('faculty_code', 'faculty_name', 'deskripsi')
                ->where('institution_code', $universitasCode)
                ->where('status', 'aktif')
                ->orderBy('faculty_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data fakultas berhasil dimuat',
                'data' => $fakultas,
                'universitas' => $universitas->name
            ], 200);

        } catch (Exception $e) {
            Log::error('Error loading fakultas: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data fakultas',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    public function getProdi(Request $request): JsonResponse
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'institution_code' => 'required|string|max:10',
                'faculty_code' => 'required|string|max:20'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Parameter tidak valid',
                    'errors' => $validator->errors()
                ], 422);
            }

            $universitasCode = $request->input('institution_code');
            $facultyCode = $request->input('faculty_code');

            // Validasi fakultas exists
            $faculty = Faculty::where('faculty_code', $facultyCode)
                ->where('institution_code', $universitasCode)
                ->where('status', 'aktif')
                ->first();

            if (!$faculty) {
                return response()->json([
                    'success' => false,
                    'message' => 'Fakultas tidak ditemukan atau tidak aktif'
                ], 404);
            }

            $prodi = Department::select('department_code', 'department_name', 'jenjang', 'akreditasi')
                ->where('institution_code', $universitasCode)
                ->where('faculty_code', $facultyCode)
                ->where('status', 'aktif')
                ->orderBy('department_name', 'asc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data program studi berhasil dimuat',
                'data' => $prodi,
                'faculty' => $faculty->name
            ], 200);

        } catch (Exception $e) {
            Log::error('Error loading prodi: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data program studi',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

}
