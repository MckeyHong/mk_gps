<?php

use Illuminate\Database\Seeder;

class UsersRoleTableSeeder extends Seeder
{
    protected $table = 'users_role';
    protected $user = 'System';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::collection($this->table)->delete();
        DB::collection($this->table)->insert([
            '_id'            => new MongoId('56528b612081a96c428b4567'),
            'role_name'      => '最高權限',
            'role_privilege' => array(),
            'create_date'    => time(),
            'create_user'    => $this->user,
            'modify_date'    => time(),
            'modify_user'    => $this->user
        ]);
    }
}
