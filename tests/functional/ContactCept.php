<?php
$I = new FunctionalTester($scenario);
$I->wantTo('check the contact page form elements');
$I->amOnPage('/index/contact');

$form = new \Forms\ContactForm();
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

$I->click('Submit');
$I->expect('The form is not submitted');