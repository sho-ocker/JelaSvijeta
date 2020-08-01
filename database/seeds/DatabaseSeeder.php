<?php

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
            MealSeeder::class,
            CategorySeeder::class,
            IngredientSeeder::class,
            TagSeeder::class,
        ]);        
    }
}
