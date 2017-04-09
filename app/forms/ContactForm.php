<?php
namespace Forms;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Forms\Element\Textarea;

use \Phalcon\Validation\Validator\PresenceOf as PresenceOfValidator;
use \Phalcon\Validation\Validator\Email as EmailValidator;

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
            'label'         => 'Name',
            'required'      => 'required',
        ]);
        $name->setLabel('Name');
        $name->setFilters(['striptags', 'string', 'trim']);
        $name->addValidators([
            new PresenceOfValidator([
                'message'   => 'Name is required'
            ])
        ]);
        $this->add($name);

        // Email
        $email = new Email('emailaddress', [
            'placeholder'   => 'Email address',
            'required'      => 'required',
        ]);
        $email->setLabel('Email address');
        $email->setFilters(['email', 'strtolower', 'trim']);
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
        $phone->setLabel('Phone');
        $this->add($phone);

        $message = new Textarea('message', [
            'placeholder'   => 'Message',
        ]);
        $message->setFilters(['striptags', 'string', 'trim']);
        $message->setLabel('Message');
        $this->add($message);
        
        // Add a text element to put a hidden CSRF
        $csrf = new Hidden('csrf', [
            'value' => $this->security->getToken(),
            'name'  => 'csrf'
        ]);
        $this->add($csrf);
        
        // Submit button
        $this->add(new Submit('submit', [
            'value' => 'Submit',
            'name'  => 'submit'
        ]));
    }
}