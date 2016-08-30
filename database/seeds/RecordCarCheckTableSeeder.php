<?php

use Illuminate\Database\Seeder;

class RecordCarCheckTableSeeder extends Seeder
{
    protected $table = 'record_car_check';
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
                'car_id'         => '',
                'car_no'         => 'ABV-0001',
                'car_brand_id'   => '',
                'brand_name'     => 'Honda',
                'normal_item'    => array('大燈是否都可正常點亮', '雨刷是否正常運作'),
                'abnormal_item'  => array('方向燈是否都可正常點亮'),
                'check_img'      => 'data:image/jpg;base64,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',
                'check_remark'   => '左邊異常',
                'create_user_no' => 'admin'
            ),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'car_id'         => $aVal['car_id'],
                'car_no'         => $aVal['car_no'],
                'car_brand_id'   => $aVal['car_brand_id'],
                'brand_name'     => $aVal['brand_name'],
                'normal_item'    => $aVal['normal_item'],
                'abnormal_item'  => $aVal['abnormal_item'],
                'check_img'      => $aVal['check_img'],
                'check_remark'   => $aVal['check_remark'],
                'create_date'    => $sTime,
                'create_user'    => $this->user,
                'create_user_no' => $aVal['create_user_no']
            ]);
        }
    }
}
