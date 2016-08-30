<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    protected $table = 'users';
    protected $user = 'System';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection('record_login')->delete();
        DB::collection($this->table)->delete();
        DB::collection($this->table)->insert([
            'username'     => 'admin',
            'users_name'   => '總管理者',
            'password'     => Hash::make('qwe123'),
            'enable_type'  => 1,
            'role_id'      => '56528b612081a96c428b4567',
            'dept_id'      => '',
            'city'         => array('Taipei', 'NewTaipei', 'Taoyuan', 'Taichung', 'Changhua'),
            'area'         => array(),
            'work_notice'  => '',
            'work_keynote' => array(),
            'api_key'      => '',
            'create_date'  => time(),
            'create_user'  => $this->user,
            'modify_date'  => time(),
            'modify_user'  => $this->user
        ]);
    }

}
