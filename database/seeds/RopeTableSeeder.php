<?php

use Illuminate\Database\Seeder;

class RopeTableSeeder extends Seeder
{
    protected $table = 'rope';
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
        $aParam = array('Y0001', 'Y0002', 'Y0003');

        $aParam = array(
            0 => array(
                'city'        => 'Taipei',
                'rope_no'     => 'Y0001',
                'rope_status' => 1,
                'staff_info'  => array()
            ),
            1 => array(
                'city'        => 'Taipei',
                'rope_no'     => 'Y0002',
                'rope_status' => 2,
                'staff_info'  => array(
                    0 => array('_id' => 'xxx', 'username' => '1001'),
                    1 => array('_id' => 'xxx', 'username' => '1002'),
                )
            ),
            2 => array(
                'city'        => 'Taipei',
                'rope_no'     => 'Y0003',
                'rope_status' => 2,
                'staff_info'  => array(
                    0 => array('_id' => 'xxx', 'username' => '1003'),
                    1 => array('_id' => 'xxx', 'username' => '1004'),
                )
            ),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'city'        => $aVal['city'],
                'rope_no'     => $aVal['rope_no'],
                'rope_status' => $aVal['rope_status'],
                'staff_info'  => $aVal['staff_info'],
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }
}
