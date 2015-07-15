<?php

use Illuminate\Database\Seeder;
use App\University;

class UniversityTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('universities')->delete();
        DB::table('university_university')->delete();

        $bu = University::create([
            'name'         => 'Boston University',
            'abbreviation' => 'BU',
            'email_suffix' => 'bu.edu',
            'is_public'    => true,
        ]);

        $mit = University::create([
            'name'         => 'Massachusetts Institute of Technology',
            'abbreviation' => 'MIT',
            'email_suffix' => 'mit.edu',
            'is_public'    => false,
        ]);

        $neu = University::create([
            'name'  => 'Northeastern University',
            'abbreviation'  => 'NEU',
            'email_suffix'  => 'neu.edu',
            'is_public'     => false,
        ]);

        $harvard = University::create([
            'name'  => 'Harvard University',
            'abbreviation'  => 'HARVARD',
            'email_suffix'  => 'harvard.edu',
            'is_public'     => false,
        ]);

        $bc = University::create([
            'name'  => 'Boston College',
            'abbreviation'  => 'BC',
            'email_suffix'  => 'bc.edu',
            'is_public'     => false,
        ]);

        $bu->addDeliverToUniversity($mit->id);
        $bu->addDeliverToUniversity($neu->id);
        $bu->addDeliverToUniversity($harvard->id);
        $bu->addDeliverToUniversity($bc->id);
    }

}
