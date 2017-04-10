<?php

/**
 * Class UserTest
 */
class UserTest extends \Codeception\Test\Unit
{
    public $user;
    public $new_user;
    
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->user = new Users();
    }

    protected function _after()
    {
        $this->user->delete();
    }

    public function testValidation()
    {
        $faker = \Phalcon\DI::getDefault()->get('faker');
        
        // Cannot save empty user
        $this->assertFalse($this->user->validation(), 'User validation succeeded where it should not');

        $this->user->name     = $faker->name;
        $this->user->email    = $faker->email;
        $this->user->password = $faker->uuid;
        $this->assertTrue($this->user->validation(), 'Failed user validation');
    }
    
    public function testCreate()
    {
        $faker = \Phalcon\DI::getDefault()->get('faker');
        $password = $faker->uuid;

        $this->user->name     = $faker->name;
        $this->user->email    = $faker->email;
        $this->user->password = $password;

        $this->assertTrue($this->user->create(), 'Failed creating user');

        $this->assertTrue(password_verify($password, $this->user->password), 'Failed password_verify');

        $email_confirmation = EmailConfirmations::findFirstByUserId($this->user->id);
        $this->assertNull($email_confirmation->confirmed_at, 'Failed email confirmation');

        $mail_log = MailLog::findFirstByRecipient($this->user->email);
        $this->assertEquals('1', $mail_log->mail_sent, 'Failed to log mail');

        $email_confirmation->confirm();
        $this->assertEquals('1', $email_confirmation->user->email_confirmed, 'Failed to confirm user email');

        // Clean up
        $mail_log->delete();
    }
}

