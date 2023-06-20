<?php

namespace Database\Seeders;

use App\Models\Application\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $string = "New,Elt or Interview Passed,Conditional Offer,Unconditional Offer,Enrolled,Rejected";
        $array = explode(",",$string);
        foreach($array as $row){
            $data = Status::create([
                'title'=>$row,
            ]);
        }
    }
}
