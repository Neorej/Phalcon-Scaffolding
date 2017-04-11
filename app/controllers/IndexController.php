<?php

/**
 * Class IndexController
 */
class IndexController extends ControllerBase
{
    public function indexAction()
    {

    }

    public function contactAction()
    {
        $form = new \Forms\ContactForm();
        $form->reusePreviouslySubmittedValues();

        $this->view->form = $form;
    }

    /**
     * @return mixed
     */
    public function formPostAction()
    {
        return $this->response->redirect('index/contact');
    }

    /**
     * @return int
     */
    public function notFoundAction()
    {
        $this->view->disable;
        return http_response_code(404);
    }
}

