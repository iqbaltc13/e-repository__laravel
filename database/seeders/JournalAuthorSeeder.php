<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use App\Models\JournalAuthor;
use Illuminate\Support\Str;


class JournalAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function __construct()
    {
        $this->prefix_id =  'migrasi_eprint_';

    }
    public function run()
    {
        DB::beginTransaction();
        try{
            JournalAuthor::truncate();
            $arrSelectCreatorsName = [
                'eprintid',
                'creators_name_family',
                'creators_name_given',
            ];
            $arrSelectCreatorsId = [

                'creators_id'
            ];


        $sourceData = DB::table('eprint_creators_id as eci')
                    ->join('eprint_creators_name', 'eci.eprintid', '=', 'eprint_creators_name.eprintid')
                    ->selectRaw('eci.creators_id as email, eprint_creators_name.eprintid as eprintid ,eprint_creators_name.creators_name_family as nama_belakang, eprint_creators_name.creators_name_given as nama_depan')
                    ->where('creators_id','!=','')
                    ->whereNotNull('creators_id')
                    ->orderByRaw("CONCAT(creators_id) DESC")->get();

        $transformedData = $sourceData->map(function ($creator) {
            return [
                'id' => 'AUTHOR_' . strtoupper(Str::random(8)),
                'email'   => $creator->email,
                'eprintid' => $creator->eprintid,
                'first_name' => $creator->nama_depan,
                'last_name' => $creator->nama_belakang,
                'journal_id' => $this->prefix_id.str_pad($creator->eprintid, 6, '0', STR_PAD_LEFT),

            ];
        })->toArray();
        $chunkSize = 1000;
        $chunks = array_chunk( $transformedData, $chunkSize);
        foreach ($chunks as $chunk) {
            $bulkInsertTransformedData = JournalAuthor::insert($chunk);
        }
            DB::commit();


        } catch (QueryException $e) {
            DB::rollback();

            Log::error('Query Exception:', [
                'message' => $e->getMessage(),
                'sql' => $e->getSql(),
                'bindings' => $e->getBindings(),
            ]);
            return false;
        }
    }
}
