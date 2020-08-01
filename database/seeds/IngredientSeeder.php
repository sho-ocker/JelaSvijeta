<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<10; $i++){
            DB::table('ingredients')->insert([
                'title' => 'Naslov sastojka '.$i,
                'slug' => 'sastojak-'.$i,
            ]);
        }
    }
}
