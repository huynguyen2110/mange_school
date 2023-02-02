<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Utils\Base;
use Carbon\Carbon;
use Faker\Generator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

        for ($i = 0; $i < 1; $i++) {
            $dataSeeders = [
                [
                    'uuid' => Base::generateUuid('user'),
                    'name' => 'user'.$i,
                    'email' => 'huy1@gmail.com',
                    'role' => '0',
                    'phone' => $faker->phoneNumber,
                    'password' => Hash::make('password'),
                ],
            ];
            DB::table('users')->insert($dataSeeders);
        }

    }
}
