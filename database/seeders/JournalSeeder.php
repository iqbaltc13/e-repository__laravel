<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\QueryException;

class JournalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        DB::beginTransaction();
        try{
            DB::commit();

        //     // all good
        } catch (QueryException $e) {
            DB::rollback();

            return false;
        }
    }
}
