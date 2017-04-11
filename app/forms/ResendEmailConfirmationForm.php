<?php
namespace Forms;

use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Submit;

use \Phalcon\Validation\Validator\Email as EmailValidator;
use \Phalcon\Validation\Validator\Identical as IdenticalValidator;

/**
 * Class ResendEmailConfirmationForm
 * @package Forms
 */
class ResendEmailConfirmationForm extends FormBase
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