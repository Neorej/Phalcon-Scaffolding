<?php

/**
 * Class UsersController
 */
class UsersController extends \Phalcon\Mvc\Controller
{
    /**
     * User signup form
     */
    public function signupAction()
    {
        $form = new \Forms\SignupForm();
        $form->reuse_previously_submitted_values();

        $this->view->form = $form;
    }

    /**
     * Handle POSTs of the user signup form
     */
    public function signupPostAction()
    {
        $form = new \Forms\SignupForm();
        if(!$this->request->isPost() || !$form->isValid($this->request->getPost()))
        {
            foreach($form->getMessages() as $message)
            {
                $this->flashSession->error($message);
            }
            
            return $this->response->redirect('users/signup');
        }

        $user = new Users();
        // Assign the posted and filtered form values to the model
        $form->bind($this->request->getPost(), $user);
        $user->create();
        
        $this->view->email = $user->email;
    }

    /**
     * Confirm an email address
     * @param string $confirmation_code
     */
    public function confirmEmailAction($confirmation_code = '')
    {
        $this->view->disable();
        
        $email_confirmation = EmailConfirmations::findFirst([
            'confirmation_code = :confirmation_code: AND confirmed_at IS NULL',
            'bind'      => ['confirmation_code' => $confirmation_code],
            'bindTypes' => ['confirmation_code' => \Phalcon\Db\Column::BIND_PARAM_STR]
        ]);
        
        if(!$email_confirmation)
        {
            $this->flashSession->error('Invalid confirmation code');
            return $this->response->redirect('users/resendEmailConfirmation');
        }

        $email_confirmation->confirm();

        $this->flashSession->success('Email confirmed. You can now sign in');
        return $this->response->redirect('users/login');
    }

    public function resendEmailConfirmationAction()
    {
        // new resendemailconfirmationform
    }

    public function loginAction()
    {
        // new loginform
    }

    public function logoutAction()
    {

    }

    public function forgotPasswordAction()
    {
        // new passwordreset form
    }

    public function changePasswordAciton()
    {
        // new changepasswordform
    }

    public function saveNewPasswordAction()
    {
        // new changepasswordform
    }

}

