<?php
$scenario->skip('sort bars not in view');

$book = \App\Book::hasProducts()->orderByRaw('RAND()')->first();

$I = new FunctionalTester($scenario);
$I->wantTo('sort textbooks by condition');

$I->amOnPage('/textbook/buy/'.$book->id);
$I->click('Condition');
$I->see('Condition', '.sort-by-type');
