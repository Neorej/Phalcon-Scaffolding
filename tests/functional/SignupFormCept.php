<?php
$I = new FunctionalTester($scenario);
$I->wantTo('check the signup page form elements');
$I->amOnPage('/users/signup');

$faker = \Phalcon\DI::getDefault()->get('faker');

$form = new \Forms\SignupForm();

foreach($form->getElements() as $element)
{
    if(get_class($element) == 'Phalcon\Forms\Element\Hidden')
    {
        // Check if a hidden element exists by getting its value
        $I->grabTextFrom('[name="'.$element->getName().'"]');
        continue;
    }

    $I->seeElement('[name="'.$element->getName().'"]');
}