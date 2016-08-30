<?php

use Illuminate\Database\Seeder;

class StationAreaTableSeeder extends Seeder
{
    protected $table = 'station_area';
    protected $user = 'System';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection($this->table)->delete();
        $sTime = time();
        $aParam = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

        foreach ($aParam as $sVal) {
            DB::collection($this->table)->insert([
                'area_name'   => $sVal,
                'staff'       => array(),
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }
}
