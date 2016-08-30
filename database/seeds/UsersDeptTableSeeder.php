<?php

use Illuminate\Database\Seeder;

class UsersDeptTableSeeder extends Seeder
{
    protected $table = 'users_dept';
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
                'city'       => 'Taipei',
                'parent_id'  => '',
                'parent_arr' => array(),
                'dept_name'  => '台北市',
                'sort'       => 1,
                'staff_info' => array()
            ),
            1 => array(
                'city'       => 'NewTaipei',
                'parent_id'  => '',
                'parent_arr' => array(),
                'dept_name'  => '新北市',
                'sort'       => 2,
                'staff_info' => array()
            ),
            2 => array(
                'city'       => 'Taoyuan',
                'parent_id'  => '',
                'parent_arr' => array(),
                'dept_name'  => '桃園市',
                'sort'       => 3,
                'staff_info' => array()
            ),
            3 => array(
                'city'       => 'Taichung',
                'parent_id'  => '',
                'parent_arr' => array(),
                'dept_name'  => '台中市',
                'sort'       => 4,
                'staff_info' => array()
            ),
            4 => array(
                'city'       => 'Changhua',
                'parent_id'  => '',
                'parent_arr' => array(),
                'dept_name'  => '彰化縣',
                'sort'       => 5,
                'staff_info' => array()
            ),
        );

        foreach ($aParam as $aVal) {
            DB::collection($this->table)->insert([
                'city'        => $aVal['city'],
                'level'       => (int)1,
                'sort'        => (int)$aVal['sort'],
                'parent_id'   => $aVal['parent_id'],
                'parent_arr'  => $aVal['parent_arr'],
                'dept_name'   => $aVal['dept_name'],
                'staff_info'  => $aVal['staff_info'],
                'create_date' => $sTime,
                'create_user' => $this->user,
                'modify_date' => time(),
                'modify_user' => $this->user
            ]);
        }
    }
}
