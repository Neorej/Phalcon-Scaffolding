<?php
namespace Forms;

use \Phalcon\Forms\Element\Check;

/**
 * Class SigninForm
 * @package Forms
 */
class SigninForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $this->add($this->createUserEmailElement());
        
        $this->add($this->createUserPasswordElement());

        /*
        $remember = new Check('remember', [
            'value' => 'yes',
        ]);
        $remember->setLabel('Remember me');
        $this->add($remember);
        */
        
        $this->add($this->createSubmitElement());
    }
}