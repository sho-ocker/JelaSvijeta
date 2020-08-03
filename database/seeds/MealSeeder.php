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
    public function run(){                           //SEEDANJE FAKE PODACIMA
    
        for($i=1; $i<25; $i++){
            $r = random_int('1', '10');
            $s = random_int('1', '10');         
            $t = random_int('1', '10');

            $cat = random_int('0', '1');
            $tag = random_int('1', '3');
            $ing = random_int('1', '3');
            

            
            

            if($cat == 1){

                    if($tag == 1){                      //TAGOVI
                        $ran1 = random_int(1,10);
                        $tago = array([
                            'id' => $ran1, 
                            'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ]);
                    }elseif($tag == 2){
                        $ran1 = random_int(1,10);
                        $ran2 = random_int(1,10);

                        $tago = array([
                            'id' => $ran1, 
                            'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ],[
                            'id' => $ran2,
                            'title' =>'Naslov taga '.$ran2.' na HRV jeziku',
                            'slug' => 'tag-'.$ran2,
                        ]);
                    }else{
                        $ran1 = random_int(1,10);
                        $ran2 = random_int(1,10);
                        $ran3 = random_int(1,10);
                        
                        $tago = array([
                            'id' => $ran1, 
                            'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ],[
                            'id' => $ran2,
                            'title' =>'Naslov taga '.$ran2.' na HRV jeziku',
                            'slug' => 'tag-'.$ran2,
                        ],[
                            'id' => $ran3,
                            'title' =>'Naslov taga '.$ran3.' na HRV jeziku',
                            'slug' => 'tag-'.$ran3,
                        ]);
                    }


                    if($ing == 1){                          //SASTOJCI
                        $ran1 = random_int(1,10);
                        $ingo = array([
                            'id' => $ran1, 
                            'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ]);
                    }elseif($ing == 2){
                        $ran1 = random_int(1,10);
                        $ran2 = random_int(1,10);

                        $ingo = array([
                            'id' => $ran1, 
                            'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ],[
                            'id' => $ran2,
                            'title' =>'Naslov sastojka '.$ran2.' na HRV jeziku',
                            'slug' => 'tag-'.$ran2,
                        ]);
                    }else{
                        $ran1 = random_int(1,10);
                        $ran2 = random_int(1,10);
                        $ran3 = random_int(1,10);
                        
                        $ingo = array([
                            'id' => $ran1, 
                            'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                            'slug' => 'tag-'.$ran1,
                        ],[
                            'id' => $ran2,
                            'title' =>'Naslov sastojka '.$ran2.' na HRV jeziku',
                            'slug' => 'tag-'.$ran2,
                        ],[
                            'id' => $ran3,
                            'title' =>'Naslov sastojka '.$ran3.' na HRV jeziku',
                            'slug' => 'tag-'.$ran3,
                        ]);
                    }


                    DB::table('meals')->insert([
                    'title' => 'Naslov jela na HRV jeziku',
                    'description' => 'Opis jela na HRV jeziku',
                    'category' => json_encode([
                        'id' => $r,
                        'title' => 'Naslov kategorije '.$r.' na HRV jeziku',
                        'slug' => 'category-'.$r,
                    ]),
                    'tags' => json_encode($tago), 
                    'ingredients' => json_encode($ingo)
                    ]); 
            }
            else{   
                if($tag == 1){
                    $ran1 = random_int(1,10);
                    $tago = array([
                        'id' => $ran1, 
                        'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ]);
                }elseif($tag == 2){
                    $ran1 = random_int(1,10);
                    $ran2 = random_int(1,10);

                    $tago = array([
                        'id' => $ran1, 
                        'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ],[
                        'id' => $ran2,
                        'title' =>'Naslov taga '.$ran2.' na HRV jeziku',
                        'slug' => 'tag-'.$ran2,
                    ]);
                }else{
                    $ran1 = random_int(1,10);
                    $ran2 = random_int(1,10);
                    $ran3 = random_int(1,10);
                    
                    $tago = array([
                        'id' => $ran1, 
                        'title' =>'Naslov taga '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ],[
                        'id' => $ran2,
                        'title' =>'Naslov taga '.$ran2.' na HRV jeziku',
                        'slug' => 'tag-'.$ran2,
                    ],[
                        'id' => $ran3,
                        'title' =>'Naslov taga '.$ran3.' na HRV jeziku',
                        'slug' => 'tag-'.$ran3,
                    ]);
                }


                if($ing == 1){                          //SASTOJCI
                    $ran1 = random_int(1,10);
                    $ingo = array([
                        'id' => $ran1, 
                        'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ]);
                }elseif($ing == 2){
                    $ran1 = random_int(1,10);
                    $ran2 = random_int(1,10);

                    $ingo = array([
                        'id' => $ran1, 
                        'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ],[
                        'id' => $ran2,
                        'title' =>'Naslov sastojka '.$ran2.' na HRV jeziku',
                        'slug' => 'tag-'.$ran2,
                    ]);
                }else{
                    $ran1 = random_int(1,10);
                    $ran2 = random_int(1,10);
                    $ran3 = random_int(1,10);
                    
                    $ingo = array([
                        'id' => $ran1, 
                        'title' =>'Naslov sastojka '.$ran1.' na HRV jeziku',    
                        'slug' => 'tag-'.$ran1,
                    ],[
                        'id' => $ran2,
                        'title' =>'Naslov sastojka '.$ran2.' na HRV jeziku',
                        'slug' => 'tag-'.$ran2,
                    ],[
                        'id' => $ran3,
                        'title' =>'Naslov sastojka '.$ran3.' na HRV jeziku',
                        'slug' => 'tag-'.$ran3,
                    ]);
                }


                    DB::table('meals')->insert([
                        'title' => 'Naslov jela na HRV jeziku',
                        'description' => 'Opis jela na HRV jeziku',
                        'category' => json_encode(null),
                        'tags' => json_encode($tago),
                        'ingredients' => json_encode($ingo)
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
            }   
            
            $faker = Faker\Factory::create();
            $faker->addProvider(new \FakerRestaurant\Provider\hr_HR\Restaurant($faker));



            for($i=0; $i<10; $i++){
                DB::table('meals')->insert([
                    'title' => $faker->foodName,
                    'description' => '',
                    'category' => json_encode(null),
                    'tags' => json_encode(null), 
                    'ingredients' => json_encode(null)
                    ]); 
            }   */
        }
    }
}
