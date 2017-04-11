<?php
namespace Forms;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Forms\Element\Password;

use Phalcon\Validation\Validator\PresenceOf     as PresenceOfValidator;
use \Phalcon\Validation\Validator\StringLength  as StringLengthValidator;
use \Phalcon\Validation\Validator\Email         as EmailValidator;
use \Phalcon\Validation\Validator\Uniqueness    as UniquenessValidator;
use \Phalcon\Validation\Validator\Confirmation  as ConfirmationValidator;
use \Phalcon\Validation\Validator\Identical     as IdenticalValidator;

/**
 * Class SignupForm
 * @package Forms
 */
class SignupForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();
        
        $name = new Text('name', [
            'placeholder'   => 'Name',
            'required'      => 'required',
        ]);
        $name->setFilters(['striptags', 'string', 'trim']);
        $name->addValidators([
            new PresenceOfValidator([
                'message' => 'A name is required'
            ]),
            new StringLengthValidator([
                'min'            => 2,
                'max'            => 255,
                'messageMinimum' => 'Names must be at least 2 characters',
                'messageMaximum' => 'Names are limited to 255 characters',
            ])
        ]);
        $this->add($name);

        $email = new Email('email', [
            'placeholder'   => 'Email address',
            'required'      => 'required',
        ]);
        $email->setFilters(['email', 'lower', 'trim']);
        $email->addValidators([
            new EmailValidator([
                'message'   => 'Invalid email address'
            ]),
            new UniquenessValidator([
                'model'   => new \Users(),
                'message' => 'This email address is already in use',
            ])
        ]);
        $this->add($email);

        $password = new Password('password', [
            'placeholder'   => 'Password',
            'required'      => 'required',
        ]);
        $password->addValidators([
            new StringLengthValidator([
                'min'            => 8,
                'messageMinimum' => 'Passwords must be at least 8 characters'
            ])
        ]);
        $this->add($password);

        $passwordConfirmation = new Password('passwordConfirmation', [
            'placeholder'   => 'Confirm password',
            'required'      => 'required',
        ]);
        $passwordConfirmation->addValidators([
            new ConfirmationValidator([
                'message'   => 'Passwords do not match',
                'with'      => 'password'
            ])
        ]);
        $this->add($passwordConfirmation);
        
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