<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<10; $i++){
            DB::table('tags')->insert([
                'title' => 'Naslov taga '.$i.' na HRV jeziku',
                'slug' => 'tag-'.$i,
            ]);
        }
    }
}
