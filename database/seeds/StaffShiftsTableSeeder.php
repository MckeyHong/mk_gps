<?php

use Illuminate\Database\Seeder;

class StaffShiftsTableSeeder extends Seeder
{
    protected $table = 'staff_shifts';
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
            0 => array(
                'user_id'    => '565401fe2081a94d3f8b4567',
                'shift_name' => '日班'
            ),
        );

        for($day = 1 ; $day <= date('t'); $day++) {
            $sDate = date('Y-m').'-'.sprintf('%02d', $day);
            foreach ($aParam as $aVal) {
                DB::collection($this->table)->insert([
                    'user_id'     => $aVal['user_id'],
                    'shift_date'  => strtotime($sDate),
                    'shift_name'  => $aVal['shift_name'],
                    'create_date' => $sTime,
                    'create_user' => $this->user,
                    'modify_date' => $sTime,
                    'modify_user' => $this->user
                ]);
            }
        }
    }
}
