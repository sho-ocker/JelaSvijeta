<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        for($i=0; $i<10; $i++){
            DB::table('categories')->insert([
                'title' => 'Naslov kategorije '.($i+1).' na HRV jeziku',
                'slug' => 'category-'.($i+1),
            ]);
        }
    }
}
