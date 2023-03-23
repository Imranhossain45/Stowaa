<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {        
        $this->call([
          //RolesAndPermissionsSeeder::class,
          /* CategorySeeder::class,
          ColorSeeder::class,
          SizeSeeder::class,
          ProductSeeder::class, */
        ]);
    //User::factory(10)->create();
    } 
}