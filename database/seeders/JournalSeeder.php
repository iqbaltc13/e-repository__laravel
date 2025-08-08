<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Journal;
use App\Models\JournalAuthor;
use App\Models\User;

class JournalSeeder extends Seeder
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
            DB::table('journals')->truncate();
            $arrSelect = [
                'eprintid',
                'userid',
                'fileinfo',
                'lastmod_year',
                'lastmod_month',
                'lastmod_day',
                'lastmod_hour',
                'lastmod_minute',
                'lastmod_second',
                'datestamp_year',
                'datestamp_month',
                'datestamp_day',
                'datestamp_hour',
                'datestamp_minute',
                'datestamp_second',
                'rev_number',
                'title',
                'abstract',
                'institution',
                'eprint_status',
                'issn',
                'number',
                'volume'

            ];


        $sourceData = DB::table('eprint')
                    ->select($arrSelect)
                    ->whereNotNull('last')
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->whereNotNull()
                    ->where('type','thesis')
                    ->get();

        $transformedData = $sourceData->map(function ($journal) {
            return [
                'id' => $this->prefix_id.str_pad($journal->eprintid, 6, '0', STR_PAD_LEFT),
                'eprintid' => $journal->eprintid,
                'volume' => $journal->volume,
                'issue' => $journal->number,
                'issn' => $journal->issn,
                'status' => $journal->eprint_status,
                'institution' => $journal->institution,
                'abstract' =>  $journal->abstract,
                'journal_name' => $journal->title,
                'author_id' => $this->prefix_id.str_pad($journal->userid, 6, '0', STR_PAD_LEFT),
                'pdf_file' => $journal->fileinfo,
                'other_document_file' => $journal->fileinfo,
                'revision_number' => $journal->rev_number,
                'updated_at' => $journal->lastmod_year.'-'.$journal->lastmod_month.'-'.$journal->lastmod_day.' '.$journal->lastmod_hour.':'.$journal->lastmod_month.':'.$journal->lastmod_second,
                'publication_date' => $journal->datestamp_year.'-'.$journal->datestamp_month.'-'.$journal->datestamp_day.' '.$journal->datestamp_hour.':'.$journal->datestamp_month.':'.$journal->datestamp_second,
            ];
        })->toArray();
        $chunkSize = 1000;
        $chunks = array_chunk( $transformedData, $chunkSize);
        foreach ($chunks as $chunk) {
            $bulkInsertTransformedData = DB::table('journals')->insert($chunk);
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
