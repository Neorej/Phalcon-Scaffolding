<?php
namespace Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
use Phalcon\Forms\Element\Check;
use Phalcon\Forms\Element\Hidden;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\Identical;

//@todo

/**
 * Class LoginForm
 * @package Forms
 */
class LoginForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();
        
        $email = new Text('email', [
            'placeholder' => 'Email',
        ]);

        $email->addValidators([
            new PresenceOf([
                'message' => 'The e-mail is required',
            ]),
            new Email([
                'message' => 'The e-mail is not valid',
            ]),
        ]);

        $this->add($email);


        $password = new Password('password', [
            'placeholder' => 'Password',
        ]);

        $password->addValidator(
            new PresenceOf([
                'message' => 'The password is required',
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
            new Identical([
                'value' => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed',
            ])
        );

        $this->add($csrf);

        $this->add(new Submit('go', [
            'class' => 'btn btn-success',
        ]));
    }
}