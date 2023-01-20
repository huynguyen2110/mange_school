<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Utils\Base;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);
//        $arrayRole = UserRole::getValue();

        for ($i = 0; $i < 300; $i++) {
            $dataSeeders = [
                [
                    'uuid' => Base::generateUuid('user'),
                    'name' => 'user'.$i,
                    'email' => $faker->unique()->safeEmail(),
                    'role' => '2',
                    'phone' => $faker->phoneNumber,
                    'password' => '12345678',
                ],
            ];
            DB::table('users')->insert($dataSeeders);
        }

    }
}
