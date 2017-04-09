<?php
$I = new FunctionalTester($scenario);
$I->wantTo('check the signup page submit results');
$I->amOnPage('/users/signup');

$faker = \Phalcon\DI::getDefault()->get('faker');

$fakename = $faker->name;

$I->fillField('name', $fakename);
$I->fillField('email', $faker->name);
$I->fillField('password', 'a');
$I->fillField('passwordConfirmation', 'b');

$I->click('Submit');

$I->see('Passwords do not match');
$I->see('Invalid email address');
$I->see('Passwords must be at least 8 characters');

$I->fillField('password', 'abcdefghijk');
$I->fillField('passwordConfirmation', 'abcdefghijk');
$I->fillField('email', $faker->email);

$I->click('Submit');