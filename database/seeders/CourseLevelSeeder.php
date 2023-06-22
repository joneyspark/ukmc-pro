<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Course\CourseLevel;

class CourseLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $string = "Diploma,Foundation,Grade 12,HNC/HND - Level 4 & 5,Level 3,Level 4,Level 5,Postgraduate,Postgraduate Research (PhD /DBA),Pre-Master's,Undergraduate";
        $array = explode(",",$string);
        foreach($array as $row){
            $data = CourseLevel::create([
                'title'=>$row,
            ]);
        }
    }
}
