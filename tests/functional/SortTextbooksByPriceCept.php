<?php
$book = \App\Book::hasProducts()->orderByRaw('RAND()')->first();

$I = new FunctionalTester($scenario);
$I->wantTo('sort textbooks by price');

$I->amOnPage('/textbook/buy/'.$book->id);
$I->click('Price');
$I->see('Price', '.sort-by-type');
