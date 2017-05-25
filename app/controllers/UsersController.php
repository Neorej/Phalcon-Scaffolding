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
            return $this->response->redirectWithMessage('users/signin', 'This email address has already been confirmed', 'notice');
        }
        
        $user->createNewEmailConfirmation();
        
        $this->view->email = $user->email;
    }

    /**
     *
     */
    public function signinAction()
    {
        $form = new \Forms\SigninForm();
        $form->reusePreviouslySubmittedValues();

        $this->view->form = $form;
    }

    /**
     *
     */
    public function logoutAction()
    {

    }

    /**
     * Form for requesting a new password reset
     */
    public function resetPasswordAction()
    {
        $this->view->form = new \Forms\ResetPasswordForm();
    }

    /**
     * Request a new password reset
     *
     * @return mixed
     */
    public function resetPasswordPostAction()
    {
        $form  = new \Forms\ResetPasswordForm();
        $email = new stdClass();

        if(!$this->request->isPost() || !$form->isValid($this->request->getPost(), $email))
        {
            return $this->response->redirectWithMessage('users/resetPassword', $form->getMessages());
        }

        $user = Users::findFirstByEmail($email->email);
        if(!$user)
        {
            return $this->response->redirectWithMessage('users/signup', 'There is no user with this email address. You can sign up here', 'error');
        }

        if(!$user->email_confirmed)
        {
            return $this->response->redirectWithMessage('users/resetPassword', 'Please confirm your e-mailaddress first', 'notice');
        }
        
        $user->createNewPasswordReset();

        $this->view->email = $user->email;
    }

    /**
     * Form for setting a new password following a reset
     *
     * @param $code
     * @return mixed
     */
    public function changePasswordAction($code)
    {
        $passwordReset = PasswordResets::findFirstByCode($code);
        if(!$passwordReset || !$passwordReset->isValid())
        {
            return $this->response->redirectWithMessage('users/resetPassword', 'This request is invalid or has expired', 'error');
        }

        $this->view->code = $passwordReset->code;
        $this->view->form = new \Forms\ChangePasswordForm();
    }

    /**
     * Save the new password
     *
     * @param $code
     * @return mixed
     */
    public function changePasswordPostAction($code)
    {
        $passwordReset = PasswordResets::findFirstByCode($code);
        if(!$passwordReset || !$passwordReset->isValid())
        {
            return $this->response->redirectWithMessage('users/resetPassword', 'This request is invalid or has expired', 'error');
        }
        
        $form = new \Forms\ChangePasswordForm();
        $user = $passwordReset->user;

        if(!$this->request->isPost() || !$form->isValid($this->request->getPost(), $user))
        {
            return $this->response->redirectWithMessage('users/resetPassword', $form->getMessages(), 'error');
        }

        $user->update();

        $passwordReset->used_at = time();
        $passwordReset->update();

        return $this->response->redirectWithMessage('users/login', 'Password changed successfully', 'success');
    }

}