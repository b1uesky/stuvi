<?php
$faker = \Faker\Factory::create();
$isbn = '128516590X';

$I = new FunctionalTester($scenario);
$I->wantTo('click search button on home page with ISBN input');
$I->amOnPage('/');

$I->fillField('query', $isbn);
$I->click('Search');
$I->see('Confirm your book');