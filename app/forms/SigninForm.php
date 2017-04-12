<?php
namespace Forms;

use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Forms\Element\Check;
use \Phalcon\Forms\Element\Hidden;

use Phalcon\Validation\Validator\PresenceOf     as PresenceOfValidator;
use \Phalcon\Validation\Validator\Email         as EmailValidator;
use \Phalcon\Validation\Validator\Identical     as IdenticalValidator;

/**
 * Class SigninForm
 * @package Forms
 */
class SigninForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $email = new Email('email', [
            'placeholder'   => 'Email address',
            'required'      => 'required',
        ]);
        $email->setFilters(['email', 'lower', 'trim']);
        $email->addValidators([
            new EmailValidator([
                'message'   => 'Invalid email address'
            ])
        ]);
        $this->add($email);
        
        $password = new Password('password', [
            'placeholder' => 'Password',
        ]);
        $password->addValidator(
            new PresenceOfValidator([
                'message' => 'Password is required',
            ])
        );
        $this->add($password);

        $remember = new Check('remember', [
            'value' => 'yes',
        ]);
        $remember->setLabel('Remember me');
        $this->add($remember);

        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new IdenticalValidator([
                'value' => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed',
            ])
        );

        $csrf->clear();
        $this->add($csrf);

        $this->add(new Submit('submit', [
            'value' => 'Submit',
            'name'  => 'submit'
        ]));
    }
}