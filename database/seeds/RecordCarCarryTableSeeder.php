<?php

use Illuminate\Database\Seeder;

class RecordCarCarryTableSeeder extends Seeder
{
    protected $table = 'record_car_carry';

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
                'city_name' => 'Taipei',
                'car_id' => '',
                'car_no' => 'ABV-001',
                'carry_num' => '20',
                'staff' => array(
                    0 => array('_id' => '', 'username' => '105001', 'users_name' => 'ricky'),
                    1 => array('_id' => '', 'username' => '105002', 'users_name' => 'bobo')
                ),
                'create_date' => strtotime('2015-11-18')
            ),
            1 => array(
                'city_name' => 'Taipei',
                'car_id' => '',
                'car_no' => 'ABV-001',
                'carry_num' => '30',
                'staff' => array(
                    0 => array('_id' => '', 'username' => '105001', 'users_name' => 'ricky'),
                    1 => array('_id' => '', 'username' => '105002', 'users_name' => 'bobo')
                ),
                'create_date' => strtotime('2015-11-19')
            ),
            2 => array(
                'city_name' => 'Taipei',
                'car_id' => '',
                'car_no' => 'ABV-001',
                'carry_num' => '38',
                'staff' => array(
                    0 => array('_id' => '', 'username' => '105001', 'users_name' => 'ricky'),
                    1 => array('_id' => '', 'username' => '105002', 'users_name' => 'bobo')
                ),
                'create_date' => strtotime('2015-11-20')
            ),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'city_name'   => $aVal['city_name'],
                'car_id'      => $aVal['car_id'],
                'car_no'      => $aVal['car_no'],
                'carry_num'   => $aVal['carry_num'],
                'staff'       => $aVal['staff'],
                'create_date' => $aVal['create_date']
            ]);
        }
    }
}
