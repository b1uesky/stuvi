<?php

$I = new FunctionalTester($scenario);
$I->wantTo('see trade in program page and search a book');

$I->amOnPage('/');
$I->click('Check Out Our Trade-In Program');
$I->seeCurrentUrlEquals('/trade-in-program');
$I->fillField('query', \App\Book::orderByRaw('RAND()')->first()->isbn10);
$I->click('Sell Your Textbook Now');
$I->see('Confirm your book');