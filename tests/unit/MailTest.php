<?php

/**
 * Class MailTest
 */
class MailTest extends \Codeception\Test\Unit
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

    public function testSMTPConnection()
    {
        $mail = \Phalcon\DI::getDefault()->get('mail');

        $mail->phpMailer->SMTPDebug = 3;
        try
        {
            $mail->phpMailer->smtpConnect();
            $mail->phpMailer->smtpClose();

            $result = true;
        }
        catch(phpmailerException $e)
        {
            echo $e->getMessage();
            $result = false;
        }

        $this->assertTrue($result);
    }
}