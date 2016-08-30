<?php

use Illuminate\Database\Seeder;

class MaintainUnitTableSeeder extends Seeder
{
    protected $table = 'maintain_unit';
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
        $aParam = array('個', '片', '條', '箱', '綑', '顆');

        foreach ($aParam as $sVal) {
            DB::collection($this->table)->insert([
                'unit_name'   => $sVal,
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => $sTime,
                'modify_user' => $this->user
            ]);
        }
    }

}
