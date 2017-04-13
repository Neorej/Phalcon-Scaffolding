<?php
namespace Forms;

use \Phalcon\Forms\Element\Email;
use \Phalcon\Forms\Element\Hidden;
use \Phalcon\Forms\Element\Password;
use \Phalcon\Forms\Element\Submit;
use \Phalcon\Forms\Element\Text;

use \Phalcon\Validation\Validator\Email         as EmailValidator;
use \Phalcon\Validation\Validator\Identical     as IdenticalValidator;
use \Phalcon\Validation\Validator\PresenceOf    as PresenceOfValidator;
use \Phalcon\Validation\Validator\StringLength  as StringLengthValidator;
/**
 * Class FormBase
 * @package Forms
 */
class FormBase extends \Phalcon\Forms\Form
{
    private $di;
    private $request;
    private $session;

    // Items to not preserve in formData
    public $skipPostItems = [
        'password',
        'passwordConfirmation',
        'csrf',
        'submit'
    ];
    
    public function initialize()
    {
        $this->di = $this->getDI();

        $this->request = $this->di->get('request');
        $this->session = $this->di->get('session');

        // Forms always have a anti-csrf element
        $this->add($this->createCsrfElement());
    }
    
    /**
     *
     */
    public function beforeExecuteRoute()
    {
        // Clear the old form data
        if($this->session->get('formDataSeen') > 0)
        {
            $this->session->remove('formData');
            $this->session->remove('formDataSeen');
        }

        $this->saveFormDataToSession();
        
        if($this->session->has('formDataSeen'))
        {
            $formDataSeen = $this->session->get('formDataSeen');

            // Increments to 0 (false)
            // Once loaded again, increments to 1 (true)
            //      & Removed on next page load.
            $this->session->set('formDataSeen', ++$formDataSeen);
        }
    }

    /**
     * Save posted data to session so it can be reused in the form after a page load
     */
    private function saveFormDataToSession() : void
    {
        if(!$this->request->isPost())
        {
            return;
        }

        $postData = [];
        foreach($_POST as $key => $value)
        {
            if(in_array($key, $this->skipPostItems))
            {
                continue;
            }

            $postData[$key] = $this->request->getPost($key);
        }

        // Store the Session Data
        $this->session->set('formData', $postData);
        $this->session->set('formDataSeen', -2);
    }

    /**
     * Set previously submitted data as default values
     */
    public function reusePreviouslySubmittedValues() : void
    {
        if(!$this->session->has('formData'))
        {
            return;
        }

        foreach($this->getElements() as &$element)
        {
            if(in_array($element->getName(), $this->skipPostItems))
            {
                continue;
            }

            $element->setDefault($this->session->get('formData')[$element->getName()] ?? '');
        }
    }

    /**
     * Create a basic anti-csrf element
     *
     * @return Hidden
     */
    public function createCsrfElement() : Hidden
    {
        $csrf = new Hidden('csrf');
        $csrf->addValidator(
            new IdenticalValidator([
                'value' => $this->security->getSessionToken(),
                'message' => 'CSRF validation failed',
            ])
        );
        $csrf->clear();

        return $csrf;
    }

    /**
     * Create a basic submit button
     *
     * @return Submit
     */
    public function createSubmitElement(string $submitName = 'Submit') : Submit
    {
        return new Submit('submit', [
            'value' => $submitName,
            'name'  => 'submit'
        ]);
    }

    /**
     * Create a basic email input element
     *
     * @return Email
     */
    public function createUserEmailElement() : Email
    {
        $email = new Email('email', [
            'placeholder' => 'Email address',
            'required'    => 'required'
        ]);
        $email->setFilters(['email', 'lower', 'trim']);
        $email->addValidators([
            new EmailValidator([
                'message'   => 'Invalid email address'
            ])
        ]);
        
        return $email;
    }

    /**
     * @return Text
     */
    public function createUserNameElement()
    {
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
        
        return $name;
    }

    /**
     * Create a basic password input element
     * 
     * @param string $name
     * @return Password
     */
    public function createUserPasswordElement(string $name = 'password', string $placeholder = 'Password') : Password
    {
        $password = new Password($name, [
            'placeholder' => $placeholder,
            'required'    => 'required'
        ]);
        $password->addValidators([
            new PresenceOfValidator([
                'message' => $placeholder.' is required',
            ]),
            new StringLengthValidator([
                'min'            => 8,
                'messageMinimum' => $placeholder.'s must be at least 8 characters'
            ])
        ]);
        
        return $password;
    }
}