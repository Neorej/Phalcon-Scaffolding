<?php

/**
 * Class UsersController
 */
class UsersController extends \Phalcon\Mvc\Controller
{
    /**
     * 
     */
    public function signupAction()
    {
        $form = new \Forms\SignupForm();
        $form->reuse_previously_submitted_values();

        $this->view->form = $form;
    }

    /**
     *
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
        $user->password = password_hash($user->password, PASSWORD_BCRYPT);
        $user->create();

        $email_confirmation = new EmailConfirmations($user->id);
        $email_body = (new \Phalcon\Mvc\View\SimpleView())->render(
            'email_templates/email_confirmation',
            [
                'name' => $user->name,
                'code' => $email_confirmation->confirmation_code,
            ]
        );
        $this->mail->sendMail($user->email, $user->name, 'Activate your account', $email_body);

        $this->view->email = $user->email;
    }

    public function confirmEmailAction()
    {
        
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

