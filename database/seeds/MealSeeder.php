<?php

use App\Meal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()       //SEEDANJE FAKE PODACIMA
    {
        for($i=1; $i<25; $i++){
            $r = random_int('1', '10');
            $s = random_int('1', '10');         
            $t = random_int('1', '10');

            $cat = random_int('0', '1');
            $tag = random_int('1', '3');
            $ing = random_int('1', '3');

            
            

            if($cat == 1){
                    DB::table('meals')->insert([
                    'title' => 'Naslov jela na HRV jeziku',
                    'description' => 'Opis jela na HRV jeziku',
                    'category' => json_encode([
                        'id' => $r,
                        'title' => 'Naslov kategorije '.$r.' na HRV jeziku',
                        'slug' => 'category-'.$r,
                    ]),
                    'tags' => json_encode([
                        'id' => $s,
                        'title' =>'Naslov taga '.$s.' na HRV jeziku',
                        'slug' => 'tag-'.$s,
                    ]), 
                    'ingredients' => json_encode([
                        'id' => $t,
                        'title' => 'Naslov sastojka '.$t.' na HRV jeziku',
                        'slug' => 'sastojak-'.$t,
                    ])
                    ]); 
            }
            else{   
                    DB::table('meals')->insert([
                        'title' => 'Naslov jela na HRV jeziku',
                        'description' => 'Opis jela na HRV jeziku',
                        'category' => json_encode(null),
                        'tags' => json_encode([
                            'id' => $s,
                            'title' =>'Naslov taga '.$s.' na HRV jeziku',
                            'slug' => 'tag-'.$s,
                        ]),
                        'ingredients' => json_encode([
                            'id' => $t,
                            'title' => 'Naslov sastojka '.$t.' na HRV jeziku',
                            'slug' => 'sastojak-'.$t,
                        ])
                        ]);
            } 

           /*  for($j = 0; $j < $tag; $j++){
                $s = random_int('1', '10');         
                DB::table('meals')->insert([
                'title',
                'description',
                'category',
                'tags' => json_encode([                             //NEJE DOBRO
                    'id' => $s,
                    'title' =>'Naslov taga '.$s.' na HRV jeziku',
                    'slug' => 'tag-'.$s,
                ]),
                'ingredients',
            ]);
            }   */
            
            
        }
    }
}
