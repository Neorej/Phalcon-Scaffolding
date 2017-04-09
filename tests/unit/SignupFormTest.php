<?php

/**
 * Class UserTest
 */
class SignupFormTest extends \Codeception\Test\Unit
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
        $controller = new UsersController();
        $controller->signupAction();
    }
}

