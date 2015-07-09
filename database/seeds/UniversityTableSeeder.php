<?php

use Illuminate\Database\Seeder;
use App\University;

class UniversityTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('universities')->delete();

        University::create([
            'name'         => 'Boston University',
            'abbreviation' => 'BU',
            'email_suffix' => 'bu.edu',
            'is_public'    => true,
        ]);

        University::create([
            'name'         => 'Massachusetts Institute of Technology',
            'abbreviation' => 'MIT',
            'email_suffix' => 'mit.edu',
            'is_public'    => false,
        ]);

        University::create([
            'name'  => 'Northeastern University',
            'abbreviation'  => 'NEU',
            'email_suffix'  => 'neu.edu',
            'is_public'     => false,
        ]);

        University::create([
            'name'  => 'Harvard University',
            'abbreviation'  => 'HARVARD',
            'email_suffix'  => 'harvard.edu',
            'is_public'     => false,
        ]);

        University::create([
            'name'  => 'Boston College',
            'abbreviation'  => 'BC',
            'email_suffix'  => 'bc.edu',
            'is_public'     => false,
        ]);
    }

}
