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
        $form->reusePreviouslySubmittedValues();

        $this->view->form = $form;
    }

    /**
     * Handle POSTs of the user signup form
     */
    public function signupPostAction()
    {
        $form = new \Forms\SignupForm();
        $user = new Users();

        if(!$this->request->isPost() || !$form->isValid($this->request->getPost(), $user))
        {
            return $this->response->redirectWithMessage('users/signup', $form->getMessages());
        }

        $user->create();
        
        $this->view->email = $user->email;
    }

    /**
     * Confirm an email address
     *
     * @param string $confirmation_code
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function confirmEmailAction($confirmation_code = '')
    {
        $email_confirmation = EmailConfirmations::findFirst([
            'confirmation_code = :confirmation_code: AND confirmed_at IS NULL',
            'bind'      => ['confirmation_code' => $confirmation_code],
            'bindTypes' => ['confirmation_code' => \Phalcon\Db\Column::BIND_PARAM_STR]
        ]);
        
        if(!$email_confirmation)
        {
            return $this->response->redirectWithMessage('users/resendEmailConfirmation', 'Invalid confirmation code');
        }

        $email_confirmation->confirm();

        return $this->response->redirectWithMessage('users/signin', 'Email confirmed. You can now sign in', 'success');
    }

    /**
     *
     */
    public function resendEmailConfirmationAction()
    {
        $this->view->form = new \Forms\ResendEmailConfirmationForm();
    }

    /**
     *
     */
    public function resendEmailConfirmationPostAction()
    {
        $form  = new \Forms\ResendEmailConfirmationForm();
        $email = new stdClass();

        if(!$this->request->isPost() || !$form->isValid($this->request->getPost(), $email))
        {
            return $this->response->redirectWithMessage('users/resendEmailConfirmation', $form->getMessages());
        }
        
        $user = Users::findFirstByEmail($email->email);
        if(!$user)
        {
            return $this->response->redirectWithMessage('users/signup', 'There is no user with this email address. You can sign up here', 'error');
        }
        
        if($user->email_confirmed)
        {
            return $this->response->redirectWithMessage('users/signin', 'This email address has already been confirmed', 'info');
        }
        
        $user->createNewEmailConfirmation();
        
        $this->view->email = $user->email;
    }


    public function signinAction()
    {
        $form = new \Forms\SigninForm();
        $form->reusePreviouslySubmittedValues();

        $this->view->form = $form;
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

