<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CarBrandTableSeeder extends Seeder
{
    protected $table = 'car_brand';
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
            'Toyota' => array('大燈是否都可正常點亮', '方向燈是否正常運作'),
            'NISSAN' => array('大燈是否都可正常點亮', '方向燈是否正常運作'),
            'Honda'  => array('大燈是否都可正常點亮', '方向燈是否正常運作'),
        );

        foreach ($aParam as $sKey => $aVal) {
            DB::collection($this->table)->insert([
                'brand_name'  => $sKey,
                'check_item'  => $aVal,
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }
}
