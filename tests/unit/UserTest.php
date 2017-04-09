<?php

/**
 * Class UserTest
 */
class UserTest extends \Codeception\Test\Unit
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
        $faker = \Phalcon\DI::getDefault()->get('faker');
        
        $user = new Users();

        // Cannot save empty user
        $this->assertFalse($user->validation());

        $user->name     = $faker->name;
        $user->email    = $faker->email;
        $user->password = password_hash($faker->uuid, PASSWORD_DEFAULT);
        $this->assertTrue($user->validation());
        $this->assertTrue($user->save());

        $new_user           = new Users();
        $new_user->name     = $faker->name;
        $new_user->email    = $user->email; // Use email that is already in use
        $new_user->password = password_hash($faker->uuid, PASSWORD_DEFAULT);
        $this->assertFalse($new_user->validation());
        $this->assertFalse($new_user->save());

        $new_user->email    = $faker->email;
        $this->assertTrue($new_user->validation());
        $this->assertTrue($new_user->save());
        
        $user->delete();
        $new_user->delete();
    }
}

