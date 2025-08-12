<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class JournalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function __construct()
    {
        $this->arrData =  [
            [
                'id'   => 'category_1',
                'name' => 'Journal Category 1',
                'slug' => 'journal-category-1',
                'parent' => null,
                'description' => 'Journal Category 1 Description',
            ],
            [
                'id'   => 'sub_category_1',
                'name' => 'Journal Sub Category 1',
                'slug' => 'journal-sub-category-1',
                'parent' => 'category_1',
                'description' => 'Journal Sub Category 1 Description',
            ],
        ];
    }

    public function run()
    {
        ini_set('memory_limit', '1024M');

        DB::beginTransaction();
        try{
            DB::table('journal_categories')->truncate();
            DB::table('journal_categories')->insert($this->arrData);
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
