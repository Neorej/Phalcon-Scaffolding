<?php
namespace Forms;

/**
 * Class ResetPasswordForm
 * @package Forms
 */
class ResetPasswordForm extends FormBase
{
    public function initialize()
    {
        parent::initialize();

        $this->add($this->createUserEmailElement());

        $this->add($this->createSubmitElement());
    }
}