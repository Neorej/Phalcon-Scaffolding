<?php

$faker = \Phalcon\DI::getDefault()->get('faker');

$I = new FunctionalTester($scenario);
$I->wantTo('Test submissions of the contact form');
$I->amOnPage('/index/contact');

$I->fillField('name', $faker->name);
$I->fillField('emailaddress', $faker->name);
$I->fillField('phone', $faker->e164PhoneNumber);
$I->fillField('message', $faker->text);

$I->click('Submit');
