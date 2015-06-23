<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Product;
use App\University;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();

        $this->call('BookTableSeeder');
		$this->call('UniversityTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('ProductTableSeeder');
        $this->call('AddressTableSeeder');
        $this->call('BuyerOrderSeeder');
        $this->call('BuyerPaymentSeeder');
        $this->call('SellerOrderSeeder');

        Model::reguard();
	}

}
