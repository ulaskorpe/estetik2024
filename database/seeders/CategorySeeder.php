<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::withoutEvents(function(){

        $faker = \Faker\Factory::create();

        for($i=0;$i<10;$i++){
            $name = $faker->country();
            Category::create([
                'name'=>$name,
                'slug'=>$this->createSlug($name),
                'icon'=>"",
                'description'=>$faker->sentence(),
                'parent_id'=>0,
                'rank'=>$i+1
            ]);
        }

    });
    
    }

    private function createSlug($string) {
        // Convert accented characters to their non-accented counterparts
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        
        // Replace non-alphanumeric characters with dashes
        $string = preg_replace('/[^a-zA-Z0-9\-]/', '-', $string);
        
        // Remove any consecutive dashes
        $string = preg_replace('/-+/', '-', $string);
        
        // Remove leading/trailing dashes
        $string = trim($string, '-');
        
        // Convert string to lowercase
        $string = strtolower($string);
        
        return $string;
    }

   
}
