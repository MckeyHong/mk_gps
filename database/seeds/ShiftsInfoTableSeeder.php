<?php

use Illuminate\Database\Seeder;

class ShiftsInfoTableSeeder extends Seeder
{
    protected $table = 'shifts_info';
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
        $aParam = array(
            0 => array('shift_name' => '早班', 'shift_start_time' => '07:00', 'shift_end_time' => '15:00'),
            1 => array('shift_name' => '晚班', 'shift_start_time' => '15:00', 'shift_end_time' => '23:00'),
            2 => array('shift_name' => '大夜班', 'shift_start_time' => '23:00', 'shift_end_time' => '07:00'),
        );
        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'shift_name'       => $aVal['shift_name'],
                'shift_start_time' => $aVal['shift_start_time'],
                'shift_end_time'   => $aVal['shift_end_time'],
                'create_date'      => $sTime,
                'create_user'      => $this->user,
                'modify_date'      => $sTime,
                'modify_user'      => $this->user
            ]);
        }
    }

}

