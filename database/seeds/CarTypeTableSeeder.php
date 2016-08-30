<?php

use Illuminate\Database\Seeder;

class CarTypeTableSeeder extends Seeder
{
    protected $table = 'car_type';
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
        $aParam = array('調度車', '貨車', '機車');

        foreach ($aParam as $sVal) {
            DB::collection($this->table)->insert([
                'car_type'    => $sVal,
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }

}
