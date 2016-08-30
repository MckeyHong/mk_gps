<?php

use Illuminate\Database\Seeder;

class CarSpeedTableSeeder extends Seeder
{
    protected $table = 'car_speed';
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
            0 => array('road_type' => 'general', 'speed_min' => 0, 'speed_max' => '50'),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                '_id'         => new MongoId('5645912c2081a9470b8b4568'),
                'road_type'   => $aVal['road_type'],
                'speed_min'   => $aVal['speed_min'],
                'speed_max'   => $aVal['speed_max'],
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }

}
