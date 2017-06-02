<?php
namespace Library;

/**
 * Class Auth
 */
Class Auth extends \Phalcon\Mvc\User\Component
{
    /**
     * @param string $email
     * @param string $password
     * @return bool
     * @throws \Exception
     */
    public function signin(string $email, string $password)
    {
        if($this->isSignedIn())
        {
            return false;
        }

        $user = Users::findFirst([
            '(email = :email:)',
            'bind' => [
                'email' => $email,
            ]
        ]);

        if(!$user)
        {
            $this->throttle();
            throw new \Exception('Invalid username or password');
        }

        if(!$user->email_confirmed)
        {
            throw new \Exception('You must confirm your e-mailaddress before you can sign in');
        }
        
        if(!password_verify($password, $user->password))
        {
            $this->throttle();
            throw new \Exception('Invalid username or password');
        }

        $this->set($user);

        return true;
    }

    /**
     * @return bool
     */
    public function isSignedIn() : bool
    {
        return $this->session->has('auth');
    }

    /**
     *
     */
    public function throttle()
    {

    }

    /**
     * @param Users $user
     */
    private function set(Users $user) : void
    {
        $identity = new \stdClass();
        foreach(['id', 'name', 'email', 'is_admin'] as $attribute)
        {
            $identity->{$attribute} = $user->{$attribute};
        }

        $this->session->set('auth', $identity);
    }

    /**
     * @return bool|mixed
     */
    public function get()
    {
        return $this->session->get('auth');
    }

}