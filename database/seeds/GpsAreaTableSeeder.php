<?php

use Illuminate\Database\Seeder;

class GpsAreaTableSeeder extends Seeder
{
    protected $table = 'gps_area';
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
            'Taipei'    => array('中正', '大同', '中山', '松山', '大安', '萬華'),
            'NewTaipei' => array('三重', '中和', '林口', '板橋', '金山', '烏來'),
            'Taichung'  => array('西屯', '西區', '東區', '中區', '南屯', '南區'),
        );

        foreach ($aParam as $sCity => $aVal) {
            foreach ($aVal as $sStation) {
                foreach (array('A', 'B', 'C', 'D', 'E') as $sArea) {
                    # code...
                    DB::collection($this->table)->insert([
                        'city'           => $sCity,
                        'belong_station' => $sStation,
                        'belong_area'    => $sArea,
                        'create_date'    => $sTime,
                        'create_user'    => $this->user,
                        'modify_date'    => $sTime,
                        'modify_user'    => $this->user
                    ]);
                }
            }
        }
    }

}
