<?php

/**
 * Class SignupPostTest
 */
class SignupPostTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {

    }

    protected function _after()
    {

    }

    public function testValidation()
    {
        $values = [];

        $form = new \Forms\SignupForm();

        $faker = \Phalcon\DI::getDefault()->get('faker');

        $this->assertFalse($form->isValid($values));

        $values['name']                 = $faker->name;
        $values['email']                = $faker->email;
        $values['password']             = $faker->password;
        $values['passwordConfirmation'] = $values['password'];

        $this->assertTrue($form->isValid($values));
        if(!$form->isValid($values))
        {
            print_r($form->getMessages());
            die;
        }

        foreach(['name', 'email', 'password', 'passwordConfirmation'] as $element)
        {
            $original_value = $values[$element];

            $values[$element] = '';
            $this->assertFalse($form->isValid($values));

            $values[$element] = $original_value;
        }
    }
}

