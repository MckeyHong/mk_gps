<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /* 必須填充 */
        $this->call(UsersTableSeeder::class);
        $this->call(UsersRoleTableSeeder::class);
        $this->call(CarSpeedTableSeeder::class);
        $this->call(UsersDeptTableSeeder::class);

        /* 非必須填充 */
        $this->call(GpsAreaTableSeeder::class);
        $this->call(CarTypeTableSeeder::class);
        $this->call(GpsTableSeeder::class);
        $this->call(WorkStatusTableSeeder::class);
        $this->call(StaffStatusTableSeeder::class);
        $this->call(CarBrandTableSeeder::class);
        $this->call(CarTableSeeder::class);
        $this->call(StationAreaTableSeeder::class);
        $this->call(MaintainUnitTableSeeder::class);
        $this->call(ShiftsInfoTableSeeder::class);
        $this->call(RopeTableSeeder::class);

        /* 紀錄 */
        $this->call(CarAbnormalTableSeeder::class);
        $this->call(RecordCarCheckTableSeeder::class);
        $this->call(RecordCarCarryTableSeeder::class);

        Model::reguard();
    }
}
