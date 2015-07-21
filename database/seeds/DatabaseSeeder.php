<?php

use Illuminate\Database\Seeder;
use App\Roles;
use App\Users;
use App\Style;
use App\Madein;
use App\Height;
use App\Selloff;
use App\Material;
use App\Category;
use App\Color;
use App\Size;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker\Factory::create();

        /**
         * For User
         */
        Users::create([
            "email"          => $faker->email,
            "password"       => bcrypt('123456'),
            "username"       => 'phamkhien',
            "phone"          => $faker->phoneNumber,
            "status"         => 1,
            "role_id"        => 1,
            "avatar"         => '12121',
            "remember_token" => 'asdasdas',
        ]);
        Users::create([
            "email"          => $faker->email,
            "password"       => bcrypt('123456'),
            "username"       => 'admin',
            "phone"          => $faker->phoneNumber,
            "status"         => 1,
            "role_id"        => 1,
            "avatar"         => '12121',
            "remember_token" => 'asdasdas',
        ]);
        for ($i = 0; $i < 200; $i++) {
            Users::create([
                "email"          => $faker->email,
                "password"       => $faker->password,
                "username"       => $faker->userName,
                "yourname"       => $faker->lastName,
                "phone"          => $faker->phoneNumber,
                "status"         => 0,
                "role_id"        => $faker->numberBetween(1, 3),
                "avatar"         => '12121',
                "remember_token" => 'asdasdas',
            ]);

        }

        /**
         * For Catetory
         */
        Category::create([
            "category_name" => "Giay Nam",
            'parent'        => 0,
        ]);
        Category::create([
            "category_name" => "Giay nu",
            'parent'        => 0,
        ]);
        Category::create([
            "category_name" => "Giay kiti",
            'parent'        => 2,
        ]);
        Category::create([
            "category_name" => "Giay kute",
            'parent'        => 2,
        ]);




    }

}

class RolesTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('roles')->delete();

        Roles::create(array('rolename' => 'admin'));
        Roles::create(array('rolename' => 'member'));
        Roles::create(array('rolename' => 'seller'));
    }

}

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->delete();


    }

}

