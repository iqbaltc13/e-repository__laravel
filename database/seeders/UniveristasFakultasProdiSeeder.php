<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class UniveristasFakultasProdiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function __construct()
    {
        $this->arrData =  [
            'institutions'=>[
                [

                    'id'   => 'institution_1',
                    'institution_code' => 'INS_1',
                    'institution_name' => 'Universitas',
                    'address' => 'Address',
                    'kota' => 'Kota',
                    'provinsi' => 'Provinsi',
                    'kode_pos' => '12345',
                    'phone' => '1234567890',
                    'email' => 'email@example.com',
                    'website' => 'https://www.example.com',
                    'status' => 'aktif',
                    'faculties'=> [
                                    [
                                        'id'=>'faculty_1',
                                        'institution_code'=>'INS_1',
                                        'faculty_code'=>'FAC_1',
                                        'faculty_name'=>'Fakultas',
                                        'deskripsi'=>'Fakultas',
                                        'head_name'=>'NULL',
                                        'email'=>'email@example.com',
                                        'telepon'=>'1234567890',
                                        'status'=>'aktif',
                                        'prodies'=> [
                                            [
                                                'id'=>'prodi_1',
                                                'institution_code'=>'INS_1',
                                                'faculty_code'=>'FAC_1',
                                                'department_code'=>'PRODI_1',
                                                'department_name'=>'Prodi 1',
                                                'jenjang'=>'S1',
                                                'akreditasi'=>'A',
                                                'deskripsi'=>'Prodi',
                                                'head_name'=>'NULL',
                                                'kapasitas_mahasiswa'=>0,
                                                'email'=>'email@example.com',

                                            ],
                                        ],

                                    ],
                                ],

                ],

            ]
        ];
    }

    public function run()
    {
        ini_set('memory_limit', '1024M');
        DB::beginTransaction();
        try{
            DB::table('institutions')->truncate();
            DB::table('faculties')->truncate();
            DB::table('departments')->truncate();
            foreach ($this->arrData['institutions'] as $key => $value) {
                Institution::create([
                    'id'=>$value['id'],
                    'institution_code'=>$value['institution_code'],
                    'institution_name'=>$value['institution_name'],
                    'address'=>$value['address'],
                    'kota'=>$value['kota'],
                    'provinsi'=>$value['provinsi'],
                    'kode_pos'=>$value['kode_pos'],
                    'phone'=>$value['phone'],
                    'email'=>$value['email'],
                    'website'=>$value['website'],
                    'status'=>$value['status'],
                ]);
                foreach ($value['faculties'] as $key => $value) {
                    Faculty::create([
                        'id'=>$value['id'],
                        'institution_code'=>$value['institution_code'],
                        'faculty_code'=>$value['faculty_code'],
                        'faculty_name'=>$value['faculty_name'],
                        'deskripsi'=>$value['deskripsi'],
                        'head_name'=>$value['head_name'],
                        'email'=>$value['email'],
                        'phone'=>$value['telepon'],
                        'status'=>$value['status'],
                    ]);
                    foreach ($value['prodies'] as $key => $value) {
                        Department::create([
                            'id'=>$value['id'],
                            'institution_code'=>$value['institution_code'],
                            'faculty_code'=>$value['faculty_code'],
                            'department_code'=>$value['department_code'],
                            'department_name'=>$value['department_name'],
                            'jenjang'=>$value['jenjang'],
                            'akreditasi'=>$value['akreditasi'],
                            'deskripsi'=>$value['deskripsi'],
                            'head_name'=>$value['head_name'],
                            'kapasitas_mahasiswa'=>$value['kapasitas_mahasiswa'],
                            'email'=>$value['email'],
                        ]);
                    }
                }

            }
            DB::commit();
        }catch(QueryException $e){
            DB::rollBack();
            Log::error('Query Exception:', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
            return false;
        }
        //

    }
}
