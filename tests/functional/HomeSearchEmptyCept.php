<?php 
$I = new FunctionalTester($scenario);
$I->wantTo('click search button on home page with empty input');
$I->amOnPage('/');
$I->click('Search');
$I->see('Search results');
