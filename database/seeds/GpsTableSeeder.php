<?php

use Illuminate\Database\Seeder;

class GpsTableSeeder extends Seeder
{
    protected $table = 'gps';
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
                'gps_no'             => 'gps001',
                'cellphone'          => '0988123456',
                'cellphone_provider' => '中華電信',
                'city'               => 'Taipei'
            ),
            1 => array(
                'gps_no'             => 'gps002',
                'cellphone'          => '0988987654',
                'cellphone_provider' => '中華電信',
                'city'               => 'Taipei'
            ),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'gps_no'             => $aVal['gps_no'],
                'cellphone'          => $aVal['cellphone'],
                'cellphone_provider' => $aVal['cellphone_provider'],
                'city'               => $aVal['city'],
                'car_id'             => '',
                'create_date'        => $sTime,
                'create_user'        => $this->user,
                'modify_date'        => $sTime,
                'modify_user'        => $this->user
            ]);
        }
    }

}
