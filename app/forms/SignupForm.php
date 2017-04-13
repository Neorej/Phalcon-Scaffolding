<?php
namespace Forms;

use \Phalcon\Validation\Validator\Uniqueness    as UniquenessValidator;
use \Phalcon\Validation\Validator\Confirmation  as ConfirmationValidator;

/**
 * Class SignupForm
 * @package Forms
 */
class SignupForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $this->add($this->createUserNameElement());
        
        $email = $this->createUserEmailElement();
        $email->addValidator(
            new UniquenessValidator([
                'model'   => new \Users(),
                'message' => 'This email address is already in use',
            ])
        );
        $this->add($email);

        $this->add($this->createUserPasswordElement());

        $passwordConfirmation = $this->createUserPasswordElement(
            'passwordConfirmation',
            'Confirm password'
        );
        $passwordConfirmation->addValidator(
            new ConfirmationValidator([
                'message'   => 'Passwords do not match',
                'with'      => 'password'
            ])
        );
        $this->add($passwordConfirmation);

        $this->add($this->createSubmitElement());
    }
}