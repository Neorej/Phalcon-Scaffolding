<?php

/**
 * Class EmailConfirmations
 */
class EmailConfirmations extends \Phalcon\Mvc\Model
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
     * @var string
     * @Column(type="string", length=255, nullable=false)
     */
    public $confirmation_code;

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
    public $confirmed_at;

    /**
     * Set up model relations
     */
    public function initialize()
    {
        $this->belongsTo('user_id', 'Users', 'id', ['alias' => 'user']);
    }

    public function beforeValidationOnCreate()
    {
        $this->confirmation_code = (new \Phalcon\Security\Random())->uuid();
        $this->created_at = time();
    }

    public function afterCreate()
    {
        $email_body = $this->getDI()->get('simpleView')->render(
            'email_templates/email_confirmation',
            [
                'name' => $this->user->name,
                'code' => $this->confirmation_code,
            ]
        );
        $this->getDI()->get('mail')->sendMail($this->user->email, $this->user->name, 'Activate your account', $email_body);
    }
    
    public function confirm()
    {
        $user = $this->user;
        $user->email_confirmed = 1;
        $user->save();

        $this->confirmed_at = time();
        $this->save();
    }
}
