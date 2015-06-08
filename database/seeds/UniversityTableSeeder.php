<?php

use Illuminate\Database\Seeder;
use App\University;

class UniversityTableSeeder extends Seeder {

public function run()
{
    DB::table('universities')->delete();

    University::create([
        'name'  => 'BOSTON UNIVERSITY',
        'abbreviation'  => 'BU',
        'email_suffix'  => 'bu.edu'
    ]);

    University::create([
        'name'  => 'Massachusetts Institute of Technology',
        'abbreviation'  => 'MIT',
        'email_suffix'  => 'mit.edu'
    ]);
}

}
