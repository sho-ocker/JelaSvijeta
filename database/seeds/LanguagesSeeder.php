  
<?php

use App\Language;
use Illuminate\Database\Seeder;


class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Language::count() == 0) {
        	
    		$defLanguages = array('hr','en','de','es','ru');

        	foreach ($defLanguages as $language) {
	        	Language::create([
	        		'lang' => $language
	        	]);
            }
    	}
    }
}