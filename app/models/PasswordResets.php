<?php

class PasswordResets extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=11, nullable=false)
     */
    public $id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $user_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=false)
     */
    public $created_at;

    /**
     *
     * @var integer
     * @Column(type="integer", length=11, nullable=true)
     */
    public $used_at;

    /**
     *
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $code;

    /**
     * Set up model relations
     */
    public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id', ['alias' => 'user']);
    }

    /**
     * 
     */
    public function beforeValidationOnCreate()
    {
        $this->code = (new \Phalcon\Security\Random())->uuid();
        $this->created_at = time();
    }

    /**
     * 
     */
    public function afterCreate()
    {
        $email_body = $this->getDI()->get('simpleView')->render(
            'email_templates/password_reset',
            [
                'name' => $this->user->name,
                'code' => $this->code,
            ]
        );
        $this->getDI()->get('mail')->sendMail($this->user->email, $this->user->name, 'Reset your password', $email_body);
    }

    /**
     * Check if a password reset can be used to change the password
     *
     * @return bool
     */
    public function isValid()
    {
        // A password reset can only be used once
        if($this->used_at > $this->created_at)
        {
            return false;
        }

        // Password resets expire
        if($this->created_at < (time() - $this->getDI()->get('config')->users->passwordResetCodeValidForMinutes * 60))
        {
            return false;
        }

        return true;
    }
}
