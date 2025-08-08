<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
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
            DB::table('users')->truncate();
            $arrSelect = [
                'email',
                'userid',
                'username',
                'name_given',
                'name_family',
                'password',
                'usertype',
                'dept',
                'org',
                'address',
                'country',
                'joined_year',
                'joined_month',
                'joined_day',
                'joined_hour',
                'joined_minute',
                'joined_second',

            ];


        $sourceData = DB::table('pengguna as p1')
                    ->select($arrSelect)
                    ->where('email','!=','')
                    ->where('username','!=','')
                    ->whereNotNull('email')
                    ->whereNotNull('username')
                    ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pengguna as p2')
                        ->whereColumn('p2.email', 'p1.email')
                        ->where('p2.userid', '>', DB::raw('p1.userid'));
                    })
                    ->whereNotExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('pengguna as p2')
                        ->whereColumn('p2.username', 'p1.username')
                        ->where('p2.userid', '>', DB::raw('p1.userid'));
                    })

                    ->orderByRaw("CONCAT(email,'_',username) DESC")->get();

        $transformedData = $sourceData->map(function ($user) {
            return [
                'id' => $this->prefix_id.str_pad($user->userid, 6, '0', STR_PAD_LEFT),
                'eprint_userid' => $user->userid,
                'full_name' => $user->name_given.' '.$user->name_family,
                'username' => $user->username,
                'email' => $user->email,
                'password' => $user->password,
                'role' => $user->usertype,
                'organization' =>  $user->org,
                'departemen' => $user->dept,
                'country' => $user->country,
                'address' => $user->address,
                'created_at' => $user->joined_year.'-'.$user->joined_month.'-'.$user->joined_day.' '.$user->joined_hour.':'.$user->joined_month.':'.$user->joined_second
            ];
        })->toArray();
        $chunkSize = 1000;
        $chunks = array_chunk( $transformedData, $chunkSize);
        foreach ($chunks as $chunk) {
            $bulkInsertTransformedData = DB::table('users')->insert($chunk);
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
