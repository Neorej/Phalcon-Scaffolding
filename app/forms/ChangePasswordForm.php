<?php
namespace Forms;

use \Phalcon\Validation\Validator\Confirmation  as ConfirmationValidator;

/**
 * Class ChangePasswordForm
 * @package Forms
 */
class ChangePasswordForm extends FormBase
{
    /**
     * @param null $entity
     * @param null $options
     */
    public function initialize($entity = null, $options = null)
    {
        parent::initialize();

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