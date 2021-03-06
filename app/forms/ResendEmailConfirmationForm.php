<?php
namespace Forms;

/**
 * Class ResendEmailConfirmationForm
 * @package Forms
 */
class ResendEmailConfirmationForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $this->add($this->createUserEmailElement());

        $this->add($this->createSubmitElement());
    }
}