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
    public function contactPostAction()
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

    /**
     * @return int
     */
    public function forbiddenAction()
    {
        $this->view->disable;
        return http_response_code(403);
    }
}

