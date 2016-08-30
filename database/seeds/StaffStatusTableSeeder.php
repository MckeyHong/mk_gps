<?php

use Illuminate\Database\Seeder;

class StaffStatusTableSeeder extends Seeder
{
    protected $table = 'staff_status';
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
        $aParam = array('調度', '休息', '加油');

        foreach ($aParam as $sVal) {
            DB::collection($this->table)->insert([
                'status_name' => $sVal,
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }

}
