<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Roles;
use App\Users;
class DatabaseSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 200; $i++)
        {
            Users::create([
                "email" => $faker->email,
                "password" => $faker->password,
                "username" => $faker->userName,
                "phone" => $faker->phoneNumber,
                "status" => 0,
                "role_id" => $faker->numberBetween(1,3),
                "avatar" => '12121',
                "remember_token" => 'asdasdas',
            ]);

        }
        for ($i = 0; $i < 3; $i++)
        {
            Roles::create([
                "rolename" => $faker->userName,
            ]);

        }

    }

}

class RolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('roles')->delete();

        Roles::create(array('rolename' => 'admin'));
        Roles::create(array('rolename' => 'member'));
        Roles::create(array('rolename' => 'seller'));
    }

}
class UsersTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();



    }

}

