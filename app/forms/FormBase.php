<?php
namespace Forms;

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

    /**
     * 
     */
    public function initialize()
    {
        $this->di = $this->getDI();

        $this->request = $this->di->get('request');
        $this->session = $this->di->get('session');
    }

    /**
     *
     */
    public function beforeExecuteRoute()
    {
        // Clear the old form data
        if($this->session->get('formDataSeen') > 1)
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
        $this->session->set('formDataSeen', -1);
    }

    /**
     *
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
}