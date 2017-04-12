<?php
namespace Forms;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Forms\Element\TextArea;

use \Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;
use \Phalcon\Validation\Validator\Email as EmailValidator;
use \Phalcon\Validation\Validator\Identical as IdenticalValidator;


/**
 * Class ContactForm
 * @package Forms
 */
class ContactForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        // Name
        $name = new Text('name', [
            'placeholder'   => 'Name',
            'required'      => 'required',
        ]);
        $name->setFilters(['striptags', 'string', 'trim']);
        $name->addValidators([
            new PresenceOfValidator([
                'message'   => 'Name is required'
            ])
        ]);
        $this->add($name);

        // Email
        $email = new Email('email', [
            'placeholder'   => 'Email address',
            'required'      => 'required',
        ]);
        $email->setFilters(['email', 'lower', 'trim']);
        $email->addValidators([
            new PresenceOfValidator([
                'message'   => 'Email address is required'
            ]),
            new EmailValidator([
                'message'   => 'Invalid email address'
            ])
        ]);
        $this->add($email);

        $phone = new Text('phone', [
            'placeholder'   => 'Phone',
        ]);
        $phone->setFilters(['int', 'trim']);
        $this->add($phone);

        $message = new TextArea('message', [
            'placeholder'   => 'Message',
        ]);
        $message->setFilters(['striptags', 'string', 'trim']);
        $this->add($message);
        
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