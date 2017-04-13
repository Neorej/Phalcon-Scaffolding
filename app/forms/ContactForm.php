<?php
namespace Forms;

use \Phalcon\Forms\Element\Text;
use \Phalcon\Forms\Element\TextArea;

/**
 * Class ContactForm
 * @package Forms
 */
class ContactForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $this->add($this->createUserNameElement());

        $this->add($this->createUserEmailElement());

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

        $this->add($this->createSubmitElement());
    }
}