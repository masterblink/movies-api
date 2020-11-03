<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use App\User;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        

        $faker = Faker::create();

    	foreach (range(1,10) as $index) {

            $user = User::inRandomOrder()->first();

	        DB::table('movies')->insert([
                'title' => $faker->sentence(4),
                'year' => $faker->year,
                'description' => $faker->sentence(8),
                'users_id' => $user->id
	        ]);
	    }
    }
}
